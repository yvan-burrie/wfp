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


// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

// Variables 
$output = '';
$wrap_class[] = 'kc-text-slider';
if ( $atts['align'] === 'vcenter' ) {
    $atts['align'] = 'oncenter vcenter';
}
$wrap_class[] =  $atts['align'];
$slides = array();
for ($i=0; $i < 6 ; $i++) {
    if ( isset( $atts["slide{$i}__title"] ) && isset( $atts["slide{$i}__text"] ) ) {
        if ( ! empty( $atts["slide{$i}__title"] ) && ! empty( $atts["slide{$i}__text"] ) ) {
            $slides[$i]['title'] = $atts["slide{$i}__title"];
            $slides[$i]['text'] = $atts["slide{$i}__text"];
        }
    }
}
?>
<?php if ( $slides ) : ?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>" data-delay="<?php echo esc_attr( $atts['pause_time'] ) ?>">
    <?php foreach ($slides as $key => $slide) : ?>
        <div class="text-slide <?php if ( $key === 1 ) { echo 'visible'; } ?>">
            <h2 class="text-fx"><?php rascals_core_e_esc( $slide['title'] ) ?></h2>
            <h6 class="text-fx-word"><?php rascals_core_e_esc( $slide['text'] ) ?></h6>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php 
    kc_js_callback( 'theme.text_anim' );
    kc_js_callback( 'kc_addons.text_slider' );
?>