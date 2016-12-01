<?php
/**
 * Controller Post.
 * 
 * @since 1.0
 */

SwlabsCore::load_class( 'Abstract' );
SwlabsCore::load_class( 'Model' );

class SwlabsCore_Category_Controller extends SwlabsCore_Abstract {

	public function edit( $tag ) {
		$t_id = $tag->term_id;
		$page_options = get_option( "shw_category_$t_id");
		$image_uri = get_template_directory_uri() . '/assets/admin/images';
		$img_options = array( 'style' => '' );

		$top_post = SwlabsCore::get_params( 'categoty-top-post');
		$top_post = $this->radio_image_label( $top_post, $image_uri, $img_options );

		$article = SwlabsCore::get_params( 'categoty-article');
		$article = $this->radio_image_label( $article, $image_uri, $img_options );

		$sidebar_position = SwlabsCore::get_params( 'category-sidebar-position');
		$sidebar_position = $this->radio_image_label( $sidebar_position, $image_uri, $img_options );

		$html_options = array(
			'separator' => '&nbsp;',
			'class' => 'shw-w190',
			'style' => 'display:none;',
			'labelOptions' => array(
				'class' => ' shw-image-select ',
				'selected_class' => ' shw-image-select-selected ',
			)
		);
		?>
		<table id="div_shw_post_option" class="form-table">
			<tr>
				<th scope="row">
					<div><?php esc_html_e( 'Top Posts Style', 'swlabs-core' );?></div>
				</th>
				<td class="shw-mbox-radio-row">
					<?php echo ( $this->radio_button_list( 'shw_category_options[top-post]',
																$this->get_field( $page_options, 'top-post', array( 'top-post' => '0' ) ),
																$top_post,
																$html_options ) );?>
					<p class="description" ><?php esc_html_e( 'Choose how to display the top posts. By default it will inherit the Global Category setting from the top of this page.', 'swlabs-core' );?></p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<div><?php esc_html_e( 'Article Display View', 'swlabs-core' );?></div>
				</th>
				<td class="shw-mbox-radio-row">
					<?php echo ( $this->radio_button_list( 'shw_category_options[article]',
																$this->get_field( $page_options, 'article', array( 'article' => '0' ) ),
																$article,
																$html_options ) );?>
					<p class="description" ><?php esc_html_e( 'Select a module type, this is how your article list will be displayed.', 'swlabs-core' );?></p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<div><?php esc_html_e( 'Sidebar Position', 'swlabs-core' );?></div>
				</th>
				<td class="shw-mbox-radio-row">
					<?php echo ( $this->radio_button_list( 'shw_category_options[sidebar-position]',
																$this->get_field( $page_options, 'sidebar-position', array( 'sidebar-position' => 'default' ) ),
																$sidebar_position,
																$html_options ) );?>
					<p class="description" ><?php esc_html_e( 'Choose locate to display sidebar', 'swlabs-core' );?></p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<div><?php esc_html_e( 'Set Custom Sidebar', 'swlabs-core' );?></div>
				</th>
				<td>
					<?php echo ( $this->drop_down_list( 'shw_category_options[sidebar]',
																$this->get_field( $page_options, 'sidebar', array() ),
																SwlabsCore_Com::get_regist_sidebars(),
																array( 'class' => 'shw-w200', 'prompt' => 'Default sidebar') ) );?>
					<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance > Widgets</a></p>
				</td>
			</tr>

		</table>
	<?php
	}

	public function add( $tag ) {
		$page_options = array();
		$image_uri = get_template_directory_uri() . '/assets/admin/images';
		$img_options = array( 'style' => '' );

		$top_post = SwlabsCore::get_params( 'categoty-top-post');
		$top_post = $this->radio_image_label( $top_post, $image_uri, $img_options );

		$article = SwlabsCore::get_params( 'categoty-article');
		$article = $this->radio_image_label( $article, $image_uri, $img_options );

		$sidebar_position = SwlabsCore::get_params( 'category-sidebar-position');
		$sidebar_position = $this->radio_image_label( $sidebar_position, $image_uri, $img_options );

		$html_options = array(
			'separator' => '&nbsp;',
			'class' => 'shw-w190',
			'style' => 'display:none;',
			'labelOptions' => array(
				'class' => ' shw-image-select ',
				'selected_class' => ' shw-image-select-selected ',
			)
		);
		?>
		<div class="form-field term-name-wrap">
			<label for="tag-name"><?php esc_html_e( 'Top Posts Style', 'swlabs-core' );?></label>
			<div class="shw-mbox-radio-row">
				<div class="category-inline">
					<?php echo ( $this->radio_button_list( 'shw_category_options[top-post]',
																	$this->get_field( $page_options, 'top-post', array( 'top-post' => '0' ) ),
																	$top_post,
																	$html_options ) );?>
				</div>
			</div>
			<p class="description" ><?php esc_html_e( 'Choose how to display the top posts. By default it will inherit the Global Category setting from the top of this page.', 'swlabs-core' );?></p>
		</div>
		<div class="form-field term-name-wrap">
			<label for="tag-name"><?php esc_html_e( 'Article Display View', 'swlabs-core' );?></label>
			<div class="shw-mbox-radio-row">
				<div class="category-inline">
					<?php echo ( $this->radio_button_list( 'shw_category_options[article]',
																$this->get_field( $page_options, 'article', array( 'article' => '0' ) ),
																$article,
																$html_options ) );?>
				</div>
			</div>
			<p class="description" ><?php esc_html_e( 'Select a module type, this is how your article list will be displayed.', 'swlabs-core' );?></p>
		</div>
		<div class="form-field term-name-wrap">
			<label for="tag-name"><?php esc_html_e( 'Sidebar Position', 'swlabs-core' );?></label>
			<div class="shw-mbox-radio-row">
				<div class="category-inline">
					<?php echo ( $this->radio_button_list( 'shw_category_options[sidebar-position]',
																$this->get_field( $page_options, 'sidebar-position', array( 'sidebar-position' => 'default' ) ),
																$sidebar_position,
																$html_options ) );?>
				</div>
			</div>
			<p class="description" ><?php esc_html_e( 'Choose locate to display sidebar', 'swlabs-core' );?></p>
		</div>
		<div class="form-field term-name-wrap">
			<label for="tag-name"><?php esc_html_e( 'Set Custom Sidebar', 'swlabs-core' );?></label>
			<div class="shw-mbox-radio-row">
				<div class="category-inline">
					<?php echo ( $this->drop_down_list( 'shw_category_options[sidebar]',
																$this->get_field( $page_options, 'sidebar', array() ),
																SwlabsCore_Com::get_regist_sidebars(),
																array( 'class' => 'shw-w200', 'prompt' => 'Default sidebar') ) );?>
				</div>
			</div>
			<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance>Widgets</a></p>
		</div>
	<?php
	}

	public function save_term( $term_id ) {
		if ( isset( $_POST['shw_category_options'] ) ) {
	        $t_id = $term_id;
	        $cat_meta = get_option( "shw_category_$t_id");
	        $cat_keys = array_keys($_POST['shw_category_options']);
            foreach ( $cat_keys as $key ){
	            if ( isset( $_POST['shw_category_options'][$key] ) ){
	                $cat_meta[$key] = $_POST['shw_category_options'][$key];
	            }
        	}
	        update_option( "shw_category_$t_id", $cat_meta );
	    }
	}
}