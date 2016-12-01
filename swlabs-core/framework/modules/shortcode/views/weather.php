<div class="shw-shortcode swlabs-sc-<?php echo esc_attr($id).' '.esc_attr($extra_class); ?>">
<?php
	if(!empty($title)){
		printf('<div class="section-name">%s</div>', $title);
	}
	printf('<div class="section-content">
				<div class="weather-news weather-%s" data-item="%s"></div>
				<div class="clearfix"></div>
			</div>',
			esc_attr( $id ),
			esc_attr( $location )
		);
	if(!empty($color)) {
		$custom_css = '.swlabs-sc-'. esc_attr($id).' .section-name{
			color : '.esc_attr($color).';
			border-color : '.esc_attr($color).';
		}';
		do_action( 'swlabscore_add_inline_style', $custom_css );
	}
?>
</div>