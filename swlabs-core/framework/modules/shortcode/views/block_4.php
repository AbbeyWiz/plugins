<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$thumb_href_class = '';
$title_class = 'title';
//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
if($model->attributes['style'] == '2' ) {
	$html_format = '
			<div class="media col-sm-6 col-xs-6 media-full-width caption-2-row %6$s">
				<div class="media-body">
					%1$s
					<div class="caption light">
						%2$s
					</div>
				</div>
			</div>
		';
	$title_class = 'title big-text';
	$open_group = '<div class="list-submedia-style-1 col-sm-12">';
	$open_row = '<div class="row layout-media-horizontal"><div class="style-1">';
	$close_row = '</div></div>';
	$close_group = '</div>';

}
else {
	$html_format = '
			<div class="media  media-full-width col-xs-6 '. $model->attributes['responsive-class'] .' %6$s">
				<div class="media-body">
					%1$s%2$s
					<div class="info info-style-1">%3$s</div>
					%4$s
					<div class="description">%5$s</div>
				</div>
			</div>
		';
	$thumb_href_class = 'media-image';
	$open_group = '<div class="list-submedia-style-1 col-sm-12">';
	$open_row = '<div class="row layout-media-horizontal"><div class="style-1">';
	$close_row = '</div></div>';
	$close_group = '</div>';
}

$html_small_format = '
	<div class="media '. $model->attributes['responsive-class'] .' %6$s">
		<div class="media-left">
			%1$s
		</div>
		<div class="media-right">
			%2$s
			<div class="info info-style-1">%3$s</div>
		</div>
	</div>
	';

?>
<div class="shw-shortcode <?php if ($model->attributes['style'] == '3') { echo 'block-4-style-3'; }?> <?php echo esc_attr($block_cls) ?>">
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
		 	<?php if($model->attributes['style'] != '3' ){ 
		 		echo '
				<div class="layout-media-vertical row">
				<div class="style-1">';
			 } ?>
					<?php
						$post_options = array(
							'large_post_format' => $html_format,
							'small_post_format' => $html_small_format ,
							'open_group'        => $open_group,
							'open_row'          => $open_row,
							'close_row'         => $close_row,
							'close_group'       => $close_group,
							'large_post_counter' => 2,
							'large_thumb_href_class'  => $thumb_href_class,
							'small_thumb_href_class'  => 'media-image',
							'large_title_class'       => $title_class,
							'large_limit_content'     => true,
						);
						$model->render_block( $post_options );
					?>
			<?php if($model->attributes['style'] != '3' ){ echo '</div></div>'; } ?>
		</div>
	<?php endif; // have_post?>
</div>
<?php wp_reset_postdata();?>