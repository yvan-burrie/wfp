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
$wrap_class[] = 'layers-slider-block';

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

$slides = array();
for ($i=0; $i < 6 ; $i++) {
    if ( isset( $atts["slide{$i}__image"] ) && isset( $atts["slide{$i}__bg"] ) ) {
        if ( ! empty( $atts["slide{$i}__image"] ) && ! empty( $atts["slide{$i}__bg"] ) ) {
            $slides[$i]['image'] = $atts["slide{$i}__image"];
            $slides[$i]['bg'] = $atts["slide{$i}__bg"];
            $slides[$i]['subtitle'] = $atts["slide{$i}__subtitle"];
            $slides[$i]['title'] = $atts["slide{$i}__title"];
            $slides[$i]['subtitle'] = $atts["slide{$i}__subtitle"];
            if ( isset( $atts["slide{$i}__ca"] ) ) {
                $slides[$i]['ca'] = $atts["slide{$i}__ca"];
            } else {
                $slides[$i]['ca'] = '';
            }
            if ( isset( $atts["slide{$i}__link"] ) ) {
                $slides[$i]['link'] = $atts["slide{$i}__link"];
            } else {
                $slides[$i]['link'] = '';
            }
            if ( isset( $atts["slide{$i}__audio_id"] ) ) {
                $slides[$i]['audio_id'] = $atts["slide{$i}__audio_id"];
            } else {
                $slides[$i]['audio_id'] = '';
            }
        }
    }
}

?>
<?php if ( $slides ) : ?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
    <ul class="layers-slider trans-20" data-delay="<?php echo esc_attr( $atts['pause_time'] ) ?>">
        <?php foreach ($slides as $key => $slide) : ?>

            <li class="<?php if ( $key === 1 ) { echo 'on'; } ?>">
                <div class="back-layer" <?php if ( $atts['parallax'] ) : ?> data-parallax='{"y": -20}' <?php endif ?> >
                    <?php echo meloo_get_image( false, 'mixone-content-thumb', 'trans-25', false, $slide['bg'], $srcset=false); ?>
                    <div class="desc-layer" data-parallax='{"y": -10}'>
                        <h3 class="title text-fx delay-08 on"><?php rascals_core_e_esc( $slide['title'] ); ?></h3>
                        <h6 class="sub-title text-fx-word delay-10 on"><?php rascals_core_e_esc( $slide['subtitle'] ) ?></h6>
                    </div>
                </div>
                <div class="front-layer" <?php if ( $atts['parallax'] ) : ?> data-parallax='{"y": -40}' <?php endif ?>>
                    <?php 
                       $icon = '';
                     ?>
                    <?php 

                    // Link
                    if ( $slide['ca'] !== '' && $slide['ca'] === 'link' ) : ?>
                        <?php $icon = 'pe-7s-expand1'; ?>
                        <a href="<?php echo esc_url( $slide['link'] ) ?>" class="thumb overlay-dark module-thumb-block fx-trigger">
                    
                    <?php 

                    // Audio
                    elseif ( $slide['ca'] !== '' && $slide['ca'] === 'audio_id' && $slide['audio_id'] !== 'none' ) : ?>
                        <?php
                        $t_id = 'ls-player-' . esc_attr( $slide['audio_id'] );
                        $icon = 'pe-7s-play';
                        if ( function_exists( 'sp_hidden_tracklist' ) ) {
                            echo sp_hidden_tracklist( array(
                                 'id'           => $slide['audio_id'],
                                 'ids'          => '',
                                 'tracklist_id' => esc_attr( $t_id ),
                                 'ctrl'         => '',
                                 'vis'          => 'none'
                            ) );
                        }
                        ?>
                        <a href="#" data-id="<?php echo esc_attr( $t_id )?>" class="sp-play-list thumb overlay-dark module-thumb-block fx-trigger">
                    <?php else : ?>
                        <a class="thumb overlay-dark module-thumb-block fx-trigger">
                    <?php endif ?>

                        <?php echo meloo_get_image( false, 'meloo-large-square-thumb', 'trans-25 delay-02', false, $slide['image'], $srcset=false); ?>
                        <?php if ( ! empty( $icon ) ) : ?>
                            <span class="thumb-icon trans-40">
                                <svg class="circle-svg" width="60" height="60" viewBox="0 0 50 50">
                                    <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                                </svg>
                                <span class="<?php echo esc_attr( $icon ) ?>"></span>
                            </span>
                        <?php endif ?>
                    </a>
                </div>

            </li>

        <?php endforeach; ?>

    </ul>
</div>
<?php endif; ?>

<?php 
    kc_js_callback( 'theme.text_anim' );
    kc_js_callback( 'kc_addons.layers_slider' );
?>