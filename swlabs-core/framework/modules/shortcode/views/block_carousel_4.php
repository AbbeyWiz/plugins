<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class']; 
$type = 'small';

$random_id = rand(1,100);
?>

<div class="shw-shortcode slide-banner-sidebar shw-shortcode <?php echo esc_attr($block_cls); ?>">
	<div class="heading block-title">
		<?php echo esc_attr( $model->attributes['block_title'] );?>
	</div>

	<?php if ( $model->query->have_posts() ) :?>
	<div id="viewed_posts_carousel-<?php echo esc_attr($random_id);?>"> 
		<div class="banner-sidebar">
			<?php while ( $model->query->have_posts() ) {
			$model->query->the_post();
			$model->loop_index(); 

			echo '<div class="item">
					<div class="slide-wrapper">
						'.$model->get_featured_image().$model->get_title().'<div class="info info-style-1">'.$model->get_meta().'<div class="description">'.$model->get_excerpt().'</div>
				</div></div>
				</div>';
			} //end while 
			?>
		</div>
	<?php endif; ?>
	</div>
</div>


<?php wp_reset_postdata();?>