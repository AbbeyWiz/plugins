<?php
$args = array(
	'posts_per_page'   => -1,
	'post_type'        => 'awesome-surveys',
	'post_status'      => 'publish'
);
$posts = get_posts( $args );
$surveys = array(''=>'');
foreach($posts as $post){
	$k = (!empty($post->post_title))? $post->post_title : $post->post_name;
	$surveys[$k] = $post->ID;
}
$params = array(
	array(
		'type'        => 'dropdown',
		'admin_label' => true,
		'heading'     => esc_html__( 'Choose survey', 'swlabs-core' ),
		'param_name'  => 'survey',
		'value'       => $surveys,
		'description' => esc_html__( 'Choose survey to display.', 'swlabs-core' )
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Extra Class', 'swlabs-core' ),
		'param_name'  => 'extra_class',
		'value'       => '',
		'description' => esc_html__( 'Add extra class to block', 'swlabs-core' )
	),
);
if(SWLABSCORE_AWESOME_SURVEYS_ACTIVE){
	vc_map(array(
			'name'        => esc_html__( 'SW Survey', 'swlabs-core' ),
			'base'        => 'swlabscore_survey_sc',
			'class'       => 'swlabs-core-sc',
			'icon'        => 'icon-swlabscore_survey_sc',
			'category'    => SWLABSCORE_SC_CATEGORY,
			'description' => esc_html__( 'Create a survey.', 'swlabs-core' ),
			'params'      => $params
		)
	);
}