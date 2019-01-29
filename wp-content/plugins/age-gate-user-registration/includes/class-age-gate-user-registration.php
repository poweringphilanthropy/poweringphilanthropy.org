<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://agegate.io
 * @since      1.0.0
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/includes
 * @author     Phil Baker <support@wordpressagegate.com>
 */
class Age_Gate_User_Registration {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Age_Gate_User_Registration_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'AGE_GATE_USER_REGISTRATION_VERSION' ) ) {
			$this->version = AGE_GATE_USER_REGISTRATION_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'age-gate-user-registration';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Age_Gate_User_Registration_Loader. Orchestrates the hooks of the plugin.
	 * - Age_Gate_User_Registration_i18n. Defines internationalization functionality.
	 * - Age_Gate_User_Registration_Admin. Defines all hooks for the admin area.
	 * - Age_Gate_User_Registration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible shared functionality
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-age-gate-user-registration-common.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-age-gate-user-registration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-age-gate-user-registration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-age-gate-user-registration-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-age-gate-user-registration-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-age-gate-user-registration-default.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-age-gate-user-registration-woocommerce.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-age-gate-user-registration-buddypress.php';

		$this->loader = new Age_Gate_User_Registration_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Age_Gate_User_Registration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Age_Gate_User_Registration_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Age_Gate_User_Registration_Admin();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_filter('age_gate_addons', $plugin_admin, 'register_addon');
		$this->loader->add_action('age_gate_custom_tab_' . $this->plugin_name, $plugin_admin, 'display_options_page');
		$this->loader->add_filter('age_gate_export_settings', $plugin_admin, 'add_export_option');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Age_Gate_User_Registration_Public();
		$plugin_default = new Age_Gate_User_Registration_Default();

		$plugin_woo = new Age_Gate_User_Registration_WooCommerce();
		$plugin_bp = new Age_Gate_User_Registration_Buddypress;

		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		//

		/**
 		 * Default Registration Class Actions
 		 */
 		$this->loader->add_action( 'register_form',  $plugin_default, 'extend_registration_form' );
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_default, 'register_style' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_default, 'register_style' );
		$this->loader->add_filter( 'registration_errors', $plugin_default, 'extend_registration_form_show_errors', 10, 3 );
		$this->loader->add_action( 'user_register', $plugin_default, 'extend_registration_user_data', 10, 1 );

		/**
 		 * WooCommerce Registration Class Actions
 		 */
 		/* Registration settings */
		$this->loader->add_action( 'woocommerce_register_form', $plugin_woo, 'wooc_extra_register_fields' );
		$this->loader->add_action( 'woocommerce_register_post', $plugin_woo, 'wooc_validate_extra_register_fields', 10, 3 );
		$this->loader->add_action( 'woocommerce_created_customer', $plugin_woo, 'wooc_save_extra_register_fields' );


		/* My account settings */
		$this->loader->add_action( 'woocommerce_edit_account_form', $plugin_woo, 'wooc_extra_account_fields' );
		$this->loader->add_action('woocommerce_save_account_details_errors', $plugin_woo, 'wooc_validate_extra_account_fields');
		$this->loader->add_action('woocommerce_save_account_details', $plugin_woo, 'wooc_save_extra_register_fields');

		/* Checkout */
		/**
		 * Add the field to the checkout
		 */
		 $this->loader->add_action( 'woocommerce_after_checkout_billing_form', $plugin_woo, 'wooc_custom_checkout_fields');//woocommerce_before_order_notes
		 $this->loader->add_action('woocommerce_checkout_process', $plugin_woo, 'custom_checkout_field_process');
		 $this->loader->add_action('woocommerce_after_checkout_registration_form', $plugin_woo, 'wooc_checkout_register_fields');


		 /**
		  * Buddy press
		  */
		 $this->loader->add_action( 'bp_signup_profile_fields', $plugin_bp, 'bp_fields');
		 $this->loader->add_action( 'bp_signup_validate', $plugin_bp, 'bp_validate');


		 /** All versions **/
		 $this->loader->add_action( 'show_user_profile', $plugin_default, 'extend_user_profile_fields', 10, 1 );
		 $this->loader->add_action( 'edit_user_profile', $plugin_default, 'extend_user_profile_fields', 10, 1 );



	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();

		global $wp_filter; // test is register action name with callback function

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Age_Gate_User_Registration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
