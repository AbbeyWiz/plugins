<?php
SwlabsCore::load_class( 'models.Blog_Model' );

class SwlabsCore_Block extends SwlabsCore_Blog_Model {

	public $large_image_post = true;
	public $start_group = true;
	private $row_post_counter = 0;
	private $row_counter;
	private $post_counter = 0;
	private $block_atts;
	
	public function init( $atts, $content = null ) {
		// default
		$this->large_image_post = true;
		$this->start_group = true;
		$this->row_post_counter = 0;
		$this->row_counter = 1;
		$this->post_counter = 0;

		// set attributes
		$atts['content'] = $content;
		$atts = $this->get_block_setting($atts);
		$this->block_atts = $atts;
		$this->set_attributes( $atts );
		$this->block_atts['block-class'] = $this->attributes['block-class'];

		$this->get_thumb_size();
		$this->set_responsive_class($atts);
		
		// add inline css
		$custom_css = $this->add_custom_css();
		if( $custom_css ) {
			do_action( 'swlabscore_add_inline_style', $custom_css ); 
		}
	}
	public function set_post_options_defaults( $atts ) {
		$default = array(
			'large_post_format' => '',
			'small_post_format' => '',
			'open_group'        => '',
			'open_row'          => '',
			'close_row'         => '',
			'close_group'       => '',
			'content_length'    => '',
			'large_post_counter'=> '',
			'show_related_post' => '',
			'new_row'           => '1',
			'thumb_href_class'  => 'media-image',
		);
		foreach($default as $key => $val ) {
			if( isset( $atts[$key] ) ) {
				$default[$key] = $atts[$key];
				unset( $atts[$key] );
			}
		}
		if( $atts ) {
			foreach($atts as $key => $val ) {
				$default[$key] = $atts[$key];
			}
		}
		return $default;
	}
	public function set_responsive_class($atts) {
		$class = '';
		$column = $this->attributes['column'];
		if( isset($atts['res_class']) ) {
			$class = $atts['res_class'];
		}
		$def = array(
			'1' => 'col-sm-12',
			'2' => 'col-sm-6 ' . $class,
			'3' => 'col-sm-4 col-xs-12',
			'4' => 'col-sm-3',
		);;
		
		if( $column && isset($def[$column])) {
			$this->attributes['responsive-class'] = $def[$column];
		} else {
			$this->attributes['responsive-class'] = $def['1'];
		}
	}
	/**
	 * Render html to shortcode
	 *
	 */
	public function render_sc( $options = array() ) {
		while ( $this->query->have_posts() ) {
			$this->query->the_post();
			$this->loop_index();
			$related_post = '';
			$options = $this->set_post_options_defaults( $options );
			// render post
			$html_format = $options['large_post_format'];
			if( isset($options['show_related_post']) && $options['show_related_post'] ) {
				$related_post = $this->get_related_post($this->attributes['related_post_count']);
			}
			printf( $html_format,
					$this->get_featured_image(),
					$this->get_title(),
					$this->get_meta(),
					$related_post,
					$this->get_excerpt(),
					$this->get_post_class(),
					$this->get_meta_2()
			);
		}// end while
		//paging
		if( $this->attributes['pagination'] == 'yes' ) {
			printf('<div class="row col-md-12" >%s</div>', $this->paging_nav( $this->query->max_num_pages, 2, $this->query) );
		}
		// reset query
		wp_reset_postdata();
	}
	public function render_block( $options = array() ) {
		$exclude = array();
		$options = $this->set_post_options_defaults( $options );
		$is_close_group = false;
		while ( $this->query->have_posts() ) { 
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			$related_post = '';
			$limit_content = true;
			// render post
			$html_format = $options['small_post_format']; 
			if( $this->large_image_post ) {
				// large image group
				if( empty($options['large_post_counter']) || 
					( !empty($options['large_post_counter']) && $options['large_post_counter'] == $this->post_counter ) ) {
						$this->large_image_post = false;
				}
				$type = 'large';
				if( $this->attributes['show_related'] != 'hide' ) {
					$related_post = $this->get_related_post($this->attributes['related_post_count']);
				}
				$html_format = $options['large_post_format'];
				if( isset($options['large_limit_content']) ) {
					$limit_content = true;
				} else {
					$limit_content = false;
				}
				if( isset($options['large_thumb_href_class'] ) ) {
					$options['thumb_href_class'] = $options['large_thumb_href_class'];
				}
				if( isset($options['large_title_class'])) {
					$options['title_class'] = $options['large_title_class'];
				}
			} else {
				if( isset($options['small_thumb_href_class'] ) ) {
					$options['thumb_href_class'] = $options['small_thumb_href_class'];
				}
				unset($options['title_class']);
				if( isset($options['small_title_class'])) {
					$options['title_class'] = $options['small_title_class'];
				}
				// small image group
				$type = 'small';
				if( $this->start_group ) {
					echo ( $options['open_group'] . $options['open_row'] );
					$is_close_group = true;
					$this->start_group = false;
				}
				$this->row_post_counter ++;
			}
			if( $options['new_row'] && $this->attributes['column'] > 1 && $this->row_post_counter > $this->attributes['column'] ) {
				// add new row
				$this->row_counter ++;
				$this->row_post_counter = 1;
				echo ( $options['close_row'] . $options['open_row'] );
			}
			printf( $html_format,
					$this->get_featured_image( $type, false, $options ),
					$this->get_title(true, false, $options ),
					$this->get_meta(),
					$related_post,
					$this->get_excerpt( $limit_content ),
					$this->get_post_class(),
					$this->attributes['responsive-class']
			);
		}// end while
		if( $is_close_group ) {
			echo ( $options['close_row'] . $options['close_group'] );
		}
		if( isset($options['close_block']) && !empty($options['close_block']) ) {
			echo ( $options['close_block'] );
		}
		//paging
		if( $this->attributes['pagination'] == 'yes' ) {
			printf('<div class="clearfix" >%s</div>', $this->paging_nav( $this->query->max_num_pages, 2, $this->query) );
		}
		else if( $this->attributes['pagination'] == 'ajax' ) {
			printf('<div class="clearfix" >%s</div>', $this->paging_ajax( $this->query->max_num_pages, 2, $this->query) );
		}
		else if( $this->attributes['pagination'] == 'load_more' ) {
			$atts = $this->block_atts;
			printf('<div class="pagination-box clearfix" ><input type="hidden" name="block_atts" class="block_atts" value="%s"/><button class="btn btn-block btn-lg btn-primary text-uppercase pagination_with_load_more">%s</button></div>', esc_attr(json_encode($atts)), Swbignews_Translate::_swt('load more') );
		}
		// reset query
		wp_reset_postdata();
	}

