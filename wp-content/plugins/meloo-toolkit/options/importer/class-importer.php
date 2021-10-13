<?php

/**
 * Rascals Importer Data
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


// Include main RascalsImporter class
include_once( RASCALS_TOOLKIT_PATH . '/core/importer/class-importer.php' );

if ( ! class_exists( 'Meloo_Toolkit_Importer' ) ) {
	class Meloo_Toolkit_Importer extends RascalsImporter {

		/**
		 * Set framewok
		 *
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $theme_options_framework = 'RascalsPanel';


		public $flag_as_imported;

		/**
		 * Show Console
		 *
		 *
		 * @since 0.0.3
		 *
		 * @var string
		 */
		public $wp_importer_console = 'hidden'; // hidden or empty


		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;


		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var array
		 */
		public $importer_options;

		/**
		 * Set the key to be used to store theme options
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $theme_option_name  = 'meloo_panel_opts'; 


		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Required plugins
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $required_plugins;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {


			// Set demos path
			$this->demo_files_path = dirname(__FILE__) . '/'; 
			$this->demo_files_url = RASCALS_TOOLKIT_URL . '/options/importer/';
			
			/* ==================================================
			   Main Demos
			================================================== */ 
			$this->importer_options = array(


				/* DEMO1 - Blog Page (Dark)
				 -------------------------------- */
				array(
					'id'		   	 	 => 'demo1',
					'name'   	 		 => 'Blog Page (Dark)',
					'thumb'				 => 'demo1/thumb.jpg', 
					'content_files'      =>  array(
						array(
							'file_path' => 'demo1/content_media.xml',
						),
						array(
							'file_path' => 'demo1/content.xml',
						),
					),
					'widget_file'        => 'demo1/widgets.wie',
					'customizer_file'    => 'demo1/customizer.dat',
					'panel_options_file' => 'demo1/theme_options.txt',
					'rev_sliders_files'	 => 'rev_sliders',
					'import_notice'      => '',
				),

				/* DEMO2 - One Page (Dark)
				 -------------------------------- */
				array(
					'id'		   	 	 => 'demo2',
					'name'   	 		 => 'One Page (Dark)',
					'thumb'				 => 'demo1/thumb2.jpg', 
					'content_files'      =>  array(
						array(
							'file_path' => 'demo1/content_media.xml',
						),
						array(
							'file_path' => 'demo1/content.xml',
						),
					),
					'widget_file'        => 'demo1/widgets.wie',
					'customizer_file'    => 'demo1/customizer.dat',
					'panel_options_file' => 'demo1/theme_options.txt',
					'rev_sliders_files'	 => 'rev_sliders',
					'import_notice'      => '',
				),


				/* DEMO3 - Hip Hop Artist (Dark)
				 -------------------------------- */
				array(
					'id'		   	 	 => 'demo3',
					'name'   	 		 => 'Hip-Hop Artist (Dark)',
					'thumb'				 => 'demo1/thumb3.jpg', 
					'content_files'      =>  array(
						array(
							'file_path' => 'demo1/content_media.xml',
						),
						array(
							'file_path' => 'demo1/content.xml',
						),
					),
					'widget_file'        => 'demo1/widgets.wie',
					'customizer_file'    => 'demo1/customizer.dat',
					'panel_options_file' => 'demo1/theme_options.txt',
					'rev_sliders_files'	 => 'rev_sliders',
					'import_notice'      => '',
				),


				/* DEMO4 - Blog (Light)
				 -------------------------------- */
				array(
					'id'		   	 	 => 'demo4',
					'name'   	 		 => 'Blog Page (Light)',
					'thumb'				 => 'demo2/thumb.jpg', 
					'content_files'      =>  array(
						array(
							'file_path' => 'demo2/content_media.xml',
						),
						array(
							'file_path' => 'demo2/content.xml',
						),
					),
					'widget_file'        => 'demo2/widgets.wie',
					'customizer_file'    => 'demo2/customizer.dat',
					'panel_options_file' => 'demo2/theme_options.txt',
					'rev_sliders_files'	 => 'rev_sliders',
					'import_notice'      => '',
				),


				/* DEMO5 - One Page (Light)
				 -------------------------------- */
				array(
					'id'		   	 	 => 'demo5',
					'name'   	 		 => 'One Page (Light)',
					'thumb'				 => 'demo2/thumb2.jpg', 
					'content_files'      =>  array(
						array(
							'file_path' => 'demo2/content_media.xml',
						),
						array(
							'file_path' => 'demo2/content.xml',
						),
					),
					'widget_file'        => 'demo2/widgets.wie',
					'customizer_file'    => 'demo2/customizer.dat',
					'panel_options_file' => 'demo2/theme_options.txt',
					'rev_sliders_files'	 => 'rev_sliders',
					'import_notice'      => '',
				),


				/* DEMO6 - Hip Hop Artist (Light)
				 -------------------------------- */
				array(
					'id'		   	 	 => 'demo6',
					'name'   	 		 => 'Hip-Hop Artist (Light)',
					'thumb'				 => 'demo2/thumb3.jpg', 
					'content_files'      =>  array(
						array(
							'file_path' => 'demo2/content_media.xml',
						),
						array(
							'file_path' => 'demo2/content.xml',
						),
					),
					'widget_file'        => 'demo2/widgets.wie',
					'customizer_file'    => 'demo2/customizer.dat',
					'panel_options_file' => 'demo2/theme_options.txt',
					'rev_sliders_files'	 => 'rev_sliders',
					'import_notice'      => '',
				),

			);


			
			$this->required_plugins = array(
				array(
				    	'path' => 'kingcomposer/kingcomposer.php',
				    	'name' => esc_html__( 'KingComposer - The most professional WordPress page builder plugin, it\'s weight and high efficiency to help you build any layout design quickly.', 'meloo-toolkit' )
				    ),
			    array(
			    	'path' => 'kirki/kirki.php',
			    	'name' => esc_html__( 'Kirki - Theme customization options.', 'meloo-toolkit' )
			    ),
			    array(
			    	'path' => 'meloo-toolkit/meloo-toolkit.php',
			    	'name' => esc_html__( 'Meloo Toolkit - This is a complimentary plugin for the Rascals WordPress themes. You can use it to create, manage and update Custom Posts Types, Widgets, Modules, Customizer Options.', 'meloo-toolkit' )
			    )
			);

			self::$instance = $this;	
			parent::__construct();

		}


		/**
		 * Run this function before demo import
		 * @param  string $demo_id - Demo imported ID
		 * @return void
		 */
		public function before_import(){

			
			/* Remove Default Widgets from sidebar
			 -------------------------------- */
			
			/* Sidebar slugname */
			$sidebar = 'primary-sidebar';

			$sidebars_widgets = get_option( 'sidebars_widgets' );
		 	if ( isset( $sidebars_widgets ) && is_array( $sidebars_widgets ) ) {
		 		if ( isset( $sidebars_widgets[$sidebar] ) ) {
		 			$sidebars_widgets[$sidebar] = array();
		 			update_option( 'sidebars_widgets', $sidebars_widgets );
		 		}
		 	} 
		}


		/**
		 * Run this function after demo import
		 * @param  string $demo_id - Demo imported ID
		 * @return void
		 */
		public function after_import($demo_id){


			/* Set demo name
			 -------------------------------- */  

			$demo_name = 'main';

			switch ($demo_id) {
				case 'demo1':
				case 'demo2':
				case 'demo3':
				case 'demo4':
				case 'demo5':
				case 'demo6':
					$demo_name = 'main';
					break;
				
				default:
					$demo_name = 'main';
					break;
			}


			/* ==================================================
			  Main DEMO 
			================================================== */

			if ( $demo_name == 'main' ) {


				/* Set homepage
				 -------------------------------- */

				/* Homepage slugname */

				/* Get home page name depends on demo */
				switch ($demo_id) {
					case 'demo1':
					case 'demo4':
						$homepage_name = 'Home 1 - Blog';
						break;
					case 'demo2':
					case 'demo5':
						$homepage_name = 'Home - One Page';
						break;
					case 'demo3':
					case 'demo6':
						$homepage_name = 'Home - Hip-Hop';
						break;
					default:
						
						break;
				}

				$home_id = get_page_by_title( $homepage_name );
				if ( isset( $home_id ) ) {
					update_option( 'page_on_front', $home_id->ID );
					update_option( 'show_on_front', 'page' );
				}

				
				/* Set Menus Locations
				 -------------------------------- */

				/* Get menu name depends on demo */
				/* One Page */
				if ( $demo_id == 'demo2' || $demo_id == 'demo5'  ) {
					$menu_name = 'One Page Menu';

					// Set One Page ID in customizer
					$page = get_page_by_title( 'Home - One Page' );
				    if ( isset( $page ) ) {
				        set_theme_mod( 'one_page_id', $page->ID );
				    } 

				/* Others demos */
				} else {
					$menu_name = 'Main menu';
				}

				$main_menu     = get_term_by( 'name', $menu_name, 'nav_menu' );
				if ( $main_menu ) {	
					set_theme_mod( 'nav_menu_locations', array(
							'main' => $main_menu->term_id
						)
					);
				}
				$this->flag_as_imported['menus'] = true;


				/* One Page Menu
				 -------------------------------- */
				if ( $menu_name == 'One Page Menu' ) {
					/* Settings */
					$one_page_menu = get_term_by( 'name', $menu_name, 'nav_menu' );

					/* Get One Page URL */
					$one_page_url = get_permalink( get_page_by_title( 'Home - One Page' ) );
					
					/* Set One Page URL */
					if ( $one_page_menu && $one_page_url ) {
						$menu_obj = wp_get_nav_menu_items( $one_page_menu );

						foreach ( $menu_obj as $menu_item ) {
							$matches = null;
							$hash = preg_match('/#.*/', $menu_item->url, $matches);
							if ( $hash ) {
								$menu_item->url = $one_page_url . $matches[0];
							}
							update_post_meta( $menu_item->ID, '_menu_item_url', $menu_item->url );

							if ( $menu_item->title == 'Recent' ){
								update_post_meta( $menu_item->ID, '_menu_item_super_menu_type', 'music__slider' );
								update_post_meta( $menu_item->ID, '_menu_item_super_menu_music_cat_id', 'breakbeat' );
							}
						}

					}
				}


				/* Set Super Menu 
				 -------------------------------- */
				if ( $main_menu  ) {
					$menu_obj = wp_get_nav_menu_items( $main_menu );
					foreach ( $menu_obj as $menu_item ) {

						/* Reviews */
						if ( $menu_item->title == 'Reviews' ){
							update_post_meta( $menu_item->ID, '_menu_item_super_menu_type', 'music__slider' );
							update_post_meta( $menu_item->ID, '_menu_item_super_menu_music_cat_id', 'breakbeat' );
						}
						if ( $menu_item->title == 'Music' ){
							update_post_meta( $menu_item->ID, '_menu_item_super_menu_type', 'super-menu' );
						}
						if ( $menu_item->title == 'Events' ){
							update_post_meta( $menu_item->ID, '_menu_item_super_menu_type', 'super-menu' );
						}
						if ( $menu_item->title == 'News' ){
							update_post_meta( $menu_item->ID, '_menu_item_super_menu_type', 'super-menu' );
						}

					}

				}

			} // end Main demo

		}


	}

	return new Meloo_Toolkit_Importer();
}