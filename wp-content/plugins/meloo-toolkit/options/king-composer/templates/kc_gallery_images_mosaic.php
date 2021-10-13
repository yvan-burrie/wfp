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
$wrap_class[] = 'kc-images-mosaic-block';

$meloo_opts = get_option( 'meloo_panel_opts' );

// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

// Lazy effect is disabled in backend 
if ( $meloo_opts['lazyload'] === 'on' ) {
   $lazy = true;
} else {
    $lazy = false;
}
if ( is_admin() ) {
	$lazy = false;
}
?>
<div class="<?php echo esc_attr( implode(' ', $wrap_class) ); ?> <?php echo esc_attr( $atts['classes'] ); ?>">
    <div class="kc-images-mosaic-block-inner">

        <?php if ( $atts['album_id'] !== 'none' ) : ?>

             <?php

            // Variables 
            $thumb_size = 'meloo-content-thumb';

            // Album ID 
            $album_id = $atts['album_id'];

            // Images 
            $images_ids = get_post_meta( $album_id, '_images', true ); 

            // Count 
            $i = 0;

            // Output 
            $output = '';
            ?>

            <?php ob_start(); ?>
                
            <div class="gallery gallery-mosaic">
            
                <?php if ( $images_ids || $images_ids !== '' ) :

                    $ids = explode( '|', $images_ids ); 

                    $gallery_loop_args = array(
                        'post_type'      => 'attachment',
                        'post_mime_type' => 'image',
                        'post__in'       => $ids,
                        'orderby'        => 'post__in',
                        'post_status'    => 'any'
                    );

                    if ( $atts['limit'] !== 0 ) {
                        $gallery_loop_args['showposts'] = $atts['limit'];
                    }

                    $posts_block_q = new WP_Query();
                    $posts_block_q->query( $gallery_loop_args );
                    ?>
        
                    <?php while ( $posts_block_q->have_posts() ) : ?>

                        <?php

                        $last = false;
                        if ( ( $i ) < ( $posts_block_q->post_count -1 ) ) {
                            $last = false;
                        } else {
                            $last = true;
                        }
                        $posts_block_q->the_post();
                  
                        $image_att = wp_get_attachment_image_src( get_the_id(), $thumb_size );
                        if ( ! $image_att[0] ) { 
                            continue;
                        }

                        // Get image meta 
                        $image = get_post_meta( $album_id, '_gallery_ids_' . get_the_id(), true );

                        // Add default values 
                        $defaults = array(
                            'title' => '',
                            'custom_link'  => '',
                            'thumb_icon' => 'view'
                         );

                        if ( isset( $image ) && is_array( $image ) ) {
                            $image = array_merge( $defaults, $image );
                        } else {
                            $image = $defaults;
                        }

                        // Add image src to array 
                        $image['src'] = $image_att[0];
                        if ( $image[ 'custom_link' ] !== '' ) {
                            $link = $image[ 'custom_link' ];
                            $link_class = 'iframe-link';
                        } else {
                            $link = wp_get_attachment_image_src( get_the_id(), 'full' );
                            $link = $link[0];
                            $link_class = '';
                        }

                        $img_src = wp_get_attachment_image_src( get_the_id(), $thumb_size );
                        $img_src = $img_src[0];

                        if ( ! $last ) {
                            $close_mosaic = '';
                        } else {
                            $close_mosaic = '</div>';
                        }

                        if ( $lazy )  {
                            $mosaic_html = '<a href="' . esc_url( $link ) . '" class="permalink lazy '. esc_attr( $link_class ) .' g-item" data-src="' . esc_attr( $img_src ) . '" title="' . esc_attr( $image['title'] ) . '" data-group="gallery"></a>';
                        } else {
                            $mosaic_html = '<a href="' . esc_url( $link ) . '" class="permalink '. esc_attr( $link_class ) .' g-item" style="background-image:url(' . esc_attr( $img_src ) . ')" title="' . esc_attr( $image['title'] ) . '" data-group="gallery"></a>';
                        }

                        // 1
                        if ( $i % 8 === 0 ) {

                            $output .= '<div class="gallery-row">';

                                $output .= '<div class="mosaic-item mosaic-item-main">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                                $output .= $close_mosaic;
                                
                        }
                        // 2
                        if ( $i % 8 === 1 ) {
                                $output .= '<div class="mosaic-item mosaic-item-two">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                                $output .= $close_mosaic;
                        }

                        // 3
                        if ( $i % 8 === 2 ) {
                                $output .= '<div class="mosaic-item mosaic-item-two">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                            $output .= '</div>';
                        }

                        // 4
                        if ( $i % 8 === 3 ) {
                            $output .= '<div class="gallery-row">';
                                $output .= '<div class="mosaic-item mosaic-item-narrow">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                                $output .= $close_mosaic;
                        }

                        // 5
                        if ( $i % 8 === 4 ) {
                                $output .= '<div class="mosaic-item mosaic-item-big">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                            $output .= '</div>';
                        }

                        // 6
                        if ( $i % 8 === 5 ) {
                            $output .= '<div class="gallery-row">';
                                $output .= '<div class="mosaic-item mosaic-item-3">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                                $output .= $close_mosaic;
                        }

                        // 7
                        if ( $i % 8 === 6 ) {
                                $output .= '<div class="mosaic-item mosaic-item-3">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                                $output .= $close_mosaic;
                        }

                        // 8
                        if ( $i % 8 === 7 ) {
                                $output .= '<div class="mosaic-item mosaic-item-3">';
                                $output .= $mosaic_html;
                                $output .= '</div>';
                            $output .= '</div>';
                        }

                         $i++; 

                        ?>

                    <?php endwhile ?>
                    <?php rascals_core_e_esc( $output );  ?>
                
                 <?php else : ?>
                    <div class="warning"><?php esc_html_e( 'Warning: There are no items to display this module.', 'meloo-toolkit' ); ?></div>
                <?php endif; ?>

            </div>

        

        <?php else : ?>
            <div class="warning"><?php esc_html_e( 'Warning: There are no items to display this module.', 'meloo-toolkit' ); ?></div>
        <?php endif; ?>
       
    </div>
</div>

<?php
    
    wp_reset_postdata();

    $output = ob_get_clean();

    rascals_core_e_esc( $output ); 
?>