	public function render_videos( $options = array(), $typess = false ) {
		$exclude = array();
		$options = $this->set_post_options_defaults( $options );
		$index = -1;
		$counts = $this->query->post_count;
		$is_close_group = false;
		while ( $this->query->have_posts() ) {
			$index++;
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			$related_post = '';
			$limit_content = true;
			// render post
			$html_format = $options['small_post_format'];
			if( $this->large_image_post ) {
				// large image group
				if( empty($options['large_post_counter']) || 
					( !empty($options['large_post_counter']) && $options['large_post_counter'] == $this->post_counter ) ) {
						$this->large_image_post = false;
				}
				$type = 'large';
				$related_post = $this->get_related_post($this->attributes['related_post_count']);
				$html_format = $options['large_post_format'];
				$limit_content = false;
				if( isset($options['large_thumb_href_class'] ) ) {
					$options['thumb_href_class'] = $options['large_thumb_href_class'];
				}
				if( isset($options['large_title_class'])) {
					$options['title_class'] = $options['large_title_class'];
				}
			} else {
				if( isset($options['small_thumb_href_class'] ) ) {
					$options['thumb_href_class'] = $options['small_thumb_href_class'];
				}
				unset($options['title_class']);
				if( isset($options['small_title_class'])) {
					$options['title_class'] = $options['small_title_class'];
				}
				// small image group
				$type = 'small';
				if( $this->start_group ) {
					echo ( $options['open_group'] . $options['open_row'] );
					$this->start_group = false;
					$is_close_group = true;
				}
				$this->row_post_counter ++;
			}
			if( $options['new_row'] && $this->attributes['column'] > 1 && $this->row_post_counter > $this->attributes['column'] ) {
				// add new row
				$this->row_counter ++;
				$this->row_post_counter = 1;
				echo ( $options['close_row'] . $options['open_row'] );
			}
			$video_option = get_post_meta( get_the_ID() ,'shw_post_options',true );
			$video_type = SwlabsCore::get_value( $video_option, 'video_type');
			$youtube_id = SwlabsCore::get_value( $video_option, 'youtube_id');
			$vimeo_id = SwlabsCore::get_value( $video_option, 'vimeo_id');
			$link_upload = SwlabsCore::get_value( $video_option, 'upload_video');
			if ($typess) {
				if ($index == 0 || $index%2 == 0) {
				$html_format = '<div class="row" >'.$html_format;
				}
				if ( $index%2 == 1 || $index == ($counts - 1)) {
					$html_format = $html_format.'</div>';
				}
			}
			
			
			printf( $html_format,
					$this->get_video( $video_type , $youtube_id, $vimeo_id , $link_upload ),
					$this->get_featured_image( $type, false, $options ),
					$this->get_title(true, false, $options ),
					$this->get_meta(),
					$related_post,
					$this->get_excerpt( $limit_content ),
					$this->get_post_class(),
					$this->attributes['responsive-class'],
					$index
			);
		}// end while
		if( $is_close_group ) {
			echo ( $options['close_row'] . $options['close_group'] );
		}
		if ($typess) {
		//paging
			if( $this->attributes['pagination'] == 'ajax' ) {
				printf('<div class="" >%s</div>', $this->paging_ajax( $this->query->max_num_pages, 2, $this->query) );
			}
		}
		// reset query
		wp_reset_postdata();
	}
	public function render_grid( $options = array() ) {
		$is_close_group = false;
		while ( $this->query->have_posts() ) {
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			$options = $this->set_post_options_defaults( $options );
			// render post
			$small_grp_class = '';
			$html_format = $options['small_post_format'];
			if( $this->large_image_post ) {
				// large image group
				if( empty($options['large_post_counter']) || 
					( !empty($options['large_post_counter']) && $options['large_post_counter'] == $this->post_counter ) ) {
						$this->large_image_post = false;
				}
				$type = 'large';
				$html_format = $options['large_post_format'];
			} else {
				// small image group
				$type = 'small';
				if( $this->start_group ) {
					echo ( $options['open_group'] . $options['open_row'] );
					$is_close_group = true;
					$this->start_group = false;
				}
				$this->row_post_counter ++;
			}
			if( $options['new_row'] && $this->attributes['column'] > 1 && $this->row_post_counter > $this->attributes['column'] ) {
				// add new row
				$this->row_counter ++;
				$this->row_post_counter = 1;
				echo ( $options['close_row'] . $options['open_row'] );
			}
			if( isset($options['small-group-class'][$this->row_counter]) ) {
				$small_grp_class = $options['small-group-class'][$this->row_counter];
			}
			printf( $html_format,
					$this->get_featured_image( $type, false, $options ),
					$this->get_title(),
					$this->get_meta(),
					$this->get_post_class(),
					$this->attributes['responsive-class'],
					$small_grp_class,
					$this->get_excerpt($type, false),
					$this->get_meta_2() ,
					$this->get_category()
			);
			 
		}// end while
		if( $is_close_group ) {
			echo ( $options['close_row'] . $options['close_group'] );
		}

		//pagination
		if( $this->attributes['pagination'] == 'ajax' ) {
			printf('<div class="" >%s</div>', $this->paging_ajax( $this->query->max_num_pages, 2, $this->query) );
		}
		// reset query
		wp_reset_postdata();
	}
	public function render_category_grid( $options = array() ) {
		$is_close_group = false;
		$i = 0;
		while ( $this->query->have_posts() ) {
			$i++;
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			$options = $this->set_post_options_defaults( $options );
			// render post
			$small_grp_class = '';
			$html_format = $options['small_post_format'];
			if( $this->large_image_post ) {
				// large image group
				if( empty($options['large_post_counter']) || 
					( !empty($options['large_post_counter']) && $options['large_post_counter'] == $this->post_counter ) ) {
						$this->large_image_post = false;
				}
				$type = 'large';
				$html_format = $options['large_post_format'];
			} else {
				// small image group
				$type = 'small';
				if( $this->start_group ) {
					echo ( $options['open_group'] . $options['open_row'] );
					$is_close_group = true;
					$this->start_group = false;
				}
				$this->row_post_counter ++;
			}
			if( $options['new_row'] && $this->attributes['column'] > 1 && $this->row_post_counter > $this->attributes['column'] ) {
				// add new row
				$this->row_counter ++;
				$this->row_post_counter = 1;
				echo ( $options['close_row'] . $options['open_row'] );
			}
			if( isset($options['small-group-class'][$this->row_counter]) ) {
				$small_grp_class = $options['small-group-class'][$this->row_counter];
			}
			printf( $html_format,
					$this->get_featured_image( $type, false, $options ),
					$this->get_title(),
					$this->get_meta(),
					$this->get_post_class(),
					$this->attributes['responsive-class'],
					$small_grp_class,
					$this->get_excerpt($type, false),
					$this->get_meta_2() ,
					$this->get_category()
			);
			 
		}// end while

		$paged = ( !empty( $_GET['page'] ) ) ? absint( $_GET['page'] ) : 1;
		$i = $i * $paged;

		if( !empty( $options['min_post'] ) && $i < $options['min_post'] ){
			if($i > 0) {
				$html_format = $options['default_post_format'];
				$type = 'small';
			}

			for($a = 0; $a < $options['min_post'] - $i; $a++) {
				printf( $html_format,
					'<img width="600" height="470" src="' . esc_url($options['default_image']) . '" class="img-responsive" alt="default" />',
					'',
					'',
					$this->get_post_class(),
					$this->attributes['responsive-class'],
					$small_grp_class,
					'',
					'' ,
					''
				);
			}
		}
		if( $is_close_group ) {
			echo ( $options['close_row'] . $options['close_group'] );
		}

		//pagination
		if( $this->attributes['pagination'] == 'ajax' ) {
			printf('<div class="" >%s</div>', $this->paging_ajax( $this->query->max_num_pages, 2, $this->query) );
		}

		if( $this->attributes['pagination'] == 'custom' ) {
			if(empty($_GET['tt'])){
				$tt = $this->query->max_num_pages;
			} else {
				$tt = absint( $_GET['tt'] );
				$this->query->max_num_pages = $tt;
			}

			$paged = ( !empty( $_GET['page'] ) ) ? absint( $_GET['page'] ) : 1;
			printf('<div class="clearfix" >%s</div>', $this->paging_custom( $paged, $this->query, true, $tt) );
		}

		// reset query
		wp_reset_postdata();
	}
	public function render_masonry_sc( $options = array() ) {
		$html_format = $options['large_post_format'];
		while ( $this->query->have_posts() ) {
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			$related_post = '';
			// render post
			$masonry_class = $this->get_masonry_class_item( $this->post_counter );
			printf( $html_format,
					$this->get_featured_image('large', false, array('thumb_href_class' => 'img') ),
					$this->get_title(),
					$this->get_meta(),
					$related_post,
					$this->get_excerpt(),
					$this->get_post_class($masonry_class)
			);
		}// end while
		// reset query
		wp_reset_postdata();
		if( $this->post_counter < $this->attributes['limit_post'] ) {
			for( $i = $this->post_counter+1; $i <= $this->attributes['limit_post']; $i++ ) {
				$masonry_class = $this->get_masonry_class_item( $i );
				printf( $html_format,
						'',
						'',
						'',
						'',
						'',
						$masonry_class
				);
			}
		}
		
	}
	private function get_masonry_class_item( $index ) {
		$class_item = '';
		$thumb_size = SWLABSCORE_THEME_PREFIX . '-thumb-600x600';
		if( $index == 1) {
			$thumb_size = SWLABSCORE_THEME_PREFIX . '-thumb-600x450';
			$class_item = 'item-size item-width-2 ' . $index;
		} else if ( $index == 2 ) {
			$class_item = 'item-width-2 item-height-2 ' . $index;
		} else if( $index == 7 ) {
			$thumb_size = SWLABSCORE_THEME_PREFIX . '-thumb-600x450';
			$class_item = 'item-width-2 ' . $index;
		} else {
			$class_item = 'item-width-1 ' . $index;
		}
		$this->attributes['thumb-size']['large'] = $thumb_size;
		return $class_item;
	}

