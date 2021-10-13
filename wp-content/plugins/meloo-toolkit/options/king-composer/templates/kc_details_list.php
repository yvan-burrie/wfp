<?php
/**
 * Rascals King Composer Extensions
 *
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Kingcomposer wrapper class for each element 
$wrap_class = apply_filters( 'kc-el-class', $atts );

// Add custom classes to element 
$wrap_class[] = 'kc-details-list';
$wrap_class[] = $atts['list_style'];

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

$output = '<div class="' .  esc_attr( implode(' ', $wrap_class) ) . ' ' . esc_attr( $atts['classes'] ) . '">';
$output .= '<ul class="track-details-1">';
$output .= do_shortcode( str_replace('kc_details_list#', 'kc_details_list', $content ) );
$output .= '</ul>';
$output .= '</div>';
 
rascals_core_e_esc( $output );

?>