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

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

// Kingcomposer wrapper class for each element 
$wrap_class = apply_filters( 'kc-el-class', $atts );
$text = $atts['title'];
$post_title = $atts['post_title'];
$style = 'h-style-1';
switch ($atts['style']) {
	case 'style1':
		$style = 'h-style-1';
		break;
	case 'style2':
		$style = 'h-style-2';
		break;
	case 'style3':
		$style = 'h-style-4';
		break;
	case 'style4':
		$style = 'h-style-5';
		break;
	
}

// Add custom classes to element 
$wrap_class[] = 'kc-fancy-title';

if ( $post_title === 'yes' ){
	
	$text_title = get_the_title();
	
	if( $text_title !== '' ) {
		$text = $text_title;
	}
	
}

?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?>">
	<div class="kc-inner-wrap <?php echo esc_attr( $atts['classes'] ); ?>">
		<div class="kc-fancy-title-block on-<?php echo esc_attr( $atts[ 'align' ] ) ?>">
	   		<<?php echo esc_attr( $atts['size'] ); ?> class="kc-h-style <?php echo esc_attr( $style ) ?>"><?php echo esc_html( $text ) ?> </<?php echo esc_attr( $atts['size'] ); ?>>
	   		<?php if( $atts['style'] === 'style4' && $atts['back_layer_title'] !== '' ) : ?>
				<h6 class="h-style-5-back" data-parallax='{"y": <?php echo esc_attr( $atts['back_layer_parallax'] ) ?>}'><?php rascals_core_e_esc( $atts['back_layer_title'] ); ?></h6>
	   		<?php endif ?>
		</div>
	</div>
</div>