<?php
return array(
	'init' => array(
		array( 'add_action', 'swlabscore_add_inline_style', array( 'SwlabsCore', '[setting.Setting_Init, add_inline_style]' ) ),

		array( 'add_action', 'wp_ajax_swlabscore', array( 'SwlabsCore', '[Application, ajax]' ) ),
		array( 'add_action', 'wp_ajax_nopriv_swlabscore', array( 'SwlabsCore', '[Application, ajax]' ) ),
	),

	'admin_init' => array(
		// add action
		array( 'add_action', 'save_post', array( 'SwlabsCore', '[Application, save]' ) ),
		array( 'add_action', 'admin_enqueue_scripts', array( 'SwlabsCore', '[setting.Setting_Init, enqueue]' ) ),
		
		// Page
		array( 'add_action', 'swlabscore_page_init', array( 'SwlabsCore', '[page.Page_Controller, init]' ) ),
		array( 'add_action', 'swlabscore_page_meta_box', array( 'SwlabsCore', '[page.Page_Controller, add_page_metabox]' ) ),

		array( 'do_action', 'swlabscore_page_init'),
		array( 'do_action', 'swlabscore_page_meta_box'),
		
		//post: add metabox
		array( 'add_meta_box', 'swlabscore_mbox_post_templates', 'Post Template', array( 'SwlabsCore', '[post.Post_Controller, meta_box_post_template]' ), 'post', 'normal', 'high' ),
		//post: add metabox
		array( 'add_meta_box', 'swlabscore_mbox_post_video', 'Video Options', array( 'SwlabsCore', '[post.Post_Controller, meta_box_video]' ), 'post', 'normal', 'high' ),

		//category: add category field
		array( 'add_action', 'edit_category_form_fields', array( 'SwlabsCore', '[category.Category_Controller, edit]' ) ),
		//category: add category field
		array( 'add_action', 'category_add_form_fields', array( 'SwlabsCore', '[category.Category_Controller, add]' ) ),
		//category: save value 
		array( 'add_action', 'edited_category', array( 'SwlabsCore', '[category.Category_Controller, save_term]' ) ),
		array( 'add_action', 'create_category', array( 'SwlabsCore', '[category.Category_Controller, save_term]' ) ),
	),

	'save_post' => array(
		'page'             => array( 'page.Page_Controller', 'save' ),
		'post'             => array( 'post.Post_Controller', 'save' ),
	),
	'shortcode' => array(
		'swlabscore_block_sc_1'          => 'block_1',
		'swlabscore_block_sc_2'          => 'block_2',
		'swlabscore_block_sc_3'          => 'block_3',
		'swlabscore_block_sc_4'          => 'block_4',
		'swlabscore_block_sc_5'          => 'block_5',
		'swlabscore_block_sc_6'          => 'block_6',
		'swlabscore_block_sc_7'          => 'block_7',
		'swlabscore_block_sc_8'          => 'block_8',
		'swlabscore_block_sc_9'          => 'block_9',
		'swlabscore_block_sc_10'         => 'block_10',
		'swlabscore_block_sc_11'         => 'block_11',
		'swlabscore_block_carousel_sc_1' => 'block_carousel_1',
		'swlabscore_block_carousel_sc_2' => 'block_carousel_2',
		'swlabscore_block_carousel_sc_3' => 'block_carousel_3',
		'swlabscore_block_carousel_sc_4' => 'block_carousel_4',
		'swlabscore_block_carousel_sc_5' => 'block_carousel_5',
		'swlabscore_block_slider_sc_1'   => 'block_slider_1',
		'swlabscore_block_slider_sc_2'   => 'block_slider_2',
		'swlabscore_block_slider_sc_3'   => 'block_slider_3',
		'swlabscore_grid_sc_1'           => 'grid_1',
		'swlabscore_grid_sc_2'           => 'grid_2',
		'swlabscore_grid_sc_3'           => 'grid_3',
		'swlabscore_grid_sc_4'           => 'grid_4',
		'swlabscore_video_list_sc'       => 'video_list',
		'swlabscore_accordion_sc'        => 'accordion',
		'swlabscore_advertisement_sc'    => 'advertisement',
		'swlabscore_block_info_sc'       => 'block_info',
		'swlabscore_categories_sc'       => 'categories',
		'swlabscore_item_list_sc'        => 'item_list',
		'swlabscore_livescore_sc'        => 'livescore',
		'swlabscore_tab_sc'              => 'tab',
		'swlabscore_social_counter_sc'   => 'social_counter',
		'swlabscore_survey_sc'           => 'survey',
		'swlabscore_weather_sc'          => 'weather',
	),
	'page_options' => array(
		'post_types' => array( 'post', 'page' ),
	),
);