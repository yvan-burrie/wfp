<?php
/**
 *
 * Shortcodes
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

add_filter( 'widget_text', 'do_shortcode' );