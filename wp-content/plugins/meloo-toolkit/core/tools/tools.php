<?php
/**
 * Rascals Toolkit Tools
 *
 *
 * @author Rascals Themes
 * @version 1.0.0
 * @category Core
 * @package Toolkit Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Display escaped text.
 * @version 1.0.0
 * @param  $text
 * @return string
 */
if ( ! function_exists( 'rascals_core_esc' ) ) :
function rascals_core_esc( $text ) {
	$text = preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $text );
	return $text;
}
endif;


/**
 * Display escaped text through echo function.
 * @version 1.0.0
 * @param  $text
 * @return string
 */
if ( ! function_exists( 'rascals_core_e_esc' ) ) :
function rascals_core_e_esc( $text ) {
	echo preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $text );
}
endif;


/**
 * Get Theme Panel
 * @version 1.0.0
 * @return void
 */
if ( ! function_exists( 'rascals_core_get_panel' ) ) :

function rascals_core_get_panel( $option_name = false ) {
	if ( defined( 'RASCALS_THEME_PANEL' ) ) {
		return RASCALS_THEME_PANEL;
	} else if ( $option_name ) {
		return get_option( $option_name );
	} else {
		return false;
	}

}
endif;


/**
 * Set Revo Slider options for Ajax loader
 * @version 1.0.0
 * @return void
 */
if ( ! function_exists( 'rascals_core_set_revoslider' ) ) :
function rascals_core_set_revoslider() {

	if ( class_exists( 'RevSlider' ) && function_exists( 'rev_slider_shortcode' ) ) {
		
		// Only for 6 and above versions
		if ( defined('RS_REVISION') && version_compare( RS_REVISION, '6.0.0' ) >= 0 ) {
			$ajax = rascals_core_get_option( 'ajaxed', 'off' );

			if ( $ajax === 'on' ) {
				$rev_slider = new RevSlider();

				$rev_opts = $rev_slider->get_global_settings();
				if ( is_array( $rev_opts ) && isset( $rev_opts['include'] ) && $rev_opts['include'] === 'false' ) {
					$rev_opts['include'] = 'true';
					$rev_slider->set_global_settings($rev_opts);

				}
        	}
        }
	}
}
// Revolution Slider
endif;


/**
 * Get Theme Option
 * @version 1.0.0
 * @return void
 */
if ( ! function_exists( 'rascals_core_get_option' ) ) :

function rascals_core_get_option( $option, $default = null ) {
	if ( rascals_core_get_panel() ) {
   		$theme_panel = rascals_core_get_panel();

	   	if ( $theme_panel === false || ! is_array( $theme_panel )  || ! isset( $option ) ) {
			return false;
		}
		if ( isset( $theme_panel[ $option ] ) ) {
			return $theme_panel[ $option ];
		} elseif ( $default !== null ) {
			return $default;
		} else {	
			return false;
		}
	}

}
endif;