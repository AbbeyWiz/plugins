<?php
$param = array (
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Title', 'swlabs-core' ),
			'param_name'  => 'title',
			'description' => esc_html__( 'Enter title.', 'swlabs-core' )
		),
		array(
			'type'        => 'textarea_html',
			'class'       => '',
			'heading'     => esc_html__( 'Content', 'swlabs-core' ),
			'param_name'  => 'content',
			'description' => esc_html__( 'Enter content.', 'swlabs-core' )
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Extra class', 'swlabs-core' ),
			'param_name'  => 'extra_class',
			'description' => esc_html__( 'Enter extra class.', 'swlabs-core' )
		),
	);

vc_map(array(
	'name'				=> esc_html__( 'SW Block Info', 'swlabs-core' ),
	'base'				=> 'swlabscore_block_info_sc',
	'class'				=> 'swlabs-core-sc',
	'icon'				=> 'icon-swlabscore_block_info_sc',
	'category'			=> SWLABSCORE_SC_CATEGORY,
	'description'		=> esc_html__( 'Show block information.', 'swlabs-core' ),
	'params'			=> $param 
	)
);