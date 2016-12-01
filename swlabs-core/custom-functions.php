<?php
if( ! function_exists( 'swlabscore_post_pagination_link' ) ) :
	function swlabscore_post_pagination_link($link)
	{
		$url =  preg_replace('!">$!','',_wp_link_page($link));
		$url =  preg_replace('!^<a href="!','',$url);
		return $url;
	}
endif;

if( ! function_exists( 'swlabscore_get_pagenum_link' ) ) :
	function swlabscore_get_pagenum_link( $pagenum = 1, $escape = true, $base = null) {
		global $wp_rewrite;
	
		$pagenum = (int) $pagenum;
	
		$request = $base ? remove_query_arg( 'paged', $base ) : remove_query_arg( 'paged' );
	
		$home_root = parse_url(home_url());
		$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
		$home_root = preg_quote( $home_root, '|' );
	
		$request = preg_replace('|^'. $home_root . '|i', '', $request);
		$request = preg_replace('|^/+|', '', $request);
	
		if ( !$wp_rewrite->using_permalinks() || is_admin() ) {
			$base = trailingslashit( get_bloginfo( 'url' ) );
	
			if ( $pagenum > 1 ) {
				$result = add_query_arg( 'paged', $pagenum, $base . $request );
			} else {
				$result = $base . $request;
			}
		} else {
			$qs_regex = '|\?.*?$|';
			preg_match( $qs_regex, $request, $qs_match );
	
			if ( !empty( $qs_match[0] ) ) {
				$query_string = $qs_match[0];
				$request = preg_replace( $qs_regex, '', $request );
			} else {
				$query_string = '';
			}
	
			$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
			$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
			$request = ltrim($request, '/');
	
			$base = trailingslashit( get_bloginfo( 'url' ) );
	
			if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
				$base .= $wp_rewrite->index . '/';
	
			if ( $pagenum > 1 ) {
				$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
			}
	
			$result = $base . $request . $query_string;
		}
	
		/**
		 * Filter the page number link for the current request.
		 *
		 * @since 2.5.0
		 *
		 * @param string $result The page number link.
		 */
		$result = apply_filters( 'get_pagenum_link', $result );
	
		if ( $escape )
			return esc_url( $result );
		else
			return esc_url_raw( $result );
	}
endif;


/*  COMMENT */
if ( !function_exists('commment_init') ) {
	function commment_init() {
		$cmt_facebook_enable = get_theme_option('cmt-facebook-enable');
		$cmt_google_enable = get_theme_option('cmt-google-enable');
		$cmt_disqus_enable = get_theme_option('cmt-disqus-enable');

		if ( $cmt_google_enable == 'yes' || $cmt_facebook_enable == 'yes' || $cmt_disqus_enable == 'yes' ) {
			add_filter( 'comments_template', 'social_commenting' );
		}
	}
	add_action( 'init', 'commment_init' );
}

