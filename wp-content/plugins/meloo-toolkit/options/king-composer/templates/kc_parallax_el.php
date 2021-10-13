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
$wrap_class[] = 'kc-parallax-el';
$wrap_class[] = $atts['classes'];

$output = '<div class="' .  esc_attr( implode(' ', $wrap_class) ) . '">';
$output .= '<div class="kc-parallax-wrap" data-parallax=\'{"y": ' . esc_attr( $atts['parallax_y'] ) . '}\' >';
$output .= do_shortcode( str_replace('kc_parallax_el#', 'kc_parallax_el', $content ) );
$output .= '</div>';
$output .= '</div>';
 
rascals_core_e_esc( $output ); 

?>