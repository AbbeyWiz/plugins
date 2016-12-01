<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$model->large_image_post = false;

$html_format = '
		<div class="media %6$s">
			<div class="media-body">
				%1$s
				<div class="caption dark">%2$s</div>
			</div>
		</div>
	';
?>
<div class="most-popular-sidebar shw-shortcode <?php echo esc_attr($block_cls) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) ) :?>
		<div class="section-name block-title">
			<?php echo esc_attr($model->attributes['block_title']);?>
			<div class="clearfix"></div>
		</div>
	<?php endif;?>
	<?php if ( $model->query->have_posts() ) : ?>
		<div class="section-content">
			<div class="most-poppular-widget" data-item="<?php echo esc_attr( $model->query->post_count );?>">
			<?php
				$post_options = array(
					'small_post_format' => $html_format,
					'small_thumb_href_class'  => '',
				);
				$model->render_block( $post_options );
			?>
			</div>
		</div>
	<?php endif; // have_post ?>
</div>
<?php wp_reset_postdata();?>