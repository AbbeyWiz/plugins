<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$model->large_image_post = false;
$show_excerpt = '';
$show_excerpt = $atts['showexceprt'];
//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
if (  $show_excerpt == '2' ){
	$desc = '<div class="description">%5$s</div>';
}else{
	$desc = '';
}
$html_format = '
		 <div class="media">
			<div class="media-left">%1$s</div>
			<div class="media-right">%2$s
				<div class="info info-style-1">%3$s</div>'.$desc.'
			</div>
		</div>';
?>
<div class="list-page-horizotal-1 block-8 shw-shortcode <?php echo esc_attr($block_cls) ?>">
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
					'small_post_format' => '<div class="style-1 %7$s">'.$html_format.'</div>',
					'open_row'			=> '<div class="layout-media-horizontal row">',
					'close_row'			=> '</div>',
				);
			$model->render_block( $post_options );?>
		</div>
	<?php endif;?>
</div>
<?php wp_reset_postdata();?>