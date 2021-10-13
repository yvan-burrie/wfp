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
$wrap_class[] = 'kc-event-details';

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

$queried_object = get_queried_object();

$post_id = null;
if ( $queried_object ) {
    $post_id = $queried_object->ID;
}


if ( isset( $post_id ) ) {
	 // Event Date 
    $event_date_start = get_post_meta( $post_id, '_event_date_start', true );
    $event_time_start = get_post_meta( $post_id, '_event_time_start', true );

    $city = get_post_meta( $post_id, '_city', true );
    $place = get_post_meta( $post_id, '_place', true );
    $address = get_post_meta( $post_id, '_address', true );

} else {
	$event_date_start = '2030-01-01';
	$event_time_start = '21:00';
	$city = esc_html__( 'City name', 'meloo-toolkit' );
    $place = esc_html__( 'Place', 'meloo-toolkit' );
}
	
$event_date_start = strtotime( $event_date_start );

?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
	<h3 class="kc-event-details-inner">
		<?php echo date_i18n( $atts['date_format'], $event_date_start ) ?>	<?php esc_html_e( 'in', 'meloo-toolkit' ); ?> <?php echo esc_html( $place ) ?>, <?php echo esc_html( $city ) ?><br>
		<?php esc_html_e( 'Start', 'meloo-toolkit' ); ?>: <?php echo esc_html( $event_time_start ) ?>
	</h3>
</div>