<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];

//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
$html_large = '
	<div class="media %6$s">
		<div class="media-body">%1$s
			<div class="caption dark">%2$s</div>
		</div>
	</div>';
$html_small = '
	<div class="media %6$s">
		<div class="media-left">%1$s</div>
		<div class="media-right">%2$s</div>
	</div>';
?>
 <div class="news-category shw-shortcode <?php echo esc_attr( $block_cls ) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) ) :?>
		<div class="section-name">
			<div class="pull-left block-title"><?php echo esc_attr($model->attributes['block_title']);?></div>
			<div class="clearfix"></div>
		</div>
	<?php endif;?>
	<?php if ( $model->query->have_posts() ) :?>
		<div class="section-content">
			<?php
				$post_options = array(
					'large_post_format' => $html_large,
					'small_post_format' => $html_small,
					'open_group'        => '<div class="category-list-style-1 auto-width-style">',
					'open_row'          => '',
					'close_row'         => '',
					'close_group'       => '</div>',
					'large_thumb_href_class'  => '',
					'small_thumb_href_class'  => 'media-image',
				);
				$model->render_block( $post_options );?>
		</div>
	<?php endif;?>
</div>
<?php wp_reset_postdata();?>