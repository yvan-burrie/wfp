<?php
/**
 * Rascals Scamp Player Shortcodes
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Get tracklist in array
 * @param  integer $audio_post_id 
 * @return array               
 */
if ( ! function_exists( 'meloo_toolkit_sp_getList' ) ) :
function meloo_toolkit_sp_getList( $audio_post, $custom_ids = '' ) {

	// Get IDS
	if ( $custom_ids !== '' ) {
		$audio_ids = $custom_ids;
	} else {
		$audio_ids = get_post_meta( $audio_post, '_audio_tracks', true );
	}

	if ( ! $audio_ids || $audio_ids === '' ) {
		 return false;
	}

	$count = 0;
	$ids = explode( '|', $audio_ids );
	$defaults = array(
		'id'               => 0,
		'custom'           => false,
		'custom_url'       => false,
		'title'            => '',
		'artists'          => false,
		'buttons'          => false,
		'cover'            => false,
		'cover_full'       => false,
		'release_url'      => '',
		'release_target'   => '', 
		'artists'          => '',
		'artists_url'      => '',
		'artists_target'   => '',
		'cart_url'         => '',
		'cart_target'      => '',
		'free_download'    => 'no',
		'track_length'     => '',
		'lyrics'           => '',
		'disable_playback' => 'no',
		'waveform'         => ''
	);

	$tracklist = array();

	/* Start Loop */
	foreach ( $ids as $id ) {

		// Vars 
		$title = '';
		$subtitle = '';

		// Get image meta 
		$track = get_post_meta( $audio_post, '_audio_tracks_' . $id, true );

		// Add default values 
		if ( isset( $track ) && is_array( $track ) ) {
			$track = array_merge( $defaults, $track );
		} else {
			$track = $defaults;
		}

		// ID 
		$track['id'] = $id;

		// Custom cover 
		if ( $track['cover'] ) {

			// If from Media Libary
			if ( is_numeric( $track['cover'] ) ) {
				$image_cover = wp_get_attachment_image_src( $track['cover'], 'thumbnail' );
				$image_cover = (isset($image_cover[0])) ? $image_cover[0] : false;
				$image_cover_full = wp_get_attachment_image_src( $track['cover'], 'meloo-release-thumb' );
				$image_cover_full = (isset($image_cover_full[0])) ? $image_cover_full[0] : false;
				if ( $image_cover ) {
					$track['cover'] =  $image_cover;
					$track['cover_full'] =  $image_cover_full;
				} else {
					$track['cover'] = false;
				}
			} else {
				$track['cover_full'] = $track['cover'];
			}

		}

		/* Waveform */
		if ( $track['waveform'] ) {

			$image_waveform = wp_get_attachment_image_src( $track['waveform'], 'full' );
			$image_waveform = $image_waveform[0];
		
			if ( $image_waveform ) {
				$track['waveform'] = $image_waveform;
			} else {
				$track['waveform'] = false;
			}
		}

		// Check if track is custom 
	   	if ( wp_get_attachment_url( $id ) ) {
	      	$track_att = get_post( $id );
	      	$track['url'] = wp_get_attachment_url( $id );
	      	if ( $track['title'] === '' ) {
	      		$track['title'] = $track_att->post_title;
	      	}
	    } else {
			$track['url'] = $track['custom_url'];
			if ( $track['url'] === '' ) {
				continue;
			}
			if ( $track['title'] === '' ) {
				$track['title'] = esc_html__( 'Custom Title', 'meloo-toolkit' );
			}
			$track['custom'] = true;
	    }

	    array_push( $tracklist, $track );
	}
	
	return $tracklist;

}
endif;


