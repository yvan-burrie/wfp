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
$wrap_class[] = 'kc-artists-block';
$block = $atts['block'];
$ajax_filter = $atts['ajax_filter'];

if ( function_exists( 'meloo_get_paged' ) ) {
    $paged = meloo_get_paged();
}
if ( get_query_var( 'paged' ) ) { 
    $paged = get_query_var( 'paged' ); 
} elseif ( get_query_var( 'page' ) ) { 
    $paged = get_query_var( 'page' ); 
} else { 
    $paged = 1; 
}

// Add grid classes depends on block 
$grid_classes = '';
if ( $atts['block'] === 'block1' ) {

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
    <div class="kc-artists-block-inner">
        <?php

        // Variables 
        $showposts = 3;
        $date_format = get_option( 'date_format' );

        // Filter 
        $filter_atts = array(
            'post_ids'        => $atts['post_ids'],
            'sort_order'      => $atts['sort_order'],
            'limit'           => (int)$atts['limit'],
            'offset'          => $atts['offset'],
            // Filters  
            'filters_order'   => $atts['filters_order'],
            // 1  
            'category_label'  => $atts['category_label'],
            'category_ids'    => $atts['category_ids'],
            'category_slugs'  => $atts['category_slugs'],
            // 2  
            'category_label2' => $atts['category_label2'],
            'category_ids2'   => $atts['category_ids2'],
            'category_slugs2' => $atts['category_slugs2'],
            // 3  
            'category_label3' => $atts['category_label3'],
            'category_ids3'   => $atts['category_ids3'],
            'category_slugs3' => $atts['category_slugs3'],
            // 4  
            'category_label4' => $atts['category_label4'],
            'category_ids4'   => $atts['category_ids4'],
            'category_slugs4' => $atts['category_slugs4'],
        );
        $filter_args = array(
            'filter_atts'       => $filter_atts, 
            'ajax_filter'       => $atts['ajax_filter'],
            'show_filters'      => $atts['show_filters'],
            'filter_sel_method' => $atts['filter_sel_method']
        );
    
        // Filter Queries  
        $filters_query = meloo_prepare_artists_filter( $filter_args );
        $query_args = meloo_prepare_wp_query( $filters_query, 0 );

        // Begin Loop  
        $posts_block_q = new WP_Query( $query_args );

        $ajax_opts = array(
            'action' => 'meloo_load_more'
        ); ?>

        <div class="ajax-grid-block <?php echo esc_attr( $atts['classes'] ); ?>" data-loading='false' data-paged='2' data-opts='<?php echo json_encode( $ajax_opts ); ?>' data-filter='<?php  echo json_encode( $filters_query );?>'>

            <?php ob_start(); ?>

            <?php 
                /* Filters
                 -------------------------------- */
                if ( function_exists( 'meloo_get_filters' ) ) {
                    echo meloo_get_filters($filters_query);
                }
            ?>

            <?php
            // Show pagination? 
            if ( $paged === intval( $posts_block_q->max_num_pages ) ) {
                $ajax_paged_visible = false;
            } else {
                $ajax_paged_visible = true;
            }

            if ( $posts_block_q->have_posts() ) : ?>

                <?php

                    // Load Block 
                    require( "artists-block/{$block}.php" );
                ?>
                <div class="clear"></div>
                <?php 

                /* Pagination  
                 -------------------------------- */

                // Ajax 
                if ( $atts['pagination'] === 'load_more' || $atts['pagination'] === 'infinite' ) {
                    if ( $ajax_paged_visible ) {
                        if ( function_exists( 'meloo_content_loader' ) && $atts['pagination'] === 'infinite'  ) {
                            echo meloo_content_loader();
                        }
                        $pagination_class = $atts['pagination'] === 'infinite' ? 'infinite-load' : 'btn load-more';
                        echo "<a class='" . esc_attr( $pagination_class ) . "'>";
                        if ( $atts['pagination'] === 'load_more' ) {
                           esc_html_e( 'Load More', 'meloo-toolkit' );
                        }
                        echo "</a>";
                    }
                }
                
                ?>
            
            <?php else : ?>
            <div class="warning"><?php esc_html_e( 'Warning: There are no items to display this module.', 'meloo-toolkit' ); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php 
    kc_js_callback( 'theme.social_players.vimeo' ); 
    kc_js_callback( 'theme.social_players.youtube' ); 
?>
<?php
    
    wp_reset_postdata();

    $output = ob_get_clean();

    rascals_core_e_esc( $output );
?>