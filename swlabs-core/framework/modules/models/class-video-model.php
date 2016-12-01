<?php
class SwlabsCore_Video_Model {
	public $attributes;
	public function init( $atts = array() ) {
		$defaults = array(
			'post_type_meta' => 'swlabscore_video_meta',
			'thumb_size'     => '',
			'video_info'     => array(),
		);
		$this->attributes = SwlabsCore::set_meta_defaults($defaults, $atts);
		$this->get_thumb_size();
	}
	public function get_title( $post_id ){
		$data = $this->get_video_info( $post_id );
		if(isset($data['title']) && !empty($data['title'])) {
			return '<h3 class="title">'.esc_attr( $data['title'] ).'</h3>';
		}
		return '';
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
	public function get_related_video( $post_id, $index ) {
		$image = $body = '';
		$output = '<div data-target=".video-slider" data-slide-to="%1$s" class="media video-block">
						<div class="media-left">
							<a href="%2$s"><img src="%3$s" alt="" class="wp-post-image" /></a>
						</div>
						%4$s
					</div>';
		$data = array(
			'url' => '',
			'title' => '',
			'author' => '',
			'view' => '',
		);
		if ( has_post_thumbnail( $post_id ) ){
			$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $this->attributes['thumb_size']['small'] );
			$image = $attachment_image[0];
		} else {
			$image = SWLABSCORE_NO_IMG_URI . $this->attributes['thumb_size']['no-image'];
		}
		$data = $this->get_video_info( $post_id );
		printf( $output, esc_attr( $index ), esc_url( $data['url'] ), esc_url( $image ), $data['meta'] );
	}
	public function get_video_info( $post_id ) {
		$data = array(
			'url' => '',
			'title' => '',
			'author' => '',
			'view' => '',
			'meta' => '',
		);
		$post_meta = get_post_meta( $post_id , $this->attributes['post_type_meta'], true );
		$video_type = SwlabsCore::get_value( $post_meta, 'video_type');
		switch ( $video_type ) {
			case 'youtube':
				$video_id = SwlabsCore::get_value( $post_meta, 'youtube_id');
				$protocol = is_ssl() ? 'https' : 'http';
				$content = file_get_contents("http://youtube.com/get_video_info?video_id=".$video_id);
				parse_str( $content, $info );
				if( isset( $info['status'] ) && (strtolower( $info['status'] ) == 'ok') ) {
					$data['title'] = $info['title'];
					$data['author'] = $info['author'];
					$data['view'] = $info['view_count'];
					$data['url'] = $protocol . '://www.youtube.com/watch?v='. $video_id;
					$data['meta'] = $this->get_video_meta( $data );
				}
				break;
			case 'vimeo':
				$video_id = SwlabsCore::get_value( $post_meta, 'vimeo_id');
				$video_api_url = "http://vimeo.com/api/v2/video/$video_id.xml";
				if ( ! $this->is_404( $video_api_url )) {
					$xml = simplexml_load_file( $video_api_url );
					if( $xml && isset( $xml->video )) {
						foreach ($xml->video as $video) {
							$view = doubleval( $video->stats_number_of_plays );
							$data['url'] = $video->url;
							$data['title'] = $video->title;
							$data['author'] = $video->user_name;
							$data['view'] = $view;
							$data['meta'] = $this->get_video_meta( $data );
							break;
						}
					}
				}
				break;;
			case 'video-upload':
				$data['url'] = '#';
				$data['title'] = get_the_title( $post_id );
				$data['meta'] = $this->get_video_meta( $data );
				break;
		}
		return $data;
	}
	public function get_video_meta( $data = array() ) {
		$format = '<div class="media-body">%1$s</div>';
		$out_data = array(
			'title' => '',
			'author' => '',
			'view' => '',
		);
		if( $data ) {
			if( $data['title'] ) {
				$out_data['title'] = sprintf( '<h4 class="title"><a href="%1$s">%2$s</a></h4>', esc_url($data['url']), esc_attr($data['title']));
			}
			if( $data['author'] ) {
				$out_data['author'] = sprintf( '<div class="author">by %1$s</div>', esc_attr($data['author']) );
			}
			if( $data['view'] ) {
				$out_data['view'] = sprintf( '<div class="views">%1$s views</div>', number_format_i18n($data['view']) );
			}
		}
		$output = implode( '', $out_data );
		if( $output ) {
			$output = sprintf( $format, $output );
		}
		return $output;
	}
	public function is_404( $url ) {
		$headers = get_headers( $url );
		if (strpos( $headers[0],'404' ) !== false) {
			return true;
		} else {
			return false;
		}
	}
	public function get_video_thumb( $post_id, $field = 'shw_post_options' ) {
		$protocol = is_ssl() ? 'https' : 'http';
		$meta = get_post_meta( $post_id, $field, true );
		$thumb = '';
		if( $meta ) {
			$video_type = SwlabsCore::get_value( $meta, 'video_type' );
			switch ( $video_type ) {
				case 'youtube':
					$video_id = SwlabsCore::get_value( $meta, 'youtube_id' );
					if( $video_id ) {
						$img_url = $protocol . '://img.youtube.com/vi/' . $video_id;
						if ( ! $this->is_404( $img_url . '/maxresdefault.jpg')) {
							$thumb = $img_url . '/maxresdefault.jpg';
						} else {
							$thumb = $img_url . '/hqdefault.jpg';
						}
					}
					break;
				case 'vimeo':
					$video_id = SwlabsCore::get_value( $meta, 'vimeo_id' );
					if( $video_id ) {
						$video_api = @file_get_contents('http://vimeo.com/api/v2/video/' . $video_id . '.php');
						if (! empty( $video_api ) ) {
							$video_data = @unserialize( $video_api );
							if (! empty( $video_data[0]['thumbnail_large'] ) ) {
								$thumb = $video_data[0]['thumbnail_large'];
							}
						}
					}
					break;
			}
		}
		if( ! empty( $thumb ) && is_admin() ) {
			// add attached file
			add_action('add_attachment', array( &$this, 'add_featured_image' ) );
		
			// load the attachment from the URL
			media_sideload_image( $thumb, $post_id, $post_id);
		
			// remove the hook
			remove_action('add_attachment', array( &$this, 'add_featured_image' ));
		}
		return $thumb;
	}
	public function add_featured_image( $post_id ){
		// add featured image
		$p = get_post( $post_id );
		update_post_meta($p->post_parent,'_thumbnail_id', $post_id);
	}
	public function get_thumb_size() {
		$params = SwlabsCore::get_params( 'block-image-size', 'video-list' );
		$this->attributes['thumb_size'] = SwlabsCore_Util::get_thumb_size( $params );
	}
}