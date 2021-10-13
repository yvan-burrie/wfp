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


// Variables 
$i = 0;

if ( empty( $thumb_size ) ) {
    $thumb_size = 'meloo-large-square-thumb';
}

?>
<div class="flex-grid <?php echo esc_attr( $grid_classes ) ?> flex-gap-medium kc-flex-no-gap kc-pb5"> 
<?php while ( $posts_block_q->have_posts() ) : ?>
<?php
    $posts_block_q->the_post();
    $count = $posts_block_q->post_count; 

     $tax_args = array(
        'id'         => $posts_block_q->ID,
        'tax_name'   => 'category',
        'separator'  => ' ',
        'link'       => false,
        'limit'      => 2,
        'show_count' => true
    );
    $cats_html = meloo_get_taxonomies( $tax_args );

    // Excerpt 
    if ( ! empty( $excerpt ) ) {
        if ( has_excerpt() ) {
            $excerpt = wp_trim_words( get_the_excerpt(), 30, ' ...' );
        } else {
            $excerpt = wp_trim_words( strip_shortcodes( get_the_content() ), 30, ' ...' ); 
        }
    }

    $module_args = array(
        'post_id'       => $posts_block_q->post->ID,
        'thumb_size'    => $thumb_size,
        'lazy'          => true,
        'title'         => get_the_title(),
        'permalink'     => get_permalink(),
        'author'        => esc_html( get_the_author_meta( 'display_name', $posts_block_q->post->post_author ) ),
        'date'          => get_the_time( $date_format ),
        'posts_cats'    => $cats_html,
        'posts_classes' => implode( ' ', get_post_class( '', $posts_block_q->post->ID ) ),
        'classes'       => $atts['module_classes'] . ' big-module',
        'excerpt'       => $excerpt
    );

?>

    <div class="flex-item">
        <?php
            echo meloo_module3( $module_args ); 
        ?>
    </div>
 

<?php $i++;  ?>
<?php endwhile ?>
</div>