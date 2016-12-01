<?php
/**
 * Controller Shortcode class.
 *
 * @since 1.0
 */

SwlabsCore::load_class('Abstract');

class SwlabsCore_Shortcode_Controller extends SwlabsCore_Abstract {

	
	public function module( $atts, $content = null ) {
		if( ! empty( $atts['cl'] ) && ! empty( $atts['mt'] ) ) {
			if( SwlabsCore::load_class( $atts['cl'] ) ) {
				return SwlabsCore::new_object( $atts['cl'] )->{$atts['mt']}( $atts, $content );
			}
		}
	}
	/**
	 * tab
	 */
	public function tab( $atts ,$content = null) {
		$params = array(
			'style' => '01',
			'extra_class' => '',
			);
		if( function_exists( 'wpb_js_remove_wpautop' ) ) {
			$content = wpb_js_remove_wpautop( $content, true );
		}
		$data_arr = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data_arr['id'] = SwlabsCore::make_id();
		$data_arr['content'] = $content;
		return $this->render( 'tab', $data_arr, true );
		}
	/**
	 * tab
	 */
	public function block_info( $atts ,$content = null) {
		$params = array(
			'title'       => '',
			'content'     => '',
			'extra_class' => '',
			);
		if( function_exists( 'wpb_js_remove_wpautop' ) ) {
			$content = wpb_js_remove_wpautop( $content, true );
		}
		$data_arr = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data_arr['id'] = SwlabsCore::make_id();
		$data_arr['content'] = $content;
		return $this->render( 'block_info', $data_arr, true );
	}
	/**
	 * Accordion
	 */
	public function accordion( $atts ,$content = null) {
		$default = array(
			'layout'		=> '01',
			'extra_class'	=> ''
		);
		if( function_exists( 'wpb_js_remove_wpautop' ) ) {
			$content = wpb_js_remove_wpautop( $content, true );
		}
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		$data['content'] = $content;
		return $this->render( 'accordion', $data, true );
	}
	/**
	 * Item list
	 */
	public function item_list( $atts ) {
		$params = array(
			'list_item' => '',
			'extra_class' => '',
			'style' => '01',
			'icon_bg_color' =>'',
			'icon_color' => '',
			);
		$data_arr = SwlabsCore::set_shortcode_defaults( $params, $atts);
		extract( $data_arr );
		$values = (array) SwlabsCore::parse_atts( $list_item  );
		$data_arr['data'] = $values;
		$data_arr['id'] = SwlabsCore::make_id();
		return $this->render( 'item_list', $data_arr , true );
	}
	/**
	 * Block Title
	 */
	public function block_title( $atts ) {
		$params=array( 
			'title' => '',
			'extra_class' => '',
			'title_color' => '',
			'show_line' => '',
			'line_color' => '',
			'line_height' => '',
			'line_width' => ''
		);
		$data_arr = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data_arr['id'] = SwlabsCore::make_id();
		return $this->render( 'block_title', $data_arr, true );
	}
	/**
	 * Grid post 1
	 */
	public function grid_1( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'grid-01',
			'limit_post'			=> '5',
			'style'					=> '',
			'column'				=> '2',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'grid_1', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Grid Post 2
	 */
	public function grid_2( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'grid-02',
			'limit_post'			=> '6',
			'column'				=> '2',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'block_hover_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'pagination'            => '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'grid_2', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Grid Post 3
	 */
	public function grid_3( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'grid-03',
			'style'					=> '',
			'limit_post'			=> '8',
			'column'				=> '3',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'pagination'			=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'grid_3', array( 'atts' => $data, 'content' => $content ), true );
	}
	
	/**
	 * Grid Post 4
	 */
	public function grid_4( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'grid-04',
			'limit_post'			=> '8',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'grid_4', array( 'atts' => $data, 'content' => $content ), true );
	}
	
