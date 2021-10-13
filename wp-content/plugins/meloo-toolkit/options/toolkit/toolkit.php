<?php
/**
 *
 * Contains toolkit functions
 *
 *
 * @package         Meloo Toolkit
 * @author          Rascals Themes
 * @copyright       Rascals Themes
 * @version       	1.0.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==================================================
   Enqueue Toolkit Frontend scripts and styles
================================================== */ 
if ( ! function_exists( 'meloo_toolkit_enqueue' ) ) :
function meloo_toolkit_enqueue() {

  // JS
	if ( meloo_toolkit_get_option( 'combine_js', 'off' ) === 'off' ) {
		wp_enqueue_script( 'frontend-toolkit-addons' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/js/frontend-toolkit-addons.min.js' , false, false, true );
        wp_enqueue_script( 'magnific-popup', esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/vendors/magnific-popup/jquery.magnific-popup.min.js' , false, false, true );
        wp_enqueue_script( 'smooth-scrollbar' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/vendors/smooth-scrollbar.min.js' , false, false, true );
        wp_enqueue_script( 'countdown' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/vendors/jquery.countdown.min.js' , false, false, true );
        wp_enqueue_script( 'bxslider' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/vendors/jquery.bxslider.min.js' , false, false, true );
        wp_enqueue_script( 'owl-carousel' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/vendors/owl.carousel.min.js' , false, false, true );
        wp_enqueue_script( 'frontend-toolkit' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/js/frontend-toolkit.js' , false, false, true );
    } else {
        wp_enqueue_script( 'kc-addons-plugins' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/js/frontend-toolkit-pack.min.js' , false, false, true );
        wp_enqueue_script( 'kc-addons' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/js/frontend-toolkit.min.js' , false, false, true );
    }

    // CSS
    wp_enqueue_style( 'magnific-popup' ,  esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/vendors/magnific-popup/magnific-popup.css' );
    wp_enqueue_style( 'frontend-toolkit' ,  esc_url( RASCALS_TOOLKIT_URL ) . '/options/toolkit/css/frontend-toolkit.css' );

}
add_action( 'wp_enqueue_scripts', 'meloo_toolkit_enqueue' );
endif;


/* ==================================================
  DISQUS
================================================== */
if ( ! function_exists( 'meloo_toolkit_disqus' ) ) :

function meloo_toolkit_disqus($post_id) {
   	
   	$shortname = meloo_toolkit_get_option( 'disqus_shortname', false );

   	if ( $shortname !== false ) {

   		return '
   		<section id="comments" class="comments-section">
    		<div class="comments-container clearfix">
				<h3 id="reply-title"><strong>' . esc_html__( 'Leave a Reply', 'meloo-toolkit') . '</h3>
				<div id="disqus_title" class="hidden">' . esc_html( get_the_title( $post_id ) ) . '</div>
				<div id="disqus_thread" data-post_id="' . esc_attr(  $post_id ) . '" data-disqus_shortname="' . esc_attr( $shortname ) . '"></div>
    		</div>
		</section>';
   	}

}
endif;



/* ==================================================
  Image Resize
================================================== */
if ( ! function_exists( 'meloo_toolkit_image_resize' ) ) :

/**
 * Image resize function
 * @param string $image_url
 * @param integer $width
 * @param integer $height
 * @param string $crop
 * @return string
 */
function meloo_toolkit_image_resize( $image_url, $width, $height, $crop = 'c' ) {
   	
   	return rascals_core_resize( $image_url, $width, $height, true, $crop, true );

}
endif;


/* ==================================================
  Get theme panel option
================================================== */
if ( ! function_exists( 'meloo_toolkit_get_option' ) ) :

/**
 * Show share buttons
 * @param string $option <option name>
 * @param string $default <default option>
 * @return mixed
 */
function meloo_toolkit_get_option( $option, $default = null ) {
   	
   	return rascals_core_get_option( $option, $default );

}
endif;


/* ==================================================
   Get language Switcher
================================================== */ 

if ( ! function_exists( 'meloo_toolkit_wpml_switcher' ) ) :

/**
 * Show WPML Language Switcher
 * @param  $post_id [Post ID]
 * @param  $custom_ids
 * @return array
 */

function meloo_toolkit_wpml_switcher( ){
    if ( function_exists( 'icl_get_languages' ) ) {

        $languages = icl_get_languages( 'skip_missing=0&orderby=code' );
        if ( ! empty( $languages ) ) {
           
         	echo '<div class="wpml-switcher"><ul class="wpml-switcher__list">';
            foreach($languages as $l){
                
            
                    if ( ! $l[ 'active' ] ) {
                    	echo '<li>';
                        echo '<a class="ajax-off" href="'. esc_url( $l['url'] ) . '">';
                    } else {
                    	echo '<li class="wpml-switcher__active">';
                    }
                    echo '<span>' . esc_attr( $l['language_code'] ) . '</span>';

                    if ( ! $l['active'] ) {
                        echo '</a>';
                    }
                    echo '</li>';
            }
            echo '</ul></div>';
        }
    }
}
endif;


/* ==================================================
   Check is page built by elementor
================================================== */ 

if ( ! function_exists( 'meloo_toolkit_page_has_el_widget' ) ) :

function meloo_toolkit_page_has_el_widget( $id=null, $widget = false ){
    // We check if the Elementor plugin has been installed / activated.
  	if (defined('ELEMENTOR_PATH') && 
  		class_exists('Elementor\Widget_Base') && 
  		$id !== null &&
  		$widget !== false
  	){
  		if ( \Elementor\Plugin::$instance->db->is_built_with_elementor($id) ) {

  			$data = get_post_meta( $id, '_elementor_data', true ); 
  			if ( $data ) {

  				$array= json_decode($data,true);
  				
				//return searcharray('meloo_share_buttons', 'widgetType', $array);
				if ( isset($array) && meloo_toolkit_array_find_deep($array, $widget) ) {
					return true;
				}
  			}

  		}
    }

    return false;
}
endif;


/* ==================================================
   Find value in multidimensional array
================================================== */ 
function meloo_toolkit_array_find_deep($array, $search, $keys = array())
{
    foreach($array as $key => $value) {
        if (is_array($value)) {
            $sub = meloo_toolkit_array_find_deep($value, $search, array_merge($keys, array($key)));
            if (count($sub)) {
                return $sub;
            }
        } elseif ($value === $search) {
            return array_merge($keys, array($key));
        }
    }

    return array();
}