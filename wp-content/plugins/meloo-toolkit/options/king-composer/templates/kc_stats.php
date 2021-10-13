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
$wrap_class[] = 'kc-stats';

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

if ( $atts['stats'] !== '' ) :

	$stats = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $atts['stats'] ) ) );
	$stats = explode( "\n", $stats );

	$timer = $atts['timer']*1000;
	?>
	<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
		
		<?php 
		if ( is_array( $stats) && count( $stats ) >= 6 ) {
            echo '<ul class="stats kc-stats-inner" data-timer="' . esc_attr( $timer ) . '" data-parallax=\'{"y":' . esc_attr( $atts['parallax_y'] ) . '}\'>';
            foreach ( $stats as $stat ) {
                echo '<li>'; 
                $stat_a = explode( '=', $stat );
                if ( is_array( $stat_a) ) {
                    echo '<span class="stat-value">' . esc_html( $stat_a[1] ) . '</span><span class="stat-name">' . esc_html( $stat_a[0] ) . '</span>';
                }

                echo '</li>';
            }
            echo '</ul>';
        }

		?>
		
	</div>
<?php endif; ?>