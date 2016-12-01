<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$model->large_image_post = false;
$open_group= '<div class="category-list-style-1">';
$close_group = '</div>';

//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
$html_format = '
	<div class="media">
		<div class="media-left"><i class="fa fa-caret-right"></i></div>
		<div class="media-right">%2$s</div>
	</div>';
if( $model->attributes['style'] == '2') {
	$open_group= '<ul class="topic-style-1">';
	$close_group = '</ul>';
	$html_format = '
			<li>
				%2$s
				<div class="info info-style-1">%3$s</div>
			</li>
			';
}
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
			'small_post_format' => $html_format,
			'open_group'    => $open_group,
			'open_row'      => '',
			'close_row'     => '',
			'close_group'   => $close_group,
		);
		$model->render_block( $post_options );?>
	<?php endif;?>
	</div>
</div>
<?php wp_reset_postdata();?>