	public function get_meta( $seperate = '' ) {
		if( $this->attributes['show_meta'] == 'hide' ) {
			return '';
		}
		$meta_array = array(
			'category' => $this->get_category(),
			'date'     => $this->get_date(),
			'author'   => $this->get_author(),
			'view'     => $this->get_views(),
			'comment'  => $this->get_comments(),
		);
		foreach( $meta_array as $key => $val ) {
			if( empty( $val ) ) {
				unset($meta_array[$key]);
			}
		}
		return implode( $seperate, $meta_array );
	}

	public function get_meta_2( $seperate = '' ) {
		if( $this->attributes['show_meta'] == 'hide' ) {
			return '';
		}
		$meta_array = array(
			'category' => $this->get_author(),
			'date'     => $this->get_date(),
		); 
		foreach( $meta_array as $key => $val ) {
			if( empty( $val ) ) {
				unset($meta_array[$key]);
			}
		}
		return implode( $seperate, $meta_array );
	}

	public function add_custom_css() {
		$css = '';
		if( $this->attributes['block_title_color'] ) {
			$css .= sprintf('.%s .block-title { color: %s;}', $this->attributes['block-class'], $this->attributes['block_title_color']);
			$css .= sprintf('.%s .section-name { border-color: %s;}', $this->attributes['block-class'], $this->attributes['block_title_color']);
		}
		return $css;
	}
	private function get_thumb_size() {
		$params = SwlabsCore::get_params( 'block-image-size', $this->attributes['layout'] );
		$this->attributes['thumb-size'] = SwlabsCore_Util::get_thumb_size( $params, $this->attributes );
	}
	private function get_block_setting( $atts ) {
		$displays = array(
			'show_category'        => '',
			'show_tag'             => '',
			'show_comment'         => '',
			'show_views'           => '',
			'show_date'            => '',
			'show_author'          => '',
			'show_excerpt'         => '',
			'show_meta'            => '',
			'content_length'       => '',
			'title_length'         => '',
		);
		$displays['layout'] = $atts['layout'];
		if( function_exists('swbignews_get_block_options')){
			swbignews_get_block_options( $displays );
		}
		foreach( $displays as $key => $val ) {
			if( ! isset($atts[$key]) ) {
				$atts[$key] = $displays[$key];
			} else if( ($atts[$key] == 'no' || $atts[$key] == 'hide') ) {
				$atts[$key] = 'hide';
			}
		}
		return $atts;
	}

