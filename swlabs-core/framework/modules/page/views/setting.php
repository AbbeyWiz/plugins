<?php 
	global $wpdb;
	$revolution_sliders[0] = esc_html__( 'Select a revolution slider', 'swlabs-core' );
	if( SWLABSCORE_REVSLIDER_ACTIVE ) {
		$get_revslider = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'revslider_sliders' );
		if ( $get_revslider ) {
			foreach ( $get_revslider as $slider ) {
				$revolution_sliders[$slider->alias] = $slider->title;
			}
		}
	}
	$categories_slider = SwlabsCore_Com::get_tax_options( 'shw_slider_category');
	$category_slider[0]= esc_html__( 'Select a category slider', 'swlabs-core' );
	foreach( $categories_slider as $k => $v ){
		$category_slider[ $v ] = $k;
	}
	// post
	$image_uri = get_template_directory_uri() . '/assets/admin/images/';
	$post_layout = SwlabsCore::get_params( 'post_layout');
	$img_options = array( 'style' => '' );
	$post_layout = $this->radio_image_label( $post_layout, $image_uri, $img_options );
	$html_options = array(
		'separator' => '&nbsp;',
		'class' => 'shw-w190',
		'style' => 'display:none;',
		'labelOptions' => array(
			'class' => ' shw-image-select ',
			'selected_class' => ' shw-image-select-selected ',
		)
	);
	$navigation = array(
		'none'              => esc_html__('None', 'swlabs-core'),
		'breaking_news' => esc_html__('Breaking News', 'swlabs-core'),
		'breadcrumb'    => esc_html__('Breadcrumb', 'swlabs-core' ),
	);
	$html_options_nav = array(
		'separator' => '&nbsp;',
		'class' => 'shw-w190'
	);
	$first_tab = 'active';
	$post_tab = 'hide';
	$screen = get_current_screen();
	$tab_hide = '';
	if( $screen && $screen->post_type == 'post' ) {
		$post_tab = 'active';
		$first_tab = '';
		$tab_hide = 'hide';
	}
