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

// Variables 
$output = '';
$wrap_class[] = 'slider-block';
$wrap_class[] = 'testi-slider-block';
$wrap_class[] = 'slider-nav-simple';

$slides = array();
for ($i=0; $i < 6 ; $i++) {
    if ( isset( $atts["slide{$i}__image"] ) && ! empty( $atts["slide{$i}__image"] ) ) {
     
        $slides[$i]['image'] = $atts["slide{$i}__image"];
        $slides[$i]['name'] = $atts["slide{$i}__name"];
        $slides[$i]['text'] = $atts["slide{$i}__text"];
        
    }
}

?>
<?php if ( $slides ) : ?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
    <ul class="testi-slider trans-20" data-delay="<?php echo esc_attr( $atts['pause_time'] ) ?>">
        <?php foreach ($slides as $key => $slide) : ?>

            <li class="<?php if ( $key === 1 ) { echo 'on'; } ?>">
                <div class="back-layer" <?php if ( $atts['parallax'] ) : ?> data-parallax='{"y": -30}' <?php endif ?> >
                    <?php echo meloo_get_image( false, 'full', 'trans-25', false, $slide['image'], $srcset=false); ?>
                </div>
                <div class="front-layer" <?php if ( $atts['parallax'] ) : ?> data-parallax='{"y": -20}' <?php endif ?>>
                    <div class="text">
                        <p><?php rascals_core_e_esc( $slide['text'] ) ?><span class="name"><?php rascals_core_e_esc( $slide['name'] ); ?></span></p>
                    </div>
                </div>
            </li>

        <?php endforeach; ?>

    </ul>
</div>
<?php endif; ?>

<?php 
    kc_js_callback( 'kc_addons.testi_slider' );
?>