	public function pagin_nav($page = '',$query = '' ,$show  = false) {
		$max_num_pages = $query->max_num_pages;
		$paged = ( $page !== null ) ? absint( $page  ) : 1;
		$paginate = paginate_links( array (
			'base'      => '%_%',
			'type'      => 'array',
			'total'     => $max_num_pages,
			'format'    => '?page=%#%',
			'current'   => $paged,
			'end_size'  => 1,
			'mid_size'  => 2,
			'prev_next' => true,
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>'
		) );
		if ( $query->max_num_pages > 1 ) : ?>
		<nav class="pagination-box">
			<ul class="pagination mbn full-width"><?php
			if ( $paged != 1 ):
				echo '<li class="page-num page-num-first"><a href="?page=1"><i class="fa fa-angle-double-left"></i> </a></li>';
			endif;
			foreach ( $paginate as $index => $page ) { 
				echo '<li >' . $page . '</li>';
			}
			if ( $paged != $max_num_pages ):
				echo '<li class="page-num page-num-last"><a href="?page='.$max_num_pages.'"><i class="fa fa-angle-double-right"></i> </a></li>';
			endif; 
			?>
			</ul>
			<?php 
			if ($show) { ?> 
				<div class="result-count">
					<?php echo '<p>' . sprintf( esc_html__('Page %1$s of %2$s ','swlabs-core'), $paged, $max_num_pages) . '</p>' ?>
				</div>
			<?php } ?>
		</nav><?php
		endif;
	}
	public function paging_custom($page = '',$query = '' ,$show  = false, $tt) {
		$max_num_pages = $tt;
		$paged = ( $page !== null ) ? absint( $page  ) : 1;
		$paginate = paginate_links( array (
			'base'      => '%_%',
			'type'      => 'array',
			'total'     => $max_num_pages,
			'format'    => '?page=%#%&tt='.$max_num_pages,
			'current'   => $paged,
			'end_size'  => 1,
			'mid_size'  => 2,
			'prev_next' => true,
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>'
		) );
		if ( $query->max_num_pages > 1 ) : ?>
		<nav class="pagination-box">
			<ul class="pagination mbn full-width"><?php
			if ( $paged != 1 ):
				echo '<li class="page-num page-num-first"><a href="?page=1&tt='.$max_num_pages.'"><i class="fa fa-angle-double-left"></i> </a></li>';
			endif;
			foreach ( $paginate as $index => $page ) { 
				echo '<li >' . $page . '</li>';
			}
			if ( $paged != $max_num_pages ):
				echo '<li class="page-num page-num-last"><a href="?page='.$max_num_pages.'&tt='.$max_num_pages.'"><i class="fa fa-angle-double-right"></i> </a></li>';
			endif; 
			?>
			</ul>
			<?php 
			if ($show) { ?> 
				<div class="result-count">
					<?php echo '<p>' . sprintf( esc_html__('Page %1$s of %2$s ','swlabs-core'), $paged, $max_num_pages) . '</p>' ?>
				</div>
			<?php } ?>
		</nav><?php
		endif;
	}
	public function paging_nav( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;

		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		
		$prev = $paged - 1;
		$next = $paged + 1;
		$showitems = ($range * 2)+1;
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if(is_single()) {
			$method = self::$post_page_link;
		}
		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';
		if( 1 != $pages ) {
			$output_page .= '<ul class="pagination">';
			// first
			if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
				$output_page .= '<li ><a href="'.$method(1).'"><i class="fa fa-angle-double-left" ></i></a></li>';
			}
			// prev
			$output_page .= ($paged > 1 && $showitems < $pages)? '<li><a href="'.$method($prev).'" ><i class="fa fa-angle-left" ></i></a></li>':'';
			if( $paged - $range > 2 ) {
				$output_page .= '<li><a href="'.$method($prev).'">&bull;&bull;&bull;</a></li>';
			}
		
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					$output_page .= ($paged == $i)? '<li class="active"><a href="#">'.$i.'</a></li>':'<li class=""><a href="'.$method($i).'" class="" >'.$i.'</a></li>';
				}
			}
		
			if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
				if( $paged+$range < $pages -1) {
					$output_page .= '<li><a href="'.$method($next).'">&bull;&bull;&bull;</a></li>';
				}
				if( $paged != $pages - $range) {
					$output_page .= '<li class="last"><a href="' . $method($pages) . '"><span>' . $pages . '</span></a></li>';
				}
			}
			$output_page .= ($paged < $pages && $showitems < $pages) ? '<li><a href="'.$method($next).'" ><i class="fa fa-angle-right" ></i></a></li>' :'';
			$output_page .= ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? '<li><a href="'.$method($pages).'"><i class="fa fa-angle-double-right"></i></a></li>':'';
			$output_page .= '</ul>'."\n";

			// Show page of total
			$pages_of_total = sprintf('<span class="result-count">%1$s %2$s %3$s %4$s</span>', esc_html__('Page', 'swlabs-core'), $paged, esc_html__('of', 'swlabs-core'), $pages );
		}
		$output = sprintf('<nav class="pagination-box">%1$s%2$s</nav>', $output_page, $pages_of_total);
		return $output;
	}
	
	// pagination with ajax
	public function paging_ajax( $pages = '', $range = 2, $current_query = '' ) {
		global $paged;
		if( $current_query == '' ) {
			global $paged;
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 1; // only edit this if you want to show more page-links
		$showitems = ($range * 2)+1;
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		$output_page = $output_prev = $output_next = $last = $pages_of_total = '';
		$output_page .= '<input type="hidden" name="block_atts" class="block_atts" value="'.esc_attr(json_encode($this->block_atts)).'"/>';
		if( 1 != $pages ) {
			$output_page .= '<ul class="pagination pagination_with_ajax">';
			// first
			if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
				$output_page .= '<li ><a href="1"><i class="fa fa-angle-double-left" ></i></a></li>';
			}
			// prev
			$output_page .= ($paged > 1 && $showitems < $pages)? '<li><a href="'.$prev.'" ><i class="fa fa-angle-left" ></i></a></li>':'';
			if( $paged - $range > 2 ) {
				$output_page .= '<li><a href="'.$prev.'">&bull;&bull;&bull;</a></li>';
			}
		
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					$output_page .= ($paged == $i)? '<li class="active"><a href="'.$i.'">'.$i.'</a></li>':'<li class=""><a href="'.$i.'" class="" >'.$i.'</a></li>';
				}
			}
		
			if( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) {
				if( $paged+$showitems < $pages +1) {
					$output_page .= '<li><a href="'.$next.'">&bull;&bull;&bull;</a></li>';
				}
			}
			$output_page .= ($paged < $pages && $showitems < $pages) ? '<li><a href="'.$next.'" ><i class="fa fa-angle-right" ></i></a></li>' :'';
			$output_page .= ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? '<li><a href="'.$pages.'"><i class="fa fa-angle-double-right"></i></a></li>':'';
			$output_page .= '</ul>'."\n";

			// Show page of total
			$pages_of_total = sprintf('<span class="result-count">%1$s %2$s %3$s %4$s</span>', Swbignews_Translate::_swt('Page'), $paged, Swbignews_Translate::_swt('of'), $pages );
		}
		$output = sprintf('<nav class="pagination-box clearfix">%1$s%2$s</nav>', $output_page, $pages_of_total);
		return $output;
	}
	
	// render category tabs
	public function render_category_tabs() {
		if($this->attributes['pagination'] == 'yes'){
			return;
		}
		$output = '<input type="hidden" name="cat_block_atts" class="cat_block_atts" value="'.esc_attr(json_encode($this->block_atts)).'"/>';
		$output .= '<ul role="tablist" class="nav nav-tabs style-tabs block_category_tabs droptabs">';
		$tabs = array();
		$slug = array();
		$all_tab = array();
		$slug_name = '';

		if($this->attributes['category_filter'] == 'category'){
			$slug_name = 'category_slug';
			$data = (array) vc_param_group_parse_atts($this->attributes['category_list']);
			foreach($data as $val){
				if(isset($val['category_slug'])) $slug[] = $val['category_slug'];
			}
			$all_tab[$this->attributes['category_list']] = $this->attributes['category_filter_text'];
			$tabs = SwlabsCore_Com::get_tax_options('category', array('slug'=>$slug));
		}
		else if($this->attributes['category_filter'] == 'author'){
			$slug_name = 'author';
			$data = (array) vc_param_group_parse_atts($this->attributes['author_list']);
			foreach($data as $val){
				if(isset($val['author'])) $slug[] = $val['author'];
			}
			$all_tab[$this->attributes['author_list']] = $this->attributes['category_filter_text'];
			$tabs = SwlabsCore_Com::get_user_id2login(array('include'=>$slug));
		}
		else if($this->attributes['category_filter'] == 'tag_slug'){
			$slug_name = 'tag_slug';
			$data = (array) vc_param_group_parse_atts($this->attributes['tag_list']);
			foreach($data as $val){
				if(isset($val['tag_slug'])) $slug[] = $val['tag_slug'];
			}
			$all_tab[$this->attributes['tag_list']] = $this->attributes['category_filter_text'];
			$tabs = SwlabsCore_Com::get_tax_options( 'post_tag', array('slug'=>$slug) );
		}
		
		if(!empty($tabs)){
			$tabs = $all_tab + $tabs;
			$count = 0;
			foreach($tabs as $k=>$v){
				$active_cls = '';
				if(is_array($this->attributes[$slug_name]) && $v == "All") $active_cls = 'class="active"';
				else if($k == $this->attributes[$slug_name]) $active_cls = 'class="active"';
				$count++;
				if($count == 5){
					$output .= '<li class="dropdown">
					<a id="block-tab" data-toggle="dropdown" href="#" aria-controls="block-tab-contents"
					 aria-expanded="false" data-hover="dropdown" class="dropdown-toggle">more 
					 <span class="caret"></span></a>
						<ul id="block-tab-contents" aria-labelledby="block-tab" class="dropdown-menu dropdown-menu-tab">';
				}
				$output .= '<li '.$active_cls.' ><a href="'.esc_attr($k).'">'.esc_attr($v).'</a></li>';
			}
			if($count >= 5) $output .= '</ul></li>';
		}
		$output .= '</ul>';
		
		return print $output;
	}
	//
	public function get_single_video($sort_by){
		$atts = array(
			'layout'               => 'grid-03',
			'limit_post'           => '',
			'column'               => '3',
			'block_title'          => '',
			'block_title_color'    => '',
			'offset_post'          => '0',
			'sort_by'              => '',
			'pagination'           => '',
			'category_filter'      => '',
			'category_filter_text' => Swbignews_Translate::_swt('All'),
			'extra_class'          => '',
			'category_list'        => '',
			'tag_list'             => '',
			'author_list'          => '',
			'post_filter_by'       =>'post_same_format',
		);
		if($sort_by == 'popular'){
			$atts['sort_by'] = 'popular';
		}
		$this->init($atts);
		$this->large_image_post = false;
		if ( $this->query->have_posts() ) :
			echo '<div class="section-content">';
				$html_format = '
					<div class="media">
						<div class="media-body">%1$s%2$s
							<div class="info info-style-1">%3$s</div>
						</div>
					</div>';

				$post_options = array(
						'small_post_format' => '<div class="col-sm-4 style-1">'.$html_format.'</div>',
						'open_row'          => '<div class="layout-media-horizontal row">',
						'close_row'         => '</div>',
					);
				$this->render_block( $post_options );
			echo '</div>';
		endif;
	}
	public function get_video( $category, $youtube_id, $vimeo_id, $upload_video ){
		$item = '';
		if ( $category == 'youtube' ){
			$item = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.esc_attr( $youtube_id ).'" allowfullscreen ></iframe> ';
		}else if( $category == 'vimeo' ){
			$item ='<iframe width="560" height="315" src="https://player.vimeo.com/video/'.esc_attr( $vimeo_id ).'?'.'" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}else{
			if ( filter_var( $upload_video, FILTER_VALIDATE_URL ) ){
				if( is_array( getimagesize( $upload_video ) ) ){
					$item = '<img class="img-video-related" alt="" src="'.  esc_url( $upload_video ).'" />';
				}
				else {
					$item = '<video controls >
								<source src="'.  esc_url( $upload_video ).'"type="video/mp4"/>
							</video>';
				}
			}
		}
		$out_put = '<div class="video-wrapper">'.$item.'</div>';
		return $out_put;
	}

	/**
	* Get information football livescore from website http://www.livefootball.com
	*/
	function get_livescore_football($league){
		$urls = array(
			'league-3'=> "http://www.livefootball.com/football/italy/serie-a/",
			'league-8'=> "http://www.livefootball.com/football/italy/serie-b//",
			'league-7'=> "http://www.livefootball.com/football/england/premier-league/",
			'league-1'=> "http://www.livefootball.com/football/spain/primera-division/",
			'league-4'=> "http://www.livefootball.com/football/germany/bundesliga/",
			'league-2'=> "http://www.livefootball.com/football/france/ligue-1/",
			'league-5'=> "http://www.livefootball.com/football/holland/eredivisie/",
			'league-6'=> "http://www.livefootball.com/football/belgium/jupiler-pro-league/"
		);  
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, $urls[$league] );
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6'); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$datas = array(); 
		$htmls = curl_exec($ch); 
		$doc = new DOMDocument;
	    $doc->preserveWhiteSpace = false;
		if (!empty($htmls)) {  
			$doc = new DOMDocument;
		    $doc->preserveWhiteSpace = false;  
		    $htmls = preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/", "&amp;", $htmls);
		    @$doc->loadHTML($htmls);
		    
		    $domxpath = new DOMXpath($doc);
		    $tables =  $domxpath->query('//div[@id="sdLt"]/table/tr'); 
		    $flag = true;
		   	foreach ($tables as $key => $row) {
		   		if ( $flag) {
		   			$flag = false;
		   			continue;
		   		}
		   		$data = array('rank' => '',
		   			'name' => '',
		   			'played' => '',
		   			'points' => '');
		   		foreach ($row->childNodes as $k => $td) {  
		   			if (preg_match('/\bltid\b/i',$td->getAttribute('class')) ) { 
		   				$data['rank'] = $td->nodeValue;
		   			}
		   			if (preg_match('/\bltn\b/i',$td->getAttribute('class')) ) {
		   				$data['name'] = $td->nodeValue;
		   			}
		  			if (preg_match('/\bltg\b/i',$td->getAttribute('class')) ) {
		   				$data['played'] = $td->nodeValue;
		   			} 
		   			if (preg_match('/\bltp\b/i',$td->getAttribute('class')) ) {
		   				$data['points'] = $td->nodeValue;
		   			} 
		   		}  
		   		$datas[] = $data; 
		   	} 
	   	}
		return $datas;
	} 
}