<?php
	$model = new SwlabsCore_Block;
	$model->init( $atts, $content );
	$block_cls = $model->attributes['extra_class'] . ' ' . $model->attributes['block-class'];
	$block_attr = $model->attributes['block-class'];
	$data_json = json_encode( $model->attributes );
	$data_json = trim( $data_json, " " );
	$html_format_tab1 = ' 
		<div class ="media">
			<div class="media-left"><div class="thumb">%1$s</div>
			</div>
			<div class="media-right">
				<div class="media-heading"> %2$s </div>
				<div class="info info-style-1"> %3$s </div>
				<div class="description">  %7$s</div>
			</div> </div>';
	$html_format_tab2 = ' 
		<li>
			<div class="title">%2$s</div>
			<div class="info info-style-1"> %3$s </div>
			<div class="thumb">%1$s</div>
			<div class="description">  %7$s</div> 
		</li>';
	$html_format_tab3 = ' 
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="thumb media">%1$s
			<div class="caption dark"> %2$s</div>
			</div> 
		</div>';
	$paged = !empty( $model->attributes['paged'] ) ? absint(esc_attr( $model->attributes['paged'] )) : 1;
if (!empty($atts['load_ajax']) && $atts['load_ajax'] == 1): 
	if ( $model->query->have_posts() ) :?>
		<div id="tab1-<?php echo esc_attr($block_attr) ?>" class="tab-pane <?php echo ($atts['active'] == 0) ? 'active': '' ?>">
			<div class="list-view">
			<?php
				$post_options = array(
				'small_post_format' => $html_format_tab1,
				'large_post_format' => $html_format_tab1,
				'thumb_href_class'  => '', 
				'small_thumb_href_class' => '',
				);
				$model->render_grid( $post_options );?>
			</div>
		</div>
		<div id="tab2-<?php echo esc_attr($block_attr) ?>" class="tab-pane <?php echo ($atts['active'] == 1) ? 'active': '' ?>"> 
			<div class="list-view-2">
				<ul class="list-unstyled">
				<?php
					$post_options = array(
						'small_post_format' => $html_format_tab2,
						'large_post_format' => $html_format_tab2,
						'thumb_href_class'  => ' img-responsive',
						'small_thumb_href_class' => ' img-responsive',
					);
					$model->render_grid( $post_options );?> 
				</ul>
			</div>
		</div>
		<div id="tab3-<?php echo esc_attr($block_attr) ?>" class="tab-pane  <?php echo ($atts['active'] == 2) ? 'active': '' ?>">
			<div class="grid-view">
				<div class="row">
					<?php
						$post_options = array(
							'small_post_format' => $html_format_tab3,
							'large_post_format' => $html_format_tab3,
						);
						$model->render_grid( $post_options );?> 
					</div>
				</div>
		</div>
		<?php
		if ($model->attributes['pagination'] == '1') {
			$model->pagin_nav($paged, $model->query,true);
		}
	endif; // have_post

// not load ajax
else:
?>

<div class="grid2 section-category  <?php echo esc_attr($block_cls) ?> shw-shortcode">

	<div class="section-name block-title">
		<div class="pull-left">
		<?php if( !empty( $model->attributes['block_title'] ) ) :?>
		<!-- <div class="section-name"> -->
		<?php echo esc_html($model->attributes['block_title']);?>
		<!-- </div> -->
		<?php endif;  ?></div>
			<div class="pull-right">
				<ul class="nav nav-tabs views">
					<li class=""><a href="#tab1-<?php echo esc_attr($block_attr) ?>" data-toggle="tab" aria-expanded="false"><i class="fa fa-th-list fa-fw"></i></a></li>
					<li class=""><a href="#tab2-<?php echo esc_attr($block_attr) ?>" data-toggle="tab" aria-expanded="false"><i class="fa fa-navicon fa-fw mlm"></i></a></li>
					<li class="active"><a href="#tab3-<?php echo esc_attr($block_attr) ?>" data-toggle="tab" aria-expanded="true"><i class="fa fa-th fa-fw mlm"></i></a></li>
				</ul>
			</div>
		<div class="clearfix"> </div>
	</div> 
	<div class="section-content">
		<div class="latest-articles-list latest-articles-list-grid " id="latest-articles-list-<?php echo esc_attr($block_attr) ?>">
			<div class="tab-content" id="tab-content-of-<?php echo esc_attr($block_attr) ?>"  
			data-grid="<?php echo esc_attr( $data_json ); ?>" data-block="<?php echo esc_attr($block_attr) ?>">
			<?php if ( $model->query->have_posts() ) :?>
				<div id="tab1-<?php echo esc_attr($block_attr) ?>" class="tab-pane">
					<div class="list-view">
						<?php
						$post_options = array(
							'small_post_format' => $html_format_tab1,
							'large_post_format' => $html_format_tab1,
							'thumb_href_class'  => '', 
							'small_thumb_href_class' => '',
						);
						$model->render_grid( $post_options );?>
					</div>
				</div>
			<div id="tab2-<?php echo esc_attr($block_attr) ?>" class="tab-pane">
					<div class="list-view-2">
					<ul class="list-unstyled">
							<?php
							$post_options = array(
								'small_post_format' => $html_format_tab2,
								'large_post_format' => $html_format_tab2,
								'thumb_href_class'  => ' img-responsive',
								'small_thumb_href_class' => ' img-responsive',
							);
							$model->render_grid( $post_options );?> 
						</ul>
					</div>
			</div>
				<div id="tab3-<?php echo esc_attr($block_attr) ?>" class="tab-pane active">
					<div class="grid-view">
						<div class="row">
							<?php
							$post_options = array(
								'small_post_format' => $html_format_tab3,
								'large_post_format' => $html_format_tab3,
							);
							$model->render_grid( $post_options );?> 
						</div>
					</div>
				</div>
			<?php 
			if ($model->attributes['pagination'] == '1') {
				$model->pagin_nav($paged, $model->query,true);
			} ?>
			<?php endif; // have_post?>
			</div>
		</div>
	</div>
</div>
<?php endif;?>