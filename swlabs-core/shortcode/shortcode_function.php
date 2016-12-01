<?php

// Add custom type
if( function_exists("vc_add_shortcode_param") ) {
	/*
	 * Dropdown multiple
	 * 
	 * Using: array(
				"type" => "shw_dropdownmultiple",
				"class" => "",
				"heading" => esc_html__("Services", 'swlabs-core'),
				"param_name" => "services",
				"value" => $categories
		),
	 */
	vc_add_shortcode_param( 'shw_dropdownmultiple' , 'swlabscore_dropdownmultiple_settings_field' );
	function swlabscore_dropdownmultiple_settings_field( $settings, $value ) {
		$dependency = vc_generate_dependencies_attributes( $settings );
		$value = explode( ",", $value );
		$output = '<select name="' . esc_attr( $settings['param_name'] ).'" class="wpb_vc_param_value wpb-input wpb-select ' .
					esc_attr( $settings['param_name'] ) . ' ' .
					esc_attr( $settings['type'] ) . '"' . $dependency . ' multiple>';
		foreach( $settings['value'] as $text_val => $val ) {
			if( is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val) ) {
				$text_val = $val;
			}
			$selected = '';
			if ( in_array( $val, $value ) ) {
				$selected = ' selected="selected" ';
			}
			$output .= '<option class="' . $val. '" value="' . $val . '"' . $selected . '>' . $text_val . '</option>';
		}
		$output .= '</select>';
		return $output;
	}

	//hidden
	vc_add_shortcode_param( 'shw_hidden', 'swlabscore_hidden_settings_field' );
	function swlabscore_hidden_settings_field( $settings, $value ) {
		$dependency = vc_generate_dependencies_attributes( $settings );
		$output = '<input name="' . $settings['param_name'] . '" ';
		$output .= 'class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'].'_field" ';
		$output .= 'type="hidden" value="' . $value . '" ' . $dependency . '/>';
		return $output;
	}

	// date time picker
	vc_add_shortcode_param( 'shw_datetime_picker' , 'swlabscore_datetime_picker_field' , SWLABSCORE_ASSET_URI . '/js/sw-datetimepicker.js');
	
	function swlabscore_datetime_picker_field( $settings, $value ) {
		$dependency = vc_generate_dependencies_attributes( $settings );
		$output = '<input name="' . $settings['param_name'] . '" ';
		$output .= 'class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'].'_field" ';
		$output .= 'type="text" value="' . $value . '" ' . $dependency . ' id="datetimepicker"/>';
		return $output;
	}
}

if( SWLABSCORE_VC_ACTIVE ) {
	// Map Shortcodes
	// =============================================================================
	if( ! function_exists( 'swlabscore_vc_map_shortcodes' ) ) {
		function swlabscore_vc_map_shortcodes() {
			$list_shortcodes = SwlabsCore::get_config( 'shortcode' );
			foreach( $list_shortcodes as $shortcode => $func ) {
				$sc_file = SWLABSCORE_SHORTCODE_DIR . '/inc/' . $func . '.php';
				if( file_exists( $sc_file ) ) {
					require_once( $sc_file );
				}
			}
		}
	}
	add_action('vc_before_init', 'swlabscore_vc_map_shortcodes');
}

//Add Shortcode
// =============================================================================
if( ! function_exists( 'swlabscore_add_shortcodes' ) ) {
	function swlabscore_add_shortcodes() {
		$list_shortcodes = SwlabsCore::get_config( 'shortcode' );
		foreach( $list_shortcodes as $shortcode => $func ) {
			if ( ! SWLABSCORE_WOOCOMMERCE_ACTIVE && in_array( $func, array( 'product_tab', 'product_slide', 'product_category_tab', 'product_countdown' ) ) ) {
				continue;
			}
			add_shortcode( $shortcode, array( 'SwlabsCore', '[shortcode.Shortcode_Controller, ' . $func . ']' ) );
		}
	}
}
add_action('init', 'swlabscore_add_shortcodes');

