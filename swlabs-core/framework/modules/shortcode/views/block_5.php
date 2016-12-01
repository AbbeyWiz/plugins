<?php
$model = new SwlabsCore_Block;
$atts['related_post_count'] = 2;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];

//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
$excerpt = '';

if( $atts['showexcerpt'] == '2'){
	$excerpt = '<div class="abc">%5$s</div>';

}

$html_large = '
		<div class="thumb">
			%1$s
			%2$s
			<div class="info info-style-1">%3$s</div>'.$excerpt.'
		</div>';
$html_large = '<div class="col-md-6 col-sm-6">'.$html_large.'</div>';

$html_small = '
		<div class="media-left">%1$s</div>
		<div class="media-right">
			<div class="media-heading">%2$s</div>
			<div class="info info-style-1">%3$s</div>
		</div>';
$html_small = '<div class="media">' .$html_small .'</div>';
$open_group = '<div class="col-md-6 col-sm-6">';
$open_row = '<div class="block12-list">';
$close_row = '</div>';
$close_group = '</div>';
$thumb_href_class = 'img-wrapper';

?>
<div class="index-topics <?php echo ($atts['showexcerpt'])=='2' ? 'has-description' : '' ?> media-vertical shw-shortcode  <?php echo esc_attr($block_cls) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) ) :?>
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
		echo '<div class="row">';// open block
		$post_options = array(
			'large_post_format'			=> $html_large,
			'small_post_format'			=> $html_small,
			'open_group'				=> $open_group,
			'open_row'					=> $open_row,
			'new_row'					=> '',
			'small_thumb_href_class'	=> '',
			'large_thumb_href_class'	=> 'media-image',
			'close_row'					=> $close_row,
			'close_group'				=> $close_group,
			'thumb_href_class'			=> $thumb_href_class,
			'large_limit_content'		=> true,
			'close_block'               => '</div>',
		);
		$model->render_block( $post_options );?>
	</div>
	<?php endif;?>
</div>
<?php wp_reset_postdata();?>