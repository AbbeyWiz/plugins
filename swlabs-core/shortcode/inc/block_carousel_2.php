<?php
$category = SwlabsCore_Com::get_category2slug_array();
$tag = SwlabsCore_Com::get_tax_options2slug( 'post_tag', array('empty' => esc_html__( '-All tags-', 'swlabs-core' )) );
$author = SwlabsCore_Com::get_user_login2id(array(), array('empty' => esc_html__( '-All authors-', 'swlabs-core' )) );
$orderby = SwlabsCore::get_params('sort_blog');
$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'swlabs-core' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title', 'swlabs-core' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'swlabs-core' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose block title color.', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'swlabs-core' ),
		'param_name'  => 'limit_post',
		'value'       => '10',
		'description' => esc_html__( 'Enter number of posts to display', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Posts', 'swlabs-core' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display', 'swlabs-core' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'swlabs-core' ),
		'param_name'  => 'sort_by',
		'value'       => $orderby,
		'description' => esc_html__( 'Choose criteria to display.', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'swlabs-core' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'swlabs-core' )
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Category', 'swlabs-core' ),
		'param_name' => 'category_list',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'swlabs-core' ),
				'param_name'  => 'category_slug',
				'value'       => $category,
				'description' => esc_html__( 'Choose special category to filter', 'swlabs-core'  )
			),
		),
		'value'       => '',
		'callbacks'   => array(
			'after_add' => 'vcChartParamAfterAddCallback'
		),
		'description' => esc_html__( 'Default no filter by category.', 'swlabs-core' ),
		'group'       => esc_html__('Filter', 'swlabs-core')
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Tag', 'swlabs-core' ),
		'param_name' => 'tag_list',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Tag', 'swlabs-core' ),
				'param_name'  => 'tag_slug',
				'value'       => $tag,
				'description' => esc_html__( 'Choose special tag to filter', 'swlabs-core'  )
			),
		),
		'value'       => '',
		'callbacks'   => array(
			'after_add' => 'vcChartParamAfterAddCallback'
		),
		'description' => esc_html__( 'Default no filter by tag.', 'swlabs-core' ),
		'group'       => esc_html__('Filter', 'swlabs-core')
	),
	
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Author', 'swlabs-core' ),
		'param_name' => 'author_list',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Author', 'swlabs-core' ),
				'param_name'  => 'author',
				'value'       => $author,
				'description' => esc_html__( 'Choose special author to filter', 'swlabs-core'  )
			),
		),
		'value'       => '',
		'callbacks'   => array(
			'after_add' => 'vcChartParamAfterAddCallback'
		),
		'description' => esc_html__( 'Default no filter by author.', 'swlabs-core' ),
		'group'       => esc_html__('Filter', 'swlabs-core')
	),
);
vc_map(array(
		'name'        => esc_html__( 'SW Carousel 2', 'swlabs-core' ),
		'base'        => 'swlabscore_block_carousel_sc_2',
		'class'       => 'swlabs-core-sc',
		'icon'        => 'icon-swlabscore_block_carousel_sc_2',
		'category'    => SWLABSCORE_SC_CATEGORY,
		'description' => esc_html__( 'Carousel with WP Posts.', 'swlabs-core' ),
		'params'      => $params
	)
);