?>
<div class="tab-panel">
	<ul class="tab-list">
		<li class="<?php echo esc_attr( $post_tab );?>">
			<a href="shw-tab-page-post">Post Setting</a>
		</li>
		<li class="<?php echo esc_attr( $first_tab );?>">
			<a href="shw-tab-page-general">General</a>
		</li>
		<li>
			<a href="shw-tab-page-header">Header</a>
		</li>
		<li class="<?php echo esc_attr( $tab_hide );?>">
			<a href="shw-tab-page-sidebar">Sidebar</a>
		</li>
		<li>
			<a href="shw-tab-page-footer">Footer</a>
		</li>
	</ul>
	<div class="tab-container">
		<div class="tab-wrapper shw-page-meta">
			<!-- Post Setting -->
			<div id="shw-tab-page-post" class="tab-content <?php echo esc_attr( $post_tab );?>">
				<table class="form-table">
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Main Category', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'If the post has multiple categories, choose one category to display in the category labels.', 'swlabs-core' );?></p>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'shw_page_options[blog_main_category]',
																		$this->get_field( $page_options, 'blog_main_category', $defaults ),
																		$params['category'],
																		array( 'class' => 'shw-w190' ) ) );?>
							
						</td>
					</tr>
				</table>
			</div>
			<!-- General -->
			<div id="shw-tab-page-general" class="tab-content <?php echo esc_attr( $first_tab );?>">
				<table class="form-table">
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Display below Navigation', 'swlabs-core' );?></div>
							<p class="description" ></p>
						</th>
						<td>
							<?php echo ( $this->radio_button_list( 'shw_page_options[header_below_navigation]',
																		$this->get_field( $page_options, 'header_below_navigation', $defaults ),
																		$navigation,
																		$html_options_nav ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Hover Style', 'swlabs-core' );?></div>
							<p class="description" ></p>
						</th>
						<td>
							<?php echo ( $this->text_field( 'shw_page_options[hover_style_color]',
																		$this->get_field( $page_options, 'hover_style_color', $defaults ),
																		array('class' => 'swlabscore-meta-color') ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row" colspan="2">
							<label><?php echo (  $this->check_box( 'shw_page_options[show_title]',
																	$this->get_field( $page_options, 'show_title', 0 ),
																	array( 'class' => 'shw-show-title' ) ) );
									esc_html_e( 'Hide Title', 'swlabs-core' )?></label>
							<p class="description" ><?php esc_html_e( '( Show / Hide page title in page detail.)', 'swlabs-core' );?></p>
						</th>
					</tr>
					<tr>
						<th scope="row" colspan="2">
							<label><?php echo (  $this->check_box( 'shw_page_options[general_default]',
																	$this->get_field( $page_options, 'general_default', 1 ),
																	array( 'class' => 'shw-general-option' ) ) );
									esc_html_e( 'Default Setting', 'swlabs-core' )?></label>
							<p class="description" ><?php esc_html_e( '( Using setting of theme options. All below setting will NOT be allowed.)', 'swlabs-core' );?></p>
						</th>
					</tr>

				</table>
				<table id="div_shw_general_option" class="form-table <?php echo ( $this->get_field( $page_options, 'general_default', 1 )? 'hide' : '' ); ?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Background Style', 'swlabs-core' );?></label>
							<p class="description" >(background-color, background-repeat, background-size, background-attachment, background-position, background-image)</p>
						</th>
						<td>
							<?php echo ( $this->text_field( 'shw_page_options[background_color]',
																		$this->get_field( $page_options, 'background_color', $defaults ),
																		array('class' => 'swlabscore-meta-color') ) );?>
							<span>
								<?php echo (  $this->check_box( 'shw_page_options[background_transparent]',
																	$this->get_field( $page_options, 'background_transparent', $defaults ),
																	array( 'id'=>'background_transparent_id' ,'value' => 'transparent') ) );
									esc_html_e( 'Transparent', 'swlabs-core' );?>
							</span>
							<br/>
							<div><?php echo ( $this->drop_down_list( 'shw_page_options[background_repeat]',
																		$this->get_field( $page_options, 'background_repeat', $defaults ),
																		$params['background-repeat'],
																		array( 'class' => 'shw-w190' ) ) );?>
								<?php echo ( $this->drop_down_list( 'shw_page_options[background_size]',
																		$this->get_field( $page_options, 'background_size', $defaults ),
																		$params['background-size'],
																		array( 'class' => 'shw-w190' ) ) );?>
								
							</div>
							<br/>
							<div>
								<?php echo ( $this->drop_down_list( 'shw_page_options[background_attachment]',
																		$this->get_field( $page_options, 'background_attachment', $defaults ),
																		$params['background-attachment'],
																		array( 'class' => 'shw-w190' ) ) );?>
								<?php echo ( $this->drop_down_list( 'shw_page_options[background_position]',
																		$this->get_field( $page_options, 'background_position', $defaults ),
																		$params['background-position'],
																		array( 'class' => 'shw-w190' ) ) ); ?>
								
							</div>
							<br/>
							<div>
								<?php echo ( $this->text_field( 'shw_bg_image[name]',
																esc_attr( $params['bg_image']['url'] ),
																array( 'id' => 'shw_bg_image_name', 'readonly'=>'readonly', 'style'=>'width:98%;') ) );?>
								<input type="hidden" name="shw_page_options[background_image_id]" id="shw_bg_image_id" value="<?php echo esc_attr( $params['bg_image']['id'] ); ?>" />
								<div class="screenshot <?php echo esc_attr( $params['bg_image']['class'] );?>" >
									<img src="<?php echo esc_attr( $params['bg_image']['url'] ); ?>"/>
								</div>
								<br/>
								<input type="button" data-rel="shw_bg_image" class="button shw-btn-upload" value="<?php esc_html_e( 'Upload Image', 'swlabs-core' )?>" />
								<input type="button" data-rel="shw_bg_image" class="button shw-btn-remove <?php echo esc_attr( $params['bg_image']['class'] );?>" value="<?php esc_html_e( 'Remove', 'swlabs-core' )?>" />
							</div>
						</td>
					</tr>
				</table>
			</div>
			<!-- Header -->
			<div id="shw-tab-page-header" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row" colspan="2">
							<label><?php echo ( $this->check_box( 'shw_page_options[header_default]',
																	$this->get_field( $page_options, 'header_default', 1 ),
																	array( 'class' => 'shw-header-option' ) ) );
									esc_html_e( 'Default Setting', 'swlabs-core' )?></label>
							<p class="description" ><?php esc_html_e( '( Using setting of theme options. All below setting will NOT be allowed.)', 'swlabs-core' );?></p>
						</th>
					</tr>
				</table>
				<table id="div_shw_header_option" class="form-table <?php echo ($this->get_field( $page_options, 'header_default', 1 )? 'hide' : '');?>">
					<!-- demo -->
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Header Style', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Select a header style', 'swlabs-core' );?></p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[header_style_id]',
																		$this->get_field( $page_options, 'header_style_id', $defaults ),
																		 array( 
																					'header-custom' => 'Header Default',
																					'header-1' 	=> 'Header 1',
																					'header-2' 	=> 'Header 2',
																					'header-3'	=> 'Header 3',
																					'header-4'	=> 'Header 4',
																				),
																		 array('class'=>'header_style_id')
																				) );?></label>
						</td>
					</tr>
					<!-- end demo -->

				</table>
			</div>
			<!-- Sidebar -->
			<div id="shw-tab-page-sidebar" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row" colspan="2">
							<label><?php echo ( $this->check_box( 'shw_page_options[sidebar_default]',
																	$this->get_field( $page_options, 'sidebar_default', 1 ),
																	array( 'class' => 'shw-sidebar-option' ) ) );
									esc_html_e( 'Default Setting', 'swlabs-core' )?></label>
							<p class="description" ><?php esc_html_e( '( Using setting of theme options. All below setting will NOT be allowed.)', 'swlabs-core' );?></p>
						</th>
					</tr>
				</table>
				<table id="div_shw_sidebar_option" class="form-table <?php echo ($this->get_field( $page_options, 'sidebar_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Sidebar Layout', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Choose locate to display sidebar', 'swlabs-core' );?></p>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'shw_page_options[sidebar_layout]',
																		$this->get_field( $page_options, 'sidebar_layout', $defaults ),
																		$params['sidebar_layout'],
																		array( 'class' => 'shw-w200' ) ) );?>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Sidebar Name', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance>Widgets</a></p>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'shw_page_options[sidebar_id]',
																		$this->get_field( $page_options, 'sidebar_id', $defaults ),
																		$params['regist_sidebars'],
																		array( 'class' => 'shw-w200', 'prompt' => 'Default sidebar') ) );?>
						</td>
					</tr>
				</table>
			</div>
			<!-- Footer -->
			<div id="shw-tab-page-footer" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row" colspan="2">
							<label><?php echo ( $this->check_box( 'shw_page_options[footer_default]',
																	$this->get_field( $page_options, 'footer_default', 1 ),
																	array( 'class' => 'shw-footer-option' ) ) );
									esc_html_e( 'Default Setting', 'swlabs-core' )?></label>
							<p class="description" ><?php esc_html_e( '( Using setting of theme options. All below setting will NOT be allowed.)', 'swlabs-core' );?></p>
						</th>
					</tr>
				</table>
				<table id="div_shw_footer_option" class="form-table <?php echo ($this->get_field( $page_options, 'footer_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Section', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Show/Hide footer', 'swlabs-core' );?></p>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'shw_page_options[footer_show]',
																	$this->get_field( $page_options, 'footer_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'swlabs-core' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Bottom', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Show/Hide footer bottom', 'swlabs-core' );?></p>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'shw_page_options[footer_bottom_show]',
																	$this->get_field( $page_options, 'footer_bottom_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'swlabs-core' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Style', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Select a footer style', 'swlabs-core' );?></p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[footer_style_id]',
																		$this->get_field( $page_options, 'footer_style_id', $defaults ),
																		 array( 
																			        'footer-1' 	=> 'Footer 1',
																			        'footer-2' 	=> 'Footer 2',
																			        'footer-3'	=> 'Footer 3',
																			        'footer-4'	=> 'Footer 4',
																			        'footer-5'	=> 'Footer 5',
																			        'footer-6'	=> 'Footer 6',
																			    ) ) );?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Column', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e(  'Choose grid layout for footer.<br> Please go on "Appearance->Widget" to set data for footer' , 'swlabs-core' );?> </p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[footer_column_id]',
																		$this->get_field( $page_options, 'footer_column_id', $defaults ),  array(
																								'11'	=> '1 Column & text center',
																								'1' => '1 Column',
																								'2' => '2 Columns',
																								'3' => '3 Columns',
																								'4' => '4 Columns'
																							) ) );?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Column 1', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance>Widgets</a></p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[footer_sidebar1_id]',
																		$this->get_field( $page_options, 'footer_sidebar1_id', $defaults ),$params['regist_sidebars'] ) );?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Column 2', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance>Widgets</a></p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[footer_sidebar2_id]',
																		$this->get_field( $page_options, 'footer_sidebar2_id', $defaults ), $params['regist_sidebars'] ) );?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Column 3', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance>Widgets</a></p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[footer_sidebar3_id]',
																		$this->get_field( $page_options, 'footer_sidebar3_id', $defaults ), $params['regist_sidebars'] ) );?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<div><?php esc_html_e( 'Footer Column 4', 'swlabs-core' );?></div>
							<p class="description" ><?php esc_html_e( 'Choose sidebar to display. If you want to add new sidebar, please go to ', 'swlabs-core' );?><a href="<?php echo admin_url( 'widgets.php' )?>" >Appearance>Widgets</a></p>
						</th>
						<td>
							<label><?php echo ( $this->drop_down_list( 'shw_page_options[footer_sidebar4_id]',
																		$this->get_field( $page_options, 'footer_sidebar4_id', $defaults ), $params['regist_sidebars'] ) );?></label>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>