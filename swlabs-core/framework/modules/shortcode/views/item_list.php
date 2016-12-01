<?php
$custom_css = "";
$class = "list-style-" . $style;
if ( $style == '02' || $style == '03'){
	$custom_css .= sprintf('.%s-%s.light ul li:before{color:%s}',esc_attr( $class ),esc_attr( $id ),esc_attr( $icon_color ));
}else{
	$custom_css .= sprintf('.%s-%s.light ul li:before{color:%s;background-color:%s;border-color:%s}',esc_attr( $class ),esc_attr( $id ),esc_attr( $icon_color ),esc_attr( $icon_bg_color ),esc_attr( $icon_bg_color ));
}
do_action( 'swlabscore_add_inline_style', $custom_css );
?>
<div class="demo-list-style shw-shortcode">
		<div class="<?php echo esc_attr( $class )." "; echo esc_attr( $class ).'-'.esc_attr( $id )." ";echo esc_attr( $extra_class );?>">
			<ul class="list-unstyled">
				<?php foreach ( $data as $value){
						$item_title = SwlabsCore::get_value( $value, 'title' );
						if ( !empty( $item_title ) ) {
							echo '<li>'.esc_attr( $item_title ).'</li>';
						}
					}
				?>
			</ul>
		</div>
</div>
