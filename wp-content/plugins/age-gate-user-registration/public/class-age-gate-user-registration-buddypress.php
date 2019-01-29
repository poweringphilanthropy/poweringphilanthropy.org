<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://agegate.io
 * @since      1.0.0
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/public
 * @author     Phil Baker <support@wordpressagegate.com>
 */
class Age_Gate_User_Registration_Buddypress extends Age_Gate_User_Registration_Common {
	private $settings;
	private $addon;
	private $restrictions;
	private $age;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

		parent::__construct();

		$this->addon = $this->_filter_values(get_option('wp_age_gate_addon_' . $this->plugin_name, array()), '');
		// $this->settings = $this->ag_settings;
		$this->restrictions = (object) get_option('wp_age_gate_restrictions', array());

		$this->age = ($this->addon['register_age']) ? $this->addon['register_age'] : $this->restrictions->min_age;



	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );

	}

	public function bp_fields()
	{

		if(!$this->addon['restrict_register']) return;
		global $bp;
		if(isset($_POST['age_gate'])){
			$validation = new Age_Gate_Validation;
			$age = $validation->sanitize($_POST['age_gate']);
		}
		echo '<fieldset class="registration-age-gate--bp">';
		echo "<legend>" . __("Date of birth", $this->plugin_name) . "</legend>";
		if(isset($bp->signup->errors['age_gate'])){
			echo "<div class=\"error\">" . $bp->signup->errors['age_gate'] . "</div>";
		}
		echo '<div class="editfield field_1 field_name required-field visibility-public field_type_textbox">';
		include AGE_GATE_PATH . 'public/partials/form/'. ($this->restrictions->input_type !== 'buttons' ? $this->restrictions->input_type : 'inputs') .'.php';
		echo "</div>";
		echo "</fieldset>";

	}

	public function bp_validate()
	{
		if(!$this->addon['restrict_register']) return;
		global $bp;
		$validation = new Age_Gate_Validation;
		$data = $validation->sanitize($_POST);

		$validated = Age_Gate_Validation::is_valid($data['age_gate'], array(
    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
    ));

		if($validated === true) {
      if ( $this->_ageTest($data['age_gate']) < (int) $this->age ){

				$bp->signup->errors['age_gate'] = sprintf($this->addon['registration_error'], $this->age);
      }
    } else {
      $bp->signup->errors['age_gate'] = $this->addon['invalid_error'];
    }
	}


}
