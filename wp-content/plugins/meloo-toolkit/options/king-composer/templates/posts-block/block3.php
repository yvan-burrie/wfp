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
$limit = 5; 
$thumb_size = 'meloo-large-square-thumb';

?>
<?php while ( $posts_block_q->have_posts() ) : ?>
<?php
    $posts_block_q->the_post();
    $count = $posts_block_q->post_count; 

    if ( $count < $limit ) {
        echo '<div class="warning">' . esc_html__( 'Warning: The number of posts is too small to display this module. The minimum number is: ', 'meloo-toolkit' ) . esc_attr( $limit ) . '</div>';
        break;
    }

    $tax_args = array(
        'id' => $posts_block_q->ID,
        'tax_name' => 'category',
        'separator' => '',
        'link' => false,
        'limit' => 2,
        'show_count' => true
    );
    $cats_html = meloo_get_taxonomies( $tax_args );

    $module_args = array(
        'post_id' => $posts_block_q->post->ID,
        'thumb_size' => $thumb_size,
        'lazy' => true,
        'title' => get_the_title(),
        'permalink' => get_permalink(),
        'author' => esc_html( get_the_author_meta( 'display_name', $posts_block_q->post->post_author ) ),
        'date' => get_the_time( $date_format ),
        'posts_cats' => $cats_html,
        'posts_classes' => implode( ' ', get_post_class( '', $posts_block_q->post->ID ) ),
        'classes' => $atts['module_classes']
    );

?>

<?php if ( $i % 5 === 0 ) : ?>
    <div class="kc-pb kc-pb3">
         <div class="kc-pb-col kc-pb-col1">
            <?php
                $module_args['thumb_size'] = 'meloo-large-square-thumb';
                $module_args['classes'] .= ' big-module';
                echo meloo_module5( $module_args ); 
            ?>
        </div>
<?php endif ?>

<?php if ( $i % 5 === 1 ) : ?>
       <div class="kc-pb-col kc-pb-col2">
            <div class="kc-pb-row">
                <?php 
                    $module_args['thumb_size'] = 'meloo-medium-square-thumb';
                    $module_args['classes'] .= ' small-module';
                    echo meloo_module5( $module_args ); 
                ?> 
<?php endif ?>

<?php if ( $i % 5 === 2 ) : ?>
                <?php 
                    $module_args['thumb_size'] = 'meloo-medium-square-thumb';
                    $module_args['classes'] .= ' small-module';
                    echo meloo_module5( $module_args ); 
                ?>
            </div>
<?php endif ?>

<?php if ( $i % 5 === 3 ) : ?>
            <div class="kc-pb-row">
                <?php 
                    $module_args['thumb_size'] = 'meloo-medium-square-thumb';
                    $module_args['classes'] .= ' small-module';
                    echo meloo_module5( $module_args ); 
                ?> 
<?php endif ?>

<?php if ( $i % 5 === 4 ) : ?>
                <?php 
                    $module_args['thumb_size'] = 'meloo-medium-square-thumb';
                    $module_args['classes'] .= ' small-module';
                    echo meloo_module5( $module_args ); 
                ?>
            </div>
        </div>
    </div>
<?php endif ?>

<?php 
    if ( $i === ( $limit-1 ) ) {
        break;  
    } 
?>
<?php $i++;  ?>
<?php endwhile ?>