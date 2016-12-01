<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];

//1: Feature image, 2: post title, 3: post meta, 4: post class, 5: responsive class, 6: small-group-class

$large_post_format = '';
$small_post_format = '';
$open_group = '';
$open_row = '';
$close_row = '';
$close_group = '';

if( $model->attributes['style'] == '2' ){

	$html_large = '
			<div class="block-item item-width-2">
				<div class="wrapper-item news-image">
					%1$s
					<div class="news-content caption dark">
						%2$s
						
					</div>
				</div>
			</div>
	';
	$html_small = '
			<div class="block-item item-width-1">
				<div class="wrapper-item news-image">
					%1$s
					<div class="news-content caption dark">
						%2$s
						
					</div>
				</div>
			</div>
	';

	$large_post_format = $html_large;
	$small_post_format = $html_small;
	$open_group = '';
	$open_row = '';
	$close_row = '';
	$close_group = '';
	$small_group_class = '';

}elseif ( $model->attributes['style'] == '3' ) {

	$html_format = '
				<div class="media-body %4$s">
					%1$s
					<div class="caption dark">%2$s</div>
				</div>';
	$large_post_format = '<div class="col-md-6 left-video-gallery"><div class="media big">'.$html_format.'</div></div>';
	$small_post_format = '<div class="col-md-6 col-xs-6"><div class="media %6$s">' .$html_format .'</div></div>';
	$open_group = '<div class="col-md-6 right-video-gallery">';
	$open_row = '<div class="row">';
	$close_row = '</div>';
	$close_group = '</div>';
	$small_group_class = array( '1' => 'top', '2' => 'bottom');

}
else{

	$html_large = '
			<div class="block-item item-width-2">
				<div class="wrapper-item news-image media">
					%1$s
					<div class="news-content caption dark">
						%2$s
						
					</div>
				</div>
			</div>
	';
	$html_small = '
			<div class="block-item item-width-1">
				<div class="wrapper-item news-image media">
					%1$s
					<div class="news-content caption dark">
						%2$s
						
					</div>
				</div>
			</div>
	';

	$large_post_format = $html_large;
	$small_post_format = $html_small;
	$open_group = '';
	$open_row = '';
	$close_row = '';
	$close_group = '';
	$small_group_class = '';

}
?>


<div class="<?php echo ( ( $model->attributes['style'] == '3' ) ? 'video-gallery caption-2-row' : 'technology-main news-masonry' ) ?> <?php echo ( ($model->attributes['style'] == '2') ? 'style-2' : '' ) ?> <?php echo ( ( $model->attributes['style'] != '2' && $model->attributes['style'] != '3') ? 'style-default' : '' ) ?> shw-shortcode <?php echo esc_attr($block_cls) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) ) :?>
		<div class="section-name">
			<div class="pull-left block-title"><?php echo esc_attr($model->attributes['block_title']);?></div>
			<div class="clearfix"></div>
		</div>
	<?php endif;?>
	<?php if ( $model->query->have_posts() ) :?>
		<div class="section-content">
		<?php 
			if( $model->attributes['style'] == '3' )
			{
				echo '<div class="carousel-style-2"><div class="row">';
			}
						$post_options = array(
							'large_post_format' => $large_post_format,
							'small_post_format' => $small_post_format,
							'open_group'        => $open_group,
							'open_row'          => $open_row,
							'thumb_href_class'  => '',
							'close_row'         => $close_row,
							'close_group'       => $close_group,
							'small-group-class' => $small_group_class
						);
						$model->render_grid( $post_options );
			if( $model->attributes['style'] == '3' )
			{
				echo '</div></div>';
			}
			?>
		</div>
	<?php endif; // have_post?>
</div>
<?php wp_reset_postdata();?>