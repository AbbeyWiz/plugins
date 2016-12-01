<?php
/**
 * Constants.
 * 
 * @author Swlabs
 * @package Swlabs-Core
 * @since 1.0
 */

defined( 'SWLABSCORE_VERSION' )        || define( 'SWLABSCORE_VERSION', '1.0' );
defined( 'SWLABSCORE_LANG' )           || define( 'SWLABSCORE_LANG', 'swlabs-core' );
defined( 'SWLABSCORE_SC_CATEGORY' )    || define( 'SWLABSCORE_SC_CATEGORY', 'SwlabsCore' );

defined( 'SWLABSCORE_URI' )            || define( 'SWLABSCORE_URI', plugin_dir_url( __FILE__ ) );
defined( 'SWLABSCORE_DIR' )            || define( 'SWLABSCORE_DIR', dirname( __FILE__ ) );

defined( 'SWLABSCORE_ASSET_URI' )      || define( 'SWLABSCORE_ASSET_URI', SWLABSCORE_URI . 'assets' );

defined( 'SWLABSCORE_CF_DIR' )         || define( 'SWLABSCORE_CF_DIR', SWLABSCORE_DIR . '/config' );
defined( 'SWLABSCORE_SHORTCODE_DIR' )  || define( 'SWLABSCORE_SHORTCODE_DIR', SWLABSCORE_DIR . '/shortcode' );


// Active ContactForm7 Plugin 
defined( 'SWLABSCORE_WPCF7_ACTIVE' )           || define( 'SWLABSCORE_WPCF7_ACTIVE', is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) );
//Active VC Plugin
defined( 'SWLABSCORE_VC_ACTIVE' )              || define( 'SWLABSCORE_VC_ACTIVE', is_plugin_active( 'js_composer/js_composer.php' ) );
//Active Woocommerce Plugin
defined( 'SWLABSCORE_WOOCOMMERCE_ACTIVE' )     || define( 'SWLABSCORE_WOOCOMMERCE_ACTIVE', is_plugin_active( 'woocommerce/woocommerce.php' ) );
defined( 'SWLABSCORE_REVSLIDER_ACTIVE' )       || define( 'SWLABSCORE_REVSLIDER_ACTIVE', is_plugin_active( 'revslider/revslider.php' ) );
defined( 'SWLABSCORE_BREAKING_NEWS_ACTIVE' )   || define( 'SWLABSCORE_BREAKING_NEWS_ACTIVE', is_plugin_active( 'breaking-news-ticker/breaking-news-ticker.php' ) );
defined( 'SWLABSCORE_AWESOME_SURVEYS_ACTIVE' ) || define( 'SWLABSCORE_AWESOME_SURVEYS_ACTIVE', is_plugin_active( 'awesome-surveys/awesome-surveys.php' ) );
defined( 'SWLABSCORE_SAMPLE_DATA_DIR' ) || define( 'SWLABSCORE_SAMPLE_DATA_DIR', get_template_directory () . '/sample-data/' );
defined( 'SWLABSCORE_SAMPLE_DATA_URL' ) || define( 'SWLABSCORE_SAMPLE_DATA_URL', get_template_directory_uri () . '/sample-data/' );

// Default Image
defined( 'SWLABSCORE_NO_IMG_REC' )         || define( 'SWLABSCORE_NO_IMG_REC', SWLABSCORE_ASSET_URI.'/images/no-image/thumb-rectangle.gif' );
defined( 'SWLABSCORE_NO_IMG_SQUARE' )      || define( 'SWLABSCORE_NO_IMG_SQUARE', SWLABSCORE_ASSET_URI.'/images/no-image/thumb-square.gif' );
defined( 'SWLABSCORE_NO_IMG_URI' )         || define( 'SWLABSCORE_NO_IMG_URI', SWLABSCORE_ASSET_URI.'/images/no-image/' );
defined( 'SWLABSCORE_NO_IMG_DIR' )         || define( 'SWLABSCORE_NO_IMG_DIR', SWLABSCORE_DIR.'/assets/images/no-image/' );

// Options
defined( 'SWLABSCORE_THEME_PREFIX' )       || define( 'SWLABSCORE_THEME_PREFIX', 'swbignews' );
defined( 'SWLABSCORE_POST_VIEWS' )         || define( 'SWLABSCORE_POST_VIEWS', SWLABSCORE_THEME_PREFIX . '_postview_number' );
defined( 'SWLABSCORE_CUSTOM_SIDEBAR_NAME' )    || define( 'SWLABSCORE_CUSTOM_SIDEBAR_NAME', 'swbignews_custom_sidebar' );