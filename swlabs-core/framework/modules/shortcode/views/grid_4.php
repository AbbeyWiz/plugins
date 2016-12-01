<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$model->large_image_post = false;

//1: Feature image, 2: post title, 3: post meta, 4: post class, 5: responsive class, 6: small-group-class

$html_format = '
	<li>%1$s
		<div class="description">
			<div class="inner">
				<div class="media-content">%2$s
					<div class="info info-style-1">%3$s</div>
				</div>
			</div>
		</div>
	</li>';
$open_group = '<ul class="most-view-list">';
$close_group = '</ul>';

?>
<div class="most-viewed-widget shw-shortcode <?php echo esc_attr($block_cls) ?>">
	<?php if( !empty( $model->attributes['block_title'] ) ) :?>
	<div class="section-name">
		<div class="pull-left block-title"><?php echo esc_attr($model->attributes['block_title']);?></div>
		<div class="clearfix"></div>
	</div>
	<?php endif;?>
	<div class="section-content">
		<?php if ( $model->query->have_posts() ) :?>
			<?php
				$post_options = array(
							'small_post_format' => $html_format ,
							'open_group'        => $open_group,
							'open_row'          => '',
							'close_row'         => '',
							'close_group'       => $close_group,
							'thumb_href_class'  => '',
						);
				$model->render_grid( $post_options );?>
		<?php endif; // have_post?>
	</div>
</div>
<?php wp_reset_postdata();?>