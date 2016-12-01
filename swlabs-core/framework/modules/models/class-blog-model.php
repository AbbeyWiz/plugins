<?php
class SwlabsCore_Blog_Model {
public $post_id;
	public $title;
	public $title_attribute;
	public $has_thumbnail = false;
	public $permalink;

	public $uniq_id;
	public $post;
	public $attributes = array();
	public $query;

	public function set_attributes( $atts = array() ) {
		$this->uniq_id = SwlabsCore::make_id();
		$default = array(
			'layout'               => '',
			'style'                => '',
			'block_title'          => '',
			'block_title_color'    => '',
			'block_title_bg_color' => '',
			'limit_post'           => '',
			'offset_post'          => '0',
			'extra_class'          => '',
			'sort_by'              => '',
			'pagination'           => '',
			'category_filter'      => '',
			'category_filter_text' => 'All',
			'title_length'         => '',
			'excerpt_length'       => '',
			'show_category'        => '',
			'show_related'         => '',
			'show_tag'             => '',
			'show_date'            => '',
			'show_author'          => '',
			'show_comments'        => '',
			'show_views'           => '',
			'show_excerpt'         => '',
			'show_meta'            => '',
			'category_list'        => '',
			'tag_list'             => '',
			'author_list'          => '',
			'category_slug'        => '',
			'tag_slug'             => '',
			'author'               => '',
			'cur_post_id'          => '',
			'post_filter_by'       => '',
			'block-class'          => '',
			'responsive-class'     => '',
			'column'               => '1',
			'related_post_count'   => '2',
			'paged'                => '',
			'cur_limit'            => '', 
		);
		$data = SwlabsCore::set_shortcode_defaults( $default, $atts);
		if( empty( $data['category_slug'] ) ) {
			list( $data['category_list_parse'], $data['category_slug'] ) = SwlabsCore_Util::get_list_vc_param_group( $data, 'category_list', 'category_slug' );
		}
		if( empty( $data['tag_slug'] ) ) {
			list( $data['tag_list_parse'], $data['tag_slug'] ) = SwlabsCore_Util::get_list_vc_param_group( $data, 'tag_list', 'tag_slug' );
		}
		if( empty( $data['author'] ) ) {
			list( $data['author_list_parse'], $data['author'] ) = SwlabsCore_Util::get_list_vc_param_group( $data, 'author_list', 'author' );
		}
		// Check valid
		if($data['limit_post'] != -1) {
			$data['limit_post'] = absint($data['limit_post']);
		}
		$data['offset_post'] = absint($data['offset_post']);
		if( empty($data['offset_post']) ) {
			$data['offset_post'] = 0;
		}
		if( empty($data['block-class'] ) ) {
			$data['block-class'] = sprintf( '%s-%s', $data['layout'], $this->uniq_id ) ;
		}
		$this->attributes = $data;
		// query
		$this->query = $this->get_query( $data );
	}
	/**
	 * Loop posts.
	 */
	public function loop_index() {
		global $post;

		$this->post_id = $post->ID;
		$this->post = $post;

		$this->title = get_the_title( $post->ID );
		$this->title_attribute = esc_attr( strip_tags( $this->title ) );
		$this->permalink = esc_url( $this->get_post_url( $post->ID ) );

		if ( has_post_thumbnail( $post->ID ) ) {
			$this->has_thumbnail = true;
		} else {
			$this->has_thumbnail = false;
		}
	}
	/**
	 * Query
	 * 
	 * @return WP_Query
	 */
	private function get_query( $data, $paged = '') {
		$query_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1 // do not move sticky posts to the start of the set.
		);
		$is_paging = false;
		// post id
		if( isset( $data['post_id'] ) && !empty( $data['post_id'] ) ) {
			if( is_array( $data['post_id'] ) ) {
				$query_args['post__in'] = $data['post_id'];
			}
		}
		// limit post
		$posts_per_page = get_option('posts_per_page');
		//custom pagination limit
		if( isset($data['limit_post']) ) {
			if ( empty($data['limit_post'] ) ) {
				$data['limit_post'] = $posts_per_page;
			}
			if( isset( $data['cur_limit'] ) &&  $data['cur_limit'] ) {
				$data['limit_post'] = $data['cur_limit'];
			}
			$query_args['posts_per_page'] = $data['limit_post'];
		}
		//paging
		if( isset($data['paged']) && $data['paged'] ) {
			$paged = $data['paged'];
		} else {
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		}
		
