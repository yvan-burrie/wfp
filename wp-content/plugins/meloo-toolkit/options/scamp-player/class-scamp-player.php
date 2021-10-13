<?php
/**
 * Rascals Scamp Player
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class RascalsScampPlayer {

	/*
	Private variables
	 */
	private $tracks_filter_args = array();

	/*
	Public variables
	 */
	public $theme_panel = null;
	public $post_type   = 'tracks';
	public $icon        = 'dashicons-format-audio';
	public $supports    = array('title', 'editor');


	/**
	 * Rascals CPT Constructor.
	 * @return void
	 */
	public function __construct( $options = null ) {

		if ( $options !== null ) {
			$this->theme_panel = $options['theme_panel'];
			$this->post_type = $options['post_type'];
		}
		$this->init();
	}

	/**
	 * Initialize class
	 * @return void
	 */
	public function init() {

		// Check if player is enabled
		if ( $this->option( 'scamp_player', 'off' ) === 'off' ) {
			return;
		}

		// Frontend Scripts
		add_action( 'wp_enqueue_scripts' , array( $this, 'scampPlayerEnqueue' ) );

		// Add post state
		add_filter('display_post_states', array( $this, 'setPostState' ) );

		// Render Player
		add_action( 'wp_footer', array( $this, 'renderPlayer' ) );

	}


	
	/**
	 * Enqueue all frontend scripts and styles 
	 * @return void
	 */
	public function scampPlayerEnqueue() {

		
		// Player Styles
		wp_enqueue_style( 'scamp-player' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/css/scamp.player.css' );

		if ( $this->option( 'player_skin' ) ) {
			wp_enqueue_style( 'scamp-player-skin' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/css/scamp.player.' . esc_attr( $this->option( 'player_skin' ) ) . '.css' );
		}


		// Player Scripts
		if ( $this->option( 'combine_js', 'off' ) === 'off' ) {

			// SC API
			if ( $this->option( 'soundcloud', 'on' ) === 'on' ) {
				wp_enqueue_script( 'soundcloud-sdk' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/sdk.js' , false, false, true );
			}

			// Shoutcast
			wp_enqueue_script( 'jquery-shoutcast' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/jquery.shoutcast.min.js' , false, false, true );
			// SM2
			wp_enqueue_script( 'soundmanager2' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/soundmanager2-nodebug-jsmin.js' , false, false, true );

			if ( $this->option( 'player_base64', 'on' ) === 'on' ) {
				wp_enqueue_script( 'base64' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/base64.min.js' , false, false, true );
			}

			// Scamp Player
			wp_enqueue_script( 'scamp-player' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/jquery.scamp.player.min.js' , false, false, true );
		} else {
			// SC API
			if ( $this->option( 'soundcloud', 'on' ) === 'on' ) {
				wp_enqueue_script( 'soundcloud-sdk' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/sdk.js' , false, false, true );
			}
			wp_enqueue_script( 'scamp-player' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/scamp-player-pack.min.js' , false, false, true );

		}

		// Shortcodes
		wp_enqueue_style( 'scamp-player-shortcodes' ,  esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/css/scamp-player-shortcodes.css' );

		// JS Init
	    wp_enqueue_script( 'scamp-player-init' , esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/jquery.scamp.player-init.js' , false, false, true );

	    $js_variables = array(
			'plugin_uri'         =>	esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/js/',
			'plugin_assets_uri'  => esc_url( RASCALS_TOOLKIT_URL ) . '/options/scamp-player/',
			'shoutcast_interval' => $this->option( 'shoutcast_interval', 20000 ),
			'smooth_transition'  => false,
			'volume'             => $this->option( 'player_volume', '90' ),
			'play_label'         => esc_html__( 'Play', 'meloo-toolkit' ),
			'cover_label'        => esc_html__( 'Cover', 'meloo-toolkit' ),
			'title_label'        => esc_html__( 'Title/Artist', 'meloo-toolkit' ),
			'buy_label'          => esc_html__( 'Buy/Download', 'meloo-toolkit' ),
			'remove_label'       => esc_html__( 'Remove', 'meloo-toolkit' ),
			'empty_queue'        => esc_html__( 'Empty Queue', 'meloo-toolkit' )
		);

	    // Settings

		// Autoplay
		if ( $this->option( 'player_autoplay', 'off' ) === 'on' ) {
			$js_variables['autoplay'] = true;
		} else {
			$js_variables['autoplay'] = false;
		}

	 	// Base
		if ( $this->option( 'player_base64', 'on' ) === 'on' ) {
			$js_variables['base64'] = true;
		} else {
			$js_variables['base64'] = false;
		}

		// Random
		if ( $this->option( 'player_random', 'off' ) === 'on' ) {
			$js_variables['random'] = true;
		} else {
			$js_variables['random'] = false;
		}

		// Loop
		if ( $this->option( 'player_loop', 'on' ) === 'on' ) {
			$js_variables['loop'] = true;
		} else {
			$js_variables['loop'] = false;
		}

		// Load first track on tracklist
		if ( $this->option( 'load_first_track', 'on' ) === 'on' ) {
			$js_variables['load_first_track'] = true;
		} else {
			$js_variables['load_first_track'] = false;
		}

		// Show current track name instead off body title
		if ( $this->option( 'player_titlebar', 'on' ) === 'on' ) {
			$js_variables['titlebar'] = true;
		} else {
			$js_variables['titlebar'] = false;
		}

		// SC KEY
		if ( $this->option( 'soundcloud_id', '23f5c38e0aa354cdd0e1a6b4286f6aa4' ) !== '' ) {
			$js_variables['soundcloud_id'] = $this->option( 'soundcloud_id', '23f5c38e0aa354cdd0e1a6b4286f6aa4' );
		} else {
			$js_variables['soundcloud_id'] = '';
		}
	 
		// Shoutcast
		if ( $this->option( 'shoutcast', 'on' ) === 'on' ) {
			$js_variables['shoutcast'] = true;
		} else {
			$js_variables['shoutcast'] = false;
		}
		
		wp_localize_script( 'scamp-player-init', 'scamp_vars', $js_variables );

	
	}


	/**
	 * Add ScampPlayer container
	 * @return void
	 */
	public function renderPlayer() {

		// Player Classes
		$classes = '';

		// Open player after click on track
		if ( $this->option( 'open_player', 'on' ) === 'on' ) {
			$classes .= ' sp-open-after-click';
		}

		// Show Player on startup
		if ( $this->option( 'show_player', 'off' ) === 'on' ) {
			$classes .= ' sp-show-player';
		}

		// Show Tracklist on startup
		if ( $this->option( 'show_tracklist', 'off' ) === 'on' ) {
			$classes .= ' sp-show-list';
		}

		$classes .= ' sp-anim';
		?>
		<div id="scamp_player" class="<?php echo esc_attr( $classes ); ?>">
			<?php  
				// Startup Tracklist
				if ( $this->option( 'startup_tracklist', 'none' ) !== 'none' ) {
					$startup_tracklist = meloo_toolkit_sp_getList( $this->option( 'startup_tracklist' ) );
					if ( $startup_tracklist ) {
						foreach ( $startup_tracklist as $track ) {
						
							if ( $track['disable_playback'] === 'no' ) {
								if ( $this->option( 'player_base64', 'off' ) === 'on' ) {
									$track['url'] = base64_encode( $track['url'] );
								}
								echo '<a href="' . $this->esc( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">' . esc_html( $track['title'] ) . '</a>';
							}
								
						}
					}
				}
			?>
		</div>
		<?php
		
	}


	/**
	 * Display autostart tracklist in post list
	 * @param array
	 */
	public function setPostState( $states ) { 
		global $post;
		
		if ( isset($post) ) {
			if ( $this->post_type === get_post_type( $post->ID ) && $this->option( 'startup_tracklist' ) ) {
				$tracklist_id = $this->option( 'startup_tracklist' );
				if ( is_numeric( $tracklist_id ) ) {
					$tracklist_id = intval( $tracklist_id );

					if ( $tracklist_id === $post->ID ) {
						$states[] = esc_html__( 'Startup tracklist', 'meloo-toolkit' );
					}
				} 
				
			}
		}

	    return $states;
	} 


	/**
	 * Get the theme option
	 * @return string|bool|array
	 */
	public function option( $option, $default = null ) {

		if ( $this->theme_panel !== null && is_array( $this->theme_panel ) ) {
	
			if ( isset( $this->theme_panel[ $option ] ) ) {
				return $this->theme_panel[ $option ];
			} elseif ( $default !== null ) {
				return $default;
			} else {	
				return false;
			}

		} elseif ( $default !== null ) {
			return $default;
		} else {
			return false;
		}
	}


	/**
	 * Display escaped text.
	 * @param  $text
	 * @return string
	 */
	public function esc( $text ) {
		$text = preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $text );
		return $text;
	}


	/**
	 * Display escaped text through echo function.
	 * @param  $text
	 * @return string
	 */
	public function e_esc( $text ) {
		echo preg_replace( array('/<(\?|\%)\=?(php)?/', '/(\%|\?)>/'), array('',''), $text );
	}

}