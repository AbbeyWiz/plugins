<?php
$model = new SwlabsCore_Block;
$model->init( $atts, $content );
$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
$type = 'large';

if($model->attributes['style'] == '2' ) {
	$params = SwlabsCore::get_params( 'block-image-size', 'block-slider-01-2' );
	$model->attributes['thumb-size'] = SwlabsCore_Util::get_thumb_size( $params, $model->attributes );
	if ( $model->query->have_posts() ) :
		echo ' <div class="slider-news-style2 '. esc_attr($block_cls).' shw-shortcode"> 
			<div id="'.esc_attr( $model->attributes['block-class'] ).'" data-ride="carousel" class="slider-news-carousel carousel slide mbs">
				<div class="carousel-inner">';
					while ( $model->query->have_posts() ) {
						$model->query->the_post();
						$model->loop_index();
						echo '<div class="item">
							<div class="items-wrapper">
								<div class="slider-caption">
									'.$model->get_title().'
	
									<div class="info info-style-1">
										
										'.$model->get_category().'
										
									
										'.$model->get_date().'
									</div>
									<div class="description">
										'.$model->get_excerpt().'
									</div>
								</div>
								'.$model->get_featured_image( $type ).'
							</div>
						</div>';
					};
				echo '
				</div>
				<a href="#'.esc_attr( $model->attributes['block-class'] ).'" data-slide="prev" class="left carousel-control">
					<span class="fa fa-angle-left"></span>
				</a>
				<a href="#'.esc_attr( $model->attributes['block-class'] ).'" data-slide="next" class="right carousel-control">
					<span class="fa fa-angle-right"></span>
				</a>
			</div>
			<div class="clearfix"></div>
		</div>';
	endif;
}
else{
	if ( $model->query->have_posts() ) :
		echo '<div class="slider-for '. esc_attr($block_cls).'">';
	
				while ( $model->query->have_posts() ) {
					$model->query->the_post();
					$model->loop_index();
					echo '<div class="items">
								<div class="items-wrapper">
									<div class="slider-caption">
										'. $model->get_title() .'
										<div class="info info-style-1">
											'. $model->get_category() .'
											'.$model->get_date() .'
										</div>
									<div class="description">'.$model->get_excerpt() .'</div>
									</div>
									'. $model->get_featured_image($type) .'
								</div>
							</div>';
				}
	
		echo '</div>';
	
		// small
		$type = 'small';
		echo '
		<div class="slider-nav">';
	
			while ( $model->query->have_posts() ) {
				$model->query->the_post();
				$model->loop_index();
	
			echo '
				<div class="items">
					<div class="news-image">
						<div class="images">'.$model->get_featured_image($type) .'</div>
						<div class="caption dark">'. $model->get_title() .'</div>
					</div>
				</div>';
			}
		echo ' </div>';
	endif;
}
wp_reset_postdata();