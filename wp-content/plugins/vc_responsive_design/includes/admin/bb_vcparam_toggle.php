<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if(!class_exists('BestBug_VcParam_Toggle'))
{
	class BestBug_VcParam_Toggle
	{
		function __construct()
		{
			if ( class_exists( 'WpbakeryShortcodeParams' ) && is_admin() )
			{
				WpbakeryShortcodeParams::addField('bb_toggle' , array($this, 'bb_toggle'), BESTBUG_VCEDO_URL . 'assets/admin/js/bb-vcparam-toggle.js');
			}
		}

		function bb_toggle($settings, $value){

			$output = $checked = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			if(empty($value)) {
				$value = isset($settings['value']) ? $settings['value'] : '';
			}

			$output = '<label class="bestbug-switch">';

			$output .= '<input class="switch-checkbox" type="checkbox" '.(($value == "yes")?'checked':"").'><div class="bestbug-slider round"></div>';

			$output .= '<input class="switch-value wpb_vc_param_value" name="'.$param_name.'" type="text" value="'.$value.'" />';

			$output .= '</label>';

			return $output;
		}

	}

	new BestBug_VcParam_Toggle();
}
