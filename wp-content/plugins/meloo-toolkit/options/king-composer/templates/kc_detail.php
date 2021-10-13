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
$wrap_class[] = 'kc-detail';

$queried_object = get_queried_object();

$post_id = null;
if ( $queried_object ) {
    $post_id = $queried_object->ID;
}

?>
<li class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?>">
    <span class="label"><?php echo esc_html( $atts['label'] ); ?></span>
	<div class="value">
		<?php if ( $atts['type'] === 'text' ) :  ?>
			<?php rascals_core_e_esc( $atts['text'] ) ?>
		<?php elseif ( $atts['type'] === 'links' && ! empty( $atts['links'] ) ) : ?>
			<?php echo meloo_toolkit_get_buttons( $atts['links'], $separator = ' ', $classes = '' ) ?>
		<?php elseif ( $atts['type'] === 'buttons' && ! empty( $atts['buttons'] ) ) : ?>
			<?php echo meloo_toolkit_get_buttons( $atts['buttons'], $separator = ' ', $classes = 'micro-btn' ) ?>
		<?php elseif ( $atts['type'] === 'share_buttons' ) : ?>
			<?php echo meloo_toolkit_get_share_buttons( $post_id, $classes = 'micro-btn micro-share' ); ?>
		<?php endif; ?>
	</div>
</li>