<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://agegate.io
 * @since      1.0.0
 *
 * @package    Age_Gate_User_Registration
 * @subpackage Age_Gate_User_Registration/admin/partials
 */

$can_register = false;
?>
<form class="custom-form-fields" action="admin-post.php" method="post">
  <input type="hidden" name="action" value="age_gate_addon">
  <input type="hidden" name="addon" value="<?php echo $this->plugin_name; ?>">
  <?php wp_nonce_field( 'age_gate_addon', 'nonce'); ?>
  <table class="form-table">
    <tr>
      <th scope="row">
        <?php _e('Restrict registration', $this->plugin_name); ?>
      </th>
      <td>
        <?php if (get_option('users_can_register')): $can_register = true; ?>
          <label>
            <?php echo form_checkbox(
                array(
                  'name' => "ag_settings[restrict_register]",
                  'id' => "wp_age_gate_restrict_register"
                ),
                1, // value
                $this->settings['restrict_register'] // checked
              ); ?>
              <?php $buddypress = (class_exists('BuddyPress') ? 'BuddyPress' : 'WordPress');
              echo sprintf(__('Age check users during %s registration', $this->plugin_name), $buddypress); ?>
          </label><br />
        <?php endif; ?>
        <?php if(class_exists('WooCommerce')): $can_register = true;?>
          <label>
            <?php echo form_checkbox(
                array(
                  'name' => "ag_settings[restrict_register_woocommerce]",
                  'id' => "wp_age_gate_restrict_register_woocommerce"
                ),
                1, // value
                $this->settings['restrict_register_woocommerce'] // checked
              ); ?> <?php _e('Age check users during WooCommerce registration', $this->plugin_name); ?>
          </label><br />
          <label>
            <?php echo form_checkbox(
                array(
                  'name' => "ag_settings[restrict_checkout_woocommerce]",
                  'id' => "wp_age_gate_restrict_checkout_woocommerce"
                ),
                1, // value
                $this->settings['restrict_checkout_woocommerce'] // checked
              ); ?> <?php _e('Age check users during WooCommerce checkout', $this->plugin_name); ?>
          </label><br />
        <?php endif; ?>
        <?php if (!$can_register): ?>
          <p><?php _e('Standard registrations are disabled and WooCommerce/BuddyPress are not installed.', $this->plugin_name); ?></p>
        <?php endif; ?>
      </td>
    </tr>
    <?php if ($can_register): ?>
    <tr>
      <th scope="row">
        <label for="wp_age_gate_registration_age"><?php _e('Registration age', $this->plugin_name); ?></label>
      </th>
      <td>
        <?php echo form_input(array(
            'name' => 'ag_settings[register_age]',
            'type' => 'number',
            'id' => 'wp_age_gate_registration_age'
          ), $this->settings['register_age'], array('class' => 'small-text ltr'));
          ?> <?php _e("years or older to register", $this->plugin_name); ?>
          <p class="note"><small><?php _e('Leave blank to use age from Age Gate Restriction settings', $this->plugin_name); ?></p>
      </td>
    </tr>
    <tr>
      <th scope="row">
        <label for="wp_age_gate_store_dob"><?php _e('Registration age', $this->plugin_name); ?></label>
      </th>
      <td>
        <label>
          <?php echo form_checkbox(
              array(
                'name' => "ag_settings[store_dob]",
                'id' => "wp_age_gate_store_dob"
              ),
              1, // value
              $this->settings['store_dob'] // checked
            ); ?> <?php _e('Store users date of birth when registering', $this->plugin_name); ?>
        </label>
      </td>
    </tr>
    <tr>
      <th scope="row">
        <label for="wp_age_gate_invalid_error"><?php _e('Invalid date error', $this->plugin_name); ?></label>
      </th>
      <td>
        <label>
          <?php echo form_input(array(
              'name' => 'ag_settings[invalid_error]',
              'type' => 'text',
              'id' => 'wp_age_gate_invalid_error'
            ), $this->settings['invalid_error'], array('class' => 'regular-text ltr'));
            ?>
        </label>
      </td>
    </tr>

    <tr>
      <th scope="row">
        <label for="wp_age_gate_registration_error"><?php _e('Registration error message', $this->plugin_name); ?></label>
      </th>
      <td>
        <label>
          <?php echo form_input(array(
              'name' => 'ag_settings[registration_error]',
              'type' => 'text',
              'id' => 'wp_age_gate_registration_error'
            ), $this->settings['registration_error'], array('class' => 'regular-text ltr'));
            ?>
        </label>
      </td>
    </tr>
    <?php if(class_exists('WooCommerce')): ?>
    <tr>
      <th scope="row">
        <label for="wp_age_gate_registration_error"><?php _e('Account error message', $this->plugin_name); ?></label>
      </th>
      <td>
        <label>
          <?php echo form_input(array(
              'name' => 'ag_settings[account_error]',
              'type' => 'text',
              'id' => 'wp_age_gate_account_error'
            ), $this->settings['account_error'], array('class' => 'regular-text ltr'));
            ?>
        </label>
      </td>
    </tr>
    <tr>
      <th scope="row">
        <label for="wp_age_gate_registration_error"><?php _e('Checkout error message', $this->plugin_name); ?></label>
      </th>
      <td>
        <label>
          <?php echo form_input(array(
              'name' => 'ag_settings[checkout_error]',
              'type' => 'text',
              'id' => 'wp_age_gate_checkout_error'
            ), $this->settings['checkout_error'], array('class' => 'regular-text ltr'));
            ?>
        </label>
      </td>
    </tr>
    <?php endif; ?>
    <?php endif; ?>

  </table>
<?php submit_button(); ?>
</form>



