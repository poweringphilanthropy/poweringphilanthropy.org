<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://agegate.io
 * @since             1.0.0
 * @package           Age_Gate_User_Registration
 *
 * @wordpress-plugin
 * Plugin Name:       Age Gate User Registration
 * Plugin URI:        https://agegate.io/addons/age-gate-user-registration
 * Description:       An Age Gate addon to check the age of users registering or using WooCommerce
 * Version:           0.2.0
 * Author:            Phil Baker
 * Author URI:        https://agegate.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       age-gate-user-registration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AGE_GATE_USER_REGISTRATION_VERSION', '0.2.0' );
define( 'AGE_GATE_USER_REGISTRATION_NAME', 'age-gate-user-registration' );
define( 'AGE_GATE_USER_REGISTRATION_PEER', '2.1.0');
define( 'AGE_GATE_USER_REGISTRATION_PATH', plugin_dir_path(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-age-gate-user-registration-activator.php
 */
function activate_age_gate_user_registration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-age-gate-user-registration-activator.php';
	Age_Gate_User_Registration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-age-gate-user-registration-deactivator.php
 */
function deactivate_age_gate_user_registration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-age-gate-user-registration-deactivator.php';
	Age_Gate_User_Registration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_age_gate_user_registration' );
register_deactivation_hook( __FILE__, 'deactivate_age_gate_user_registration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-age-gate-user-registration.php';

function age_gate_user_registration_missing_parent() {
	echo '<div id="message" class="notice notice-error"><p>'. __('You have activated Age Gate: User Registration but Age Gate is not installed', 'age-gate-user-registration') .'</p></div>';
}

function age_gate_user_registration_unmet_dependency() {
	echo '<div id="message" class="notice notice-error"><p>'. sprintf(__('Age Gate: User Registration requires Age Gate %s or higher', 'age-gate-user-registration'), AGE_GATE_USER_REGISTRATION_PEER) .'</p></div>';

}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_age_gate_user_registration() {
	if(!function_exists('is_plugin_active')){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	if(!is_plugin_active('age-gate/age-gate.php')){
		add_action( 'admin_notices', 'age_gate_user_registration_missing_parent' );
	} elseif(version_compare(get_option('wp_age_gate_version', false), AGE_GATE_USER_REGISTRATION_PEER, '<')) {
		add_action( 'admin_notices', 'age_gate_user_registration_unmet_dependency' );

	} else {
		$plugin = new Age_Gate_User_Registration();
		$plugin->run();
	}


}
run_age_gate_user_registration();
