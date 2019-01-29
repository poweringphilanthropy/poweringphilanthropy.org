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
 * The adds age checking to default register form.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/public
 * @author     Phil Baker <support@wordpressagegate.com>
 */
class Age_Gate_User_Registration_Default extends Age_Gate_User_Registration_Common {
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

	public function extend_registration_form()
	{
		if(!$this->addon['restrict_register']) return;
		echo '<fieldset class="registration-age-gate">';
		echo "<legend>" . __("Date of birth", $this->plugin_name) . "</legend>";
		include AGE_GATE_PATH . 'public/partials/form/'. ($this->restrictions->input_type !== 'buttons' ? $this->restrictions->input_type : 'inputs') .'.php';
		echo "</fieldset>";
	}
	public function register_style()
	{
		if(!$this->addon['restrict_register']) return;

    wp_enqueue_style( $this->plugin_name . '-reg', plugin_dir_url( __FILE__ ) . 'css/public.css', array(), $this->version, 'all' );
	}
	public function extend_registration_form_show_errors($errors, $login, $email)
	{
		if(!$this->addon['restrict_register']) return $errors;
		$validation = new Age_Gate_Validation;

		$data = $validation->sanitize($_POST);

    if(!isset($data['age_gate'])){
      return $errors;
    }

    $validated = Age_Gate_Validation::is_valid($data['age_gate'], array(
    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
    ));


    if($validated === true) {
      if ( $this->_ageTest($data['age_gate']) < (int) $this->age ){
        $errors->add( 'toyoungerror', '<strong>' . __('ERROR', $this->plugin_name) . '</strong>: '. sprintf($this->addon['registration_error'], $this->age) );
      }
    } else {
      $errors->add( 'toyoungerror', '<strong>' . __('ERROR', $this->plugin_name) . '</strong>: '. $this->addon['invalid_error'] );
    }

		return $errors;
	}
	public function extend_registration_user_data( $user_id )
	{
		if(!$this->addon['restrict_register']) return;

		if($this->addon['store_dob']){

	    $validation = new Age_Gate_Validation;
	    $data = $validation->sanitize($_POST);

	    if(!isset($data['age_gate'])){
	      return $user_id;
	    }

	    $validated = Age_Gate_Validation::is_valid($data['age_gate'], array(
	    	'd' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
	      'm' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
	      'y' => 'required|numeric|min_len,4|max_len,4|max_numeric,' . date('Y'),
	    ));

	    if($validated === true) {
	      update_user_meta( $user_id, 'u_db', $data['age_gate']['y'] . '-' . $data['age_gate']['m'] . '-' . $data['age_gate']['d'] );
	      update_user_meta( $user_id, 'user_dob', $data['age_gate'] );
	    }
		}

    return $user_id;
	}

	// show on profile
	public function extend_user_profile_fields($profileuser)
	{
		?>
		<table class="form-table">
		<tr>
			<th>
				<label for="user_location"><?php _e('Location'); ?></label>
			</th>
			<td>
				<input type="text" name="user_location" id="user_location" value="<?php echo esc_attr( get_the_author_meta( 'u_db', $profileuser->ID ) ); ?>" class="regular-text" />
				<br><span class="description"><?php _e('Your location.', 'text-domain'); ?></span>
			</td>
		</tr>
	</table>
		<?php
	}

}
