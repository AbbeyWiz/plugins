<div class="shw-shortcode social-counter">
	<div class="swlabs-sc-<?php echo esc_attr($atts['id']).' '.esc_attr($atts['extra_class']); ?>">
	<?php
		if(!empty($atts['title'])) {
			printf( '<div class="section-name">%s</div>', $atts['title']);
		}
		$social_api = new SwlabsCore_Social_Api();
		$socials_array = SwlabsCore::get_params( 'social-counter' );
		echo '<ul class="social-connected">';
		foreach ($socials_array as $social_id => $social_name) { 
			if (isset($atts[$social_id]) && !empty($atts[$social_id])) {
				if( function_exists( 'swbignews_get_social_network_meta' ) ) {
					$social_network_meta = swbignews_get_social_network_meta($social_id, $atts[$social_id], $social_api);
					echo '<li>';
					echo '<a href="' . esc_url($social_network_meta['url']) . '" target="_blank" class="' . esc_attr($social_id) . '">';
					if($social_id == 'google') $social_id = 'google-plus';
					echo '<i class="fa fa-' . esc_attr($social_id) . '"></i>';
					echo '</a>';
					echo '<div class="detail">';
					echo '<strong>' . esc_attr(number_format($social_network_meta['api'])) . '</strong>';
					echo '<span>' . esc_attr($social_network_meta['text']) . '</span>';
					echo '</div>';
					echo '</li>';
				}
			}
		}
		echo '</ul>';
		if(!empty($atts['color'])) {
			$custom_css = '.swlabs-sc-'. esc_attr($atts['id']).' .section-name{
				color : '.esc_attr($atts['color']).';
				border-color : '.esc_attr($atts['color']).';
			}';
			do_action( 'swlabscore_add_inline_style', $custom_css );
		}
	?>
	</div>
</div>