<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$type = 'large';
?>

<div class=" shw-shortcode <?php echo esc_attr($block_cls); ?>"> 
	<?php
		if( !empty($model->attributes['block_title']))
		{
			echo '
				<div class="section-name block-title">
					'.esc_attr($model->attributes['block_title']).'
				</div>';
		}
	?>

	<div class="carousel-inner-style" id="read-carousel-<?php echo esc_attr($model->attributes['block-class']) ?>">
	
		<?php if ( $model->query->have_posts() ) :?>
			<?php 
			$count = 0;
			while ( $model->query->have_posts() ) {
				$model->query->the_post();
				$model->loop_index();
				$count ++; 
				echo '	<div class="item">
							<div class="thumb">
								'.$model->get_featured_image($type).'
								<div class="caption">
									<div class="title">
										'.$model->get_category().'
										<div class="info">'.$model->get_title().'</div>
									</div>
								</div>
							</div>
						</div>';
			} //end while 
		?>
		<?php endif; ?>
	</div>
</div>
<?php wp_reset_postdata();

?>
