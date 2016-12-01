<?php
$model = new SwlabsCore_Block; 

$model->init( $atts, $content );



$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$small_class = 'style-1 ';
if( $model->attributes['column'] == '1' ) {
	$small_class = 'style-2 ';
}

//1: Feature image, 2: post title, 3: post meta, 4: related post, 5: content, 6: post class
if($model->attributes['style'] == '2' ) {
	$html_format = '
			<div class="media  %6$s">
				<div class="media-body">
					%1$s
					<div class="media-content">
						%2$s
						<div class="info info-style-1">%3$s</div>
						%4$s
						<div class="description">%5$s</div>
					</div>
				</div>
			</div>
		';
	$thumb_href_class = 'media-image';
	$title_class = 'title';
	$open_group = '<div class="list-submedia-style-1">';
	$open_row = '<div class="layout-media-horizontal row">';
	$close_row = '</div>';
	$close_group = '</div>';
}else {
	$html_format = '
		<div class="row mbxl">
			<div class="col-md-12">
				<div class="thumb">%1$s</div>
					%2$s
					<div class="info info-style-1">%3$s</div>
					<div class="description">%5$s</div>
			</div>
		</div>
	';
	$thumb_href_class = 'media-image';
	$title_class = 'title';
	$open_group = '<div class="topic-list-small"><div class="row">';
	$open_row = '<div class="col-md-6 col-sm-6">';
	$close_row = '</div>';
	$close_group = '</div></div>';
}

if($model->attributes['style'] == '2'){
	$html_small_format = '
			<div class="media %6$s">
				<div class="media-left">
					%1$s
				</div>
				<div class="media-right">
					%2$s
					<div class="info info-style-1">%3$s</div>
					<div class="description">%5$s</div>
				</div>
			</div>
			';
	$small_post_format ='<div class="' . $small_class . $model->attributes['responsive-class'] .'">' .$html_small_format .'</div>';
}else{
	$small_post_format = '
		<div class="media">
			<div class="media-left">
				%1$s
			</div>
			<div class="media-right">
				<div class="media-heading">%2$s</div>
				<div class="info info-style-1">%3$s</div>
				
			</div>
		</div>
		';
}
?>
<div class="media-vertical shw-shortcode <?php if ($model->attributes['style'] == '') { echo 'block-9-style-3'; }?> <?php echo esc_attr($block_cls) ?>">
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
			echo '
			<div class="layout-media-vertical row">
				<div class="col-sm-12">';
					
						$post_options = array(
							'large_post_format' => $html_format,
							'small_post_format' => $small_post_format,
							'open_group'        => $open_group,
							'open_row'          => $open_row,
							'close_row'         => $close_row,
							'close_group'       => $close_group,
							'large_thumb_href_class'  => $thumb_href_class,
							'small_thumb_href_class'  => 'media-image',
							'large_title_class'       => $title_class,
							'large_limit_content'     => true,
						);
						$model->render_block( $post_options );
					
				echo '	
				</div>
			</div>'; ?>
		</div>
	<?php endif; // have_post?>
</div>
<?php wp_reset_postdata();?>