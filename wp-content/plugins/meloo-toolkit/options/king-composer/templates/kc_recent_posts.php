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

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

// Add custom classes to element 
$wrap_class[] = 'kc-recent-posts';
$wrap_class[] = 'rt-recent-posts';
if ( $atts['thumbnails'] === 'yes' ) {
    $wrap_class[] = 'rt-show-thumbs';
}
?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
    <?php

    $thumb_size = 'meloo-medium-square-thumb';

    // Loop Args. 
    $loop_args = array(
        'showposts' => (int)$atts['limit']
    );

    // Number words to show 
    $words_number = 10;

    $recent_posts_q = new WP_Query( $loop_args );

    ob_start();
    if ( $recent_posts_q->have_posts() ) : ?>

    <ul class="rp-list">
        <?php while ( $recent_posts_q->have_posts() ) : ?>
        <?php
            $recent_posts_q->the_post();

            $tax_args = array(
                'id'         => $recent_posts_q->ID,
                'tax_name'   => 'category',
                'separator'  => '',
                'link'       => false,
                'limit'      => 2,
                'show_count' => true
            );
        ?>
        <li>
            <?php if ( ! empty( $atts['thumbnails'] ) ) : ?>
            <div class="rp-post-thumb">
                <a class="rp-post-thumb-link" href="<?php echo get_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo meloo_get_image( $recent_posts_q->ID, $thumb_size, 'rp-thumb', true ); ?></a>
            </div>
            <?php endif ?>
            <div class="rp-caption">
                <div class="rp-cats"><?php echo meloo_get_taxonomies( $tax_args ); ?></div>
                <h4><a href="<?php echo get_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" ><?php echo get_the_title(); ?></a></h4>
                <?php
                    $rating = '';
                    if ( ! empty( $atts['ratings'] ) ) {
                        // Has Reviews 
                        $has_reviews = get_post_meta( $recent_posts_q->post->ID, '_has_reviews', true );
                        if ( $has_reviews ) {

                            // Rating 
                            $rating = get_post_meta( $recent_posts_q->post->ID, '_rating', true );

                            echo meloo_get_stars_rating( $rating );
                        }
                    }
                ?>
                <?php if ( has_excerpt() && ! empty( $atts['excerpt'] ) ) : ?>
                    <div class="rp-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), $words_number ); ?>
                    </div>
                <?php endif; ?>        
            </div>
        </li>
    <?php endwhile ?>
    </ul>
    <?php endif; ?>
</div>

<?php

    wp_reset_postdata();

    $output = ob_get_clean();

   	rascals_core_e_esc( $output ); 
?>