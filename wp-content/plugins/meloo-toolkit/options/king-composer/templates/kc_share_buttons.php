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
$wrap_class[] = 'kc-share-buttons';

$queried_object = get_queried_object();

$post_id = null;
if ( $queried_object ) {
    $post_id = $queried_object->ID;
}

?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
	<div class="kc-share-buttons-inner">
		<?php echo meloo_toolkit_get_share_buttons( $post_id, $classes = 'micro-btn micro-share' ); ?>
	</div>
</div>