		$offset = SwlabsCore::get_value( $data, 'offset_post', 0 );  
		if( isset( $data['pagination'] ) ) {
			if( empty($data['paged']) && ($data['pagination'] == 'ajax' || $data['pagination'] == 'load_more') ) {
				$paged = 1;
			}
			if( $data['pagination'] == '' ) {
				$query_args['nopaging '] = false;
			} else {
				$is_paging = true;
				$query_args['nopaging '] = 'paging';
				$query_args['paged'] = $paged;
				if( isset($data['offset_post']) && $paged > 1 ) {
					$offset += ( ($paged - 1) * $data['limit_post']) ;
				}
			}
		}  
		$query_args['offset'] = $offset ;
		// tax query
		$this->parse_tax_query( $query_args, $data );
		// filter by
		$this->parse_post_filter( $query_args, $data );
		//search by meta
		$this->parse_meta_key( $query_args, $data );
		// sort by
		switch ( $data['sort_by'] ) {
			case 'az_order':
				$query_args['orderby'] = 'title';
				$query_args['order'] = 'ASC';
				break;
			case 'za_order':
				$query_args['orderby'] = 'title';
				$query_args['order'] = 'DESC';
				break;
			case 'popular':
				$query_args['meta_key'] = SWLABSCORE_POST_VIEWS;
				$query_args['orderby'] = 'meta_value_num';
				$query_args['order'] = 'DESC';
				break;
			case 'random_posts':
				$query_args['orderby'] = 'rand';
				break;
			case 'random_today':
				$query_args['orderby'] = 'rand';
				$query_args['year'] = date('Y');
				$query_args['monthnum'] = date('n');
				$query_args['day'] = date('j');
				break;
			case 'random_7_day':
				$query_args['orderby'] = 'rand';
				$query_args['date_query'] = array(
					'column' => 'post_date_gmt',
					'after' => '1 week ago'
				);
				break;
			case 'random_month':
				$query_args['orderby'] = 'rand';
				$query_args['date_query'] = array(
					'column' => 'post_date_gmt',
					'after' => '1 month ago'
				);
				break;
			case 'comment_count':
				$query_args['orderby'] = 'comment_count';
				$query_args['order'] = 'DESC';
				break;
			default:
		}
		$query = new WP_Query( $query_args );
		if( $is_paging && $this->attributes['offset_post'] > 0 ) {
			$start_offset = $this->attributes['offset_post']; 
			$query->found_posts = $this->recalc_found_posts($query, $start_offset );
			$query->max_num_pages = ceil( $query->found_posts / $query_args['posts_per_page']);
		}
		return $query;
	} 
	private function recalc_found_posts($query, $start_offset ) {
		$query->set( 'posts_per_page', $start_offset );
		return $query->found_posts - $start_offset;
	}
	private function parse_post_filter( &$query_args, $data ) {
		if( !empty( $data['post_filter_by'] ) ) {
			$cur_post_id = $this->attributes['cur_post_id'];
			if( empty($cur_post_id) ) {
				$cur_post_id = get_the_ID();
			}
			switch ($data['post_filter_by'] ) {
				case 'post_same_author':
					$query_args['author'] = get_post_field( 'post_author', $cur_post_id );
					$query_args['post__not_in'] = array( $this->post_id );
					break;
				case 'post_same_category':
					$query_args['category__in'] = wp_get_post_categories( $cur_post_id );
					$query_args['post__not_in'] = array( $cur_post_id );

					break;
				case 'post_same_format':
					$post_format = get_post_format( $cur_post_id );
					if( $post_format ) {
						$tax_query = array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array("post-format-{$post_format}")
							)
						);
						$query_args["tax_query"] = $tax_query;
						$query_args['post__not_in'] = array( $cur_post_id );
					}
					break;
				case 'post_same_tag':
					$tags = wp_get_post_tags( $cur_post_id );
					if ( $tags ) {
						$tag_list = array();
						for ($i = 0; $i <= 4; $i++) {
							if (!empty($tags[$i])) {
								$taglist[] = $tags[$i]->term_id;
							} else {
								break;
							}
						}
						$query_args['tag__in'] = $tag_list;
						$query_args['post__not_in'] = array( $this->post_id  );
					}
					break; 
				case 'post_format_video': 
						$tax_query = array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array("post-format-video")
							)
						);
						$query_args["tax_query"] = $tax_query; 
					break;
			}
		}
	}
	private function parse_tax_query( &$query_args, $data ) {
		if( !empty( $data['category_slug'] ) ) {
			if( is_array( $data['category_slug'] ) ) {
				$data['category_slug'] = implode(',', $data['category_slug']);
			}
			$query_args['category_name'] = $data['category_slug'];
		}
		if( !empty( $data['tag_slug'] ) ) {
			if( is_array( $data['tag_slug'] )) {
				$data['tag_slug'] = implode(',', $data['tag_slug']);
			}
			$query_args['tag'] = $data['tag_slug'];
		}
		if( !empty( $data['author'] ) ) {
			//author_id
			if( is_array( $data['author'] )) {
				$data['author'] = implode(',', $data['author']);
			}
			$query_args['author'] = $data['author'];
		}
		
		$tax_query = array();
		// Any taxonomy
		if( isset($data['taxonomy_slug']) && !empty( $data['taxonomy_slug'] ) ) {
			$taxonomy_slug = $data['taxonomy_slug'];
			if( is_array($taxonomy_slug) ) {
				foreach( $taxonomy_slug as $taxonomy_name => $slug_val ) {
					if( !empty($slug_val ) ) {
						$taxonomy_args = array(
							'taxonomy' => $taxonomy_name,
							'field'    => 'slug',
							'terms'    => $slug_val,
						);
						$tax_query[] = $taxonomy_args;
					}
				}
			}
		}
		if(! empty( $tax_query ) ) {
			if( count($tax_query) > 1 ) {
				$tax_query['relation'] = 'AND';
			}
			$query_args["tax_query"] = $tax_query;
		}
	}
	private function parse_meta_key( &$query_args, $data ){
		$meta_query = array();
		if( isset($data['meta_key']) && !empty( $data['meta_key'] ) ) {
			$meta_key_arr = $data['meta_key'];
			if( is_array($meta_key_arr) ) {
				//multi key
				foreach( $meta_key_arr as $key => $val ) {
					$meta_query[] = array(
						'key'     => $key,
						'value'   => $val,
					);
				}
			} else {
				//single key
				$meta_query[] = array(
					'key'     => $data['meta_key'],
					'value'   => $data['meta_value']
				);
			}
		}
		if( isset($data['meta_key_compare']) && !empty( $data['meta_key_compare'] ) ) {
			$meta_key_arr = $data['meta_key_compare'];
			foreach( $meta_key_arr as $value ) {
				$meta_query[] = $value;
			}
		}
		if(! empty( $meta_query ) ) {
			if( count( $meta_query ) > 1 ) {
				$meta_query['relation'] = 'AND';
			}
			$query_args["meta_query"] = $meta_query;
		}
	}
	/**
	 * Get post author.
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function get_author( $echo= false ) {
		$out = $format = '';
		if( $this->attributes['show_author'] != 'hide' ) {
			if ( is_singular() || is_multi_author() ) {
				$format = '<a href="%1$s" class="style-icon">%2$s</a>';
				$url = get_author_posts_url( $this->post->post_author );
				$format = '<div class="author item">' . $format . '</div>';
				$out = sprintf( $format,
						esc_url( $url ),
						esc_attr( get_the_author_meta('display_name', $this->post->post_author) )
				);
			}
		}
		if( ! $echo ) {
			return $out;
		}
		echo wp_kses_post( $out );
	}
	/**
	 * Get post views
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function get_views( $echo= false ) {
		$out = '';
		$format = '<div class="views item"><a href="%1$s" class="style-icon">%2$s</a></div>';
		if( $this->attributes['show_views'] != 'hide' ) {
			$icon = sprintf( '<i class="icon %s"></i>', SwlabsCore::get_params( 'meta-icon', 'view' ) );
			$out = sprintf( $format, $this->permalink, $this->get_post_view( $this->post_id ));
		}
		if( ! $echo ) {
			return $out;
		}
		echo wp_kses_post( $out );
		
	}
	/**
	 * Get post comment number.
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function get_comments( $echo = false ) {
		$out = '';
		$format = '<div class="comments item"><a href="%1$s" class="style-icon">%2$s</a></div>';
		if( $this->attributes['show_comments'] != 'hide' ) {
			if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				$out = sprintf( $format, get_comments_link( $this->post_id ), get_comments_number() );
			}
		}
		if( ! $echo ) {
			return $out;
		}
		echo wp_kses_post( $out );
	}
	/**
	 * Get post date
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function get_date( $echo = false ) {
		$out = '';
		$format = '<div class="date-created item"><a href="%1$s" class="style-icon" >%2$s</a></div>';
		if( $this->attributes['show_date'] != 'hide' ) {
			$date = get_the_date();
			$out = sprintf( $format, $this->permalink, $date );
		}
		if( ! $echo ) {
			return $out;
		}
		echo wp_kses_post( $out );
	}
	/**
	 * Get main category of post
	 * 
	 */
	/**
	 * Get main category of post.
	 * 
	 * @param string $echo - false(default)
	 * @return string
	 */
	public function get_category( $echo = false ) {
		$out = $cat = '';
		if( $this->attributes['show_category'] != 'hide' ) {
			$format = '<div class="category item"><a href="%1$s" class="">%2$s</a></div>';
			// Read the post meta
			$post_options = get_post_meta( $this->post_id, 'shw_page_options', true);
			if ( isset( $post_options['blog_main_category'] ) && !empty( $post_options['blog_main_category'] ) ) {
				// Main category has seleted post setting
				$cat = get_category_by_slug( $post_options['blog_main_category'] );
			} else {
				// Get one auto
				$cat = current( get_the_category( $this->post ) );
			}
			if ( $cat ) {
				$out = sprintf( $format, get_category_link($cat->cat_ID), esc_attr( $cat->name ) );
			}
		}
		if( !$echo ) {
			return $out;
		}
		echo wp_kses_post( $out );
	}
	/**
	 * Feature images
	 * 
	 */
	public function get_featured_image( $thumb_type = 'large', $echo = false, $options = array() ) {
		$out = $thumb_img = $img_cate = '';
		$thumb_size = $this->attributes['thumb-size'][$thumb_type];
		//add_image_size( $thumb_name, $size[0], $size[1] );

		if( ! isset( $options['thumb_href_class'] ) ) {
			$options['thumb_href_class'] = 'media-image';
		}
		// 1: href, 2: image, 3: icon format, 4: thumb_href_class
		$out = '<a href="%1$s" class="%4$s">%2$s%3$s</a>';
		$thumb_class = SwlabsCore::get_value( $options, 'thumb_class', 'img-responsive' );
		if( $this->has_thumbnail ) {
			$thumb_id = get_post_thumbnail_id( $this->post_id );
			// regenerate if not exist.
			$helper = new SwlabsCore_Helper();
			$helper->regenerate_attachment_sizes($thumb_id, $thumb_size);
			$thumb_img = wp_get_attachment_image( $thumb_id, $thumb_size, false, array('class' => $thumb_class ) );
		}else {
			$thumb_img = SwlabsCore_Util::get_no_image( $this->attributes['thumb-size'], $this->post, $thumb_type, array('thumb_class' => $thumb_class ) );
		}
		$format_icon = SwlabsCore::get_params( 'post-format-icon' );
		$post_format = get_post_format( $this->post_id );
		if( isset($format_icon[$post_format]) ) {
			$img_cate = $format_icon[$post_format];
			$img_cate = sprintf('<div class="img-cate"><i class="fa %s"></i></div>', $img_cate );
		}
		$out = sprintf( $out, $this->permalink, $thumb_img, $img_cate, $options['thumb_href_class'] );
		if( !$echo ) {
			return $out;
		}
		echo wp_kses_post( $out );
	}
	/**
	 * Get related post
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function get_related_post( $limit = '', $echo = false, $options = array() ) {
		$out = '';
		if( empty($limit) ) {
			$limit = -1;
		}
		$args = array( 'posts_per_page' => $limit );
		$related_query = SwlabsCore_Com::get_query_related_posts( $this->post_id, $args );
		$format = '<a href="%1$s"><i class="fa fa-caret-right"></i><span>%2$s</span></a>';
		if ( $related_query->have_posts() ) {
			$related_posts = $related_query->posts;
			foreach($related_posts as $row ) {
				$title = isset( $row->post_title ) ? $row->post_title : '';
				if( ! empty ( $title ) ) {
					$out .= sprintf($format, get_permalink($row->ID), get_the_title($row->ID) );
				}
			}
		}
		if( empty( $out ) ) {
			return '';
		}
		$format = '<div class="sub-link">%s</div>';
		if( !$echo ) {
			return sprintf( $format, $out );
		}
		printf( $format, $out );
	}
	/**
	 * Get post title
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function get_title( $is_limit = true, $echo = false, $options = array() ) {
		$output = '<a href="%2$s" class="%3$s" >%1$s</a>';
		if( ! isset( $options['title_class'] ) ) $options['title_class'] = 'title';
		if( isset( $options['title_format'] ) && !empty( $options['title_format'] ) ) {
			$output = $options['title_format'];
		}
		$title = $this->title;
		$limit = $this->attributes['title_length'];
		if( $is_limit && !empty( $limit ) ) {
			// cut title by limit
			$title = wp_trim_words($this->title, $limit);
		}
		if( ! $echo ) {
			return sprintf( $output, esc_attr( $title ), $this->permalink, $options['title_class'] );
		} 
		printf( $output, esc_attr( $title ), $this->permalink, $options['title_class'] );
	}
	/**
	 * Get the excerpt
	 * 
	 * @param string $limit
	 * @param string $echo
	 * @return string
	 */
	public function get_excerpt( $is_limit = true, $echo = false ) {
		$trim_excerpt = '';
		if ( $this->attributes['show_excerpt'] != 'hide'){
			$trim_excerpt = get_the_excerpt();
			$limit = $this->attributes['excerpt_length'];
			if( $is_limit && !empty( $limit ) ) {
				$trim_excerpt = wp_trim_words($trim_excerpt, $limit, ' […]');
			}
		}
		if( !$echo ) {
			return $trim_excerpt;
		}
		echo (!empty($trim_excerpt) ? $trim_excerpt : '');
	}
	private function isLink( $post_id ) {
		return get_post_format( $post_id ) === 'link';
	}
	private function isVideo() {
		return get_post_format( $post_id ) === 'video';
	}
	private function isGallery() {
		return get_post_format( $post_id ) === 'gallery';
	}
	private function get_post_url( $post_id ) {
		if( $this->isLink( $post_id ) ) {
			$content = get_the_content( $post_id );
			$has_url = get_url_in_content( $content );
				
			return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink( $post_id ) );
		} else {
			return get_permalink( $post_id );
		}
	}
	public function add_post_filter_atts( $atts ) {
		if ( !empty( $atts['post_filter_by'] ) ) {
			$atts['cur_post_id'] = get_queried_object_id(); //add the current post id
			$atts['cur_post_author'] =  get_post_field( 'post_author', $atts['cur_post_id']); //get the current author
		}
		return $atts;
	}
	public function get_post_view( $post_id = '' ) {
		global $post;
		if( $post_id ) {
			$post_id = $post->ID;
		}
		$count_key = SWLABSCORE_POST_VIEWS;
		$count = get_post_meta( $post_id, $count_key, true );
		$res = '';
		if($count == '') {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
			$res = 0;
		} else {
			$res = $count;
		}
		return $res;
	}
	public function get_post_class( $class = '', $post_id = '' ) {
		if( empty( $post_id ) ) {
			$post_id = $this->post_id;
		}
		return join( ' ', get_post_class( $class, $post_id ) );
	}
	public function view_more_button( $echo = false, $post_id = '', $btn_content = '', $html_options = array() ) {
		if( empty( $btn_content ) ) {
			$btn_content = Swbignews_Translate::_swt( 'View more');
		}
		if( ! isset( $html_options['class'] ) ) {
			$html_options['class'] = 'btn btn-viewmore';
		}
		if( $echo ) {
			return printf( '<a href="%1$s" class="%2$s">%3$s</a>', $this->permalink, $html_options['class'], $btn_content );
		}
		return sprintf( '<a href="%1$s" class="%2$s">%3$s</a>', $this->permalink, $html_options['class'], $btn_content );
	}
}