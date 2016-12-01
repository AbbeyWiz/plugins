<?php

SwlabsCore::load_class( 'Demo_Importer' );
class Swlab_DemoImporterPlugin {

	function form() {
?>

<div class="wrap about-wrap shw-wrap shw-tab-style">
	<h1><?php esc_html_e( "Welcome to BigNews!", 'bignews' ); ?></h1>
	<div class="about-text"><?php esc_html_e( "BigNews is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it!", 'bignews' ); ?></div>
	<h2 class="nav-tab-wrapper">
		<?php 
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_requirement' ), esc_html__( "Recommendations", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_plugin' ), esc_html__( "Plugins", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab nav-tab-active">%s</a>', admin_url( 'admin.php?page='.SWBIGNEWS_THEME_PREFIX.'_demo_importer' ), esc_html__( "Install Demos", 'bignews' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=BigNews_options' ), esc_html__( "Theme Options", 'bignews' ) );
		?>
	</h2>
	<?php
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] && empty( $_GET['data'] ) ) :
	?>
	<div class="shw-important-notice">
		<p class="about-description"><?php esc_html_e('Works best to import on a new install of WordPress. You should remove all posts, pages, widgets content before import demo data. Please install required plugins before click import demo.', 'bignews' );?></p>
	</div>
	<div class="shw-demo-themes shw-install-plugins">
		<div class="feature-section theme-browser rendered">
		<?php
			if( is_dir( SWLABSCORE_SAMPLE_DATA_DIR ) )
				$demo_directory = array_diff( scandir( SWLABSCORE_SAMPLE_DATA_DIR ), array( '..', '.' ) );
			$dir_array = array();

			if ( !empty( $demo_directory ) && is_array( $demo_directory ) ) {

				foreach ( $demo_directory as $key => $value ) {

					if ( is_dir( SWLABSCORE_SAMPLE_DATA_DIR . $value ) && is_file( SWLABSCORE_SAMPLE_DATA_DIR . $value . '/config.json' ) ) {

						$dir = SWLABSCORE_SAMPLE_DATA_DIR . $value . '/';
						$json_data = file_get_contents( $dir . 'config.json' );
						$json_data = json_decode($json_data, true);

						if( !empty( $json_data['redux_opt_name'] ) && is_file( $dir . $json_data['wordpress_content_file'] ) && is_file( $dir . $json_data['theme_option_file'] ) && is_file( $dir . $json_data['widget_backup_file'] ) ) {
							$dir_array[$value]['data'] = $json_data;
							$dir_array[$value]['dir'] = $dir;
							$dir_array[$value]['name'] = $value;
							$dir_array[$value]['url'] = SWLABSCORE_SAMPLE_DATA_URL . $value;
						}
					}
				}

				uksort( $dir_array, 'strcasecmp' );
			} else {
				echo '<b>' . esc_html_e('No Demo Data Provided', 'bignews' ) . '</b>';
			}


			foreach( $dir_array as $demo => $data ):
			?>
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo esc_url( $data['url'] . '/' . $data['data']['screen_image_file'] ); ?>" alt="" />
				</div>
				<?php if( !empty( $data['data']['description'] ) ) echo '<span class="more-details">' . esc_attr( $data['data']['description'] ) . '</span>'; ?>
				<h3 class="theme-name">
					<?php
					echo esc_attr( $data['data']['name'] );
					?>
				</h3>
				<div class="theme-actions">
					<?php

						if( !empty( $data['data']['demo_url'] ) ) {
							echo '<a href="' . $data['data']['demo_url'] . '" target="_blank" class="button button-primary">' . esc_html__('Demo', 'bignews' ) . '</a>&nbsp;';
						}

						$my_options = get_option('shw_import');
						if( is_array( $my_options ) && in_array( $data['name'], $my_options ) ) {
							echo '<a href="' . admin_url( 'admin.php?page=' . SWBIGNEWS_THEME_PREFIX . '_demo_importer' ) . '&data=' . esc_attr( $data['name'] ) . '" onclick="return confirm(\'Are you sure to re-install this content ?\')" class="button button-primary">' . esc_html__('Re-Install', 'bignews' ) . '</a>';
						} else {
							echo '<a href="' . admin_url( 'admin.php?page=' . SWBIGNEWS_THEME_PREFIX . '_demo_importer' ) . '&data=' .  esc_attr( $data['name'] ) . '" onclick="return confirm(\'Are you sure to install this content ?\')" class="button button-primary">' . esc_html__('Install', 'bignews' ) . '</a>';
						}

					?>

				</div>

				<?php if( !empty( $data['data']['tag'] ) ) echo '<div class="plugin-recommend">' . esc_attr( $data['data']['tag'] ) . '</div>'; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

	<?php

	elseif ( !empty($_GET['data'] ) ):

	?>
	<div class="shw-demo-themes shw-install-plugins">
		<div class="feature-section theme-browser rendered">
			<div class="shw-important-loading">
				<h3 class="about-description" id="title_loading"><?php esc_html_e('Installing the demo...', 'bignews' );?></h3>
				<h3 class="about-description" id="title_success" style="display: none;"><?php esc_html_e('Congratulation! Demo is installed', 'bignews' );?></h3>
				<h3 class="about-description" id="title_error" style="display: none;"><?php esc_html_e('Something Wrong!', 'bignews' );?></h3>
			</div>
			<?php
				$demo_loading = SWLABSCORE_SAMPLE_DATA_DIR . esc_attr ( $_GET['data'] );
				if( is_dir( $demo_loading ) && is_file ( $demo_loading . '/config.json' ) ){
			?>
			<div class="td-box" id="progress_bar">
				<div class="td-box-row">
					<div class="td-section td-loading" id="content_loading">
						<p><?php esc_html_e('Please wait until the demo is installing. It may take 10 to 15 minutes.', 'bignews' );?></p>
					</div>

					<div class="td-section td-complete" id="content_success" style="display:none">
					</div>

					<div class="td_progress_bar_wrap">
						<div class="td_progress_bar" id="progress_loading">
							<div></div>
						</div>
						<div><a href="#" class="td-progress-show-details"><?php esc_html_e('Show details', 'bignews' );?></a></div>
					</div>
				</div>
				<div class="td-clear"></div>
			</div>
			<div class="td_report" id="report">
				<?php
					$dir = $demo_loading . '/';
					$json_data = file_get_contents( $dir . 'config.json' );
					$json_data = json_decode($json_data, true);

					if( !empty( $json_data ) && is_array($json_data) ) {
						$shw_import = new SwlabsCore_Demo_Importer();
						$shw_import->fetch_attachments = true;
				
						$shw_import->widgets_file = $dir . $json_data['widget_backup_file'];
						$shw_import->demo_file = $dir . $json_data['wordpress_content_file'];
						
						if( !empty( $json_data['custom_sidebar_file'] ) && file_exists($dir . $json_data['custom_sidebar_file']) ) {
							$shw_import->custom_sidebar_file = $dir . $json_data['custom_sidebar_file'];
							$shw_import->custom_sidebar_name = SWLABSCORE_CUSTOM_SIDEBAR_NAME;
						}

						if( !empty( $json_data['custom_category_file'] ) && file_exists($dir . $json_data['custom_category_file']) ) {
							$shw_import->custom_category_file = $dir . $json_data['custom_category_file'];
						}

						if( !empty ($json_data['redux_opt_name']) && !empty ($json_data['theme_option_file']) && file_exists($dir . $json_data['theme_option_file'])){
							$shw_import->theme_option_name = $json_data['redux_opt_name'];
							$shw_import->theme_options_file = $dir . $json_data['theme_option_file'];
						}

						if(!empty($json_data['menu'])){
							$shw_import->demo_menu = $json_data['menu'];
						}
						$shw_import->import();

						$my_options = get_option('shw_import');
						if( empty( $my_options ) ) {
							$my_options = array();
						}

						if( !in_array( $_GET['data'], $my_options ) ) {
							$my_options[] = esc_attr ( $_GET['data'] );
							update_option('shw_import', $my_options);
						}
					} else {
						echo esc_html__('Cannot found this demo file. Please check and try again later', 'bignews' );
					}
				?>
			</div>
			<?php
				} else {
					echo esc_html__('Cannot found this demo file. Please check and try again later', 'bignews' );
				}
			?>
		</div>
	</div>
	<?php endif; ?>
</div>
<?php
	}
}

?>