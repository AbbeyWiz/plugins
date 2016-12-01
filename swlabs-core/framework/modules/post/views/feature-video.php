	<?php
	$video_type  =  SwlabsCore::get_params( 'video-type');
	$class_cate = $this->get_field( $post_meta, 'video_type' );
	$class_upload ="";
	$class_vimeo_id = "";
	$class_youtube_id = "";
	if ( $class_cate == 'video-upload' ){
		$class_upload = "active";
	}else if( $class_cate == 'vimeo' ) {
		$class_vimeo_id = "active";
	}
	else if( $class_cate == 'youtube' ) {
		$class_youtube_id = "active";
	}
	?>
	<div class="shw-custom-meta container-video-option" >
		<div class="shw-video-meta" >
			<div class="shw-meta-row active" >
				<div class="">
					<span><?php esc_html_e( 'Choose Video Format to use Video Options. It will be embedded in the post and Featured Image will use to thumb of this post.', 'swlabs-core' );?></span>
				</div>
			</div>
			<div class="shw-meta-row active" >
				<div class="shw-desc">
					<span><?php esc_html_e( 'Type', 'swlabs-core' );?></span>
				</div>
				<div class="shw-field">
					<?php echo ( $this->drop_down_list('shw_post_options[video_type]',
															$this->get_field( $post_meta, 'video_type' ),
															$video_type,
															array('id'=>'swlabscore_mbox_video_type') ) );?>
				</div>
			</div>
			<div class="shw-meta-row video_upload <?php echo esc_attr( $class_upload ); ?>" >
				<?php
					$this->upload_video( "shw_post_options[upload_video]",$this->get_field($post_meta,'upload_video'), esc_html__('MP4 Upload', 'swlabs-core' ), esc_html__('Choose file .mp4 to upload', 'swlabs-core' ));?>
			</div>
			<div class="shw-meta-row vimeo-id <?php echo esc_attr( $class_vimeo_id ); ?> " >
				<div class="shw-desc">
					<label><?php esc_html_e( 'Vimeo ID', 'swlabs-core' );?></label>
					<p>For example the Video ID for http://vimeo.com/86323053 is 86323053</p>
				</div>
				<div class="shw-field">
					<?php echo ( $this->text_field( 'shw_post_options[vimeo_id]',
															$this->get_field( $post_meta, 'vimeo_id' ),
															array() ) );?>
				</div>
			</div>
			<div class="shw-meta-row youtube-id <?php echo esc_attr( $class_youtube_id ); ?> " >
				<div class="shw-desc">
					<label><?php esc_html_e( 'Youtube ID', 'swlabs-core' );?></label>
					<p>For example the Video ID for http://www.youtube.com/v/8OBfr46Y0cQ is 8OBfr46Y0cQ</p>
				</div>
				<div class="shw-field">
					<?php echo ( $this->text_field( 'shw_post_options[youtube_id]',
															$this->get_field( $post_meta, 'youtube_id' ),
															array() ) );?>
				</div>
			</div>
		</div>
	</div>