<?php
$category = SwlabsCore_Com::get_category2slug_array();
$tag = SwlabsCore_Com::get_tax_options2slug( 'post_tag', array('empty' => esc_html__( '-All tags-', 'swlabs-core' )) );
$author = SwlabsCore_Com::get_user_login2id(array(), array('empty' => esc_html__( '-All authors-', 'swlabs-core' )) );
$orderby = SwlabsCore::get_params('sort_blog');
$show_paging = SwlabsCore::get_params('show-paging');
$category_filter = SwlabsCore::get_params('category_filter');
$column = SwlabsCore::get_params('column-2');
$style = array(
	'Default' => '',
	'Style 2' => '2',
);

$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Block Title', 'swlabs-core' ),
		'param_name'  => 'block_title',
		'value'       => '',
		'description' => esc_html__( 'Block title. If it blank the block will not have a title', 'swlabs-core' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__( 'Block Title Color', 'swlabs-core' ),
		'param_name'  => 'block_title_color',
		'value'       => '',
		'description' => esc_html__( 'Choose a custom title text color.', 'swlabs-core' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'swlabs-core' ),
		'param_name'  => 'style',
		'value'       => $style,
		'description' => esc_html__( 'Choose columns to display small posts.', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Number Posts', 'swlabs-core' ),
		'param_name'  => 'limit_post',
		'value'       => '5',
		'description' => esc_html__( 'The number of posts to display. If it blank the number posts will be the number from Wordpress settings -> Reading', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Offset Posts', 'swlabs-core' ),
		'param_name'  => 'offset_post',
		'value'       => '',
		'description' => esc_html__( 'Enter offset to display. If you want to start on record 6, using offset 5', 'swlabs-core' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Columns', 'swlabs-core' ),
		'param_name'  => 'column',
		'value'       => $column,
		'description' => esc_html__( 'Choose columns to display small posts.', 'swlabs-core' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Sort By', 'swlabs-core' ),
		'param_name'  => 'sort_by',
		'value'       => $orderby,
		'description' => esc_html__( 'Choose criteria to display.', 'swlabs-core' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Pagination', 'swlabs-core' ),
		'param_name'  => 'pagination',
		'value'       => $show_paging,
		'description' => esc_html__( 'Show pagination.', 'swlabs-core' )
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Show Ajax Dropdown - Filter type', 'swlabs-core' ),
		'param_name'  => 'category_filter',
		'value'       => $category_filter,
		'dependency' => array(
			'element' => 'pagination',
			'value_not_equal_to' => array( 'yes' ),
		),
		'description' => esc_html__( 'Show the ajax dropdown filter. If no items are seleted in "Filter" tab, the ajax dropdown filter will show all items ( ex: all categories, all tags, all author )', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Ajax Dropdown - Filter default text', 'swlabs-core' ),
		'param_name'  => 'category_filter_text',
		'value'       => esc_html__('All', 'swlabs-core'),
		'dependency' => array(
			'element' => 'pagination',
			'value_not_equal_to' => array( 'yes' ),
		),
		'description' => esc_html__( 'The default text for first item.', 'swlabs-core' )
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
		'name'        => esc_html__( 'SW Block 3', 'swlabs-core' ),
		'base'        => 'swlabscore_block_sc_3',
		'icon'        => 'icon-swlabscore_block_sc_3',
		'category'    => SWLABSCORE_SC_CATEGORY,
		'description' => esc_html__( 'Block of posts.', 'swlabs-core' ),
		'params'      => $params
	)
);