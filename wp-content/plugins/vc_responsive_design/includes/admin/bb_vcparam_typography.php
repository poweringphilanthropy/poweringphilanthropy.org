<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if(!class_exists('BestBug_VcParam_Typography'))
{
	class BestBug_VcParam_Typography
	{
		function __construct()
		{
			if ( class_exists( 'WpbakeryShortcodeParams' ) )
			{
				// Add the color picker css file
        		wp_enqueue_style( 'wp-color-picker' );

				WpbakeryShortcodeParams::addField('bb_typography' , array($this, 'bb_typography'), BESTBUG_VCEDO_URL . 'assets/admin/js/bb-vcparam-typography.js');

				wp_enqueue_style( 'bb_vcedo', BESTBUG_VCEDO_URL . '/assets/admin/css/admin.css' );
			}
		}

		function bb_typography($settings, $value){

			$output = $checked = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			if(empty($value)) {
				$value = isset($settings['value']) ? $settings['value'] : '';
			}

			$output = '<div class="bb-typography vc_edit_form_elements bb-layout">';

			$html_info_icon = ' <span class="dashicons dashicons-info"></span> ';

			$output .= '<div class="row">';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Color', 'bestbug').'</label><br/> <input type="text" class="bb-color-picker  bb-typo-color" />';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 'bestbug').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Line-height', 'bestbug').'</label> <input type="text" class="bb-typo-line-height" />';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 'bestbug').'" class="bbhelp--left">'.$html_info_icon.esc_html__('Letter-spacing', 'bestbug').'</label> <input type="text" class="bb-typo-letter-spacing" />';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="row">';
				$output .= '<div class="col-md-4">';
					$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 'bestbug').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Word-spacing', 'bestbug').'</label> <input type="text" class="bb-typo-word-spacing" />';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label bbhelp-label="'.esc_attr__('unit px, em or rem', 'bestbug').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Font-size', 'bestbug').'</label> <input type="text" class="bb-typo-font-size" />';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Font-weight', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-font-weight">
									<option value="">Default</option>
									<option value="100">Thin (Hairline) - 100</option>
									<option value="200">Extra Light (Ultra Light) - 200</option>
									<option value="300">Light - 300</option>
									<option value="400">Normal - 400</option>
									<option value="500">Medium - 500</option>
									<option value="600">Semi Bold (Demi Bold) - 600</option>
									<option value="700">Bold - 700</option>
									<option value="800">Extra Bold (Ultra Bold) - 800</option>
									<option value="900">Black (Heavy) - 900</option>
								</select>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="row">';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Font-style', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-font-style">
									<option value="">Default</option>
									<option value="normal">normal</option>
									<option value="italic">italic</option>
									<option value="oblique">oblique</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('White-space', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-white-space">
									<option value="">Default</option>
									<option value="normal">normal</option>
									<option value="nowrap">nowrap</option>
									<option value="pre">pre</option>
									<option value="pre-line">pre-line</option>
									<option value="pre-wrap">pre-wrap</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Text-overflow', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-text-overflow">
									<option value="">Default</option>
									<option value="clip">clip</option>
									<option value="ellipsis">ellipsis</option>
									<option value="string">string</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="row">';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Text-align', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-text-align">
									<option value="">Default</option>
									<option value="left">left</option>
									<option value="right">right</option>
									<option value="center">center</option>
									<option value="justify">justify</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Text-transform', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-text-transform">
									<option value="">Default</option>
									<option value="none">none</option>
									<option value="capitalize">capitalize</option>
									<option value="uppercase">uppercase</option>
									<option value="lowercase">lowercase</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label>'.esc_html__('Text-decoration', 'bestbug').'</label>';
					$output .= '<select class="bb-typo-text-decoration">
									<option value="">Default</option>
									<option value="none">none</option>
									<option value="underline">underline</option>
									<option value="overline">overline</option>
									<option value="line-through">line-through</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="row">';
				$output .= '<div class="col-md-8">';
					$output .= '<label bbhelp-label="'.esc_attr__('Enter URL', 'bestbug').'" class="bbhelp--right">'.$html_info_icon.esc_html__('Background image', 'bestbug').'</label> <input type="text" class="bb-typo-background-image" />';
				$output .= '</div>';
				$output .= '<div class="col-md-4">';
					$output .= '<label>&nbsp;</label><button type="button" class="bbbtn-typo-uploadimage">'.esc_html__('Upload Image', 'bestbug').'</button>';
				$output .= '</div>';
			$output .= '</div>';


			$output .= '<input class="bb-typography-value wpb_vc_param_value" name="'.$param_name.'" type="hidden" value="'.$value.'" />';

			$output .= '</div>';

			return $output;

		}

	}

	new BestBug_VcParam_Typography();
}
