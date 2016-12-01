<?php
/**
 * Controller Page.
 *
 * @since 1.0
 */

SwlabsCore::load_class( 'Abstract' );
SwlabsCore::load_class( 'Model' );

class SwlabsCore_Page_Controller extends SwlabsCore_Abstract {

	/**
	 * Init page options from theme options.
	 */
	public function init() {
		global $shw_admin_option_default;
		global $swbignews_options;
		if( class_exists('Swbignews') ) {
			$maps = Swbignews::get_config( 'mapping', 'options' );
			$special_keys = array( 'pt_padding_top', 'pt_padding_bottom', 'header_padding_top', 'header_padding_bottom' );
			$transparent_keys = array( 'background_transparent', 'header_background_transparent', 'pt_background_transparent' );

			foreach( $maps as $option_type => $options ) {
				foreach( $options as $key => $option) {
					$default = '';
					if( $option ) {
						if( is_array( $option ) ) {
							if(count($option) == 3) {
								if( isset( $swbignews_options[$option[0]][$option[1]][$option[2]] ) ) {
									$default = $swbignews_options[$option[0]][$option[1]][$option[2]];
								}
							}
							else if( isset( $swbignews_options[$option[0]][$option[1]] ) ) {
								$default = $swbignews_options[$option[0]][$option[1]];
							}
						} else if( isset( $swbignews_options[$option] ) ) {
							$default = $swbignews_options[$option];
						}
						if( in_array( $key, $special_keys ) ) {
							$default = str_replace( 'px', '', $default );
						} else if( in_array( $key, $transparent_keys ) ) {
							if( $default =='transparent' ) {
								$default = 1;
							} else {
								$default = '';
							}
						}
						$shw_admin_option_default[$key] = $default;
					}
				}
			}
		}
	}
	public function add_page_metabox() {
		if( class_exists('Swbignews') ) {
			$active_demo = Swbignews::get_config( 'demo_template', 'active' );
			if( $active_demo ) {
				add_meta_box( 'shw_mbox_pagedemo_setting', 'Page Demo Setting', array( 'SwlabsCore', '[page.Page_Controller, meta_box_demo]' ), 'page', 'normal', 'low' );
			}
			$post_types = SwlabsCore::get_config( 'page_options', 'post_types');
			foreach( $post_types as $post_type ) {
				if($post_type == 'post') continue;
				add_meta_box( 'shw_mbox_page_setting', 'Page Setting', array( 'SwlabsCore', '[page.Page_Controller, meta_box_setting]' ), $post_type, 'normal', 'low' );
			}
		}
	}
	public function save() {
		global $post;
		$post_id = $post->ID;
		parent::save();
		// save page options start
		if( class_exists( 'Swbignews' )) {
			$maps = Swbignews::get_config( 'mapping', 'options' );
			$no_default = Swbignews::get_config( 'mapping', 'no-default-options' );
			foreach($maps as $k=>$v) {
				$is_default = $k .'_default';
				if( ( !isset($_POST['shw_page_options'][$is_default]) ) ){
					$_POST['shw_page_options'][$is_default] = '';
				}
			}
		}
		update_post_meta( $post_id, 'shw_page_options', isset( $_POST['shw_page_options'] ) ? $_POST['shw_page_options'] : '' );
		// save page options end
	}
	
	/**
	 * Setting page
	 */
	public function meta_box_setting() {
		global $post;
		global $shw_admin_option_default;
		$post_id = $post->ID;

		// default
		$bg_repeat = SwlabsCore::get_params( 'background-repeat' );
		$bg_size = SwlabsCore::get_params( 'background-size' );
		$bg_position = SwlabsCore::get_params( 'background-position' );
		$bg_attachment = SwlabsCore::get_params( 'background-attachment' );
		$sidebar_layout = SwlabsCore::get_params( 'sidebar-layout' );

		// get meta
		$page_options = get_post_meta( $post_id, 'shw_page_options', true );

		if( $page_options ) {
			$bg_array = array(
				'background_transparent' => 'background_color',
				'header_background_transparent' => 'header_background_color',
				'pt_background_transparent' => 'pt_background_color'
			);
			foreach($bg_array as $key=>$val ) {
				if( isset($page_options[$key]) && !empty($page_options[$key])) {
					$page_options[$val] = $page_options[$key];
				}
			}
		}
		//echo "<pre>";
		//print_r($shw_admin_option_default);
		//print_r($page_options);
		$params = array(
			'background-repeat'     => $bg_repeat,
			'background-attachment' => $bg_attachment,
			'background-position'   => $bg_position,
			'background-size'       => $bg_size,
			'sidebar_layout'        => $sidebar_layout,
			'category'              => SwlabsCore_Com::get_category2name_array(),
			'regist_sidebars'       => SwlabsCore_Com::get_regist_sidebars(),
			'related_post'          => SwlabsCore::get_params( 'related_post_show' ),
		);
		$this->parse_image($params, $page_options, $shw_admin_option_default );
		$this->render( 'setting', array(
			'params' => $params,
			'defaults' => $shw_admin_option_default,
			'page_options' => $page_options, 

		));
	}
	private function parse_image( &$params, $page_options, $default_options ) {
		$image_id_keys = array(
			'bg_image'       => array('background_image', 'background_image_id', 'general_default' ),
		);
		foreach( $image_id_keys as $img_key => $img_val ) {
			$attachment = array ( 'id' => '', 'url' => '', 'class' => '' );
			
			$attachment['url'] = $this->get_field( $page_options, $img_val[0], $default_options );
			if( empty( $attachment['url'] ) ) {
				$attachment['class'] = 'hide';
			}
			$default_check = $this->get_field( $page_options, $img_val[2], $default_options );
			if( $default_check == '1') {
				$thumb_id = $this->get_field( $default_options, $img_val[1] );
			} else {
				$thumb_id = $this->get_field( $page_options, $img_val[1], $default_options );
			}
			
			if( ! empty( $thumb_id )) {
				$attachment_image = wp_get_attachment_image_src($thumb_id, 'full');
				$attachment = array ( 'id' => $thumb_id, 'url' => $attachment_image[0], 'class' => '' );
			}
			$params[$img_key] = $attachment;
		}
	}
}