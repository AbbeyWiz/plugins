<?php
$params = array(
	array(
		'type'        => 'textfield',
		'admin_label' => true,
		'heading'     => esc_html__( 'Title', 'swlabs-core' ),
		'param_name'  => 'block_title',
		'value'       => 'Football livescore',
		'description' => esc_html__( 'Entar title of block.', 'swlabs-core' )
		),
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Title color', 'swlabs-core'),
		'param_name' => 'block_title_color',
		'value' => '',
		'description' => esc_html__('Choose a title color for this block', 'swlabs-core')
	),
	array(
		"type"        => "textfield",
		"class"       => "",
		"heading"     => esc_html__( "Extra class", 'swlabs-core' ),
		"param_name"  => "extra_class",
		"description" => esc_html__( "Enter extra class.", 'swlabs-core' ) 
	),
	array(
		'type' => 'param_group',
		'heading' => esc_html__( 'Leagues', 'swlabs-core' ),
		'param_name' => 'leagues_list',
		'params' => array(
			array(
				'type' => 'dropdown',
				'admin_label' => true,
				'heading' => esc_html__( 'Add League', 'swlabs-core' ),
				'param_name' => 'selected',
				'value'       => array(
										esc_html__( 'All Leagues', 'swlabs-core' ) => 'All',
										esc_html__( 'Liga', 'swlabs-core' ) => 'league-1',
										esc_html__( 'Ligue 1', 'swlabs-core' ) => 'league-2',
										esc_html__( 'Serie A', 'swlabs-core' ) => 'league-3',
										esc_html__( 'Bundesliga', 'swlabs-core' ) => 'league-4',
										esc_html__( 'Eredivisie', 'swlabs-core' ) => 'league-5',
										esc_html__( 'Pro League', 'swlabs-core' ) => 'league-6',
										esc_html__( 'Premier League', 'swlabs-core' ) => 'league-7'),
				'description' => esc_html__( 'Choose special a league to show', 'swlabs-core'  )
			),
		), 
		'description' => esc_html__( 'Default all leagues.', 'swlabs-core' ), 
	)
);
vc_map( array(
	'name'        => esc_html__( 'SW Football Livescore','swlabs-core' ),
	'base'        => 'swlabscore_livescore_sc',
	'class'       => 'swlabs-core-sc',
	'icon'        => 'icon-swlabscore_livescore_sc',
	'category'    => SWLABSCORE_SC_CATEGORY,
	'description' => esc_html__( 'Create a weather block.', 'swlabs-core' ),
	'params'      => $params
		)
	);