	/**
	 * Block Post 1
	 */
	public function block_1( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-01',
			'limit_post'			=> '4',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'block_hover_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'show_excerpt'			=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'  => Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_1', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 2
	 */
	public function block_2( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-02',
			'style'					=> '',
			'limit_post'			=> '4',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'show_excerpt'			=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'  => Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_2', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 3
	 */
	public function block_3( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-03',
			'style'					=> '',
			'limit_post'			=> '5',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_3', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 4
	 */
	public function block_4( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-04',
			'style'					=> '',
			'limit_post'			=> '6',
			'column'				=> '2',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_4', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	* Block Post 5
	*/
	public function block_5( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-05',
			'limit_post'			=> '5',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'showexcerpt'			=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_5', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 6
	 */
	public function block_6( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-06',
			'limit_post'			=> '4',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text' => Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_6', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 7
	 */
	public function block_7( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-07',
			'style'					=> '',
			'limit_post'			=> '8',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'show_excerpt'			=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text' => Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_7', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 8
	 */
	public function block_8( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-08',
			'style'					=> '',
			'showexceprt'			=> '',
			'limit_post'			=> '4',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'show_excerpt'			=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text' => Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_8', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 9
	 */
	public function block_9( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-09',
			'style'					=> '',
			'limit_post'			=> '5',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_9', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 10
	 */
	public function block_10( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-10',
			'limit_post'			=> '3',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text' => Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_10', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Post 11
	 */
	public function block_11( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-11',
			'limit_post'			=> '8',
			'column'				=> '4',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_11', array( 'atts' => $data, 'content' => $content ), true );
	}
	
	/**
	 * Block Carousel 1
	 */
	public function block_carousel_1( $atts, $content = null ) {
		$default = array(
			'layout'				=>'block-carousel-01',
			'limit_post'			=> '4',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
			'post_filter_by'		=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_carousel_1', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Carousel 2
	 */
	public function block_carousel_2( $atts, $content = null ) {
		$default = array(
			'layout'               =>'block-carousel-02',
			'limit_post'           => '10',
			'column'               => '1',
			'block_title'          => '',
			'block_title_color'    => '',
			'block_hover_color'    => '',
			'offset_post'          => '0',
			'sort_by'              => '',
			'extra_class'          => '',
			'category_list'        => '',
			'tag_list'             => '',
			'author_list'          => '',
			'show_excerpt'         => '',
			'show_meta'            => '',
			'post_filter_by'       => '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_carousel_2', array( 'atts' => $data, 'content' => $content ), true );
	}

	/**
	 * Block Carousel 3
	 */
	public function block_carousel_3( $atts, $content = null ) {
		$default = array(
			'layout'				=>'block-carousel-03',
			'limit_post'			=> '5',
			'block_title'			=> '',
			'block_title_color'		=> '', 
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'left_block_title'		=> '',
			'show_category_tab'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_carousel_3', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Carousel 4
	 */
	public function block_carousel_4( $atts, $content = null ) {
		$default = array(
			'layout'				=>'block-carousel-04',
			'limit_post'			=> '4',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'block_hover_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
			'show_excerpt'			=> '',
			'show_meta'				=> '',
			'post_filter_by'		=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_carousel_4', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Block Carousel 5
	 */
	public function block_carousel_5( $atts, $content = null ) {
		$default = array(
			'layout'				=>'block-carousel-05',
			'limit_post'			=> '5',
			'column'				=> '1',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts );
		return $this->render( 'block_carousel_5', array( 'atts' => $data, 'content' => $content ), true );
	}
	/*Ajax get post in block 14*/
	function ajax_get_load_post(){
		$atts = $_POST['params'][0]['data'];  
		$default = array(
			'layout'				=>'block-carousel-03',
			'limit_post'			=> '5',
			'block_title'			=> '',
			'block_title_color'		=> '', 
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'pagination'			=> '',
			'category_filter'		=> '',
			'left_block_title'		=> '',
			'show_category_tab'		=> '',
			'category_filter_text'	=> Swbignews_Translate::_swt('All'),
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts ); 
		$data['load_ajax']   = '1';
		echo ( $this->render( 'block_carousel_3', array( 'atts' => $data, 'content' => null ), true ) );
		exit;
	}

	/**
	 * Video list
	 */
	public function video_list( $atts, $content = null  ) {
		$params = array( 
			'layout'				=> 'video-list',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'limit_post'			=> '6',
			'pagination'			=> '',
			'offset_post'			=> '',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data_arr = SwlabsCore::set_shortcode_defaults( $params, $atts); 
		return $this->render( 'video_list', array( 'atts' => $data_arr, 'content' => $content ), true );
	}
	
	public function block_slider_1( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-slider-01',
			'style'					=> '',
			'limit_post'			=> '4',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
			'block_hover_color'		=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_slider_1', array( 'atts' => $data, 'content' => $content ), true );
	}
	public function block_slider_2( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-slider-02',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'limit_post'			=> '2',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_slider_2', array( 'atts' => $data, 'content' => $content ), true );
	}
	public function block_slider_3( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'block-slider-03',
			'limit_post'			=> '4',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'block_slider_3', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Livescore
	 */
	 public function livescore( $atts, $content = null ) {
		$params=array(
			'block_title'				=> 'Football LiveScores', 
			'extra_class'				=> '',
			'block_title_color'			=> '',
			'leagues_list'				=> '',
		);  
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data['id'] = SwlabsCore::make_id(); 
		return $this->render( 'livescore', array('atts' => $data, 'content' => $content), true );
	}
	/*Ajax get post in live score*/
	function ajax_get_load_livescore(){
		$atts = $_POST['params'][0];  
		$params=array(
			'block_title'			=> 'Football LiveScores', 
			'extra_class'			=> '',
			'block_hover_color'		=> '',
			'leagues_list'			=> '',
			'loading_table'			=>  'show',
		);  
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts['data']);

		$data['loading_table'] = 'show';  
		$data['id'] = $atts['indexId'];  
		if (isset($atts['type']) && !empty($atts['type'])) {
			$data['type'] = $atts['type'];  
		}
		 
		echo ( $this->render( 'livescore', array( 'atts' => $data, 'content' => null ), true ) );
		exit;
	}
	
	/**
	 * Author
	 */
	public function author( $atts, $content = null ) {
		$params=array( 
			'block_title' => 'LIST AUTHOR OF US',
			'block_title_color' => '#333333',
			'order_by' => '',
			'author_list' => '',
			'pagination' => '',
			'limit_post' => '',
			'extra_class' => '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts);
		if(isset($atts['author_list'])){
			$author_list = (array) vc_param_group_parse_atts( $atts['author_list'] );
			$data['author_list'] = $author_list;
		}
		$data['id'] = SwlabsCore::make_id();
		return $this->render( 'author', $data, true );
	}
	function ajax_get_more_news(){
		$atts = $_POST['params'][0]['atts'];
		$block =  $_POST['params'][0]['block'];
	 
		if(isset($_POST['params'][0]['page'])){
			$page = $_POST['params'][0]['page'];
			$atts['paged'] = $page;
		}
		else{
			if(empty($atts['cur_limit'])){
				$atts['cur_limit'] = $atts['limit_post'];
			}
			$atts['cur_limit'] += intval($atts['limit_post']);
		}  
		$block = str_replace(array('-0','-'), '_', $block); 
		echo ( $this->render(  $block, array( 'atts' => $atts, 'content' => null ), true ) );
		exit;
	}
	/*Ajax get post in grid 5*/
	function ajax_get_load_grid_5(){
		$atts = $_POST['params'][0];  
		$default = array(
			'layout'				=> 'grid-02',
			'limit_post'			=> '6',
			'column'				=> '2',
			'block_title'			=> '',
			'block_title_color'		=> '',
			'block_hover_color'		=> '',
			'block-class'			=> '',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'pagination'			=> '',
			'author_list'			=> '',
			's'						=> '',
		);
		
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts['tab']);
		$data['paged'] = $atts['paged'];
		$data['active'] = $atts['active'];
		$data['load_ajax'] = '1';
		echo ( $this->render( 'grid_2', array( 'atts' => $data, 'content' => null ), true ) );
		exit;
	}
	function ajax_get_post_by_category(){
		$atts = $_POST['params'][0]['atts'];
		$block = intval($_POST['params'][0]['block']);
		$category = $_POST['params'][0]['cat'];
		$all_tab = isset($_POST['params'][0]['all_tab']) ? true : false;
		if(isset($_POST['params'][0]['page'])){
			set_query_var( "paged", $_POST['params'][0]['page']);
		}
		if($atts['category_filter'] == 'author'){
			if($all_tab)
				$atts['author'] = '';
			else
				$atts['author'] = $category;
		}
		else if($atts['category_filter'] == 'category'){
			if($all_tab)
				$atts['category_slug'] = '';
			else
				$atts['category_slug'] = $category;
		}
		else if($atts['category_filter'] == 'tag_slug'){
			if($all_tab)
				$atts['tag_slug'] = '';
			else
				$atts['tag_slug'] = $category;
		}
		if(get_query_var('paged'))
			$atts['paged'] = get_query_var('paged');
		echo ( $this->render( 'block_'.$block, array( 'atts' => $atts, 'content' => null ), true ) );
		exit;
	}
	/**
	 * Survey
	 */
	public function survey( $atts, $content = null ) {
		$params=array(
			'survey'		=> '',
			'extra_class'	=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data['id'] = SwlabsCore::make_id();
		return $this->render( 'survey', $data, true );
	}
	/**
	 * Social Counter
	 */
	public function social_counter( $atts, $content = null ) {
		$params=array(
			'title'			=> 'SOCIAL CONNECTED',
			'color'			=> '',
			'facebook'		=> '',
			'twitter'		=> '',
			'youtube'		=> '',
			'vimeo'			=> '',
			'google'		=> '',
			'instagram'		=> '',
			'soundcloud'	=> '',
			'rss'			=> '',
			'extra_class'	=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data['id'] = SwlabsCore::make_id();
		return $this->render( 'social_counter', array('atts' => $data), true );
	}
	public function masonry( $atts, $content = null ) {
		$default = array(
			'layout'				=> 'masonry',
			'limit_post'			=> '7',
			'offset_post'			=> '0',
			'sort_by'				=> '',
			'extra_class'			=> '',
			'category_list'			=> '',
			'tag_list'				=> '',
			'author_list'			=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		return $this->render( 'masonry', array( 'atts' => $data, 'content' => $content ), true );
	}
	/**
	 * Advertisement
	 */
	 public function advertisement( $atts, $content = null ) {
		$params=array(
			'advertisement'	=> 'header',
			'extra_class'	=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data['id'] = SwlabsCore::make_id();
		return $this->render( 'advertisement', $data, true );
	}
	/**
	 * Weather
	 */
	 public function weather( $atts, $content = null ) {
		$params=array(
			'title'			=> 'Weather',
			'color'			=> '',
			'location'		=> '',
			'extra_class'	=> '',
		);
		$data = SwlabsCore::set_shortcode_defaults( $params, $atts);
		$data['id'] = SwlabsCore::make_id();
		return $this->render( 'weather', $data, true );
	}
	
	/**
	 * Categories
	 */
	public function categories( $atts, $content = null ) {
		$default = array(
			'title'				=> '',
			'category_list'		=> '',
			'extra_class'		=> ''
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		if(isset($atts['category_list'])){
			$category_list = (array) vc_param_group_parse_atts( $atts['category_list'] );
			$data['category_list'] = $category_list;
		}
		$data['id'] = SwlabsCore::make_id();
		return $this->render( 'categories', array( 'atts' => $data, 'content' => $content ), true );
	}
}