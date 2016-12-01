<?php
$category = SwlabsCore_Com::get_category2slug_array();
$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'swlabs-core' ),
		'param_name'  => 'title',
		'value'       => '',
		'description' => esc_html__( 'Enter title of block', 'swlabs-core' )
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Choose Category', 'swlabs-core' ),
		'param_name' => 'category_list',
		'params'     => array(
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Add Category', 'swlabs-core' ),
				'param_name'  => 'category_slug',
				'value'       => $category,
				'description' => esc_html__( 'Choose special category to display.', 'swlabs-core'  )
			),
		),
		'value'       => '',
		'callbacks'   => array(
			'after_add' => 'vcChartParamAfterAddCallback'
		),
		'description' => esc_html__( 'Default display all categories if no category is selected.', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'swlabs-core' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'swlabs-core' )
	),
);
vc_map(array(
		'name'        => esc_html__( 'SW Categories', 'swlabs-core' ),
		'base'        => 'swlabscore_categories_sc',
		'class'       => 'swlabs-core-sc',
		'icon'        => 'icon-swlabscore_categories_sc',
		'category'    => SWLABSCORE_SC_CATEGORY,
		'description' => esc_html__( 'A categories list.', 'swlabs-core' ),
		'params'      => $params
	)
);