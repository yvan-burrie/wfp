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
$wrap_class[] = 'kc-event-countdown-block';
$wrap_class[] = $atts['size'];

$post_id = null;
if ( $atts['is_custom_id'] === 'yes' ) {
	$post_id = (int)$atts['custom_id'];
} else {

	$tax = array(
        array(
           'taxonomy' => 'meloo_event_type',
           'field' => 'slug',
           'terms' => 'future-events'
          )
    );

	$args = array(
        'post_type'        => 'meloo_events',
        'showposts'        => 1,
        'tax_query'        => $tax,
        'orderby'          => 'meta_value',
        'meta_key'         => '_event_date_start',
        'order'            => 'ASC',
        'suppress_filters' => 0 // WPML FIX
    );
    $events = get_posts( $args );
    $events_count = count( $events );

    if ( $events_count !== 0 ) {
        $post_id = $events[0]->ID;
    }
}

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

// Display Only future event 
if ( isset( $post_id ) && has_term( 'future-events', 'meloo_event_type', $post_id ) ) :

	$event_date = get_post_meta( $post_id, '_event_date_start', true );
	$event_time = get_post_meta( $post_id, '_event_time_start', true );
	$city       = get_post_meta( $post_id, '_city', true );
	$place      = get_post_meta( $post_id, '_place', true );
	$event_date = strtotime( $event_date );
	$event_time = strtotime( $event_time );
		
	?>
	<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">

		<div class="kc-event-countdown-inner" data-parallax='{"y": <?php echo esc_attr( $atts['parallax_y'] ) ?>}'>
			<div class="kc-event-countdown-header">
				<h4><?php echo get_the_title( $post_id ); ?></h4>
				<div><span><?php rascals_core_e_esc( $place ); ?></span><span><?php rascals_core_e_esc( $city ); ?></span></div>
			</div>
			

	   		<div class="kc-countdown kc-event-countdown" data-event-date="<?php echo date_i18n( 'Y/m/d', $event_date ) . ' ' . date_i18n( 'H:i', $event_time );?>:00">
	   			<div class="unit-block"><span><?php esc_html_e( 'Days', 'meloo-toolkit' ) ?></span><div class="days unit">000</div></div>
				<div class="unit-block"><span><?php esc_html_e( 'Hours', 'meloo-toolkit' ) ?></span><div class="hours unit" >000</div></div>
				<div class="unit-block"><span><?php esc_html_e( 'Minutes', 'meloo-toolkit' ) ?></span><div class="minutes unit">00</div></div>
				<div class="unit-block"><span><?php esc_html_e( 'Seconds', 'meloo-toolkit' ) ?></span><div class="seconds unit">00</div></div>

	   		</div>
		</div>
	</div>
	
 <?php else : ?>
<div class="empty-module"><?php esc_html_e( 'Currently, we have no future events.', 'meloo-toolkit' ); ?></div>
<?php endif; ?>
<?php kc_js_callback( 'kc_addons.countdown' ); ?>