//////////////
// WAVEFORM //
//////////////
function sp_wf_tracklist( $atts, $content = null ) {

    // Toolkit
    $toolkit = melooToolkit();
    $toolkit::$id++;
    $sp_sid = $toolkit::$id . uniqid();

    extract(shortcode_atts(array(
        'id'              => 0,
        'ids'             => '',
        'unique_id'       => '',
        'limit'           => '1',
        'waveform_colors' => '#4063e6,#eb18d9,#4063e6,#eb18d9',
        'color_scheme'  => get_theme_mod( 'color_scheme', 'dark' ),
        'classes'         => '',
    ), $atts));

    $output = '';
    

    if ( $id === 0 || ! meloo_toolkit_sp_getList( $id ) ) {
        return false;
    }

    // Set color scheme 
    if ( isset( $classes ) ) {
        $classes .= ' ' . $color_scheme . '-scheme-el';
    }
    
    // Classes 
    $tracklist_classes = array();

    // To integer 
    $limit = (int)$limit;
    $limit = ( $limit === 0 ? -1 : $limit ); 

    // Set global number ID 
    $sp_sid++;

    // Get tracklist array 

    $tracks = meloo_toolkit_sp_getList( $id, $ids );

    // unique ID 
    if ( empty( $unique_id ) ) {
        $unique_id = 'wft-' . $sp_sid;
    }

    $output .= '<div class="sp-wft-block ' . esc_attr( $classes ) . '">';
    $output .= '<ul id="' . esc_attr( $unique_id ) . '" class="sp-list sp-wft ' . esc_attr( implode(' ', $tracklist_classes ) ) . '">';

    foreach ( $tracks as $i => $track ) {

        $i ++;

        // Track Classes 
        $track_classes = "";

        // Custom Waveform
        if ( $track['waveform'] ) {
            $waveform_classes = 'custom-track-waveform';
            $track['waveform'] = '<img src="' . esc_url( $track['waveform'] ) . '" class="spl-waveform">';
        } else {
             $waveform_classes = 'track-waveform';
            $track['waveform'] = false;
        }

        // Radio 
        if ( strpos( $track['url'], '?sp_radio' ) !== false ) {
            $track_classes = "sp-radio";
        } 

        // Track length 
        $track_length = '';
        if ( $track['track_length'] !== '' ) {
            $track_length = '<span class="track-length">' . esc_attr( $track['track_length'] ) . '</span>';
        }

        // Waveform track 
        $wf_url =  $track['url'];

        // Encode Track 
        if ( meloo_toolkit_get_option( 'player_base64', 'off' ) === 'on' ) {
            $track['url'] = base64_encode( $track['url'] );
        }

        // Disabled track 
        if ( $track['disable_playback'] === 'yes' ) {
            $track_href = '';
            $track_disabled = 'sp-disabled';
            $track_classes .= ' track track-col sp-disabled';
        } else {
            $track_href = 'href="' .  $track['url'] . '"';
            $track_classes .= ' track track-col sp-play-track';
            $track_disabled = 'sp-track-item';
        }

        $output .= '
                    <li class="' . esc_attr( $track_disabled ) . '">
                            
                        <div class="wft-top">
                            <h6 class="wft-type wft-label">' . esc_html__('Track', 'meloo-toolkit') . '</h6>
                            <div class="wft-title">
                                <h1>' . $track['title'] . '</h1>
                            </div>
                            
                            <div class="wft-actions">
                                <a 
                                    ' . wp_kses_post( $track_href ) . ' 
                                    id="sp-track-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'"
                                    class="' . esc_attr( $track_classes ) . '" 
                                    data-cover="' . esc_url( $track['cover'] ) . '" 
                                    data-artist="' . esc_attr( $track['artists'] ) . '" 
                                    data-artist_url="' . esc_url( $track['artists_url'] ) . '" 
                                    data-artist_target="' . esc_attr( $track['artists_target'] ) . '" 
                                    data-release_url="' . esc_url( $track['release_url'] ) . '" 
                                    data-release_target="' . esc_attr( $track['release_target'] ) . '" 
                                    data-shop_url="' . esc_url( $track['cart_url'] ) . '" 
                                    data-shop_target="' . esc_attr( $track['cart_target'] ) . '" 
                                    data-free_download="' . esc_attr( $track['free_download'] ) . '" 
                                    data-control="waveform-' . esc_attr( $sp_sid ) . '-' . esc_attr( $i ) .'"
                                    title="' . esc_html( $track['title'] ) . ' - ' . esc_html( $track['artists'] ) . '"><span class="track-title hidden">' . $track['title'] . '</span><span class="track-artists hidden">' . $track['artists'] . '</span><span class="icon icon-play2"></span>
                                </a>
                            </div>
                        </div>
                        <div class="wft-artists">
                            <h3 class="wft-label">' . esc_html__('Artists', 'meloo-toolkit') . '<span>' . esc_html( $track['artists'] ) . '</span></h3>

                        </div>

                        <div class="wft-waveform ' . esc_attr( $waveform_classes ) . ' sp-content-control" id="waveform-' . esc_attr( $sp_sid ) . '-' . esc_attr( $i ) .'" data-colors="' . esc_attr( $waveform_colors ) . '" data-shadow-height="60" data-audio="' . esc_attr( $wf_url ) . '">
                            <span class="sp-content-progress">
                                <span class="sp-content-position"></span>
                            </span>';

                        
                        if ( $track['waveform'] !== false ) {
                            $output .= $track['waveform'];
                        } else {    
                            $output .= '<canvas id="ctx-waveform-' . esc_attr( $sp_sid ) . '-' . esc_attr( $i ) .'" class="waveform" width="1170" height="200"></canvas>';
                        }
                        $output .= '</div>
                    </li>';
        if ( $i === $limit ) {
            break;
        }
    }

    $output .= '</ul>'; //end playlist
    $output .= '</div>'; //end block

   return $output;
}
add_shortcode( 'rt_wf_tracklist', 'sp_wf_tracklist' );


