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
$wrp_el_classes = apply_filters( 'kc-el-class', $atts );

// Variables 
$excerpt = $atts['excerpt'];
$output = '';
$date_format = get_option( 'date_format' );
$limit = (int)$atts['limit'];
if ( $limit === 0 ) {
    $limit = 3;
}

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}
if ( isset( $atts['module_classes'] ) ) {
    $atts['module_classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

// Filter

$filter_atts = array(
    'post_ids'       => $atts['post_ids'],
    'category_ids'   => $atts['category_ids'],
    'category_slugs' => $atts['category_slugs'],
    'tag_slugs'      => $atts['tag_slugs'],
    'sort_order'     => $atts['sort_order'],
    'limit'          => $limit,
    'autors_ids'     => $atts['author_ids'],
    'offset'         => $atts['offset']
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
$the_query = new WP_Query( $query_args );
$element_attribute = array();
$el_classess = array(
    'kc-owl-post-carousel',
    'kc-posts-slider',
    'owl-carousel',
    'list-post',
);
$owl_option = array(
    'items'         => '1',
    'mobile'        => '1',
    'tablet'        => '1',
    'speed'         => intval( $atts['speed'] ),
    'navigation'    => '',
    'pagination'    => $atts['pagination'],
    'autoheight'    => '',
    'autoplay'      => $atts['auto_play']
);

$owl_option = strtolower( json_encode( $owl_option ) );

$element_attribute[] = 'class="'. esc_attr( implode(' ', $el_classess) ) .' ' . esc_attr( $atts['classes'] ) . '"';
$element_attribute[] = "data-owl-options='$owl_option'";

ob_start();

if ( $the_query->have_posts() ) :

    echo '<div '. implode(' ', $element_attribute) .'>';

    while ( $the_query->have_posts() ) :

        $the_query->the_post();
        ?>
        <div class="item list-item post-<?php echo esc_attr( $the_query->ID ); ?>">

            <div class="post-slide">
                <?php 
               
                // Excerpt 
                if ( ! empty( $excerpt ) ) {
                    if ( has_excerpt() ) {
                        $excerpt = wp_trim_words( get_the_excerpt(), 30, ' ...' );
                    } else {
                        $excerpt = wp_trim_words( strip_shortcodes( get_the_content() ), 30, ' ...' ); 
                    }
                }

                $tax_args = array(
                    'id' => $the_query->ID,
                    'tax_name' => 'category',
                    'separator' => '',
                    'link' => false,
                    'limit' => 2,
                    'show_count' => true
                );
                $cats_html = meloo_get_taxonomies( $tax_args );

                $module_args = array(
                    'post_id' => $the_query->post->ID,
                    'thumb_size' => 'full',
                    'lazy' => true,
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'author' => esc_html( get_the_author_meta( 'display_name', $the_query->post->post_author ) ),
                    'date' => get_the_time( $date_format ),
                    'posts_cats' => $cats_html,
                    'posts_classes' => implode( ' ', get_post_class( '', $the_query->post->ID ) ),
                    'classes' => $atts['module_classes'],
                    'excerpt' => $excerpt
                );
                echo meloo_module5( $module_args );

                ?>
            </div>
            

        </div>
    <?php endwhile; ?>

    </div>

<?php else : ?>

    <?php esc_html_e( 'Carousel Post: No posts found', 'meloo-toolkit' ); ?>

<?php endif; ?>

<?php 
    wp_reset_postdata();

    $output = ob_get_clean();

    echo '<div class="kc-carousel-post '. esc_attr( implode(' ', $wrp_el_classes) ) .'">'. $output .'</div>';

    kc_js_callback( 'kc_front.owl_slider' );
?>