<?php
//extend from visual composer
$style = SwlabsCore::get_params('tab_style');
vc_map( array(
	'name'                    => esc_html__( 'SW Tabs', 'swlabs-core'),
	'base'                    => 'swlabscore_tab_sc',
	'class'                   => 'swlabs-core-sc',
	'icon'                    => 'icon-swlabscore_tab_sc',
	'show_settings_on_create' => false,
	'is_container'            => true,
	'category'                => SWLABSCORE_SC_CATEGORY,
	'description'             => esc_html__( 'Collapsible content panels', 'swlabs-core' ),
	'params'                  => array(
		array(
			'type'        => 'dropdown',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'swlabs-core' ),
			'param_name'  => 'style',
			'value'       => $style,
			'description' => esc_html__( 'Choose style', 'swlabs-core' )
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'swlabs-core' ),
			'param_name'  => 'extra_class',
			'value'       => '',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'swlabs-core' )
		)
	),
	'custom_markup' => '
			<div class="wpb_vc_accordion wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
			</div>
			<div class="tab_controls">
				<a class="add_tab" title="' . esc_html__( 'Add section', 'swlabs-core' ) . '"><span class="icon-arrow"></span> <span class="tab-label">' . esc_html__( 'Add section', 'swlabs-core' ) . '</span></a>
			</div>
			',
			'default_content' => '
				[vc_accordion_tab title="' . esc_html__( 'Section 1', 'swlabs-core' ) . '"][/vc_accordion_tab]
				[vc_accordion_tab title="' . esc_html__( 'Section 2', 'swlabs-core' ) . '"][/vc_accordion_tab]
			',
	'js_view' => 'VcAccordionView'
) );