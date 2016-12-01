<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$column = $model->attributes['column'];
if ( $column == '1' ){
	$carousel_style = 'carousel-style-1-item ';
	$carousel_item = 'carousel-1a-items';
}else if ( $column == '2' ){
	$carousel_style = 'carousel-style-2-items';
	$carousel_item = 'carousel-2-items';
}else if ( $column == '3' ){
	$carousel_style = 'carousel-style-3-items';
	$carousel_item = 'carousel-3-items';
}else{
	$carousel_style = 'carousel-style-4-items';
	$carousel_item = 'carousel-4-items';
}
$html_format=' 
	<div class="media %6$s">
		<div class="media-body">%1$s%2$s
		</div>
	</div>';
?>

<div class="<?php echo esc_attr( $carousel_style );?>  carousel-section shw-shortcode <?php echo esc_attr( $block_cls ) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) ) :?>
	<div class="section-name">
		<div class="pull-left block-title"><?php echo esc_attr( $model->attributes['block_title'] );?></div>
		<div class="pull-right">
			<div class="btn-slider">
				<div class="btn-slider-left"><i class="fa fa-angle-left"></i></div>
				<div class="btn-slider-right"><i class="fa fa-angle-right"></i></div>
			</div>
		</div>
	</div>
	<?php endif;?>
	<?php if ( $model->query->have_posts() ) :?>
	<div class="section-content">
		<div class="<?php echo esc_attr( $carousel_item  );?> carousel-media">
		<?php
			$post_options = array(
				'large_post_format' => $html_format,
			);
			$model->render_sc( $post_options );
			?>
		</div>
	</div>
	<?php endif; // have_post?>
</div>
<?php wp_reset_postdata();?>