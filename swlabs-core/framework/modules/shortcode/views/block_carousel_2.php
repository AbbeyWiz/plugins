<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$type = 'large';
?>

<div class="shw-shortcode <?php echo esc_attr($block_cls); ?>"> 
	<div class="section-name block-title">
		<?php echo esc_attr($model->attributes['block_title']); ?>
	</div>
	<div class="section-content">
		<?php if ( $model->query->have_posts() ) :?>
		<div class="carousel-02">  
			<?php 
			$count = 0;
			while ( $model->query->have_posts() ) {
				$model->query->the_post();
				$model->loop_index();
				$count ++; 
				echo '<div class="item">
							<div class="thumb">
								'.$model->get_featured_image($type).'
							</div>
							'.$model->get_title().'
							<div class="info info-style-1">
								'.$model->get_meta().'
							</div>
						</div>';
			} //end while 
		?>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php wp_reset_postdata();

?>
