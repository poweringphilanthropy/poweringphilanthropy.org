<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'BestBugVCEDOAddParams' ) ) {
	/**
	 * VC BestBugVCEDOAddParams Class
	 *
	 * @since	1.0
	 */
	class BestBugVCEDOAddParams {

		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		public function init(){
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
                return;
            }

			$group = BestBugVCEDOHelper::$tab_option;
			$devices = BestBugVCEDOHelper::$devices_array;

			$tabs = array();
			foreach ($devices as $id => $device) {
				$tabs[$id] = $device;
			}

			$shortcodes = BestBugVCEDOHelper::$shortcodes_active;

			foreach ($shortcodes as $key => $shortcode) {
				$shortcode = trim($shortcode);
				vc_add_param( $shortcode, array(
					'type' => 'bb_tab',
					'param_name' => 'bb_tab_container',
					'active' => BestBugVCEDOHelper::$tab_active,
					'tabs' => $tabs,
					'suffix' => array('typo', 'show_hide'),
					'class' => BestBugVCEDOHelper::$menu_tab_position,
					'group' => $group,
				));

				foreach ($devices as $id => $device) {
					vc_add_param( $shortcode, array(
						'type' => 'css_editor',
						'heading' => $device['label'],
						'param_name' => $id,
						'group' => $group,
					));

					vc_add_param( $shortcode, array(
						'type' => 'bb_typography',
						'heading' => BestBugVCEDOHelper::$typo_label . ' - ' . $device['label'],
						'param_name' => $id . 'typo',
						'group' => $group,
					));

					vc_add_param( $shortcode, array(
						'type' => 'bb_toggle',
						'heading' => esc_html__('Show/Hide on ', 'bestbug') . $device['label'],
						'param_name' => $id. 'show_hide',
						'group' => $group,
						'value' => 'yes',
					));

				}

			}
		}

	}

	new BestBugVCEDOAddParams();
}
