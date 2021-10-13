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
// Module classes 
$classes = array(
    'post-grid-module'
);
if ( $atts['module_classes'] ) {
    $classes[] = $atts['module_classes'];  
}

// Module Opts 
$module_opts = array(
    'module' => 'meloo_music_module2',
    'excerpt' => '',
    'show_tracks' => 'yes',
    'thumb_size' => 'meloo-large-square-thumb',
    'classes' => implode( ' ', $classes )
);

?>
<div data-module-opts='<?php echo json_encode( $module_opts ) ?>' class="ajax-grid flex-grid <?php echo esc_attr( $grid_classes ) ?> flex-gap-medium flex-anim flex-anim-fadeup posts-container kc-mb4">

<?php while ( $posts_block_q->have_posts() ) : ?>
<?php
    $posts_block_q->the_post();
    $count = $posts_block_q->post_count; 

    $module_args = array(
        'post_id'       => $posts_block_q->post->ID,
        'thumb_size'    => $module_opts['thumb_size'],
        'lazy'          => true,
        'title'         => get_the_title(),
        'permalink'     => get_permalink(),
        'show_tracks'   => 'yes',
        'date'          => get_the_time( $date_format ),
        'posts_classes' => implode( ' ', get_post_class( '', $posts_block_q->post->ID ) ),
        'classes'       => $module_opts['classes']
    );

?>

    <div class="flex-item">
        <?php
            echo meloo_music_module2( $module_args ); 
        ?>
    </div>
 

<?php $i++;  ?>
<?php endwhile ?>
</div>