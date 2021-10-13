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

// Get date format  
$date_format = get_option( 'date_format' );

// Kingcomposer wrapper class for each element 
$wrap_class = apply_filters( 'kc-el-class', $atts );

// Add custom classes to element 
$wrap_class[] = 'kc-posts-block';
$wrap_class[] = $atts['module_size'];
$block = $atts['block'];

// Add grid classes depends on block 
$grid_classes = '';
if ( $atts['block'] === 'block4'
    || $atts['block'] === 'block5'
    || $atts['block'] === 'block6'
    || $atts['block'] === 'block7' ) {

    switch ( $atts['articles_number'] ) {
        case '1':
            $grid_classes = 'flex-1 flex-tablet-1 flex-mobile-1 flex-mobile-portrait-1';
            break;
        case '2':
            $grid_classes = 'flex-2 flex-tablet-2 flex-mobile-2 flex-mobile-portrait-1';
            break;
        case '3':
            $grid_classes = 'flex-3 flex-tablet-3 flex-mobile-2 flex-mobile-portrait-1';
            break;
         case '4':
            $grid_classes = 'flex-4 flex-tablet-4 flex-mobile-2 flex-mobile-portrait-1';
            break;
        case '5':
            $grid_classes = 'flex-5 flex-tablet-4 flex-mobile-2 flex-mobile-portrait-1';
            break;   
    }
}

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}
if ( isset( $atts['module_classes'] ) ) {
    $atts['module_classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
    <div class="kc-posts-block-inner">
        <?php

        // Variables 
        $showposts = 3;
        $thumb_size = $atts['thumb_size'];
        $excerpt = $atts['excerpt'];

        // Filter 
        $filter_atts = array(
            'post_ids'       => $atts['post_ids'],
            'category_ids'   => $atts['category_ids'],
            'category_slugs' => $atts['category_slugs'],
            'tag_slugs'      => $atts['tag_slugs'],
            'sort_order'     => $atts['sort_order'],
            'limit'          => (int)$atts['limit'],
            'autors_ids'     => $atts['author_ids'],
            'offset'         => $atts['offset']
        );

        // Filter
        $filter_args = array(
            'filter_atts' => $filter_atts, 
            'ajax_filter' => false,
            'show_filters' => ''
        );
        $filter_args = array(
            'filter_atts'       => $filter_atts, 
            'ajax_filter'       => false,
            'show_filters'      => '',
            'filter_sel_method' => ''
        );
                
        // Filter Queries  
        $filters_query = meloo_prepare_posts_filter( $filter_args );
        $query_args = meloo_prepare_wp_query( $filters_query, 0 );

        // Begin Loop  
        $posts_block_q = new WP_Query( $query_args );
        
        ob_start();
        if ( $posts_block_q->have_posts() ) : ?>

            <?php

                // Load Block 
                require( "posts-block/{$block}.php" );
            ?>
        
        <?php else : ?>
        <div class="warning"><?php esc_html_e( 'Warning: There are no posts to display this module.', 'meloo-toolkit' ); ?></div>
        <?php endif; ?>
    </div>
</div>

<?php
    wp_reset_postdata();

    $output = ob_get_clean();

    rascals_core_e_esc( $output ); 
?>