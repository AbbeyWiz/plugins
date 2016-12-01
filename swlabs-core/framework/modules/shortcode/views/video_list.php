<?php
	$model = new SwlabsCore_Block;
	$atts['post_filter_by']  = 'post_format_video';
	$model->init( $atts, $content );
	$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
	$model->large_image_post = false; 
	$show_excerpt = $model->attributes['show_excerpt'];
	$html_format1 = '
			<div class="item">
				 %1$s
			</div>';
	?>
	<div class="top-video  clearfix <?php echo esc_attr( $block_cls ); ?> shw-shortcode">
		<div class="section-name">
			<div class="pull-left"><a href="#"><?php echo esc_attr( $atts['block_title'] );?></a>
			</div>
		</div>
		<div class="section-content">
			<div class="row">
				<div class="col-md-12 first_video">
					<div class="video-col left">
						<div data-ride="carousel" data-interval="" class="video-slider carousel slide carousel-fade">
							<div class="carousel-inner">
							 	<?php $model->render_videos(array(
							 		'small_post_format' => '<div class="item"> %1$s </div>',
							 	));?>
							</div>
						</div>
					</div>
				</div> 
			</div>  
			<?php 
				$output = '<div data-target=".video-slider" data-slide-to="%9$s" class="media video-block col-md-6 mbxl col-sm-6 col-xs-6"> 
									<div class="media-thumb-video">
										%2$s
									</div>
									%3$s
									<div class="info info-style-1">
										 %4$s
									</div> 
								</div>';
 					?> 
 					<?php $model->render_videos(array(
							 		'small_post_format' => $output,
							 	),true);?> 
		</div>
	</div>