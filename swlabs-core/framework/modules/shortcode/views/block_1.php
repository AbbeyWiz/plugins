<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$model->large_image_post = false;
$show_excerpt = $model->attributes['show_excerpt'];
//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class

$html_format = '
		 <div class="col-md-12 col-sm-12">
			<div class="thumb">
				%1$s
				%2$s
				<div class="info info-style-1">%3$s</div>
			</div>
		</div>';
?>
<div class="block1 section-category shw-shortcode <?php echo esc_attr($block_cls) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) || !empty( $model->attributes['category_filter'] ) ) :?>
		<div class="section-name block-title">
			<?php echo esc_attr($model->attributes['block_title']);?>
		</div>
	<?php endif;?>
	<?php if ( $model->query->have_posts() ) :?>
		<div class="section-content">
			<?php
			$post_options = array(
					'small_post_format' => $html_format,
					'open_row'          => '<div class="row">',
					'close_row'         => '</div>',
					'small_thumb_href_class'  => 'img_recommended mbl',
					'image_class'       => 'img_recommended mbl',
				);
			$model->render_block( $post_options );?>
		</div>
	<?php endif;?>
</div>
<?php wp_reset_postdata();?>