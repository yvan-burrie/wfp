<?php
/**
 *
 * Contains the main King Composer functions
 *
 *
 * @package         MelooToolkit
 * @author          Rascals Themes
 * @copyright       Rascals Themes
 * @version       	1.0.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// REMOVE KC IMAGE FILTER
remove_filter ('wp_get_attachment_image_src', 'kc_get_attachment_image_src', 999, 4);


////////////////////
// ADD JS SUPPORT //
////////////////////

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_posts_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_posts_slider_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_artists_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_music_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_events_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_gallery_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_gallery_images_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}

/**
 * Add Carousel support
 * @param  array  $atts
 * @return array
 */
function kc_videos_carousel_filter( $atts = array() ){

    $atts = kc_remove_empty_code( $atts );
    extract( $atts );

    wp_enqueue_script( 'owl-carousel' );
    wp_enqueue_style( 'owl-theme' );
    wp_enqueue_style( 'owl-carousel' );

    return $atts;
}


/**
 * KC Filters / add supports for embeded scripts
 * @param  $filters
 * @return void
 */
function meloo_toolkit_add_scripts_support( $filters ) {
    $filters[] = 'posts_carousel';
    $filters[] = 'posts_slider';
    $filters[] = 'artists_carousel';
    $filters[] = 'music_carousel';
    $filters[] = 'events_carousel';
    $filters[] = 'gallery_carousel';
    $filters[] = 'gallery_images_carousel';
    $filters[] = 'videos_carousel';
    return $filters;
}

// Change KC Filters
add_filter( 'kc-core-shortcode-filters', 'meloo_toolkit_add_scripts_support', 10 );


/**
 * Get Share buttons
 * @param integer $post_id
 * @param string $classes
 * @return string
 */
function meloo_toolkit_get_share_buttons( $post_id = 0, $classes = 'share-button' ){
   return '
    <a class="' . esc_attr( $classes ) . ' fb-share-btn" target="_blank" href="http://www.facebook.com/sharer.php?u=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-facebook"></span></a>
    <a class="' . esc_attr( $classes ) . ' twitter-share-btn" target="_blank" href="http://twitter.com/share?url=' . esc_url( get_permalink( $post_id ) ) . '"><span class="icon icon-twitter"></span></a>
';
}


/**
 * Get buttons based on text separated by enter (new line)
 * @param  string $content   
 * @param  string $separator 
 * @param  string $classes  
 * @return string
 */
function meloo_toolkit_get_buttons( $content = '', $separator = ', ', $classes = '' ){

    if ( $content === '' ) {
        return;
    }

    $buttons = preg_replace( '/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n", $content ) ) );
    $buttons = explode( "\n", $buttons );
    $buttons_a = array();
    $html = '';

    if ( is_array( $buttons ) ) {
        foreach ( $buttons as $button ) {
            $button = explode( "|", $button );
            if ( is_array( $button ) ) {
                /* Icon */
                if ( isset( $button[3] ) ) {
                    $icon = '<span class="icon icon-' . esc_attr( $button[3] ) . '"></span>';
                    $classes .= ' has-icon';
                } else {
                    $icon = '';
                }
                $buttons_a[] = '<a href="' . esc_url( $button[1] ) . '" class="' . esc_attr( $classes ) . '" target="' . esc_attr($button[2]) . '">' . $icon .'<i>' . $button[0] . '</i></a>';
            }
        }
    }
    if ( ! empty( $buttons_a ) ) {
        $html = implode( $separator, $buttons_a );
    }

    return $html;
}