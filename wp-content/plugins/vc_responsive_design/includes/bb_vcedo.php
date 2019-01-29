<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'WPBakeryShortCode_Bb_Vcedo' ) ) {
	class WPBakeryShortCode_Bb_Vcedo extends WPBakeryShortCodesContainer {
	}
} else {
	global $composer_settings;
	// The class WPBakeryShortCodesContainer is defined in VC's shortcodes.php, include it so we can define our container
	if ( ! empty( $composer_settings ) ) {
		if ( array_key_exists( 'COMPOSER_LIB', $composer_settings ) ) {
			$lib_dir = $composer_settings['COMPOSER_LIB'];
			if ( file_exists( $lib_dir . 'shortcodes.php' ) ) {
				require_once( $lib_dir . 'shortcodes.php' );
			}
		}
	}

	if ( class_exists( 'WPBakeryShortCodesContainer' ) && ! class_exists( 'WPBakeryShortCode_Bb_Vcedo' ) ) {
		class WPBakeryShortCode_Bb_Vcedo extends WPBakeryShortCodesContainer {
		}
	}
}
