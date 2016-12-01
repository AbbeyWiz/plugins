<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$index = 0;
$options = array( 'thumb_href_class' => '' );
?>
<div class="clearfix shw-shortcode <?php echo esc_attr( $block_cls ) ?>">
	<?php if ( $model->query->have_posts() ) :?>
	<div data-ride="carousel" data-interval="" class="carousel-style-5 shw-shortcode carousel slide">
		<div class="carousel-inner">
			<?php while ( $model->query->have_posts() ) {
			$model->query->the_post();
			$model->loop_index();
			$type = 'large';
			echo '
				<div class="item media '. $model->get_post_class().'">'.$model->get_featured_image( $type ).'
					<div class="caption dark">
						<div class="title">'.$model->get_title().'</div>
					</div>
				</div>';
			}
			wp_reset_postdata();?>
		</div>
	</div>
	<div class="sub-carousel-style-5 shw-shortcode">
		<?php while ( $model->query->have_posts() ) {
			$model->query->the_post();
			$model->loop_index();
			$type  = 'small';
			echo '
				<div data-target=".carousel-style-5" data-slide-to="'.$index.'" class="item '. $model->get_post_class().'">
					<div class="media">
						<div class="media-body">'.$model->get_featured_image( $type, false, $options ).'
							<div class="caption dark">'.$model->get_title().'</div>
						</div>
					</div>
				</div>';
			$index++;
			} //end while 
			wp_reset_postdata();?>
	</div>
<?php endif; // have_post ?>
</div>
<?php wp_reset_postdata();?>