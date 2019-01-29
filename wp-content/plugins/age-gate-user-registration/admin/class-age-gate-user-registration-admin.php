<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://agegate.io
 * @since      1.0.0
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/admin
 * @author     Phil Baker <support@wordpressagegate.com>
 */
class Age_Gate_User_Registration_Admin extends Age_Gate_User_Registration_Common {


	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {
		parent::__construct();
		$this->_update_check();
		$this->settings = $this->_filter_values(get_option('wp_age_gate_addon_' . $this->plugin_name, array()), '');

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Age_Gate_User_Registration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Age_Gate_User_Registration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Age_Gate_User_Registration_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Age_Gate_User_Registration_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 /* No JS is actually required so let's not add extra requests.
			* Leaving for future reference
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false );
		*/
	}

	public function register_addon($addons)
	{
		$addons[$this->plugin_name] = [
			'name' => 'Age Gate User Registration',
			'cap' => 'ag_manage_restrictions',
			'icon' => plugin_dir_url( __FILE__ ) . 'img/icon-256x256.png',
			'has_options' => true
		];


		return $addons;
	}

	public function display_options_page()
	{
		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/age-gate-user-registration-admin-display.php';
	}

	/**
	 * Create a settings link in the plugins screen
	 *
	 * @param  mixed $links The standard links
	 * @return mixed $links	The links updated with our settings
	 * @since 1.0.0
	 */
	public function parent_action_links( $links ) {
    $deactivate = '<a href="#">' . __('Deactivate') . '</a>';

    array_push( $links, $deactivate );
  	return $links;
	}

	/**
	 * Checks the plugin version against the stored version
	 * and updates the settings if mismatched
	 *
	 * @since 0.0.0
	 *
	 */
	private function _update_check()
	{
		if (AGE_GATE_USER_REGISTRATION_VERSION !== get_option('wp_age_gate_addon_'. $this->plugin_name .'_version')){

			require_once AGE_GATE_USER_REGISTRATION_PATH . 'includes/class-age-gate-user-registration-activator.php';
			Age_Gate_User_Registration_Activator::activate();
		}

	}

	public function add_export_option($d){
	  return array_merge($d, [
	    'user-registration' => [
	      'options' => ['wp_age_gate_addon_age-gate-user-registration'],
	      'label' => __('User registration')
	    ]
	  ]);
	}
}