//////////////////
// TRACK BUTTON //
//////////////////
function sp_track_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'link'     => '#',
		'title'    => '',
		'icon'     => '',
		'download' => 'no',
		'target'   => '_self',
		'classes'  => ''
    ), $atts));
    $a_html = '';
    if ( $icon !== '' ) {
        $a_html = '<span class="icon icon-' . esc_attr( $icon ) . '"></span>';
        $classes .= ' has-only-icons';
    } else {
        $a_html = $title;
    }

    if ( $download === 'yes' ) {
    	$download = 'download';
    } else {
    	$download = '';
    }
    return '<a class="' . esc_attr( $classes ) . '" href="' . esc_url( $link ) . '"  title="' . esc_attr( $title ) . '" target="' . esc_attr( $target ) . '"  ' . esc_attr( $download ) . '>' . wp_kses_post( $a_html ) . '</a>';
}
add_shortcode( 'track_button', 'sp_track_button' );


///////////////
// TRACKLIST //
///////////////
function sp_tracklist( $atts, $content = null ) {

    // Toolkit
    $toolkit = melooToolkit();
    $toolkit::$id++;
    $sp_sid = $toolkit::$id . uniqid();

    extract(shortcode_atts(array(
        'id'              => 0,
        'ids'             => '',
        'unique_id'       => '',
        'covers'          => '',
        'buttons'         => '',
        'fixed_height'    => '0',
        'limit'           => '0',
        'size'            => 'medium', // medium,large,xlarge
        'show_ad'         => 'yes',
        'vis'             => 'lines', // lines, bars
        'color_scheme'    => get_theme_mod( 'color_scheme', 'dark' ),
        'waveform_colors' => '',
        'classes'         => ''
    ), $atts));

    $output = '';
    
    if ( $id === 0 || ! meloo_toolkit_sp_getList( $id ) ) {
        return false;
    }

    // Set color scheme 
    if ( isset( $classes ) ) {
        $classes .= ' ' . $color_scheme . '-scheme-el';
    }
    if ($waveform_colors === '') {
        if ( $color_scheme === 'dark' ) {
            $waveform_colors = '#444444,#555555,#444444,#555555';
        } else {
            $waveform_colors = '#999999,#dddddd,#999999,#dddddd';
        }
    }

    // Classes 
    $tracklist_classes = array();
    
    if ( $covers === 'yes' ) {
        $tracklist_classes[] = 'sp-has-cover';
    }
    if ( $buttons === 'yes' ) {
        $tracklist_classes[] = 'sp-has-buttons';
    }

    $tracklist_classes[] = 'sp-size-' . $size;

    // To integer 
    $limit = (int)$limit;
    $limit = ( $limit === 0 ? -1 : $limit ); 

    // Set global number ID 
    $sp_sid++;

    // get tracklist array 
    $tracks = meloo_toolkit_sp_getList( $id, $ids );

    // unique ID 
    if ( empty( $unique_id ) ) {
        $unique_id = 'tracklist-' . $sp_sid;
    }

    // If fixed height 
    if ( $fixed_height !== '0' ) {

        $output .= '<div id="tracklist-block-' . esc_attr( $sp_sid ) . '" class="sp-tracklist-block sp-has-fixed-height ' . esc_attr( $classes ) . '" style="height:' . esc_attr( $fixed_height ) . 'px">';
    } else {
         $output .= '<div class="sp-tracklist-block ' . esc_attr( $classes ) . '">';
    }

    $output .= '<ul id="' . esc_attr( $unique_id ) . '" class="sp-list sp-tracklist ' . esc_attr( implode(' ', $tracklist_classes ) ) . '">';
    $tracklist_length = count( $tracks );
    $adspot_place_nr = intval( $tracklist_length/2 );

    foreach ( $tracks as $i => $track ) {

        $i ++;

        // Track Classes 
        $track_classes = "";
        $li_classes = '';

        // Radio 
        if ( strpos( $track['url'], '?sp_radio' ) !== false ) {
            $li_classes .= "sp-radio";
        }

        // Lyrics 
        $lyrics_html = '';
        $lyrics_btn = '';
        if ( $track['lyrics'] !== '' ) {
            $lyrics_btn = '<span class="track-lyrics">' . __( 'Lyrics', 'meloo-toolkit' ) . '</span>';
            $lyrics_html = '
                <div class="track-row track-row-lyrics">
                    <div class="track-lyrics-text">
                        <h5>' . esc_html( $track['title'] ) . '</h5>
                        ' . do_shortcode( wpautop( $track['lyrics'], 1 ) ) . '
                    </div>
                </div>';
        }

        // Track length 
        $track_length = '';
        if ( $track['track_length'] !== '' ) {
            $track_length = '<span class="track-length">' . $track['track_length'] . '</span>';
        }

        // Cover 
        $cover_html = '';
        if ( $covers === 'yes' ) {
            if ( $track['cover'] || $track['cover'] !== '' ) {
                $cover_html = '<img src="' . $track['cover']. '" alt="' .  esc_attr( __( 'Track cover', 'meloo-toolkit' ) ) . '">';
            } else {
                $cover_html = '<img src="' . plugins_url('assets/img/no-track-image.png', __FILE__) . '" alt="' .  esc_attr( __( 'Track cover', 'meloo-toolkit' ) ) . '">';
                $track['cover'] = plugins_url('assets/img/no-track-image.png', __FILE__);
            }
        } 

        // Buttons 
        if ( $track['buttons'] !== '' ) {
            $track['buttons'] = preg_replace("/\r\n|\r|\n/",' ', $track['buttons'] );
            $buttons_html = $track['buttons'];
        } else {
            $buttons_html = '';
        }
        if ( empty( $lyrics_btn ) && empty( $buttons_html ) ) {
            $meta_col_class = 'hidden';
        } else {
            $meta_col_class = '';
        }

        // Custom Waveform
        if ( $track['waveform'] ) {
            $track['waveform'] = '<img src="' . esc_url( $track['waveform'] ) . '" class="spl-waveform">';
        } else {
            $track['waveform'] = false;
        }

        // Waveform track 
        $wf_url =  $track['url'];

        $vis_html = '';
        $vis_data = '';
        if ( $vis !== 'none' ) {
            $vis_html .= '<div class="vis-block">';

            // Visualisations 
                $track_classes .= ' has-vis';
                $vis_data = 'data-v="sp-v-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'" data-vt="' . esc_attr( $vis ) . '"';
                $vis_html .= '<div id="sp-v-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'" class="sp-vis">
                   <canvas id="sp-v-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'-canvas" width="400" height="100"></canvas>';

                // Waveform 
                if ( $vis === 'lines' ) {
                    $track_classes .= ' has-waveform';
                    if ( $track['waveform'] !== false ) {
                        $vis_html .= '<div class="tracklist-custom-waveform" id="waveform-' . esc_attr( $sp_sid ) . '-' . esc_attr( $i ) .'">';
                        $vis_html .= $track['waveform'];
                    } else {
                         $vis_html .= '<div class="tracklist-waveform" id="waveform-' . esc_attr( $sp_sid ) . '-' . esc_attr( $i ) .'" data-colors="' . esc_attr( 
                    $waveform_colors ) . '" data-shadow-height="50" data-audio="' . esc_attr($wf_url ) . '">';
                        $vis_html .= '<canvas id="ctx-waveform-' . esc_attr( $sp_sid ) . '-' . esc_attr( $i ) .'" class="waveform" width="1170" height="100" ></canvas>';
                    }

                    $vis_html .= '</div>';
                } 
                $vis_html .= '</div>';
            
        } 

        // Encode Track 
        if ( meloo_toolkit_get_option( 'player_base64', 'off' ) === 'on' ) {
            $track['url'] = base64_encode( $track['url'] );
        }

        // Disabled track 
        if ( $track['disable_playback'] === 'yes' ) {
            $track_href = '';
            $li_classes .= ' sp-disabled';
            $track_classes .= ' track track-col sp-disabled';
        } else {
            $track_href = 'href="' .  $track['url'] . '"';
            $track_classes .= ' track track-col sp-play-track';
            $li_classes .= ' sp-track-item';
        }

        // Display AD spot if is available 
        if ( ! empty( $show_ad ) && function_exists( 'meloo_show_ad' ) ) {
            if ( $i === ($adspot_place_nr+1) && isset( $theme_opts['ad_tracklist_type'] ) && ! empty( $theme_opts['ad_tracklist_type'] ) ) {
                $output .= '<li class="sp-disabled ad-tracklist">' . meloo_show_ad( 'tracklist' ) . '</li>';
            }
        }

        $output .= '
                    <li class="' . esc_attr( $li_classes ) . '">
                        <div class="track-row track-row-data">
                           <a 
                                ' . wp_kses_post( $track_href ) . ' 
                                id="sp-track-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'"
                                class="' . esc_attr( $track_classes ) . '" 
                                data-cover="' . esc_url( $track['cover'] ) . '" 
                                data-artist="' . esc_attr( $track['artists'] ) . '" 
                                data-artist_url="' . esc_url( $track['artists_url'] ) . '" 
                                data-artist_target="' . esc_attr( $track['artists_target'] ) . '" 
                                data-release_url="' . esc_url( $track['release_url'] ) . '" 
                                data-release_target="' . esc_attr( $track['release_target'] ) . '" 
                                data-shop_url="' . esc_url( $track['cart_url'] ) . '" 
                                data-shop_target="' . esc_attr( $track['cart_target'] ) . '" 
                                data-free_download="' . esc_attr( $track['free_download'] ) . '" 
                                data-control="sp-progress-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'"
                                '. wp_kses_post( $vis_data ) .'
                                title="' . esc_html( $track['title'] ) . ' - ' . esc_html( $track['artists'] ) . '">
                                <span class="track-status" data-nr="' . esc_attr( $i ) . '">
                                    ' . wp_kses_post( $cover_html ) . '
                                <span class="status-icon"></span>
                                </span>
                                <span class="track-title hidden">' . $track['title'] . '</span>
                                <span class="track-artists hidden">' . $track['artists'] . '</span>
                            </a>

                            <div class="track-col-data">
                                <span class="track-details">
                                    <span class="track-title">' . $track['title'] . ' ' . wp_kses_post( $track_length ) . '</span>
                                    <span class="track-artists">' . $track['artists'] . '</span>
                                </span>

                                <div id="sp-progress-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'" class="track-row track-row-progress sp-content-control">
                                    <span class="sp-content-progress">
                                        <span class="sp-content-loading"></span>
                                        <span class="sp-content-position"></span>
                                    </span>
                                </div>
                                '. $vis_html .'
                            </div>
                            <div class="track-col-meta ' . esc_attr( $meta_col_class ) . '">
                                    ' . wp_kses_post( $lyrics_btn ) . '
                                <div class="track-col-buttons">
                                    ' . do_shortcode ( $track['buttons'] ) . '
                                </div>
                            </div>
                        </div>
                        
                        ' . wp_kses_post( $lyrics_html ) . '
                    </li>';
        if ( $i === $limit ) {
            break;
        }
    }

    $output .= '</ul>'; //end playlist
    $output .= '</div>'; //end block

   return $output;
}
add_shortcode( 'rt_tracklist', 'sp_tracklist' );


