<?php
/**
 * This function loads both the parent styles and child theme styles for the front-end site
 */
function meloo_parent_theme_enqueue_styles() {
    // This loads the parent styles
    wp_enqueue_style( 'parent-styles', get_template_directory_uri() . '/style.css' );
    // this loads your child theme styles.
    // The array() makes the parent themes a "dependency" of the child styles
    // Dependencies get loaded *first*, so your child theme styles will override parent theme styles
    // (^^^^^^^^ as long as your CSS selectors have the same or higher specificity!)
    wp_enqueue_style( 'child-styles',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-styles' )
    );
}
add_action( 'wp_enqueue_scripts', 'meloo_parent_theme_enqueue_styles' );