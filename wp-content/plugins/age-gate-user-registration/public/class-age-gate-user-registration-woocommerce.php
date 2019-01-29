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
class Age_Gate_User_Registration_WooCommerce extends Age_Gate_User_Registration_Common {
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
	/*****
	REGISTRATION FIELDS
	******/
	/**
	 * [wooc_extra_register_fields description]
	 * @return [type] [description]
	 */

	public function wooc_extra_register_fields(){
		$validation = new Age_Gate_Validation;
    $post = $validation->sanitize($_POST);

		$age = isset($post['age_gate']) ? $post['age_gate'] : false;

		echo '<fieldset class="registration-age-gate">';
		echo "<legend>" . __("Date of birth", $this->plugin_name) . "</legend>";
		include AGE_GATE_PATH . 'public/partials/form/'. ($this->restrictions->input_type !== 'buttons' ? $this->restrictions->input_type : 'inputs') .'.php';
		echo "</fieldset>";
	}

	public function wooc_validate_extra_register_fields($username, $email, $validation_errors)
	{

		if(!$this->addon['restrict_register']) $validation_errors;

		$validation = new Age_Gate_Validation;
    $post = $validation->sanitize($_POST);

		if(!isset($post['age_gate'])){
      $validation_errors->add('age_error', 'Date of birth required');
    }

    $validated = Age_Gate_Validation::is_valid($post['age_gate'], array(
    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
    ));

    if($validated === true) {
      if ( $this->_ageTest($post['age_gate']) < (int) $this->age ){
        $validation_errors->add( 'tooyoungerror', sprintf($this->addon['registration_error'], $this->age) );
      }
    } else {
      $validation_errors->add( 'tooyoungerror', $this->addon['invalid_error'] );
    }

		// $validation_errors->add('age_error', sprintf($this->addon['registration_error'], $this->age));
		return $validation_errors;
	}


	/**
	* Below code save extra fields.
	*/
	function wooc_save_extra_register_fields( $customer_id ) {
		if(!$this->addon['restrict_register']) return $customer_id;
		if($this->addon['store_dob']){

			$validation = new Age_Gate_Validation;
	    $data = $validation->sanitize($_POST);

	    if(!isset($data['age_gate'])){
	      return $customer_id;
	    }

	    $validated = Age_Gate_Validation::is_valid($data['age_gate'], array(
	    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
	      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
	      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
	    ));

	    if($validated === true) {
	      update_user_meta( $customer_id, 'u_db', $data['age_gate']['y'] . '-' . $data['age_gate']['m'] . '-' . $data['age_gate']['d'] );
	      update_user_meta( $customer_id, 'user_dob', $data['age_gate'] );
	    }

		}

		return $customer_id;
	}

	/*****
	* ACCOUNT FIELDS
	******/

	public function wooc_extra_account_fields(){
		if(!$this->addon['store_dob']) return;


		$user_id = get_current_user_id();

		$validation = new Age_Gate_Validation;
		$post = $validation->sanitize($_POST);

		$age = isset($post['age_gate']) ? $post['age_gate'] : get_user_meta( $user_id, 'user_dob', true );

		echo '<fieldset class="registration-age-gate">';
		echo "<legend>" . __("Date of birth", $this->plugin_name) . "</legend>";
		include AGE_GATE_PATH . 'public/partials/form/'. ($this->restrictions->input_type !== 'buttons' ? $this->restrictions->input_type : 'inputs') .'.php';
		echo "</fieldset>";
	}

	public function wooc_validate_extra_account_fields($validation_errors)
	{
		if(!$this->addon['store_dob']) return $validation_errors;

		$validation = new Age_Gate_Validation;
    $post = $validation->sanitize($_POST);

		if(!isset($post['age_gate'])){
      $validation_errors->add('age_error', __('Date of birth required', $this->plugin_name));
    }

    $validated = Age_Gate_Validation::is_valid($post['age_gate'], array(
    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
    ));

    if($validated === true) {
      if ( $this->_ageTest($post['age_gate']) < (int) $this->age ){
        $validation_errors->add( 'tooyoungerror', sprintf($this->addon['account_error'], $this->age) );
      }
    } else {
      $validation_errors->add( 'tooyoungerror', $this->addon['invalid_error'] );
    }

		return $validation_errors;

	}

	/**
	 * Checkout fields
	 */
	public function wooc_custom_checkout_fields($checkout){
		if(!$this->addon['restrict_checkout_woocommerce']) return;
		$user_id = get_current_user_id();
		$age = isset($post['age_gate']) ? $post['age_gate'] : get_user_meta( $user_id, 'user_dob', true );
		echo '<fieldset class="registration-age-gate">';
		echo "<legend>" . __("Date of birth", $this->plugin_name) . "</legend>";
		include AGE_GATE_PATH . 'public/partials/form/'. ($this->restrictions->input_type !== 'buttons' ? $this->restrictions->input_type : 'inputs') .'.php';
		echo "</fieldset>";
	}


	function custom_checkout_field_process() {
		if(!$this->addon['restrict_checkout_woocommerce']) return;

		$validation = new Age_Gate_Validation;
    $post = $validation->sanitize($_POST);

		if(!isset($post['age_gate'])){
      wc_add_notice( __('Date of birth required', $this->plugin_name), 'error');
    }

		$validated = Age_Gate_Validation::is_valid($post['age_gate'], array(
    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
    ));

    if($validated === true) {
      if ( $this->_ageTest($post['age_gate']) < (int) $this->age ){
				wc_add_notice( sprintf($this->addon['checkout_error'], $this->age), 'error');
        // $validation_errors->add( 'tooyoungerror', sprintf($this->addon['account_error'], $this->age) );
      }
    } else {
			wc_add_notice( sprintf($this->addon['invalid_error']), 'error');


    }


	    // // Check if set, if its not set add an error.
	    // if ( ! $_POST['my_field_name'] ){
	    // 	wc_add_notice( __( 'Please enter something into this new shiny field.' ), 'error' );
			// }
	}

	public function wooc_checkout_register_fields($checkout){


		if(!$this->addon['restrict_checkout_woocommerce'] && $this->addon['restrict_register_woocommerce']){
			echo "<div class='create-account'>";
			echo '<fieldset class="registration-age-gate">';
			echo "<legend>" . __("Date of birth", $this->plugin_name) . "</legend>";
			include AGE_GATE_PATH . 'public/partials/form/'. ($this->restrictions->input_type !== 'buttons' ? $this->restrictions->input_type : 'inputs') .'.php';
			echo "</fieldset>";
			echo "</div>";
		}
	}
}