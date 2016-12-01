<?php
$params = array(
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'swlabs-core' ),
		'param_name'  => 'title',
		'value'       => esc_html__( 'SOCIAL CONNECTED', 'swlabs-core' ),
		'description' => esc_html__( 'Enter title for this block', 'swlabs-core' )
	),
	array(
		'type'        => 'colorpicker',
		'heading'     => esc_html__('Title color', 'swlabs-core'),
		'param_name'  => 'color',
		'value'       => '',
		'description' => esc_html__('Choose a title color for this block', 'swlabs-core')
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Facebook User:', 'swlabs-core'),
		'param_name'  => 'facebook',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Twitter User:', 'swlabs-core'),
		'param_name'  => 'twitter',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Youtube User:', 'swlabs-core'),
		'param_name'  => 'youtube',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Vimeo User:', 'swlabs-core'),
		'param_name'  => 'vimeo',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Google Plus ID:', 'swlabs-core'),
		'param_name'  => 'google',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Instagram User:', 'swlabs-core'),
		'param_name'  => 'instagram',
		'value'       => '',
		'description' => '',
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('Soundcloud User:', 'swlabs-core'),
		'value'       => '',
		'param_name'  => 'soundcloud',
		'description' => '',
	),
	array(
		'heading'     => esc_html__('RSS User:', 'swlabs-core'),
		'type'        => 'textfield',
		'param_name'  => 'rss',
		'value'       => '',
		'description' => '',
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
		'name'        => esc_html__( 'SW Social Counter', 'swlabs-core' ),
		'base'        => 'swlabscore_social_counter_sc',
		'class'       => 'swlabs-core-sc',
		'icon'        => 'icon-swlabscore_social_counter_sc',
		'category'    => SWLABSCORE_SC_CATEGORY,
		'description' => esc_html__( 'Create a social counter.', 'swlabs-core' ),
		'params'      => $params
	)
);