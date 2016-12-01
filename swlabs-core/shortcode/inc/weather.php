<?php
$params = array(
	array(
		'type'        => 'textfield',
		'admin_label' => true,
		'heading'     => esc_html__( 'Title', 'swlabs-core' ),
		'param_name'  => 'title',
		'value'       => 'Weather',
		'description' => esc_html__( 'Entar title of block.', 'swlabs-core' )
		),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__('Title color', 'swlabs-core'),
		'param_name'  => 'color',
		'value'       => '',
		'description' => esc_html__('Choose a title color for this block', 'swlabs-core')
	),
	array(
		"type"        => "textfield",
		"class"       => "",
		"heading"     => esc_html__( "Location", 'swlabs-core' ),
		"param_name"  => "location",
		"description" => esc_html__( "(i.e: Austin, TX or London, UK)", 'swlabs-core' )
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
	'name'        => esc_html__( 'SW Weather','swlabs-core' ),
	'base'        => 'swlabscore_weather_sc',
	'class'       => 'swlabs-core-sc',
	'icon'        => 'icon-swlabscore_weather_sc',
	'category'    => SWLABSCORE_SC_CATEGORY,
	'description' => esc_html__( 'Create a weather block.', 'swlabs-core' ),
	'params'      => $params
		)
	);