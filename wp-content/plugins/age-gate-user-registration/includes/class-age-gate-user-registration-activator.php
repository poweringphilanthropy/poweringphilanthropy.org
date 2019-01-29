<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * Fired during plugin activation
 *
 * @link       https://agegate.io
 * @since      1.0.0
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/includes
 * @author     Phil Baker <support@wordpressagegate.com>
 */
class Age_Gate_User_Registration_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::addDefaults();
		update_option('wp_age_gate_addon_age-gate-user-registration_version', AGE_GATE_USER_REGISTRATION_VERSION);
	}

	public static function addDefaults()
	{
		$messages = [
			'invalid_error' => 'Please enter a valid date',
			'registration_error' => 'Sorry, you must be over %s to register',
			'account_error' => 'Sorry, you must be over %s',
			'checkout_error' => 'Sorry, you must be over %s to purchase'
		];

		$user = get_option('wp_age_gate_addon_age-gate-user-registration', []);

		$defaults = array_merge($messages, $user);

		update_option('wp_age_gate_addon_age-gate-user-registration', $defaults);
	}

}
