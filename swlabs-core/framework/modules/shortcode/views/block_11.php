<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$model->large_image_post = false;
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];

//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
$html_format = '
		<div class="media %6$s">
			<div class="media-body">%1$s%2$s
				<div class="info info-style-1">%3$s</div>
				<div class="description">%5$s</div>
			</div>
		</div>
	';
?>
<div class="list-page-vertical-full-3 shw-shortcode <?php echo esc_attr($block_cls) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) || !empty( $model->attributes['category_filter'] ) ) :?>
		<div class="section-name">
			<div class="pull-left block-title"><?php echo esc_attr($model->attributes['block_title']);?></div>
			<div class="pull-right">
				<?php $model->render_category_tabs(); ?>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php endif;?>
	<?php if ( $model->query->have_posts() ) :?>
	<div class="section-content">
		<?php
		$post_options = array(
			'small_post_format' => '<div class="style-1 '. $model->attributes['responsive-class'] .'">'.$html_format.'</div>',
			'open_row'          => '<div class="layout-media-vertical row">',
			'close_row'         => '</div>',
		);
		$model->render_block( $post_options );
		?>
	</div>
	<?php endif;?>
</div>
<?php wp_reset_postdata();?>