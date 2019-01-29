<?php  if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://agegate.io
 * @since      1.0.0
 *
 * @package    Age_Gate_Accept_Terms
 * @subpackage Age_Gate_Accept_Terms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Age_Gate_Accept_Terms
 * @subpackage Age_Gate_Accept_Terms/public
 * @author     Phil Baker <support@wordpressagegate.com>
 */
class Age_Gate_User_Registration_Common {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	protected $ag_settings;

  public function __construct()
  {
    $this->plugin_name = AGE_GATE_USER_REGISTRATION_NAME;
    $this->version = AGE_GATE_USER_REGISTRATION_VERSION;
		$this->ag_settings = (object) [
			'restriction' => (object) get_option('wp_age_gate_restrictions', array())
		];
  }

  /**
   * Filter to ensure all fields get sent to the DB
   * @param  [type] $data [description]
   * @param  [type] $fill [description]
   * @return [type]       [description]
   * @since   1.0.0
   */
  protected function _filter_values($data, $fill)
  {
    $empties = array_fill_keys([
      'restrict_register',
      'restrict_register_woocommerce',
      'register_age',
			'store_dob',
			'registration_error',
			'account_error',
			'checkout_error',
			'restrict_checkout_woocommerce',
			'invalid_error'

    ], $fill);

    return array_merge($empties, $data);
  }

	protected function _ageTest($dob)
	{

		$dob = intval($dob['y']). '-' . str_pad(intval($dob['m']), 2, 0, STR_PAD_LEFT) . '-' . str_pad(intval($dob['d']), 2, 0, STR_PAD_LEFT);

		$from = new DateTime($dob);
		$to   = new DateTime('today');
		return $from->diff($to)->y;


	}
}