<?php
/**
 * Setting_Init class.
 * 
 * @since 1.0
 */

class SwlabsCore_Setting_Init {
	/**
	 * Regist scripts - admin
	 * 
	 */
	public function enqueue(){
		$uri = SWLABSCORE_ASSET_URI;
		// css
		wp_enqueue_style( 'sw-admin',        $uri . '/css/sw-admin.css', false, SWLABSCORE_VERSION, 'all' );
		wp_enqueue_style( 'sw-custom',       $uri . '/css/custom.css', false, SWLABSCORE_VERSION, 'all' );
		wp_enqueue_style( 'sw-font-awesome', $uri . '/libs/font-awesome/css/font-awesome.min.css', false, '4.4.0', 'all' );
		// js
		wp_enqueue_media();
		wp_enqueue_script( 'sw-common',    $uri . '/js/sw-common.js', array('jquery'), SWLABSCORE_VERSION, false );
		wp_enqueue_script( 'sw-admin',     $uri . '/js/sw-admin.js', array('jquery'), SWLABSCORE_VERSION, false );
		wp_enqueue_script( 'sw-image',     $uri . '/js/sw-image.js', array('jquery'), SWLABSCORE_VERSION, false );

		wp_localize_script( 'sw-image', 'shw_meta_image',
				array(
					'title' => esc_html__( 'Choose or Upload an Image', 'swlabs-core' ),
					'button' => esc_html__( 'Use this image', 'swlabs-core' ),
				)
		);
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'sw-metacolor', $uri . '/js/sw-metacolor.js', array( 'wp-color-picker' ) );

		wp_deregister_script( 'jquery.datetimepickermin' );
		wp_register_script( 'jquery.datetimepickermin', $uri . '/libs/datetimepicker/jquery.datetimepicker.min.js', array(), SWLABSCORE_VERSION, true );
		wp_enqueue_script( 'jquery.datetimepickermin' );

		// css for shortcode 
		wp_enqueue_style( 'jquery.datetimepicker.css', $uri . '/libs/datetimepicker/jquery.datetimepicker.css', array(), SWLABSCORE_VERSION );
	}

	/**
	 * Scripts & Css - frondend
	 */
	public function dev_enqueue_scripts(){
		$uri = SWLABSCORE_ASSET_URI;

		// css
		wp_enqueue_style( 'sw-carousel-css',        $uri . '/libs/owl.carousel/assets/owl.carousel.css', array(), SWLABSCORE_VERSION );
		wp_enqueue_style( 'sw-m-custom-scrollbar',  $uri . '/libs/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css', array(), SWLABSCORE_VERSION );
		//wp_enqueue_style( 'sw-slick',               $uri . '/libs/slick-slider/slick.css', array(), SWLABSCORE_VERSION );
		//wp_enqueue_style( 'sw-slick-theme',         $uri . '/libs/slick-slider/slick-theme.css', array(), SWLABSCORE_VERSION );
		wp_enqueue_style( 'swbignews-weather',      $uri . '/libs/weather-fonts/weather-font.css', array(), SWLABSCORE_VERSION );
		wp_enqueue_style( 'sw-custom',              $uri . '/css/custom.css', array(), SWLABSCORE_VERSION);

		// js
		wp_deregister_script( 'isotope.pkgd.min' );
		wp_register_script( 'isotope.pkgd.min',     $uri . '/libs/isotope.pkgd.min.js', array(), false, true );
		wp_enqueue_script( 'isotope.pkgd.min' );

		wp_deregister_script( 'owl.carousel.min' );
		wp_register_script( 'owl.carousel.min',      $uri . '/libs/owl.carousel/owl.carousel.min.js', array(), false, true );
		wp_enqueue_script( 'owl.carousel.min' );
		
		wp_deregister_script( 'jquery.droptabs.min' );
		wp_register_script( 'jquery.droptabs.min',   $uri . '/libs/jquery.droptabs.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery.droptabs.min' );
		
		wp_deregister_script( 'jquery.mCustomScrollbar.min' );
		wp_register_script( 'jquery.mCustomScrollbar.min', $uri . '/libs/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery.mCustomScrollbar.min' );

		//wp_deregister_script( 'slick.min' );
		//wp_register_script( 'slick.min',   $uri . '/libs/slick-slider/slick.min.js', array('jquery'), false, true );
		//wp_enqueue_script( 'slick.min' );

		wp_deregister_script( 'fit-columns' );
		wp_register_script( 'fit-columns',   $uri . '/libs/isotope/fit-columns.js', array('jquery'), false, true );
		wp_enqueue_script( 'fit-columns' );

		wp_deregister_script( 'isotope.pkgd.min' );
		wp_register_script( 'isotope.pkgd.min',   $uri . '/libs/isotope/isotope.pkgd.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'isotope.pkgd.min' );

		wp_deregister_script( 'masonry-horizontal' );
		wp_register_script( 'masonry-horizontal',   $uri . '/libs/isotope/masonry-horizontal.js', array('jquery'), false, true );
		wp_enqueue_script( 'masonry-horizontal' );

		wp_deregister_script( 'jquery.simpleWeather.min' );
		wp_register_script( 'jquery.simpleWeather.min',    $uri . '/libs/jquery.simpleWeather.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery.simpleWeather.min' );

		//-----------------enqueue script to run ajax-------------------------- 
		wp_enqueue_script( 'sw-form', $uri . '/js/sw-form.js', array('jquery'), SWLABSCORE_VERSION, true );
		wp_localize_script(
				'sw-form',
				'ajaxurl',
				admin_url( 'admin-ajax.php' )
		);
		wp_enqueue_script( 'sw-shortcode', $uri . '/js/sw-shortcode.js', array('jquery'), SWLABSCORE_VERSION, true );
	}
	/**
	 * action using generate inline css
	 * @param string $custom_css
	 */
	public function add_inline_style( $custom_css ) {
		wp_enqueue_style('sw-custom-css', SWLABSCORE_ASSET_URI . '/css/custom.css');
		wp_add_inline_style( 'sw-custom-css', $custom_css );
	}

}