<?php
/*
Plugin Name: Swlabs Core
Plugin URI: http://themeforest.net/user/swlabs
Description: Swlabs Core Plugin for Swlabs Themes
Version: 1.0
Author: Swlabs
Author URI: http://themeforest.net/user/swlabs
Text Domain: swlabs-core
*/

clearstatcache();

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// load constants
require_once( plugin_dir_path( __FILE__ ) . '/constants.php' );

/* Load plugin textdomain.*/
add_action( 'plugins_loaded', 'swlabs_load_text_domain' );
function swlabs_load_text_domain() {
	load_plugin_textdomain( 'swlabs-core', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

/* Initialization */
require_once( plugin_dir_path( __FILE__ ) . '/class-sw.php' );
require_once( plugin_dir_path( __FILE__ ) . '/libs/class-util.php' );
require_once( plugin_dir_path( __FILE__ ) . '/libs/class-com.php' );
require_once( plugin_dir_path( __FILE__ ) . '/libs/class-social-api.php' );
require_once( plugin_dir_path( __FILE__ ) . '/custom-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . '/framework/modules/importer/index.php' );

SwlabsCore::load_class( 'Helper' );
SwlabsCore::load_class( 'shortcode.Block' );
SwlabsCore::load_class('models.Video_Model');

$app = SwlabsCore::new_object('Application');
$app->run();

require_once( plugin_dir_path( __FILE__ ) . '/shortcode/shortcode_function.php' );

if( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', array( 'SwlabsCore', '[setting.Setting_Init, dev_enqueue_scripts]' ) );
}
