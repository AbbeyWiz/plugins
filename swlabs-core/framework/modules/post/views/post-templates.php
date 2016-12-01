	<?php
	global $wpdb;

	// post
	$image_uri = get_template_directory_uri() . '/assets/admin/images/';
	$post_layout = SwlabsCore::get_params( 'post_layout');
	$img_options = array( 'style' => '' );
	$post_layout = $this->radio_image_label( $post_layout, $image_uri, $img_options );
	$html_options = array(
		'separator' => '&nbsp;',
		'class' => 'shw-w190',
		'style' => 'display:none;',
		'labelOptions' => array(
			'class' => ' shw-image-select ',
			'selected_class' => ' shw-image-select-selected ',
		)
	);
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
					<span><?php esc_html_e( 'Post Template', 'swlabs-core' );?></span>
				</div>
				<div class="shw-field shw-mbox-radio-row">
					<?php echo ( $this->radio_button_list( 'shw_page_options[blog_layout]',
															$this->get_field( $page_options, 'blog_layout', array('blog_layout' => '0') ),
															$post_layout,
															$html_options ) );?>
				</div>
			</div>

			<div class="shw-meta-row active" >
				<div class="shw-desc">
					<span><?php esc_html_e( 'Sidebar position', 'swlabs-core' );?></span>
				</div>
				<div class="shw-field">
					<?php echo ( $this->drop_down_list( 'shw_page_options[blog_sidebar_layout]',
															$this->get_field( $page_options, 'blog_sidebar_layout', array('blog_sidebar_layout' => '0') ),
															$params['sidebar_layout'],
															array( 'class' => 'shw-w200' ) ) );?>
				</div>
			</div>

			<div class="shw-meta-row active" >
				<div class="shw-desc">
					<span><?php esc_html_e( 'Custom Sidebar', 'swlabs-core' );?></span>
				</div>
				<div class="shw-field">
					<?php echo ( $this->drop_down_list( 'shw_page_options[blog_sidebar_id]',
															$this->get_field( $page_options, 'blog_sidebar_id', array('blog_sidebar_id' => '') ),
															$params['regist_sidebars'],
															array( 'class' => 'shw-w200', 'prompt' => 'Default sidebar') ) );?>
				</div>
			</div>

			<div class="shw-meta-row active" >
				<div class="shw-desc">
					<span><?php esc_html_e( 'Related Posts', 'swlabs-core' );?></span>
				</div>
				<div class="shw-field">
					<?php echo ( $this->drop_down_list( 'shw_page_options[blog_show_related]',
															$this->get_field( $page_options, 'blog_show_related', array('blog_show_related' => '0') ),
															$params['related_post'],
															array( 'class' => 'shw-w190' ) ) );?>
					<p class="description" ><?php esc_html_e( 'Show or hide related posts. Default hide.', 'swlabs-core' );?></p>
				</div>
			</div>
			
		</div>
	</div>