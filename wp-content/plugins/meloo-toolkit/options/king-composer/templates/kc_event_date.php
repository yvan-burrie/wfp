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
$wrap_class[] = 'kc-event-date';
$queried_object = get_queried_object();

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

$post_id = null;
if ( $queried_object ) {
    $post_id = $queried_object->ID;
}

if ( isset( $post_id ) ) {
	// Event Date 
    $event_date_start = get_post_meta( $post_id, '_event_date_start', true );
    
} else {
	$event_date_start = '2030-01-01';
}
	
$event_date_start = strtotime( $event_date_start );
	
?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">

	<div class="kc-big-event-date" data-parallax='{"y": <?php echo esc_attr( $atts['parallax_y'] ) ?>}'>
   		<?php echo date_i18n( $atts['date_format'], $event_date_start ) ?>
	</div>
</div>