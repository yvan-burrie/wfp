<?php
/**
 * Plugin Name:       Meloo Toolkit
 * Plugin URI:        http://rascalsthemes.com/
 * Description:       This is a Meloo Toolkit plugin for the Meloo WordPress theme. This plugin extends theme functionality. Is a required part of the theme.
 * Version:           1.2.3
 * Author:            Rascals Themes
 * Author URI:        http://rascalsthemes.com
 * Text Domain:       meloo-toolkit
 * License:           See "Licensing" Folder
 * License URI:       See "Licensing" Folder
 * Domain Path:       /languages
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Meloo_Toolkit' ) ) {

	/**
	 * Main Meloo_Toolkit Class
	 *
	 * Contains the main functions for Meloo_Toolkit
	 *
	 * @package         Meloo_Toolkit
	 * @author          Rascals Themes
	 * @copyright       Rascals Themes
 	 * @version       	1.0.3
	 */
	class Meloo_Toolkit {


		/* Other variables
		 -------------------------------- */
		
		// @var string
		public $theme_slug = 'meloo';

		// @var string
		public $theme_panel = 'meloo_panel_opts';

		// @var string
		public $version = '1.0.0';

		// @var integer
		public static $id = 0;

		// @var Single instance of the class
		private static $_instance;


		/**
		 * Meloo Toolkit Instance
		 *
		 * Ensures only one instance of Meloo Toolkit is loaded or can be loaded.
		 *
		 * @static
		 * @return Meloo Toolkit - Main instance
		 */
		public static function getInstance() {
			if ( ! ( self::$_instance instanceof self ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Meloo Toolkit Constructor.
		 * @return void
		 */
		public function __construct() {
			
			// Set localisation
			$this->loadPluginTextdomain();

			// Get theme panel options
			$option_name = $this->theme_panel;
			$this->theme_panel = get_option( $option_name );

			$this->defineConstants();
			include_once( $this->pluginPath() . '/core/core-translate.php' );
			$this->initCore();
			$this->initOptions();
			$this->initHooks();

			do_action( 'meloo_toolkit_loaded' );
		}

		/**
		 * Include required core files used in core
		 * @return void
		 */
		public function initCore() {

			if ( is_admin() ) {
				// Admin Pages
				include_once( $this->pluginPath() . '/core/admin-pages/class-admin.php' );
			}
			
			// Tools
			include_once( $this->pluginPath() . '/core/tools/tools.php' );

			// Widgets
			include_once( $this->pluginPath() . '/core/widgets/class-widgets.php' );

			add_action( 'plugins_loaded', 'rascals_core_set_revoslider' );
			
			// Resize
			include_once( $this->pluginPath() . '/core/image-resize/class-image-resize.php' );

		}


		/**
		 * Include required theme options
		 * @return void
		 */
		public function initOptions() {
			
			// Admin
			if ( is_admin() ) {

				// Importer
				include_once( $this->pluginPath() . '/options/importer/class-importer.php' );

				// Metaboxes
				include_once( $this->pluginPath() . '/options/metaboxes/metaboxes.php' );

			}

			// Frontend

			// Load toolkit functions
			include_once( $this->pluginPath() . '/options/toolkit/toolkit.php' );

			// Twitter
			include_once( $this->pluginPath() . '/options/twitter/class-twitter.php' );

			// Shortcodes
			include_once( $this->pluginPath() . '/options/shortcodes/shortcodes.php' );

			// Register custom post types
			include_once( $this->pluginPath() . '/options/post-types/class-posts.php' );

			// Scamp Player
			include_once( $this->pluginPath() . '/options/scamp-player/class-scamp-player.php' );
			include_once( $this->pluginPath() . '/options/scamp-player/shortcodes-scamp-player.php' );
			$this->scamp_player = new RascalsScampPlayer( array( 
				'theme_name' => 'meloo', 
				'theme_panel' => $this->theme_panel,
				'post_type' => 'meloo_tracks'
			) );


			// King Composer
			include_once( $this->pluginPath() . '/options/king-composer/class-kc.php' );
			$this->kc = new RascalsKC( array( 
				'theme_name'    => 'meloo', 
				'theme_panel'   => $this->theme_panel,
				'supported_cpt' => array( 'meloo_music', 'meloo_events', 'meloo_gallery', 'meloo_videos', 'meloo_artists' ),
				'default_fonts' => '{"Roboto":["cyrillic-ext%2Ccyrillic%2Cgreek%2Cvietnamese%2Clatin%2Clatin-ext%2Cgreek-ext","100%2C100italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic","latin-ext","100%2C100italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic"],"Barlow%20Condensed":["latin%2Clatin-ext","100%2C100italic%2C200%2C200italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic","latin%2Clatin-ext","regular%2C500%2C600%2C700%2C800%2C900"],"Space%20Mono":["vietnamese%2Clatin%2Clatin-ext","regular%2Citalic%2C700%2C700italic","latin%2Clatin-ext","regular%2Citalic"]}'
			) );

			// Widgets
			add_action( 'widgets_init', array( $this, 'registerWidget' ) );
			
			// Customizer Installer
			include_once( $this->pluginPath() . '/options/customizer/class-customizer-install.php' );
			include_once( $this->pluginPath() . '/options/customizer/class-customizer.php' );
			$this->customizer = new RascalsCustomizer();


			// Super menu
			require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
			include_once( $this->pluginPath() . '/options/super-menu/super-menu-walker.php' );
			
		}

		/**
	 * Register widgets function.
	 *
	 * @return void
	 */
		public function registerWidget() {

			// Recent Posts
			include_once( $this->pluginPath() . '/options/widgets/class-widget-recent-posts.php' );
			register_widget( 'RascalsRecentPostsWidget' );

			// Instagram feed
			include_once( $this->pluginPath() . '/options/widgets/class-widget-instafeed.php' );
			register_widget( 'RascalsInstafeedWidget' );

			// Instagram feed
			include_once( $this->pluginPath() . '/options/widgets/class-widget-ad.php' );
			register_widget( 'RascalsADWidget' );

		}

		/**
		 * Hook into actions and filters
		 * @return void
		 */
		private function initHooks() {

			add_action( 'admin_bar_menu', array( $this, 'showAdminBar' ), 100 );
			add_action( 'init', array( $this, 'init' ), 0 );
		}


 		/**
 		 * Init hooks when WordPress Initialises.
 		 * @return void
 		 */
		public function init() {

			// Before init action
			do_action( 'before_meloo_toolkit_init' );		

			// Init action
			do_action( 'meloo_toolkit_init' );
		}


		/**
		 * Define constants
		 * @return void
		 */
		public function defineConstants() {

			// Panel name
			define( 'RASCALS_THEME_PANEL', $this->theme_panel );

			// Plugin's directory path.
			define( 'RASCALS_TOOLKIT_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

			// Plugin's directory URL.
			define( 'RASCALS_TOOLKIT_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );

		}


		/**
		 * Loads the plugin text domain for translation
		 * @return void
		 */
		public function loadPluginTextdomain() {

			$domain = 'meloo-toolkit';
			$locale = apply_filters( 'meloo-toolkit', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}


		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function pluginUrl() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}


		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function pluginPath() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Show admin bar hook
		 * @return void
		 */
		public function showAdminBar() {

			global $wp_admin_bar;
		
			if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
				return;
			}

			$wp_admin_bar->add_menu(
				array( 
					'id'    => 'admin-welcome', 
					'title' => '<span class="ab-icon rascals-admin-link"></span> ' . esc_html__( 'Theme Settings', 'meloo-toolkit' ), 
					'href'  => get_bloginfo('wpurl') . '/wp-admin/admin.php?page=' . 'admin-welcome'
				)
			);
		}

	}
}


// Returns the main instance of Meloo_Toolkit to prevent the need to use globals.
function melooToolkit() {
	return Meloo_Toolkit::getInstance();
}

melooToolkit(); // Run