// commment_init();
if( !function_exists('social_commenting') ) :
	function social_commenting( $file ) {
		$cmt_facebook_enable = get_theme_option('cmt-facebook-enable');
		$cmt_google_enable = get_theme_option('cmt-google-enable');
		$cmt_disqus_enable = get_theme_option('cmt-disqus-enable');
		if ( ( is_single() || is_page() || is_singular() ) && comments_open() ) {
			// if password is required, return
			if ( post_password_required() ) {
				echo '<p>'.__( 'This is password protected.', 'heateor-social-comments' ).'</p>';
				return plugin_dir_path( __FILE__ ) . '/inc/comments.php';
			}

			// check if social comments are enabled at this post type

			global $post;

			global $heateor_sc_options;
			$commentsOrder = 'wordpress,facebook,google,disqus';
			$commentsOrder = explode( ',', $commentsOrder );
			
			$tabs = '';
			$divs = '';
			foreach( $commentsOrder as $key => $order ) {
				$social = '';
				$social = get_theme_option('cmt-'.$order.'-enable');
				$commentsOrder[$key] = trim( $order );
				if ( $social == 'no' ) { unset($commentsOrder[$key]); }
			}
			// print_r($commentsOrder);
			$active_i = 0;
			$orderCount = 0;
			$active = '';
			foreach( $commentsOrder as $order ) {
				$comment_div = '';
				if ( $order == 'wordpress' ) {
					if ( isset( $heateor_sc_options['counts'] ) ) {
						$comments_count = get_wp_comment_count();
					}
					$comment_div = '<div style="clear:both"></div>' . render_wp_comments( $file ) . '<div style="clear:both"></div>';
				} elseif ( $order == 'facebook' ) {
					if ( isset( $heateor_sc_options['counts'] ) ) {
						$comments_count = get_fb_comments_count();
					}
					$comment_div = render_fb_comments();
				} elseif ( $order == 'google' ) {
					if ( isset( $heateor_sc_options['counts'] ) ) {
						$comments_count = get_gp_comments_count();
					}
					$comment_div = '<div style="clear:both"></div>' . render_gp_comments() . '<div style="clear:both"></div>';
				} else {
					if ( isset( $heateor_sc_options['counts'] ) ) {
						$comments_count = get_dq_comments_count();
					}
					$comment_div = render_dq_comments();
				}
				
				
				if( $active_i == 0 ) {
					$active = 'active';
				}else{
					$active = '';
				}
				
				$divs .= '<div class="tab-pane '.esc_attr($active).'" ' . ( $orderCount != 0 ? 'style="display:none"' : '' ) . ' id="'.esc_attr($order).'">' . ( isset( $heateor_sc_options['commenting_layout'] ) && $heateor_sc_options['commenting_layout'] == 'stacked' && isset( $heateor_sc_options['label_' . $order . '_comments'] ) ? '<h3 class="comment-reply-title">' . $heateor_sc_options['label_' . $order . '_comments'] . ( isset( $comments_count ) ? ' (' . $comments_count . ')' : '' ) . '</h3>' : '' );
				$divs .= $comment_div;
				$divs .= '</div>';
				$active_i++;
			}
			$commentingHtml = '<div class="swlabs_sc_social_comments">';
			$label = '';
			$active_label = '';
			$label_i = 0;
			$commentingHtml .= '<ul class="nav nav-tabs comment-tabs" role="tablist">';
			if($commentsOrder):
			foreach ( $commentsOrder as $other ) {
				if( $label_i == 0 ){
					$active_label = 'active';
				}else{
					$active_label = '';
				}
				if ( $other == 'wordpress' ) {
					$label = get_theme_option('cmt-'.esc_attr($other).'-label');
					$commentingHtml .= '<li class="'.esc_attr($active_label).'"><a href="#'.esc_attr($other).'" role="tab" data-toggle="tab"><span class="fa fa-wordpress"></span> '.esc_html($label).'</a></li>';
				} elseif ( $other == 'facebook' ) {
					$label = get_theme_option('cmt-'.esc_attr($other).'-label');
					$commentingHtml .= '<li class="'.esc_attr($active_label).'"><a href="#'.esc_attr($other).'" role="tab" data-toggle="tab"><span class="fa fa-facebook"></span> '.esc_html($label).'</a></li>';
				} elseif ( $other == 'google' ) {
					$label = get_theme_option('cmt-'.esc_attr($other).'-label');
					$commentingHtml .= '<li class="'.esc_attr($active_label).'"><a href="#'.esc_attr($other).'" role="tab" data-toggle="tab"><span class="fa fa-google-plus"></span> '.esc_html($label).'</a></li>';
				} else {
					$label = get_theme_option('cmt-'.esc_attr($other).'-label');
					$commentingHtml .= '<li class="'.esc_attr($active_label).'"><a href="#'.esc_attr($other).'" role="tab" data-toggle="tab"><span class="fa fa-disqus"></span> '.esc_html($label).'</a></li>';
				}
				$label_i++;
			}
			endif;
			$commentingHtml .= '</ul>';
			$commentingHtml .= '<div class="tab-content comment-tab-content">';
			$commentingHtml .= $divs;
			$commentingHtml .= '</div>';
			$commentingHtml .= '</div>';
			echo $commentingHtml;
			// hack to return empty file
			return plugin_dir_path( __FILE__ ) . '/framework/modules/comments/comments.php';
		}
		return $file;
	}
endif;

