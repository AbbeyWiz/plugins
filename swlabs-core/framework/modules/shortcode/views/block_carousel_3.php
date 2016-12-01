<?php
$model = new SwlabsCore_Block;
$limit_post = $atts['limit_post'];
$model->init( $atts, $content );
$model->large_image_post = false;
if (!empty($atts['load_ajax']) && $atts['load_ajax'] == 1): 
	$html_template = '
	<div class="item ">
		<div class="media">
			<div class="media-left"> %1$s </div>
			<div class="media-right">
				<div class="media-heading">%2$s</div> 
				<div class="info info-style-1">%3$s</div>
				<div class="description">%5$s</div>
			</div>
		</div>
	</div> ';
	if ( $model->query->have_posts() ) :
		$post_options = array(
			'small_post_format'			=> $html_template, 
			'small_thumb_href_class'	=> '', 
			'thumb_href_class'			=> 'img-wrapper'
			);
		$model->render_block( $post_options );
	endif;
else :
	$atts['limit_post'] = '';
	$model->init( $atts, $content );
	$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
	$block_attr = $model->attributes['block-class'];
	$first_category =  array();
	$first_category_name = '';
	$categories = array();
	$atts['category_list'] = ($atts['category_list'] == '%5B%7B%7D%5D') ? '': $atts['category_list'];
	$atts['author_list'] = ($atts['author_list'] == '%5B%7B%7D%5D') ? '': $atts['author_list'];
	$atts['tag_list'] = ($atts['tag_list'] == '%5B%7B%7D%5D') ? '': $atts['tag_list'];
	if( null == (vc_param_group_parse_atts($atts['category_list'])) 
		&& vc_param_group_parse_atts($atts['tag_list']) == null 
		&& vc_param_group_parse_atts($atts['author_list']) == null)
	{
		$categories = get_categories();
	}
	else
	{
		$temp_categories =  get_categories(); 
		if( null !== (vc_param_group_parse_atts($atts['category_list']))){ 
		 	$temp_arr = SwlabsCore_Util::get_list_vc_param_group($atts,'category_list','category_slug');
			foreach ($temp_arr[1] as $key => $value) 
			{
				foreach ($temp_categories as $object) 
				{
					if($value === $object->category_nicename)
					{
						array_push($categories,$object);
					}
				}
			}
		}else{
			$author_posts = get_posts($model->query) ;
			
			if ( $model->query->have_posts() ) :
				while( $model->query->have_posts()  ):
					$model->query->the_post();
					foreach(get_the_category(get_the_ID()) as $category) {
						$cat_array[$category->term_id] =  $category->term_id;
					} 
				endwhile;
			endif; 
			wp_reset_postdata();
			foreach ($cat_array as $key => $value) 
			{
				foreach ($temp_categories as $object) 
				{
					if($value == $object->term_id)
					{ 
						array_push($categories,$object);
					}
				}
			}
			
		}
	}
	
	$atts['limit_post'] = $limit_post;
	$flug = 0;
	$html_cat ='';
	foreach ($categories as $category) {
		if ($flug++ ===0) {
			$first_category = $category;
			$first_category_name = $category->cat_name; 
		} break; 
	}
	
	$model->init( $atts, $content );  
	$html_template = '
		<div class="item ">
			<div class="media">
				<div class="media-left"> %1$s </div>
				<div class="media-right">
					<div class="media-heading">%2$s</div>
					<div class="info info-style-1">%3$s</div>
					<div class="description">%5$s</div>
				</div>
			</div>
		</div> ';
	?>
	
	<div class=" shw-shortcode carousel-3 section-category  <?php echo esc_attr($block_cls) ?>">
		<?php if( !empty( $model->attributes['block_title'] ) ) :?>
		<div class="section-name block-title">
				<?php echo esc_attr($model->attributes['block_title']);?>
		</div>
		<?php endif;?>
		<div class="section-content" data-block='<?php echo json_encode($model->attributes); ?>' id="<?php echo esc_attr($block_attr) ?>"> 
			<div class="row">
				<?php if ($atts['show_category_tab']): ?>
	
					<?php $model->init( $atts, $content );  ?>
					<div class="col-md-3 col-sm-3 col-xs-3">  
					<?php if( !empty( $atts['left_block_title'] )) :?>
						<div class="subtitle">
							<?php echo esc_html($atts['left_block_title']);?>
						</div>
					<?php endif;?> 
						<ul class="location-news list-unstyled"> 
							<?php foreach ($categories as $category): ?> 
								<?php echo '<li><a class="ajax_load_carousel_3post " data-id="'.esc_attr($block_attr).'" 
								data-cate='."'".json_encode($category)."'".' href="#"><i class="fa fa-caret-right"></i>'.$category->cat_name.'</a></li>' ?>
							<?php endforeach;?>
						</ul>
					</div>
				<div class="col-md-9 col-sm-9 col-xs-9">
				<?php else:?>
				<div class="col-md-12 col-sm-12 col-xs-12">
				<?php endif;?>
				<?php if ( $model->query->have_posts() && count($categories) > 0 ) :?>
					<div class="subtitle">
						<?php if ($atts['show_category_tab']): ?> 
							<div class="pull-left" id="title-block-14-right-<?php echo esc_attr($block_attr)?>"> 
								<?php echo esc_html($first_category_name);?> 
							</div> 
						<?php endif;?> 
						<div class="pull-right">
							<a href="#location-carousel-<?php echo esc_attr($block_attr) ?>" data-slide="next" class="right carousel-control">
								<span class="fa fa-angle-right"></span>
							</a>
							<a href="#location-carousel-<?php echo esc_attr($block_attr) ?>" data-slide="prev" class="left carousel-control">
								<span class="fa fa-angle-left"></span>
							</a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="location-carousel-<?php echo esc_attr($block_attr) ?>" data-interval="false" class="carousel slide">
						<div class="carousel-inner">  
							<?php
								$post_options = array(
									'small_post_format'			=> $html_template,
									'small_thumb_href_class'	=> '', 
									'thumb_href_class'			=> 'img-wrapper'
								);
								$model->render_block( $post_options );
								?>
						</div>
					</div>
					<?php endif; ?>
				</div>
	
			</div>
		</div>
	</div>
<?php endif; ?>