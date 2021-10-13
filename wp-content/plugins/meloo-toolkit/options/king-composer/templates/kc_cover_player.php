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
$wrap_class[] = 'kc-cover-player';
$wrap_class[] = 'on-'.$atts['align'];

if ( $atts['type'] && ! empty( $atts['unique_id'] ) ) {
    $t_id = $atts['unique_id'];
} else {
    $t_id = 'cover-player-' . esc_attr( $atts['id'] );
}

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
    <div class="cover-holder" data-parallax='{"y": <?php echo esc_attr( $atts['parallax'] ) ?>}'>
        <a href="#" data-id="<?php echo esc_attr( $t_id )?>" class="thumb thumb-fade sp-play-list">
            <?php
            echo meloo_get_image( false, $atts['thumb_size'], 'cover-thumb', true, $atts['cover']);
            ?>
            <span class="thumb-icon trans-40">
                <svg class="circle-svg" width="60" height="60" viewBox="0 0 50 50">
                    <circle class="circle" cx="25" cy="25" r="23" stroke="#fff" stroke-width="1" fill="none"></circle>
                </svg>
                <span class="pe-7s-play"></span>
            </span>
        </a>
        <?php
        if ( $atts['id'] !== 'none' && function_exists( 'sp_hidden_tracklist' ) ) {
            
            echo sp_hidden_tracklist( array(
                 'id'           => $atts['id'],
                 'ids'          => $atts['ids'],
                 'tracklist_id' => esc_attr( $t_id ),
                 'ctrl'         => '',
                 'vis'          => 'none'
            ) );
        }
        ?>
    </div>
</div>