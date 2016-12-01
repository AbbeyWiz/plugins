<?php
	$category_list = $atts['category_list'];
	$categories = array();
	if( !empty($category_list) ){
		foreach( $category_list as $cat ){
			if( !empty($cat['category_slug']) ) {
				$cat_obj = get_category_by_slug($cat['category_slug']);
				$categories[$cat_obj->term_id] = $cat_obj->name;
			}
		}
	}
	else {
		$category_list = get_categories();
		foreach( $category_list as $cat ){
			if( !empty($cat->name) ) {
				$categories[$cat->term_id] = $cat->name;
			}
		}
	}
?>
<div class="swlabs-sc-<?php echo esc_attr($atts['id']).' '.esc_attr($atts['extra_class']); ?> shw-shortcode ">
	<div class="categories widget_categories section-category">
		<?php
			if( !empty( $atts['title'] ) ) {
				printf('<div class="section-name">%s</div>', esc_attr($atts['title']) );
			}
		?>
		<div class="section-content">
			<ul class="list-unstyled">
			<?php
				if( !empty( $categories ) ) {
					foreach( $categories as $key=>$val ) {
						$cat_link = get_category_link( $key );
						printf('<li><a href="%1$s" class="title">%2$s</a></li>',
								esc_url($cat_link),
								esc_attr($val)
							);
					}
				}
			?>
			</ul>
		</div>
	</div>
</div>