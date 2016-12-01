<?php
if( ! function_exists( 'swbignews_get_ads_settings' ) ){
	return;
}
$option = swbignews_get_ads_settings($advertisement);
if($option['ads_display'] != 3){
	$align_cls = '';
	if($advertisement == 'header'){
		$align_cls = ' pull-right';
	}
	else if($advertisement == 'content' || $advertisement == 'content02' || $advertisement == 'content03'){
		$align_cls = ' center';
	}
?>
<div class="shw-shortcode swlabs-sc-<?php echo esc_attr($id).' '.esc_attr($extra_class); ?>">
	<?php 
	if($option['ads_display'] == 1){
		if($option['ads_target']){
			$option['ads_target'] = ' target="new"';
		}
		else{
			$option['ads_target'] = '';
		}
		if(!empty($option['ads_image']['url'])){
			$url = $option['ads_image']['url'];
		}
		else{
			$url = '';
		}
	?>
	<div class="banner-adv <?php echo esc_attr($align_cls); ?>">
		<?php
			printf('<a href="%s" title="" %s><img src="%s" alt="%s" class="img-responsive"/></a>',
					esc_url($option['ads_link']),
					esc_attr($option['ads_target']),
					esc_url($url),
					esc_attr($option['ads_alt'])
				);
		?>
	</div>
	<?php
	}
	else{
		printf('<div class="banner-adv %s">%s</div>', $align_cls, $option['ads_code']);
	}
	?>
</div>
<?php 
} // end if
if($option['ads_spacing']['margin-left']){
	$margin_left = ' margin-left : '.esc_attr($option['ads_spacing']['margin-left']).';';
}
else{
	$margin_left = '';
}
if($option['ads_spacing']['margin-top']){
	$margin_top = ' margin-top : '.esc_attr($option['ads_spacing']['margin-top']).';';
}
else{
	$margin_top = '';
}
if($option['ads_spacing']['margin-right']){
	$margin_right = ' margin-right : '.esc_attr($option['ads_spacing']['margin-right']).';';
}
else{
	$margin_right = '';
}
if($option['ads_spacing']['margin-bottom']){
	$margin_bottom = ' margin-bottom : '.esc_attr($option['ads_spacing']['margin-bottom']).';';
}
else{
	$margin_bottom = '';
}
$custom_css = '.swlabs-sc-'. esc_attr($id).' .banner-adv{'
	.$margin_left
	.$margin_top
	.$margin_right
	.$margin_bottom
.'}';
do_action( 'swlabscore_add_inline_style', $custom_css );
?>