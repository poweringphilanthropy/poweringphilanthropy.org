<?php
add_filter( 'vc_shortcodes_css_class', 'bb_vcedo_filter', 10, 3 );

function bb_vcedo_filter( $class_string = '', $tag = '', $atts = null ) {

	if ( ! in_array($tag, BestBugVCEDOHelper::$shortcodes_active ) && BestBugVCEDOHelper::$option_by_elements != 'all' ) {
		return $class_string;
	}

	$flag_show_hide = false;
	$class_show_hide = '';

	$css_typography = '';

	foreach (BestBugVCEDOHelper::$devices_array as $id => $device) {
		if(isset($atts[ $id ]) && !empty($atts[ $id ])) {
			$class_string .= vc_shortcode_custom_css_class( $atts[ $id ], ' ' );
		}

		if(isset($atts[ $id . 'typo' ]) && !empty($atts[ $id . 'typo' ])) {
			$class_string .= vc_shortcode_custom_css_class( $atts[ $id . 'typo' ], ' ' );

			$css_typography .= $atts[ $id . 'typo' ];
		}

		if(isset($atts[ $id . 'show_hide' ]) && $atts[ $id . 'show_hide' ] == 'no') {
			$flag_show_hide = true;
			$class_show_hide .= ' ' . $id . '_hide ';
		} else {
			$class_show_hide .= ' ' . $id . '_show ';
		}
	}

	$class_typography = BestBugVCEDOHelper::get_css($css_typography);
	if(!empty($class_typography)) {
		$class_string .= ' ' . $class_typography;
	}
	if($flag_show_hide) {
		$class_string .= $class_show_hide;
	}

	return $class_string;
}
