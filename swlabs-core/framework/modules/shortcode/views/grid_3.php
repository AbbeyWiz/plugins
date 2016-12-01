<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$model->large_image_post = false;

//1: Feature image, 2: post title, 3: post meta, 4: post class, 5: responsive class, 6: small-group-class

	$html_format = '
		<div class="media">
			<div class="media-body">%1$s%2$s
				<div class="info info-style-1">%3$s</div>
			</div>
		</div>';
	if($model->attributes['column'] == '3'){
		$column = 'col-sm-4 col-xs-4';
	}
	if($model->attributes['column'] == '4'){
		$column = 'col-md-3 col-xs-6';
	}

	$small_post_format = '<div class="'.$column.' style-1">' .$html_format .'</div>';
	$open_row = '<div class="layout-media-vertical row">';
	$close_row = '</div>';
	$thumb_href_class = '';

?>
<div class="list-page-vertical-full-3 shw-shortcode grid-03  <?php echo esc_attr($block_cls) ?>">
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
				'small_post_format' => $small_post_format,
				'open_row'          => $open_row,
				'close_row'         => $close_row,
				'thumb_href_class'  => $thumb_href_class,
			);
			$model->render_grid( $post_options );?>

	</div>
	<?php endif; // have_post?>
</div>
<?php wp_reset_postdata();?>