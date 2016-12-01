<?php
$style =SwlabsCore::get_params( 'accordion_style');
$params = array(
	array(
		'type'        => 'dropdown',
		'admin_label' => true,
		'heading'     => esc_html__( 'Layout', 'swlabs-core' ),
		'param_name'  => 'layout',
		'value'       => $style,
		'description' => esc_html__( 'Choose Layout', 'swlabs-core' )
	),
	array(
		"type"        => "textfield",
		"class"       => "",
		"heading"     => esc_html__( "Extra class", 'swlabs-core' ),
		"param_name"  => "extra_class",
		"description" => esc_html__( "Enter extra class.", 'swlabs-core' )
	),
);
$custom_markup = '<div class=" wpb_vc_accordion wpb_accordion_holder wpb_holder clearfix vc_container_for_children"></div>
			<div class="tab_controls">
				<a class="add_tab" title="' . esc_html__( 'Add section', 'swlabs-core' ) . '"><span class="icon-arrow"></span> <span class="tab-label">' . esc_html__( 'Add section', 'swlabs-core' ) . '</span></a>
			</div>';
vc_map(array(
	'name'						=> esc_html__( 'SW Accordion', 'swlabs-core' ),
	'base'						=> 'swlabscore_accordion_sc',
	'class'						=> 'swlabs-core-sc',
	'icon'                      => 'icon-swlabscore_accordion_sc',
	'category'					=> SWLABSCORE_SC_CATEGORY,
	'show_settings_on_create'	=> false,
	'is_container'				=> true,
	'description'				=> esc_html__( 'Collapsible content panels', 'swlabs-core' ),
	'params'					=> $params,
	'custom_markup'				=> $custom_markup,
	'default_content'			=> '
				[vc_accordion_tab title="' . esc_html__( 'Section 1', 'swlabs-core' ) . '"][/vc_accordion_tab]
				[vc_accordion_tab title="' . esc_html__( 'Section 2', 'swlabs-core' ) . '"][/vc_accordion_tab]
			',
	'js_view'			=> 'VcAccordionView'
	)
);