if( SWLABSCORE_VC_ACTIVE ) {
	/**
	 * Find product by id
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	function productIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get product
			$product_object = wc_get_product( (int) $query );
			if ( is_object( $product_object ) ) {
				$product_sku = $product_object->get_sku();
				$product_title = $product_object->get_title();
				$product_id = $product_object->id;
	
				$product_sku_display = '';
				if ( ! empty( $product_sku ) ) {
					$product_sku_display = ' - ' . esc_html__( 'Sku', 'js_composer' ) . ': ' . $product_sku;
				}
	
				$product_title_display = '';
				if ( ! empty( $product_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' . $product_title;
				}
	
				$product_id_display = esc_html__( 'Id', 'js_composer' ) . ': ' . $product_id;
	
				$data = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display . $product_sku_display;
	
				return ! empty( $data ) ? $data : false;
			}
	
			return false;
		}
	
		return false;
	}
	
	/**
	 * Suggester for autocomplete by id/name/title/sku
	 *
	 * @param $query
	 *
	 * @return array - id's from products with title/sku.
	 */
	function productIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
						FROM {$wpdb->posts} AS a
						LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
						WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )",
						$product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );
	
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'js_composer' ) . ': ' .
						$value['id'] .
						( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' .
								$value['title'] : '' ) .
								( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'js_composer' ) . ': ' .
										$value['sku'] : '' );
				$results[] = $data;
			}
		}
	
		return $results;
	}
	
	/**
	 * Replace single product sku to id.
	 *
	 * @param $current_value
	 * @param $param_settings
	 * @param $map_settings
	 * @param $atts
	 *
	 * @return bool|string
	 */
	function productIdDefaultValue( $current_value, $param_settings, $map_settings, $atts ) {
		$value = trim( $current_value );
		if ( strlen( trim( $current_value ) ) === 0 && isset( $atts['sku'] ) && strlen( $atts['sku'] ) > 0 ) {
			$value = $this->productIdDefaultValueFromSkuToId( $atts['sku'] );
		}
	
		return $value;
	}
	
	/**
	 * Find category by id
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	function categoryIdAutocompleteRender( $query ) {
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get product
			$product_object = wc_get_product( (int) $query );
			if ( is_object( $product_object ) ) {
				$product_sku = $product_object->get_sku();
				$product_title = $product_object->get_title();
				$product_id = $product_object->id;
	
				$product_sku_display = '';
				if ( ! empty( $product_sku ) ) {
					$product_sku_display = ' - ' . esc_html__( 'Sku', 'js_composer' ) . ': ' . $product_sku;
				}
	
				$product_title_display = '';
				if ( ! empty( $product_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' . $product_title;
				}
	
				$product_id_display = esc_html__( 'Id', 'js_composer' ) . ': ' . $product_id;
	
				$data = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display . $product_sku_display;
	
				return ! empty( $data ) ? $data : false;
			}
	
			return false;
		}
	
		return false;
	}
	
	/**
	 * Suggester for autocomplete by id/name/title/sku
	 *
	 * @param $query
	 *
	 * @return array - id's from products with title/sku.
	 */
	function categoryIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$product_id = (int) $query;
		$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
						FROM {$wpdb->posts} AS a
						LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
						WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )",
						$product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );
	
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'js_composer' ) . ': ' .
						$value['id'] .
						( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' .
								$value['title'] : '' ) .
								( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'js_composer' ) . ': ' .
										$value['sku'] : '' );
				$results[] = $data;
			}
		}
	
		return $results;
	}
	
	/**
	 * Autocomplete suggester to search product category by name/slug or id.
	 *
	 * @param $query
	 * @param bool $slug - determines what output is needed
	 *      default false - return id of product category
	 *      true - return slug of product category
	 *
	 * @return array
	 */
	function productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
						$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );
	
		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = esc_html__( 'Id', 'js_composer' ) . ': ' .
						$value['id'] .
						( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'js_composer' ) . ': ' .
								$value['name'] : '' ) .
								( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'js_composer' ) . ': ' .
										$value['slug'] : '' );
				$result[] = $data;
			}
		}
	
		return $result;
	}
	
	/**
	 * Search product category by id
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	function productCategoryCategoryRenderByIdExact( $query ) {
		global $wpdb;
		$query = $query['value'];
		$cat_id = (int) $query;
		$term = get_term( $cat_id, 'product_cat' );
	
		return productCategoryTermOutput( $term );
	}
	
	/**
	 * Return product category value|label array
	 *
	 * @param $term
	 *
	 * @return array|bool
	 */
	function productCategoryTermOutput( $term ) {
		$term_slug = $term->slug;
		$term_title = $term->name;
		$term_id = $term->term_id;
	
		$term_slug_display = '';
		if ( ! empty( $term_sku ) ) {
			$term_slug_display = ' - ' . esc_html__( 'Sku', 'js_composer' ) . ': ' . $term_slug;
		}
	
		$term_title_display = '';
		if ( ! empty( $product_title ) ) {
			$term_title_display = ' - ' . esc_html__( 'Title', 'js_composer' ) . ': ' . $term_title;
		}
	
		$term_id_display = esc_html__( 'Id', 'js_composer' ) . ': ' . $term_id;
	
		$data = array();
		$data['value'] = $term_id;
		$data['label'] = $term_id_display . $term_title_display . $term_slug_display;
	
		return ! empty( $data ) ? $data : false;
	}
} // end rewrite VC functions