function get_theme_option( $name, $field = null ) {
	$theme_options = get_option('swbignews_options');

	if( $field ) {
		return ( isset( $theme_options[$name][$field] ) ) ? $theme_options[$name][$field] : '';
	}
	if( isset ($theme_options[$name] ) ) {
		return $theme_options[$name];
	}
	return '';
}

if ( !function_exists('get_wp_comment_count') ) {
	function get_wp_comment_count() {
		global $post;
		$comments_count = wp_count_comments( $post->ID );
		return ( $comments_count && isset( $comments_count -> approved ) ? $comments_count -> approved : 0 );
	}
}

if ( !function_exists('get_fb_comments_count') ) {
	function get_fb_comments_count() {
		$cmt_facebook_url = get_theme_option('cmt-facebook-url');
		if ( isset( $cmt_facebook_url ) && $cmt_facebook_url != '' ) {
			$url = $cmt_facebook_url;
		} else {
			$url = get_current_page_url();
		}
		return '<fb:comments-count href='. $url .'></fb:comments-count>';
	}
}
if ( !function_exists('get_gp_comments_count') ) {
	function get_gp_comments_count() {
		$cmt_google_url = get_theme_option('cmt-google-url');
		$response = wp_remote_get( 'https://apis.google.com/_/widget/render/commentcount?bsv&usegapi=1&href=' . ( isset( $cmt_google_url ) ? $cmt_google_url : get_current_page_url() ) );
		if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) { 
			return '0';
		}
		$body = $response['body'];
		$count = explode( "<span>", $body );
		$count = $count[1];
		$count = explode( " ", trim( $count ) );
		return $count[0];
	}
}
if ( !function_exists('get_dq_comments_count') ) {
	function get_dq_comments_count(){
		$cmt_disqus_apikey = get_theme_option('cmt-disqus-apikey');
		$cmt_disqus_shortname = get_theme_option('cmt-disqus-shortname');
		if ( ! $cmt_disqus_apikey || ! $cmt_disqus_shortname ) {
			return 0;
		}
		$response = wp_remote_get( 'https://disqus.com/api/3.0/threads/set.json?api_key=' . $cmt_disqus_apikey . '&forum=' . $cmt_disqus_shortname . '&thread=link:' . urlencode( get_current_page_url() ) );
		if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) {
			return '0';
		}
		$json = json_decode( $response['body'] );
		return isset( $json->response[0] ) && isset( $json->response[0]->posts ) ? $json->response[0]->posts : 0;	
	}
}
if ( !function_exists('get_current_page_url') ) {
	function get_current_page_url() {
		global $post;
		if ( isset( $post -> ID ) && $post -> ID ) {
			return get_permalink( $post -> ID );
		} else {
			return html_entity_decode( esc_url( get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) );
		}
	}
}
if ( !function_exists('get_http') ) {
	function get_http() {
		if ( isset( $_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
			return "https://";
		} else {
			return "http://";
		}
	}
}
if ( !function_exists('render_dq_comments') ) {
	function render_dq_comments() {
		$cmt_disqus_apikey = get_theme_option('cmt-disqus-apikey');
		$cmt_disqus_shortname = get_theme_option('cmt-disqus-shortname');
		$shortname = isset( $cmt_disqus_shortname ) && $cmt_disqus_shortname != '' ? $cmt_disqus_shortname : '';

		return '<div class="embed-container clearfix" id="disqus_thread">' . ( $shortname != '' ? $shortname : '<div style="font-size: 14px;clear: both;">' . Swbignews_Translate::_swt( 'Specify a Disqus shortname') . '</div>' ) . '</div><script type="text/javascript">var disqus_shortname = "' . $shortname . '";(function(d) {var dsq = d.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;dsq.src = "//" + disqus_shortname + ".disqus.com/embed.js"; (d.getElementsByTagName("head")[0] || d.getElementsByTagName("body")[0]).appendChild(dsq); })(document);</script>';
	}
}
if ( !function_exists('render_gp_comments') ) {
	function render_gp_comments() {
		$cmt_google_url = get_theme_option('cmt-google-url');
		if ( isset( $cmt_google_url ) && $cmt_google_url != '' ) {
			$url = $cmt_google_url;
		} else {
			$url = get_current_page_url();
		}
		return '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><div id="heateor_sc_gpcomments"></div><script type="text/javascript">window.setTimeout(function(){var e="heateor_sc_gpcomments",r="",o="FILTERED_POSTMOD";gapi.comments.render(e,{href:"'. $url .'",first_party_property:"BLOGGER",legacy_comment_moderation_url:r,view_type:o})},10);</script>';
	}
}
if ( !function_exists('render_fb_comments') ) {
	function render_fb_comments() {
		$cmt_facebook_url = get_theme_option('cmt-facebook-url');
		$cmt_facebook_language = get_theme_option('cmt-facebook-language');
		$cmt_facebook_color = get_theme_option('cmt-facebook-color');
		$cmt_facebook_number_cmt = get_theme_option('cmt-facebook-number-cmt');
		$cmt_facebook_order = get_theme_option('cmt-facebook-order');
		$cmt_facebook_width = get_theme_option('cmt-facebook-width');

		if ( isset( $cmt_facebook_url) && $cmt_facebook_url != '' ) {
			$url = $cmt_facebook_url;
		} else {
			$url = get_current_page_url();
		}
		if ( !empty( $cmt_facebook_width ) ) {
			$custom_css = sprintf('.fb-comments > span{ min-width: %spx !important; } .fb-comments span iframe[style]{ min-width: %spx !important; }', $cmt_facebook_width, $cmt_facebook_width);
		}else{
			$custom_css = sprintf('.fb-comments > span{ min-width: 100% !important; } .fb-comments span iframe[style]{ min-width: 100% !important; }', $cmt_facebook_width, $cmt_facebook_width);
		}
		
		do_action( 'swlabscore_add_inline_style', $custom_css );
		$commentingHtml = '<div id="fb-root"></div><script type="text/javascript">';
		// global $heateor_fcn_options;
		// if ( isset( $heateor_fcn_options ) ) {
		// 	$commentingHtml .= 'window.fbAsyncInit=function(){FB.init({appId:"",channelUrl:"'. site_url() .'//channel.html",status:!0,cookie:!0,xfbml:!0,version:"v2.5"}),FB.Event.subscribe("comment.create",function(e){e.commentID&&jQuery.ajax({type:"POST",dataType:"json",url:"'. site_url() .'/index.php",data:{action:"the_champ_moderate_fb_comments",data:e},success:function(){}})})};';
		// }
		$commentingHtml .= '!function(e,n,t){var o,c=e.getElementsByTagName(n)[0];e.getElementById(t)||(o=e.createElement(n),o.id=t,o.src="//connect.facebook.net/' . ( isset($cmt_facebook_language) && $cmt_facebook_language != '' ? $cmt_facebook_language : 'en_US' ) . '/sdk.js#xfbml=1&version=v2.5",c.parentNode.insertBefore(o,c))}(document,"script","facebook-jssdk");</script><div class="fb-comments" data-href="' . $url . '" data-colorscheme="' . ( isset($cmt_facebook_color) && $cmt_facebook_color != '' ? $cmt_facebook_color : '' ) . '" data-numposts="' . ( isset($cmt_facebook_number_cmt) && $cmt_facebook_number_cmt != '' ? $cmt_facebook_number_cmt : '' ) . '" data-width="' . ( isset( $cmt_facebook_width ) && $cmt_facebook_width != '' ? $cmt_facebook_width : '100%' ) . '" data-order-by="' . ( isset($cmt_facebook_order) && $cmt_facebook_order != '' ? $cmt_facebook_order : '' ) . '" ></div>';
		return $commentingHtml;
	}
}
if ( !function_exists('render_wp_comments') ) {
	function render_wp_comments( $file ) {
		ob_start();
		if ( file_exists( $file ) ) {
			require $file;
		} elseif ( file_exists( TEMPLATEPATH . $file ) ) {
			require( TEMPLATEPATH . $file );
		} elseif ( file_exists( ABSPATH . WPINC . '/theme-compat/comments.php' ) ) {
			require( ABSPATH . WPINC . '/theme-compat/comments.php');
		}
		return ob_get_clean();
	}
}

if( ! function_exists( 'swlabscore_add_menu_page' ) ) :
	function swlabscore_add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null)
	{
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
	}
endif;

if( ! function_exists( 'swlabscore_add_submenu_page' ) ) :
	function swlabscore_add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '')
	{
		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	}
endif;

