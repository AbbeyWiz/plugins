<?php
$advertisement = SwlabsCore::get_array_to_shortcode(SwlabsCore::get_params('advertisement'));
$params = array(
	array(
		'type'        => 'dropdown',
		'admin_label' => true,
		'heading'     => esc_html__( 'Choose Advertisement', 'swlabs-core' ),
		'param_name'  => 'advertisement',
		'value'       => $advertisement,
		'description' => esc_html__( 'Go to "Theme options -> Advertisement Settings" to configure advertisement.', 'swlabs-core' )
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
	'name'        => esc_html__( 'SW Ads Banner','swlabs-core' ),
	'base'        => 'swlabscore_advertisement_sc',
	'class'       => 'swlabs-core-sc',
	'icon'        => 'icon-swlabscore_advertisement_sc',
	'category'    => SWLABSCORE_SC_CATEGORY,
	'description' => esc_html__( 'Create a advertisement banner.', 'swlabs-core' ),
	'params'      => $params
		)
	);