<?php
/*
Plugin Name: Responsive for Visual Composer
Description: Change Color, Padding, Margin, Border, Font for any elements on any devices, It's a Visual Composer Addon.
Author: BestBug
Version: 2.3.6
Author URI: http://visualcomposer-responsive.lamblue.com
Text Domain: bestbug
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'BESTBUG_VCEDO_URL' ) or define('BESTBUG_VCEDO_URL', plugins_url( '/', __FILE__ )) ;
defined( 'BESTBUG_VCEDO_PATH' ) or define('BESTBUG_VCEDO_PATH', basename( dirname( __FILE__ )) ) ;

defined( 'BESTBUG_VCEDO_VERSION' ) or define('BESTBUG_VCEDO_VERSION', '2.3.6') ;

defined( 'BESTBUG_VCEDO_CATEGORY' ) or define('BESTBUG_VCEDO_CATEGORY', 'Responsive') ;

defined( 'BESTBUG_VCEDO_TEXTDOMAIN' ) or define('BESTBUG_VCEDO_TEXTDOMAIN', 'bestbug') ;
defined( 'BESTBUG_VCEDO_SHORTCODE' ) or define('BESTBUG_VCEDO_SHORTCODE', 'bb_vcedo') ;

defined( 'BESTBUG_VCEDO_OPTIONS_BY_ELEMENTS' ) or define('BESTBUG_VCEDO_OPTIONS_BY_ELEMENTS', '_bb_vcedo_options_by_elements') ;

defined( 'BESTBUG_VCEDO_CUSTOM_ELEMENTS' ) or define('BESTBUG_VCEDO_CUSTOM_ELEMENTS', '_bb_vcedo_custom_elements') ;

defined( 'BESTBUG_VCEDO_MENU_TAB_POSITION' ) or define('BESTBUG_VCEDO_MENU_TAB_POSITION', '_bb_vcedo_menu_tab_position') ;

defined( 'BESTBUG_VCEDO_PARAM_PREFIX' ) or define('BESTBUG_VCEDO_PARAM_PREFIX', 'bbvcedo_');
defined( 'BESTBUG_VCEDO_DEVICES' ) or define('BESTBUG_VCEDO_DEVICES', '_bb_vcedo_devices');
defined( 'BESTBUG_VCEDO_SHOWHIDE' ) or define('BESTBUG_VCEDO_SHOWHIDE', '_bb_vcedo_showhide');

if ( ! class_exists( 'BestBugVCEDO' ) ) {
	/**
	 * VC Animation Showup Class
	 *
	 * @since	1.0
	 */
	class BestBugVCEDO {


		/**
		 * Constructor, checks for Visual Composer and defines hooks
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
            add_action( 'vc_before_init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
		}

		public function init() {
            if ( ! defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

			include_once( 'includes/bb_edo_helper.php' );

			$this->createShortcode();
			add_shortcode( 'bb_vcedo', array( $this, 'bbVcedoShortcode' ) );

			include_once( 'includes/bb_vcedo_filter.php' );

			if(is_admin()) {
				include_once( 'includes/admin/bb_vcedo_options.php' );
				include_once( 'includes/admin/bb_vcedo_build.php' );
				include_once( 'includes/admin/bb_vcedo_build_typo.php' );
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
		}

		public function enqueueScripts() {
			wp_enqueue_style( 'bb-vcedo', BESTBUG_VCEDO_URL . '/assets/css/bb-vcedo.css' , array(), BESTBUG_VCEDO_VERSION  );
			wp_add_inline_style( 'bb-vcedo', BestBugVCEDOHelper::$show_hide_css );
		}

		public function loadTextDomain() {
			load_plugin_textdomain( BESTBUG_VCEDO_TEXTDOMAIN, false, BESTBUG_VCEDO_PATH . '/languages/' );
		}

		public function createShortcode() {

			include_once( 'includes/admin/bb_vcparam_toggle.php' );
			include_once( 'includes/admin/bb_vcparam_tab.php' );
			include_once( 'includes/admin/bb_vcparam_typography.php' );

			if ( ! defined( 'WPB_VC_VERSION' ) || ! function_exists( 'vc_add_param' ) ) {
				return;
			}

			include_once( 'includes/bb_vcedo.php' );
			vc_map( array(
			    "name" => esc_html__( "Responsive Design Options", 'bestbug' ),
			    "base" => "bb_vcedo",
			    "as_parent" => array('except' => 'bb_vcedo'),
			    "content_element" => true,
				"icon" => "bb_vcedo_icon",
			    "js_view" => 'VcColumnView',
				"description" => esc_html__( "Responsive design to any elements", 'bestbug' ),
			    "params" => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'bestbug' ),
						'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'bestbug'),
						'param_name' => 'el_class',
					),
			    ),
				'category' => esc_html( sprintf( esc_html__( 'by %s', 'bestbug' ), BESTBUG_VCEDO_CATEGORY ) )
			) );

			// Add option to elements
			include_once( 'includes/admin/bb_vcedo_add_params.php' );
		}

		public function bbVcedoShortcode( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'el_class' => 	'',
			), $atts ) );

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class, BESTBUG_VCEDO_SHORTCODE, $atts );

			return "<div class='". esc_attr($css_class) ."'>" . do_shortcode( $content ) . '</div>';
		}
	}
	new BestBugVCEDO();
}
