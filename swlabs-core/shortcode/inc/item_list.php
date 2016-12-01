<?php
//extend from visual composer
$style = SwlabsCore::get_params('item_list_style');
$params = array(
		array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Layout', 'swlabs-core' ),
				'param_name'  => 'style',
				'value'       => $style,
				'description' => esc_html__( 'Choose layout to display.', 'swlabs-core' )
			),
		array(
				'type'        => 'colorpicker',
				'class'       => '',
				'heading'     => esc_html__( 'Icon Color', 'swlabs-core' ),
				'param_name'  => 'icon_color',
				'value'       => '',
				'description' => esc_html__( 'Choose icon color.', 'swlabs-core' )
			),
		array(
				'type'        => 'colorpicker',
				'class'       => '',
				'heading'     => esc_html__( 'Icon Background  Color', 'swlabs-core' ),
				'param_name'  => 'icon_bg_color',
				'value'       => '',
				'description' => esc_html__( 'Choose icon background color.', 'swlabs-core' )
			),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Add Item', 'swlabs-core' ),
			'param_name' => 'list_item',
			'params'     => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'swlabs-core' ),
					'param_name'  => 'title',
				),
			),
			'callbacks' => array(
				'after_add' => 'vcChartParamAfterAddCallback'
			),
		),
		array(
			"type"        => "textfield",
			"class"       => "",
			"heading"     => esc_html__( "Extra class", 'swlabs-core' ),
			"param_name"  => "extra_class",
			"description" => esc_html__( "Enter extra class.", 'swlabs-core' )
			),
		);
vc_map( array(
	'name'        => esc_html__( 'SW Bullets and List','swlabs-core' ),
	'base'        => 'swlabscore_item_list_sc',
	'class'       => 'swlabs-core-sc',
	'icon'        => 'icon-swlabscore_item_list_sc',
	'category'    => SWLABSCORE_SC_CATEGORY,
	'params'      => $params
		)
	);