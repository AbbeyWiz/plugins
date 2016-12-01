<?php
/**
 * Controller Post.
 * 
 * @since 1.0
 */

SwlabsCore::load_class( 'Abstract' );
SwlabsCore::load_class( 'Model' );

class SwlabsCore_Post_Controller extends SwlabsCore_Abstract {

	public function save() {
		global $post;
		$post_id = $post->ID;
		parent::save();
		// save page options start
		if( class_exists( 'Swbignews' )) {
			$maps = Swbignews::get_config( 'mapping', 'post_options' );

			foreach ($_POST['shw_page_options'] as $key => $value) {

				if( $_POST['shw_page_options'][$key]  == '' || $_POST['shw_page_options'][$key] == '0' ) {
					if( $key == 'blog_show_related' && $_POST['shw_page_options'][$key] == '' ){
						continue;
					} else {
						unset($_POST['shw_page_options'][$key]);
					}
				}
			}
		}

		update_post_meta( $post_id, 'shw_page_options', isset( $_POST['shw_page_options'] ) ? $_POST['shw_page_options'] : '' );
		// save page options end
		update_post_meta( $post_id, 'shw_post_options', isset( $_POST['shw_post_options'] ) ? $_POST['shw_post_options'] : '' );
		$model = new SwlabsCore_Video_Model();
		$model->get_video_thumb( $post_id, 'shw_post_options' );
	}
	public function meta_box_video() {
		global $post;
		$post_id = $post->ID;
		$post_meta = array();
		if( $post_id ) {
			$post_meta = get_post_meta( $post_id, 'shw_post_options', true );
		}
		$this->render( 'feature-video', array(
			'post_meta' => $post_meta
		));
	}
	public function meta_box_post_template() {
		global $post;
		global $shw_admin_option_default;
		global $swbignews_options;
		$post_id = $post->ID;

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
		$params = array(
			'sidebar_layout'        => $sidebar_layout,
			'regist_sidebars'       => SwlabsCore_Com::get_regist_sidebars(),
			'default_sidebars'		=> $swbignews_options['shw-blog-sidebar'],
			'related_post'          => SwlabsCore::get_params( 'related_post_show' ),
		);
		$this->render( 'post-templates', array(
			'params' => $params,
			'defaults' => $shw_admin_option_default,
			'page_options' => $page_options, 

		));
	}
}