//////////////////////
// HIDDEN TRACKLIST //
//////////////////////
function sp_hidden_tracklist( $atts, $content = null ) {

    // Toolkit
    $toolkit = melooToolkit();
    $toolkit::$id++;
    $sp_sid = $toolkit::$id . uniqid();
    
    extract(shortcode_atts(array(
        'id'           => 0,
        'ids'          => '',
        'tracklist_id' => 'tracklist-id-0',
        'ctrl'         => '',
        'vis'          => 'none'
    ), $atts));

    $output = '';

    if ( $id === 0 || ! meloo_toolkit_sp_getList( $id ) ) {
        return false;
    }

    $theme_opts = get_option( 'meloo_panel_opts' );

    // Set global number ID 
    $sp_sid++;

    // get tracklist array 
    $tracks = meloo_toolkit_sp_getList( $id, $ids );
    
    $output .= '<ul id="' . esc_attr( $tracklist_id ) . '" class="sp-list sp-tracklist sp-tracklist-hidden">';
    $tracklist_length = count( $tracks );

    foreach ( $tracks as $i => $track ) {

        // Track Classes 
        $track_classes = "";


        // Radio 
        if ( strpos( $track['url'], '?sp_radio' ) !== false ) {
            $track_classes = "sp-radio";
        } 

        $i ++;

        // Visualisations 
        if ( $vis !== 'none' ) {
            $vis_data = 'data-v="sp-v-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'" data-vt="' . esc_attr( $vis ) . '"';
            $vis_html = '<div id="sp-v-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'" class="sp-vis">
               <canvas id="sp-v-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'-canvas" width="400" height="100"></canvas>
            </div>';
        } else {
            $vis_data = '';
            $vis_html = '';
        }

        // Encode Track 
        if ( meloo_toolkit_get_option( 'player_base64', 'off' ) === 'on' ) {
            $track['url'] = base64_encode( $track['url'] );
        }

        // Disabled track 
        if ( $track['disable_playback'] === 'yes' ) {
            $track_href = '';
            $track_disabled = 'sp-disabled';
            $track_classes = 'track track-col sp-disabled';
        } else {
            $track_href = 'href="' .  $track['url'] . '"';
            $track_classes = 'track track-col sp-play-track';
            $track_disabled = 'sp-track-item';
        }

        $output .= '
            <li class="' . esc_attr( $track_disabled ) . '">
                <div class="track-row track-row-data">
                   <a 
                        ' . wp_kses_post( $track_href ) . ' 
                        class="' . esc_attr( $track_classes ) . '" 
                        data-cover="' . esc_url( $track['cover'] ) . '" 
                        data-artist="' . esc_attr( $track['artists'] ) . '" 
                        data-artist_url="' . esc_url( $track['artists_url'] ) . '" 
                        data-artist_target="' . esc_attr( $track['artists_target'] ) . '" 
                        data-release_url="' . esc_url( $track['release_url'] ) . '" 
                        data-release_target="' . esc_attr( $track['release_target'] ) . '" 
                        data-shop_url="' . esc_url( $track['cart_url'] ) . '" 
                        data-shop_target="' . esc_attr( $track['cart_target'] ) . '" 
                        data-free_download="' . esc_attr( $track['free_download'] ) . '" 
                        data-control="sp-progress-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'"
                        '. wp_kses_post( $vis_data ) .'
                        title="' . esc_html( $track['title'] ) . ' - ' . esc_html( $track['artists'] ) . '">
                        <span class="track-title hidden">' . $track['title'] . '</span>
                        <span class="track-artists hidden">' . $track['artists'] . '</span>
                    </a>

                    <div class="track-col-data">';
                    
                    if ( !empty( $ctrl ) ) {
                        $output .= '<div id="sp-progress-' . esc_attr( $sp_sid ) . '-'. esc_attr( $i ) .'" class="track-row track-row-progress sp-content-control">
                                <span class="sp-content-progress">
                                    <span class="sp-content-loading"></span>
                                    <span class="sp-content-position"></span>
                                </span>
                            </div>';
                    }


                    $output .=  $vis_html .'
                    </div>
                </div>
            </li>';
    }

    $output .= '</ul>'; //end playlist

   return $output;
}
add_shortcode( 'rt_hidden_tracklist', 'sp_hidden_tracklist' );