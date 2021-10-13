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


class RascalsKC {

	/**
	 * Private variables
	 */
	private $theme = 'rascals';
	private $theme_panel = null;
	private $supported_cpt =  array( 'post', 'page' );
	private $default_fonts = null;
    private $inline_css = false;


	/**
	 * Rascals CPT Constructor.
	 * @return void
	 */
	public function __construct( $options ) {

		if ( $options !== null ) {
			$this->theme         = $options['theme_name'];
			$this->theme_panel   = $options['theme_panel'];
			$this->supported_cpt = $options['supported_cpt'];
            $this->default_fonts = $options['default_fonts'];
		}

		// Include KC functions
		include_once( RASCALS_TOOLKIT_PATH . '/options/king-composer/functions-kc.php' );

        // Remove not supported KC elements
        add_filter( 'kc_add_map', array( $this, 'removeKCElements' ), 1 , 2 );
        
		// Init
        add_action( 'init', array( $this, 'init' ),99 );

	}

	/**
	 * Initialize class
	 * @return void
	 */
	public function init() {

		// Exit if King Composer plugin is not installed
		if ( ! class_exists( 'KingComposer' ) ) {
			return;
		}

		// Load Frontend scripts and styles
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

		// Set default fonts
		$this->setFonts();

		// Add supported custom post types
		$this->addSupportedCPT();

		// Register KC elements
        $this->KC();

	}


	//////////////////////////
	// REGISTER KC ELEMENTS //
	//////////////////////////

	function KC() {

		global $kc;
    
        //get current plugin folder then define the template folder
        $plugin_template = RASCALS_TOOLKIT_PATH . '/options/king-composer/templates/';

        //register template folder with KingComposer
        $kc->set_template_path( $plugin_template );

        kc_add_map(

            array(

            	/* Revolution Slider
                 -------------------------------- */
                'rev_slider'  => array(
                    'name'        => esc_html__( 'Revolution Slider', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display videos in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-star',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Select Slider', 'meloo-toolkit' ),
                                'name'    => 'alias',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getRevoSliders(),
                                'description'   => esc_html__( 'Select Revolution Slider. Note: Revolution Slider doesn\'t refresh on visual mode. Please save and refesh manually your page to see slider.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),

                        ),
                       
                    )
                ),  // End of element kc


                 /* Artists Block
                 -------------------------------- */
                'kc_artists_block'    => array(
                    'name'        => esc_html__( 'Artists Block', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive artists profiles with many beautiful styles.', 'meloo-toolkit' ),
                    'icon'        => 'sl-user',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Block', 'meloo-toolkit' ),
                                'name'    => 'block',
                                'type'    => 'select',
                                'value'   => 'block1',
                                'options' => array(
                                    'block1' => esc_html__( 'Block 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Artists on Row', 'meloo-toolkit' ),
                                'name'    => 'articles_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Artist', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Artists', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Artists', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Artists', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Artists', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of items per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Pagination', 'meloo-toolkit' ),
                                'name'    => 'pagination',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''          => esc_html__( 'None', 'meloo-toolkit' ),
                                    'load_more' => esc_html__( 'Load More Button', 'meloo-toolkit' ),
                                    'infinite'  => esc_html__( 'Infinite Loading', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select ajax pagination.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Filter', 'meloo-toolkit' ),
                                'name'    => 'ajax_filter',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''                 => esc_html__( 'None', 'meloo-toolkit' ),
                                    'on-left'          => esc_html__( 'On Left', 'meloo-toolkit' ),
                                    'center'           => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'on-right'         => esc_html__( 'On Right', 'meloo-toolkit' ),
                                    'multiple-filters' => esc_html__( 'Multiple Filters', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Display Ajax filter above grid.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Selection Method', 'meloo-toolkit' ),
                                'name'    => 'filter_sel_method',
                                'type'    => 'select',
                                'value'   => 'filter-sel-multiple',
                                'options' => array(
                                    'filter-sel-multiple' => esc_html__( 'Multiple', 'meloo-toolkit' ),
                                    'filter-sel-single' => esc_html__( 'Single', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Select filter selection method.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('on-left', 'center', 'on-right', 'multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Show filters on Start', 'meloo-toolkit' ),
                                'name'    => 'show_filters',
                                'type'    => 'select',
                                'value'   => 'no',
                                'options' => array(
                                    'show-filters' => esc_html__( 'Yes', 'meloo-toolkit' ),
                                    'hide-filters' => esc_html__( 'No', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Show filters when page is loaded. Otherwise the filters are shown after clicking the "Filters" button.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getArtistsFilter(),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-videos-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-videos-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc

                
                /* Artists Carousel
                 -------------------------------- */
                'kc_artists_carousel'    => array(
                    'name'        => esc_html__( 'Artists Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display videos in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-user',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Video Module', 'meloo-toolkit' ),
                                'name'    => 'module',
                                'type'    => 'select',
                                'value'   => 'module1',
                                'options' => array(
                                    'module1' => esc_html__( 'Module 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select post module.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getArtistsFilter(), 
                       
                    )
                ),  // End of element kc


                /* Videos Carousel
                 -------------------------------- */
                'kc_videos_carousel'    => array(
                    'name'        => esc_html__( 'Videos Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display videos in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camrecorder',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Video Module', 'meloo-toolkit' ),
                                'name'    => 'module',
                                'type'    => 'select',
                                'value'   => 'module1',
                                'options' => array(
                                    'module1' => esc_html__( 'Module 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select post module.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'    => 'click_action',
                                'type'    => 'select',
                                'value'   => 'open_in_player',
                                'options' => array(
                                    'open_in_player'   => esc_html__( 'Open video in player', 'meloo-toolkit' ),
                                    'open_in_lightbox' => esc_html__( 'Open video in popup window', 'meloo-toolkit' ),
                                    'open_on_page'     => esc_html__( 'Open video on the new page', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Open video in popup window or on the page.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getVideosFilter(), 
                       
                    )
                ),  // End of element kc
                

                /* Videos Block
                 -------------------------------- */
                'kc_videos_block' => array(
                    'name'        => esc_html__( 'Videos Block', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive videos with many beautiful styles.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camrecorder',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Block', 'meloo-toolkit' ),
                                'name'    => 'block',
                                'type'    => 'select',
                                'value'   => 'block1',
                                'options' => array(
                                    'block1' => esc_html__( 'Block 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'    => 'click_action',
                                'type'    => 'select',
                                'value'   => 'open_in_player',
                                'options' => array(
                                    'open_in_player'   => esc_html__( 'Open video in player', 'meloo-toolkit' ),
                                    'open_in_lightbox' => esc_html__( 'Open video in popup window', 'meloo-toolkit' ),
                                    'open_on_page'     => esc_html__( 'Open video on the new page', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Open video in popup window or on the page.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                            ),
                            array(
                                'label'   => esc_html__( 'Videos on Row', 'meloo-toolkit' ),
                                'name'    => 'articles_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Video', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Videos', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Videos', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Videos', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Videos', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of items per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Pagination', 'meloo-toolkit' ),
                                'name'    => 'pagination',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''          => esc_html__( 'None', 'meloo-toolkit' ),
                                    'load_more' => esc_html__( 'Load More Button', 'meloo-toolkit' ),
                                    'infinite'  => esc_html__( 'Infinite Loading', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select ajax pagination.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Filter', 'meloo-toolkit' ),
                                'name'    => 'ajax_filter',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''                 => esc_html__( 'None', 'meloo-toolkit' ),
                                    'on-left'          => esc_html__( 'On Left', 'meloo-toolkit' ),
                                    'center'           => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'on-right'         => esc_html__( 'On Right', 'meloo-toolkit' ),
                                    'multiple-filters' => esc_html__( 'Multiple Filters', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Display Ajax filter above grid.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Selection Method', 'meloo-toolkit' ),
                                'name'    => 'filter_sel_method',
                                'type'    => 'select',
                                'value'   => 'filter-sel-multiple',
                                'options' => array(
                                    'filter-sel-multiple' => esc_html__( 'Multiple', 'meloo-toolkit' ),
                                    'filter-sel-single'   => esc_html__( 'Single', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Select filter selection method.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('on-left', 'center', 'on-right', 'multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Show filters on Start', 'meloo-toolkit' ),
                                'name'    => 'show_filters',
                                'type'    => 'select',
                                'value'   => 'no',
                                'options' => array(
                                    'show-filters' => esc_html__( 'Yes', 'meloo-toolkit' ),
                                    'hide-filters' => esc_html__( 'No', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Show filters when page is loaded. Otherwise the filters are shown after clicking the "Filters" button.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getVideosFilter(),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-videos-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-videos-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Video Cover
                 -------------------------------- */
                 'kc_video_cover'    => array(
                    'name'        => esc_html__( 'Video Cover', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display video with image cover.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camrecorder',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Video Source', 'meloo-toolkit' ),
                                'name'    => 'video_source',
                                'type'    => 'select',
                                'value'   => 'youtube',
                                'options' => array(
                                    'youtube' => esc_html__( 'YouTube', 'meloo-toolkit' ),
                                    'vimeo' => esc_html__( 'Vimeo', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Choose source of video.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__('Video link', 'meloo-toolkit'),
                                'name'        => 'video_link',
                                'type'        => 'text',
                                'value'       => '',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter the Youtube or Vimeo URL.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax_y',
                                'type'        => 'text',
                                'value'       => '0',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter parallax value e.g: 40 or -40. Note: ("0" disable effect)', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-big-event-date' ),
                                            array( 'property' => 'color', 'label' => 'Font Color', 'selector' => '.kc-big-event-date' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc

    
                /* Gallery Carousel
                 -------------------------------- */
                'kc_gallery_carousel'    => array(
                    'name'        => esc_html__( 'Gallery Albums Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display gallery albums in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camera',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Post Module', 'meloo-toolkit' ),
                                'name'    => 'module',
                                'type'    => 'select',
                                'value'   => 'module1',
                                'options' => array(
                                    'module1' => esc_html__( 'Module 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select post module.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getImageSizes( array(
                                        '' => esc_html__( 'Default', 'meloo-toolkit' )
                                    )
                                ),
                                'description'   => esc_html__( 'Select image size. By default, the image size is set for the selected module. Note: In some modules it is not possible to change image size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getGalleryFilter(), 
                       
                    )
                ),  // End of element kc


                /* Gallery Block
                 -------------------------------- */
                'kc_gallery_block'    => array(
                    'name'        => esc_html__( 'Gallery Albums', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive gallery with many beautiful styles.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camera',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Block', 'meloo-toolkit' ),
                                'name'    => 'block',
                                'type'    => 'select',
                                'value'   => 'block1',
                                'options' => array(
                                    'block1' => esc_html__( 'Block 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Items on Row', 'meloo-toolkit' ),
                                'name'    => 'articles_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Item', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Items', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Items', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Items', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Items', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of items per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Pagination', 'meloo-toolkit' ),
                                'name'    => 'pagination',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''          => esc_html__( 'None', 'meloo-toolkit' ),
                                    'load_more' => esc_html__( 'Load More Button', 'meloo-toolkit' ),
                                    'infinite'  => esc_html__( 'Infinite Loading', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select ajax pagination.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Filter', 'meloo-toolkit' ),
                                'name'    => 'ajax_filter',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''                 => esc_html__( 'None', 'meloo-toolkit' ),
                                    'on-left'          => esc_html__( 'On Left', 'meloo-toolkit' ),
                                    'center'           => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'on-right'         => esc_html__( 'On Right', 'meloo-toolkit' ),
                                    'multiple-filters' => esc_html__( 'Multiple Filters', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Display Ajax filter above grid.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Selection Method', 'meloo-toolkit' ),
                                'name'    => 'filter_sel_method',
                                'type'    => 'select',
                                'value'   => 'filter-sel-multiple',
                                'options' => array(
                                    'filter-sel-multiple' => esc_html__( 'Multiple', 'meloo-toolkit' ),
                                    'filter-sel-single'   => esc_html__( 'Single', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Select filter selection method.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('on-left', 'center', 'on-right', 'multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Show filters on Start', 'meloo-toolkit' ),
                                'name'    => 'show_filters',
                                'type'    => 'select',
                                'value'   => 'no',
                                'options' => array(
                                    'show-filters' => esc_html__( 'Yes', 'meloo-toolkit' ),
                                    'hide-filters' => esc_html__( 'No', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Show filters when page is loaded. Otherwise the filters are shown after clicking the "Filters" button.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getGalleryFilter(),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-gallery-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-gallery-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc
                
                
                /* Gallery Images Carousel
                 -------------------------------- */
                'kc_gallery_images_carousel'    => array(
                    'name'        => esc_html__( 'Gallery Images Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display album images in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camera',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Select Images Album', 'meloo-toolkit' ),
                                'name'        => 'album_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getPosts( 'meloo_gallery' ),
                                'description' => esc_html__( 'Select album. If there are no albums available, then you can add a album using Gallery menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
                                'name'    => 'limit',
                                'type'    => 'number_slider',
                                'value'   => '0',
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 40,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getImageSizes( array(
                                        '' => esc_html__( 'Default', 'meloo-toolkit' )
                                    )
                                ),
                                'description'   => esc_html__( 'Select image size. By default, the image size is set for the selected module. Note: In some modules it is not possible to change image size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                       
                    )
                ),  // End of element kc


                /* Gallery Images
                 -------------------------------- */
                'kc_gallery_images'    => array(
                    'name'        => esc_html__( 'Gallery Images', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display images from gallery album.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camera',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Select Images Album', 'meloo-toolkit' ),
                                'name'        => 'album_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getPosts( 'meloo_gallery' ),
                                'description' => esc_html__( 'Select album. If there are no albums available, then you can add a album using Gallery menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Images on Row', 'meloo-toolkit' ),
                                'name'    => 'images_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Image', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Images', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Images', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Images', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Images', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of items per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                            ),
                            array(
                                'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
                                'name'    => 'limit',
                                'type'    => 'number_slider',
                                'value'   => '0',
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 40,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-images-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-images-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc

                /* Gallery Images
                 -------------------------------- */
                'kc_gallery_images_mosaic'    => array(
                    'name'        => esc_html__( 'Gallery Mosaic Images', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display images from gallery album.', 'meloo-toolkit' ),
                    'icon'        => 'sl-camera',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Select Images Album', 'meloo-toolkit' ),
                                'name'        => 'album_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getPosts( 'meloo_gallery' ),
                                'description' => esc_html__( 'Select album. If there are no albums available, then you can add a album using Gallery menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
                                'name'    => 'limit',
                                'type'    => 'number_slider',
                                'value'   => '0',
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 40,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-images-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-images-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Stats List
                 -------------------------------- */
                'kc_stats'    => array(
                    'name'        => esc_html__( 'Stats List', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display stats list', 'meloo-toolkit' ),
                    'icon'        => 'sl-list',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__('Stats', 'meloo-toolkit'),
                                'name'        => 'stats',
                                'type'        => 'textarea',
                                'value'       => "gigs=1200\nhappy peoples=1266\nreleases=2356\ncoffees per year=1076\nred buls per year=2009\nvinyls=3238",
                                'admin_label' => false,
                                'description' => esc_html__( 'Add stats e.g.: coffees per year=1076 (Note: divide stats with linebreaks (Enter)). Minimum 6 stats.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Timer (s)', 'meloo-toolkit' ),
                                'name'        => 'timer',
                                'type'        => 'text',
                                'value'       => '10',
                                'admin_label' => false,
                                'description' => esc_html__( 'Timer in secounds.', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax_y',
                                'type'        => 'text',
                                'value'       => '0',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter parallax value e.g: 40 or -40. Note: ("0" disable effect)', 'meloo-toolkit' ),
                            ),
                             array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Button Style' => array(
                                            array( 'property' => 'color', 'label' => 'Text Color', 'selector' => '.kc-stats-inner' ),
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-stats-inner' ),
                                            array( 'property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.kc-stats-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-stats-inner' ),
                                            array( 'property' => 'width', 'label' => 'Column Width', 'selector' => '.kc-stats-inner li' ),
                                        ),
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Event Countdown
                 -------------------------------- */
                 'kc_event_countdown'    => array(
                    'name'        => esc_html__( 'Event Countdown', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display current event countdown.', 'meloo-toolkit' ),
                    'icon'        => 'sl-clock',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Size', 'meloo-toolkit' ),
                                'name'    => 'size',
                                'type'    => 'select',
                                'value'   => 'big',
                                'options' => array(
                                    'big' => esc_html__( 'Big', 'meloo-toolkit' ),
                                    'small' => esc_html__( 'Small', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Select Custom Event?', 'meloo-toolkit' ),
                                'name'        => 'is_custom_id',
                                'type'        => 'toggle',
                                'value'       => '',
                                'admin_label' => false,
                            ),
                            array(
                                'label'   => esc_html__( 'Select Event', 'meloo-toolkit' ),
                                'name'    => 'custom_id',
                                'type'    => 'select',
                                'value'   => 'hello',
                                'options' => $this->getEvents(),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'is_custom_id',
                                    'show_when' => array( 'yes' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax_y',
                                'type'        => 'text',
                                'value'       => '40',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter parallax value e.g: 40 or -40. Note: ("0" disable effect)', 'meloo-toolkit' ),
                            ),
                           array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Countdown' => array(
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-countdown' ),
                                            array( 'property' => 'color', 'label' => 'Font Color', 'selector' => '.kc-countdown' ),
                                        ),
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-countdown-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-countdown-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Events Block
                 -------------------------------- */
                'kc_events_block'    => array(
                    'name'        => esc_html__( 'Events Block', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive events blocks with many beautiful styles.', 'meloo-toolkit' ),
                    'icon'        => 'sl-plane',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Block', 'meloo-toolkit' ),
                                'name'    => 'block',
                                'type'    => 'select',
                                'value'   => 'block1',
                                'options' => array(
                                    'block1' => esc_html__( 'Block 1 - List', 'meloo-toolkit' ),
                                    'block2' => esc_html__( 'Block 2 - Grid', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Items on Row', 'meloo-toolkit' ),
                                'name'    => 'articles_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Item', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Items', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Items', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Items', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Items', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of items per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block2')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Pagination', 'meloo-toolkit' ),
                                'name'    => 'pagination',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''          => esc_html__( 'None', 'meloo-toolkit' ),
                                    'load_more' => esc_html__( 'Load More Button', 'meloo-toolkit' ),
                                    'infinite'  => esc_html__( 'Infinite Loading', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select ajax pagination.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1', 'block2')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Filter', 'meloo-toolkit' ),
                                'name'    => 'ajax_filter',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''                 => esc_html__( 'None', 'meloo-toolkit' ),
                                    'on-left'          => esc_html__( 'On Left', 'meloo-toolkit' ),
                                    'center'           => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'on-right'         => esc_html__( 'On Right', 'meloo-toolkit' ),
                                    'multiple-filters' => esc_html__( 'Multiple Filters', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Display Ajax filter above grid.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block1', 'block2' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Selection Method', 'meloo-toolkit' ),
                                'name'    => 'filter_sel_method',
                                'type'    => 'select',
                                'value'   => 'filter-sel-multiple',
                                'options' => array(
                                    'filter-sel-multiple' => esc_html__( 'Multiple', 'meloo-toolkit' ),
                                    'filter-sel-single' => esc_html__( 'Single', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Select filter selection method.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('on-left', 'center', 'on-right', 'multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Show filters on Start', 'meloo-toolkit' ),
                                'name'    => 'show_filters',
                                'type'    => 'select',
                                'value'   => 'no',
                                'options' => array(
                                    'show-filters' => esc_html__( 'Yes', 'meloo-toolkit' ),
                                    'hide-filters' => esc_html__( 'No', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Show filters when page is loaded. Otherwise the filters are shown after clicking the "Filters" button.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getEventsFilter(),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-events-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-events-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Event Details
                 -------------------------------- */
                'kc_event_details'    => array(
                    'name'        => esc_html__( 'Event Details', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display event details e.g.: Date, Time...', 'meloo-toolkit' ),
                    'icon'        => 'sl-info',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                             array(
                                'label'       => esc_html__('Date Format', 'meloo-toolkit'),
                                'name'        => 'date_format',
                                'type'        => 'text',
                                'value'       => 'l F j Y',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter Date format.', 'meloo-toolkit' )
                            ),
                           array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Button Style' => array(
                                            array( 'property' => 'color', 'label' => 'Text Color', 'selector' => '.kc-event-details-inner' ),
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-event-details-inner' ),
                                            array( 'property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.kc-event-details-inner' ),
                                            array( 'property' => 'text-align', 'label' => 'Align', 'selector' => '.kc-event-details-inner' ),
                                            array( 'property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.kc-event-details-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-event-details-inner' ),
                                        ),
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc

                /* Share Buttons
                 -------------------------------- */
                'kc_share_buttons'    => array(
                    'name'        => esc_html__( 'Share Buttons', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display share buttons.', 'meloo-toolkit' ),
                    'icon'        => 'sl-share',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'Custom class for wrapper of the shortcode widget.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Button Style' => array(
                                            array( 'property' => 'color', 'label' => 'Text Color', 'selector' => 'a.micro-share' ),
                                            array( 'property' => 'background-color', 'label' => 'Background Color', 'selector' => 'a.micro-share' ),
                                            array( 'property' => 'text-align', 'label' => 'Align', 'selector' => '.kc-share-buttons-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-share-buttons-inner' ),
                                        ),
                                        'Mouse Hover' => array(
                                            array( 'property' => 'color', 'label' => 'Text Color', 'selector' => 'a.micro-share:hover' ),
                                            array( 'property' => 'background-color', 'label' => 'Background Color', 'selector' => 'a.micro-share:hover' ),
                                        )
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Fancy Button
                 -------------------------------- */
                'kc_fancy_button'    => array(
                    'name'        => esc_html__( 'Fancy Button', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive button with many beautiful styles to attract your viewers at first click.', 'meloo-toolkit' ),
                    'icon'        => 'sl-star',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(

                            array(
                                'label'       => esc_html__('Title', 'meloo-toolkit'),
                                'name'        => 'text_title',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'Add the text that appears on the button.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Link', 'meloo-toolkit'),
                                'name'        => 'link',
                                'type'        => 'link',
                                'admin_label' => false,
                                'description' => esc_html__( 'Add your relative URL. Each URL contains link, anchor text and target attributes.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'   => esc_html__( 'Style', 'meloo-toolkit' ),
                                'name'    => 'style',
                                'type'    => 'select',
                                'value'   => 'default',
                                'options' => array(
                                    'default' => esc_html__( 'Default', 'meloo-toolkit' ),
                                    'frame' => esc_html__( 'Frame Button', 'meloo-toolkit' ),
                                    'line' => esc_html__( 'Line Link', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select button style.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax_y',
                                'type'        => 'text',
                                'value'       => '40',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter parallax value e.g: 40 or -40. Note: ("0" disable effect)', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'       => esc_html__('Button extra class', 'meloo-toolkit'),
                                'name'        => 'ex_class',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'Add class name for a tag.', 'meloo-toolkit' )
                            ),

                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Button Style' => array(
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-btn' ),
                                            array( 'property' => 'color', 'label' => 'Text Color', 'selector' => '.kc-btn' ),
                                            array( 'property' => 'background-color', 'label' => 'Background Color', 'selector' => '.kc-btn' ),
                                            array( 'property' => 'text-align', 'label' => 'Align', 'selector' => '.kc-fancy-button-inner, .kc-btn' ),
                                            array( 'property' => 'text-transform', 'label' => 'Text Transform', 'selector' => '.kc-btn' ),
                                            array( 'property' => 'width', 'selector' => '.kc-fancy-button-wrap, .kc-btn' ),
                                            array( 'property' => 'letter-spacing', 'label' => 'Letter Spacing', 'selector' => '.kc-btn' ),
                                            array( 'property' => 'padding', 'label' => 'Padding', 'selector' => '.kc-btn' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-fancy-button-inner' ),
                                        ),
                                        'Mouse Hover' => array(
                                            array( 'property' => 'color', 'label' => 'Text Color', 'selector' => '.kc-btn:hover' ),
                                            array( 'property' => 'background-color', 'label' => 'Background Color', 'selector' => '.kc-btn:hover' ),
                                        )
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc
                
               
                /* Event date
                 -------------------------------- */
                 'kc_event_date'    => array(
                    'name'        => esc_html__( 'Events Date', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display big event date.', 'meloo-toolkit' ),
                    'icon'        => 'sl-star',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            
                            array(
                                'label'       => esc_html__('Date Format', 'meloo-toolkit'),
                                'name'        => 'date_format',
                                'type'        => 'text',
                                'value'       => 'm/d',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter Date format.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax_y',
                                'type'        => 'text',
                                'value'       => '40',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter parallax value e.g: 40 or -40. Note: ("0" disable effect)', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-big-event-date' ),
                                            array( 'property' => 'color', 'label' => 'Font Color', 'selector' => '.kc-big-event-date' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Music Block
                 -------------------------------- */
                'kc_music_block'  => array(
                    'name'        => esc_html__( 'Music Block', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive music blocks with many beautiful styles.', 'meloo-toolkit' ),
                    'icon'        => 'sl-music-tone',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Block', 'meloo-toolkit' ),
                                'name'    => 'block',
                                'type'    => 'select',
                                'value'   => 'block1',
                                'options' => array(
                                    'block1' => esc_html__( 'Block 1 (3 posts)', 'meloo-toolkit' ),
                                    'block2' => esc_html__( 'Block 2 (3 posts)', 'meloo-toolkit' ),
                                    'block3' => esc_html__( 'Block 3 (5 posts)', 'meloo-toolkit' ),
                                    'block4' => esc_html__( 'Block 4', 'meloo-toolkit' ),
                                    'block5' => esc_html__( 'Block 5', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Items on Row', 'meloo-toolkit' ),
                                'name'    => 'articles_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Item', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Items', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Items', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Items', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Items', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of items per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block4', 'block5' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Module Size', 'meloo-toolkit' ),
                                'name'    => 'module_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    '' => esc_html__( 'From Block Settings', 'meloo-toolkit' ),
                                    'small-module' => esc_html__( 'Small', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select module size. Note: In some blocks it is not possible to change the size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => true,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array( 'block1', 'block2', 'block3', 'block4', 'block5' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Pagination', 'meloo-toolkit' ),
                                'name'    => 'pagination',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''          => esc_html__( 'None', 'meloo-toolkit' ),
                                    'load_more' => esc_html__( 'Load More Button', 'meloo-toolkit' ),
                                    'infinite'  => esc_html__( 'Infinite Loading', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select ajax pagination.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block4', 'block5')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Ajax Filter', 'meloo-toolkit' ),
                                'name'    => 'ajax_filter',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''         => esc_html__( 'None', 'meloo-toolkit' ),
                                    'on-left'  => esc_html__( 'On Left', 'meloo-toolkit' ),
                                    'center'   => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'on-right' => esc_html__( 'On Right', 'meloo-toolkit' ),
                                    'multiple-filters' => esc_html__( 'Multiple Filters', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Display Ajax filter above grid.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block4', 'block5' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Selection Method', 'meloo-toolkit' ),
                                'name'    => 'filter_sel_method',
                                'type'    => 'select',
                                'value'   => 'filter-sel-multiple',
                                'options' => array(
                                    'filter-sel-multiple' => esc_html__( 'Multiple', 'meloo-toolkit' ),
                                    'filter-sel-single' => esc_html__( 'Single', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Select filter selection method.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('on-left', 'center', 'on-right', 'multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Show filters on Start', 'meloo-toolkit' ),
                                'name'    => 'show_filters',
                                'type'    => 'select',
                                'value'   => 'no',
                                'options' => array(
                                    'show-filters' => esc_html__( 'Yes', 'meloo-toolkit' ),
                                    'hide-filters' => esc_html__( 'No', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Show filters when page is loaded. Otherwise the filters are shown after clicking the "Filters" button.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'ajax_filter',
                                    'show_when' => array('multiple-filters')
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getMusicFilter(),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-music-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-music-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Posts Block
                 -------------------------------- */
                'kc_posts_block'    => array(
                    'name'        => esc_html__( 'Posts Block', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive recent posts with many beautiful styles.', 'meloo-toolkit' ),
                    'icon'        => 'sl-docs',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Block', 'meloo-toolkit' ),
                                'name'    => 'block',
                                'type'    => 'select',
                                'value'   => 'block1',
                                'options' => array(
                                    'block1' => esc_html__( 'Block 1 (3 posts)', 'meloo-toolkit' ),
                                    'block2' => esc_html__( 'Block 2 (3 posts)', 'meloo-toolkit' ),
                                    'block3' => esc_html__( 'Block 3 (5 posts)', 'meloo-toolkit' ),
                                    'block4' => esc_html__( 'Block 4', 'meloo-toolkit' ),
                                    'block5' => esc_html__( 'Block 5', 'meloo-toolkit' ),
                                    'block6' => esc_html__( 'Block 6', 'meloo-toolkit' ),
                                    'block7' => esc_html__( 'Block 7', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select posts block.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Articles on Row', 'meloo-toolkit' ),
                                'name'    => 'articles_number',
                                'type'    => 'select',
                                'value'   => '2',
                                'options' => array(
                                    '1' => esc_html__( '1 Article', 'meloo-toolkit' ),
                                    '2' => esc_html__( '2 Articles', 'meloo-toolkit' ),
                                    '3' => esc_html__( '3 Articles', 'meloo-toolkit' ),
                                    '4' => esc_html__( '4 Articles', 'meloo-toolkit' ),
                                    '5' => esc_html__( '5 Articles', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select number of articles per row.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array('block4', 'block5', 'block6', 'block7', 'block8' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Show Excerpt', 'meloo-toolkit' ),
                                'name'        => 'excerpt',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show or hide short post description under title.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array( 'block5', 'block6', 'block7', 'block9' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getImageSizes( array(
                                        '' => esc_html__( 'From Block Settings', 'meloo-toolkit' )
                                    )
                                ),
                                'description'   => esc_html__( 'Select image size. By default, the image size is set for the selected module. Note: In some blocks it is not possible to change image size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array( 'block1', 'block2', 'block3', 'block4', 'block5', 'block6', 'block7', 'block8' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Module Size', 'meloo-toolkit' ),
                                'name'    => 'module_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    '' => esc_html__( 'From Block Settings', 'meloo-toolkit' ),
                                    'small-module' => esc_html__( 'Small', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select module size. Note: In some blocks it is not possible to change the size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => true,
                                'relation'    => array(
                                    'parent'    => 'block',
                                    'show_when' => array( 'block1', 'block2', 'block3', 'block4', 'block5', 'block6', 'block7', 'block8' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getBlogFilter(),
                    'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-posts-block-inner' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-posts-block-inner' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc
                

                /* Events Carousel
                 -------------------------------- */
                'kc_events_carousel'    => array(
                    'name'        => esc_html__( 'Events Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display events in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-clock',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Post Module', 'meloo-toolkit' ),
                                'name'    => 'module',
                                'type'    => 'select',
                                'value'   => 'module2',
                                'options' => array(
                                    'module2' => esc_html__( 'Module 1', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select post module.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getImageSizes( array(
                                        '' => esc_html__( 'Default', 'meloo-toolkit' )
                                    )
                                ),
                                'description'   => esc_html__( 'Select image size. By default, the image size is set for the selected module. Note: In some modules it is not possible to change image size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getEventsFilter(), 
                       
                    )
                ),  // End of element kc


                /* Music Carousel
                 -------------------------------- */
                'kc_music_carousel'    => array(
                    'name'        => esc_html__( 'Music Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display music in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-earphones',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Post Module', 'meloo-toolkit' ),
                                'name'    => 'module',
                                'type'    => 'select',
                                'value'   => 'module1',
                                'options' => array(
                                    'module1' => esc_html__( 'Module 1', 'meloo-toolkit' ),
                                    'module2' => esc_html__( 'Module 2', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select post module.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__( 'Show Excerpt', 'meloo-toolkit' ),
                                'name'        => 'excerpt_carousel',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show or hide short post description under title.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'module',
                                    'show_when' => array( 'module2', 'module3', 'module4' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getImageSizes( array(
                                        '' => esc_html__( 'Default', 'meloo-toolkit' )
                                    )
                                ),
                                'description'   => esc_html__( 'Select image size. By default, the image size is set for the selected module. Note: In some modules it is not possible to change image size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Module Size', 'meloo-toolkit' ),
                                'name'    => 'module_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    '' => esc_html__( 'Default', 'meloo-toolkit' ),
                                    'small-module' => esc_html__( 'Small', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select module size. Note: In some module it is not possible to change the size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getMusicFilter(), 
                       
                    )
                ),  // End of element kc

                
                /* Posts Carousel
                 -------------------------------- */
                'kc_posts_carousel'    => array(
                    'name'        => esc_html__( 'Posts Carousel', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display posts in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-docs',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Post Module', 'meloo-toolkit' ),
                                'name'    => 'module',
                                'type'    => 'select',
                                'value'   => 'module1',
                                'options' => array(
                                    'module1' => esc_html__( 'Module 1', 'meloo-toolkit' ),
                                    'module2' => esc_html__( 'Module 2', 'meloo-toolkit' ),
                                    'module3' => esc_html__( 'Module 3', 'meloo-toolkit' ),
                                    'module4' => esc_html__( 'Module 4', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select post module.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__( 'Show Excerpt', 'meloo-toolkit' ),
                                'name'        => 'excerpt_carousel',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show or hide short post description under title.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'module',
                                    'show_when' => array( 'module2', 'module3', 'module4' )
                                )
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => $this->getImageSizes( array(
                                        '' => esc_html__( 'Default', 'meloo-toolkit' )
                                    )
                                ),
                                'description'   => esc_html__( 'Select image size. By default, the image size is set for the selected module. Note: In some modules it is not possible to change image size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Module Size', 'meloo-toolkit' ),
                                'name'    => 'module_size',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    '' => esc_html__( 'Default', 'meloo-toolkit' ),
                                    'small-module' => esc_html__( 'Small', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select module size. Note: In some module it is not possible to change the size because it is set permanently.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Items per slide', 'meloo-toolkit' ),
                                'name'    => 'items_number',
                                'type'    => 'number_slider',
                                'value'   => 3,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'The number of items displayed per slide (not apply for auto-height)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Items On Tablet?', 'meloo-toolkit' ),
                                'name'    => 'tablet',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Tablet Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Items On Smartphone?', 'meloo-toolkit' ),
                                'name'    => 'mobile',
                                'type'    => 'number_slider',
                                'value'   => 2,
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Display number of items per each slide (Mobile Screen)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Navigation', 'meloo-toolkit' ),
                                'name'        => 'navigation',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display the "Next" and "Prev" buttons.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'         => esc_html__( 'Navigation Style', 'meloo-toolkit' ),
                                'name'          => 'nav_style',
                                'type'          => 'select',
                                'value'         => '1',
                                'options'       => array(
                                    'arrows' => esc_html__( 'Arrows', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select how navigation buttons display on slide.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                                'relation'      => array(
                                    'parent'    => 'navigation',
                                    'show_when' => 'yes'
                                )
                            ), 
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto height', 'meloo-toolkit' ),
                                'name'        => 'auto_height',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Add height to owl-wrapper-outer so you can use diffrent heights on slides. Use it only for one item per page setting.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The carousel automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getBlogFilter(), 
                       
                    )
                ),  // End of element kc
                

                /* Posts Slider
                 -------------------------------- */
                'kc_posts_slider'    => array(
                    'name'        => esc_html__( 'Posts Slider', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display posts in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-layers',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Show Excerpt', 'meloo-toolkit' ),
                                'name'        => 'excerpt',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show or hide short post description under title.', 'meloo-toolkit' ),
                                'admin_label' => false,
                            ),
                            array(
                                'label'   => esc_html__( 'Speed', 'meloo-toolkit' ),
                                'name'    => 'speed',
                                'type'    => 'number_slider',
                                'value'   => 500,
                                'options' => array(
                                    'min'        => 100,
                                    'max'        => 1500,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the speed at which autoplaying sliders will transition in second', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Pagination', 'meloo-toolkit' ),
                                'name'        => 'pagination',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show the pagination.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ), 
                            array(
                                'label'       => esc_html__( 'Auto Play', 'meloo-toolkit' ),
                                'name'        => 'auto_play',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'The slider automatically plays when site loaded', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Module Class Name', 'meloo-toolkit'),
                                'name'        => 'module_classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style loop module differently, please add a class name to this field and refer to it in your custom CSS file. Tip: no-cut-corners - disbale cut corners in module.', 'meloo-toolkit' )
                            ),
                        ),
                    'filter' => $this->getBlogFilter(),
                    'styling' => array(
                            array(
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Slider' => array(
                                            array( 'property' => 'height', 'label' => 'Height', 'selector' => '.post-slide' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-posts-slider' ),
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-posts-slider' ),
                                        ),
                                    ),
                                ),
                                'description' => esc_html__( 'Slide CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc


                /* Fancy Title
                 -------------------------------- */
                'kc_fancy_title' => array(
                    'name'        => esc_html__( 'Fancy Title', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display an extremely impressive title with many beautiful styles to attract your viewers at first click.', 'meloo-toolkit' ),
                    'icon'        => 'sl-pencil',
                    'category'    => 'Premium',
                    'live_editor' => plugin_dir_path( __FILE__ ) . 'live_editor/'.'kc_fancy_title.php',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Title', 'meloo-toolkit' ),
                                'name'        => 'title',
                                'type'        => 'text',
                                'value'       => 'The Title',
                                'admin_label' => true,
                                'description' => esc_html__( 'Enter title here.', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'       => esc_html__( 'Use Post Title?', 'meloo-toolkit' ),
                                'name'        => 'post_title',
                                'type'        => 'toggle',
                                'description' => esc_html__( 'Use the title of current post/page as content element instead of text input value.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Back Layer Title', 'meloo-toolkit' ),
                                'name'        => 'back_layer_title',
                                'type'        => 'text',
                                'value'       => 'The Title',
                                'admin_label' => true,
                                'description' => esc_html__( 'Enter back layer title here', 'meloo-toolkit' ),
                                'relation'    => array(
                                    'parent'    => 'style',
                                    'show_when' => array('style4' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'back_layer_parallax',
                                'type'        => 'text',
                                'value'       => '40',
                                'admin_label' => true,
                                'description' => esc_html__( 'Enter back layer parallax Y value.', 'meloo-toolkit' ),
                                'relation'    => array(
                                    'parent'    => 'style',
                                    'show_when' => array('style4' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Style', 'meloo-toolkit' ),
                                'name'        => 'style',
                                'type'        => 'select',
                                'value'       => 'style3',
                                'options'     => array(
                                    'style1' => esc_html__( 'Bottom Line', 'meloo-toolkit' ),
                                    'style2' => esc_html__( 'Center Line', 'meloo-toolkit' ),
                                    'style3' => esc_html__( 'Page Title', 'meloo-toolkit' ),
                                    'style4' => esc_html__( 'Page Title (Parallax)', 'meloo-toolkit' ),
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'Select heading style.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Size', 'meloo-toolkit' ),
                                'name'        => 'size',
                                'type'        => 'select',
                                'value'       => 'h1',
                                'options'     => array(
                                    'h1' => esc_html__( 'H1', 'meloo-toolkit' ),
                                    'h2' => esc_html__( 'H2', 'meloo-toolkit' ),
                                    'h3' => esc_html__( 'H3', 'meloo-toolkit' ),
                                    'h4' => esc_html__( 'H4', 'meloo-toolkit' ),
                                    'h5' => esc_html__( 'H5', 'meloo-toolkit' ),
                                    'h6' => esc_html__( 'H6', 'meloo-toolkit' )
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'Select heading size.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Align', 'meloo-toolkit' ),
                                'name'        => 'align',
                                'type'        => 'select',
                                'value'       => 'left',
                                'options'     => array(
                                    'left'   => esc_html__( 'Left', 'meloo-toolkit' ),
                                    'center' => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'right'  => esc_html__( 'Right', 'meloo-toolkit' ),
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'Select heading align.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Title' => array(
                                            array( 'property' => 'color', 'label' => 'Color', 'selector' => '.kc-h-style' ),
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-fancy-title-block' ),
                                            array( 'property' => 'padding', 'label' => 'Padding', 'selector' => '.kc-fancy-title-block' ),
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.kc-h-style' ),
                                            array( 'property' => 'font-family', 'label' => 'Font Family', 'selector' => '.kc-h-style' ),
                                            array( 'property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.kc-h-style' ),
                                            array( 'property' => 'border-color', 'label' => 'Border Color', 'selector' => '.kc-h-style' ),
                                            array( 'property' => 'border-color', 'label' => 'Border Color (Style 2)', 'selector' => '.kc-h-style:after' ),
                                        ),
                                        'Back Layer Title' => array(
                                            array( 'property' => 'color', 'label' => 'Color', 'selector' => '.h-style-5-back' ),
                                            array( 'property' => 'font-family', 'label' => 'Font Family', 'selector' => '.h-style-5-back' ),
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.h-style-5-back' ),
                                            array( 'property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.h-style-5-back' ),
                                        ),
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                    )
                ),  // End of element kc


                /* Tracklist
                 -------------------------------- */
                'rt_tracklist'    => array(
                    'name'        => esc_html__( 'Tracklist', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display tracklist.', 'meloo-toolkit' ),
                    'icon'        => 'sl-playlist',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Select Tracklist', 'meloo-toolkit' ),
                                'name'        => 'id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Unique ID', 'meloo-toolkit' ),
                                'name'        => 'unique_id',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Type unique ID. This will be used to run the tracklist via another element trigger eg a button or a cover player.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Tracks IDS', 'meloo-toolkit' ),
                                'name'        => 'ids',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Filter multiple tracks by ID. Enter the track IDs separated by | (ex: 333|18|643).', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Fixed Height', 'meloo-toolkit' ),
                                'name'    => 'fixed_height',
                                'type'    => 'number_slider',
                                'value'   => '0',
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 999,
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set fixed height (px) of tracklist. If the value is set at "0" then the height of the list is set to automatic and the scroll on right is invisible.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Show Cover Images', 'meloo-toolkit' ),
                                'name'        => 'covers',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show or hide tracks cover images in tracklist.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Display Limit', 'meloo-toolkit' ),
                                'name'    => 'limit',
                                'type'    => 'number_slider',
                                'value'   => '0',
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 999,
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'How many tracks will be visibile. If the value is set at "0" then all tracks will be shown.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Size', 'meloo-toolkit' ),
                                'name'    => 'size',
                                'type'    => 'select',
                                'value'   => 'medium',
                                'options' => array(
                                    'medium' => esc_html__( 'Medium', 'meloo-toolkit' ),
                                    'large' => esc_html__( 'Large', 'meloo-toolkit' ),
                                    'xlarge' => esc_html__( 'Extra Large', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select tracklist size.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Audio Visualisation', 'meloo-toolkit' ),
                                'name'    => 'vis',
                                'type'    => 'select',
                                'value'   => 'none',
                                'options' => array(
                                    'none' => esc_html__( 'None', 'meloo-toolkit' ),
                                    'lines' => esc_html__( 'Lines', 'meloo-toolkit' ),
                                    'bars' => esc_html__( 'Bars', 'meloo-toolkit' )
                                ),
                                'description'   => esc_html__( 'Select audio visualisation.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Show Advertisement', 'meloo-toolkit' ),
                                'name'        => 'show_ad',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show or hide advertisement tracklist. AD can be set in Theme Panel > ADS > Tracklist Inline.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                    )
                ),  // End of element kc
                

                /* Waveform Tracklist
                 -------------------------------- */
                'rt_wf_tracklist' => array(
                    'name'        => esc_html__( 'Waveform Tracklist', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display tracks with big waveform.', 'meloo-toolkit' ),
                    'icon'        => 'sl-playlist',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Unique ID', 'meloo-toolkit' ),
                                'name'        => 'unique_id',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Type unique ID. This will be used to run the tracklist via another element trigger eg a button or a cover player.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Select Tracklist', 'meloo-toolkit' ),
                                'name'        => 'id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => true,
                                'relation'    => array(
                                    'parent'    => 'type',
                                    'show_when' => array( 'tracklist' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Tracks IDS', 'meloo-toolkit' ),
                                'name'        => 'ids',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Filter multiple tracks by ID. Enter the track IDs separated by | (ex: 333|18|643).', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Display Limit', 'meloo-toolkit' ),
                                'name'    => 'limit',
                                'type'    => 'number_slider',
                                'value'   => '0',
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 999,
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'How many tracks will be visibile. If the value is set at "0" then all tracks will be shown.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Waveform Colors', 'meloo-toolkit' ),
                                'name'        => 'waveform_colors',
                                'type'        => 'text',
                                'value'       => '#eb18d9,#4063e6,#eb18d9,#4063e6',
                                'description' => esc_html__( 'Enter the waveform colors separated by "," (1 waveform start gradient, 2 waveform end gradient, 3 shadow waveform start gradient, 4 shadow waveform end gradient)', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),

                        ),
                                
                    )
                ),  // End of element kc


                /* Cover Player
                 -------------------------------- */
                'kc_cover_player' => array(
                    'name'        => esc_html__( 'Cover Player', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display album image with play button.', 'meloo-toolkit' ),
                    'icon'        => 'sl-music-tone',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'         => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'          => 'cover',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image from media library.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'   => esc_html__( 'Image size', 'meloo-toolkit' ),
                                'name'    => 'thumb_size',
                                'type'    => 'select',
                                'value'   => 'meloo-medium-square-thumb',
                                'options' => $this->getImageSizes( ),
                                'description'   => esc_html__( 'Select image size.', 'meloo-toolkit' ),
                                'admin_label'   => false,
                            ),
                            array(
                                'label'       => esc_html__( 'Align', 'meloo-toolkit' ),
                                'name'        => 'align',
                                'type'        => 'select',
                                'value'       => 'center',
                                'options'     => array(
                                    'left'   => esc_html__( 'Left', 'meloo-toolkit' ),
                                    'center' => esc_html__( 'Center', 'meloo-toolkit' ),
                                    'right'  => esc_html__( 'Right', 'meloo-toolkit' ),
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'Image align.', 'meloo-toolkit' )
                            ),
                             array(
                                'label'       => esc_html__( 'Tracklist Unique ID', 'meloo-toolkit' ),
                                'name'        => 'unique_id',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Type tracklist unique ID. This tracklist will be controlled by this cover player.', 'meloo-toolkit' ),
                                'admin_label' => true,
                                'relation'    => array(
                                    'parent'    => 'type',
                                    'show_when' => array( 'tracklist_controller' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'        => 'type',
                                'type'        => 'select',
                                'value'       => 'tracklist_controller',
                                'options'     => array(
                                    'tracklist_controller'   => esc_html__( 'Play Inlcuded Tracklist', 'meloo-toolkit' ),
                                    'tracklist' => esc_html__( 'Play External Tracklist', 'meloo-toolkit' ),
                                ),
                                'admin_label' => true,
                                'description' => esc_html__( 'Click action type, play included tracklist or external. External tracklist is selected by: Unique ID.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Select Tracklist', 'meloo-toolkit' ),
                                'name'        => 'id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => true,
                                'relation'    => array(
                                    'parent'    => 'type',
                                    'show_when' => array( 'tracklist' )
                                )
                            ),
                            array(
                                'label'       => esc_html__( 'Tracks IDS', 'meloo-toolkit' ),
                                'name'        => 'ids',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Filter multiple tracks by ID. Enter the track IDs separated by | (ex: 333|18|643).', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax',
                                'type'        => 'text',
                                'value'       => '0',
                                'admin_label' => true,
                                'description' => esc_html__( 'Enter parallax Y value for smooth motion.', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.cover-holder' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.cover-holder' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                   
                    )
                ),  // End of element kc


                /* Recent Posts
                 -------------------------------- */
                'kc_recent_posts' => array(
                    'name'        => esc_html__( 'Recent Posts', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display recent posts', 'meloo-toolkit' ),
                    'icon'        => 'sl-docs',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            array(
                                'label'   => esc_html__( 'Number Posts to Show', 'meloo-toolkit' ),
                                'name'    => 'limit',
                                'type'    => 'number_slider',
                                'value'   => '3',
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 40,
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Number posts to show.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Ratings', 'meloo-toolkit' ),
                                'name'        => 'ratings',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show posts ratings.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Show Description', 'meloo-toolkit' ),
                                'name'        => 'excerpt',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show post description (excerpt)', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Show Thumbnails', 'meloo-toolkit' ),
                                'name'        => 'thumbnails',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Show post thumbnails', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),

                    )
                ),  // End of element kc

                
                /* Instagram Feed
                 -------------------------------- */
                'kc_instafeed' => array(
                    'name'        => esc_html__( 'Instagram Feed', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display recent images from Instagram account.', 'meloo-toolkit' ),
                    'icon'        => 'kc-icon-instagram',
                    'category'    => 'Socials',
                    'params'      => array(

                        'general' => array(

                            array(
                                'label'       => esc_html__( 'Username', 'meloo-toolkit' ),
                                'name'        => 'username',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Enter the ID as it appears after the instagram url (ex. http://www.instagram.com/ID)', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Display Name', 'meloo-toolkit' ),
                                'name'        => 'display_name',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'Enter custom profile name instead of ID name.', 'meloo-toolkit' ),
                                'admin_label' => true
                            ),
                            array(
                                'label'       => esc_html__( 'Access token', 'meloo-toolkit' ),
                                'name'        => 'access_token',
                                'type'        => 'text',
                                'value'       => '',
                                'description' => esc_html__( 'You can get the Access token at https://archetypethemes.co/pages/instagram-token-generator', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'       => esc_html__( 'Display Header', 'meloo-toolkit' ),
                                'name'        => 'display_header',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Display or hide the Instagram header section.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Display Follow Overlay', 'meloo-toolkit' ),
                                'name'        => 'display_follow_overlay',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display or hide the black overlay with profile link.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Images Per Row', 'meloo-toolkit' ),
                                'name'    => 'images_per_row',
                                'type'    => 'number_slider',
                                'value'   => '3',
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 5,
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Set the number of images displayed on each row (default is 3).', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                             array(
                                'label'   => esc_html__( 'Number of Rows', 'meloo-toolkit' ),
                                'name'    => 'number_of_rows',
                                'type'    => 'number_slider',
                                'value'   => '2',
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 5,
                                    'show_input' => false
                                ),
                                'description' => esc_html__( 'Set the number of images displayed on each row (default is 3).', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Image Gap', 'meloo-toolkit' ),
                                'name'    => 'image_gap',
                                'type'    => 'select',
                                'value'   => 'no-gap',
                                'options' => array(
                                    'no-gap'    => esc_html__( 'No Gap', 'meloo-toolkit' ),
                                    'small-gap' => esc_html__( '2px', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Set a gap between images (default: No gap)', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Size', 'meloo-toolkit' ),
                                'name'    => 'size',
                                'type'    => 'select',
                                'value'   => 'no-gap',
                                'options' => array(
                                    'widget-size'    => esc_html__( 'Small Widget', 'meloo-toolkit' ),
                                    'fullwidth-size' => esc_html__( 'Fullwidth', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Set module size.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                        ),
    
                        'advanced' => array(
                            array(
                                'label'   => esc_html__( 'Request Timeout', 'meloo-toolkit' ),
                                'name'    => 'request_timeout',
                                'type'    => 'number_slider',
                                'value'   => '2',
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 5,
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Timeout in minutes for the instagram API request.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),  
                            array(
                                'label'   => esc_html__( 'Cache Time', 'meloo-toolkit' ),
                                'name'    => 'cache_time',
                                'type'    => 'number_slider',
                                'value'   => '60',
                                'options' => array(
                                    'min'        => 1,
                                    'max'        => 1000,
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Time in minutes that data is stored in the database before re-downloading.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.kc-instagram' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.kc-instagram' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                    )
                ),  // End of element kc
                

                /* AD Spot
                 -------------------------------- */
                'kc_adspot' => array(
                    'name'        => esc_html__( 'Advertisement', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display advertisement.', 'meloo-toolkit' ),
                    'icon'        => 'sl-target',
                    'category'    => 'Socials',
                    'params'      => array(

                        'general' => array(
                            array(
                                'label'       => esc_html__( 'Display AD Title', 'meloo-toolkit' ),
                                'name'        => 'display_ad_title',
                                'type'        => 'toggle',
                                'value'       => '',
                                'description' => esc_html__( 'Display small title by default is: - Advertisement -. Note: Text can be replaced by Translate plugin like Loco Translate.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ), 
                            array(
                                'label'   => esc_html__( 'Use adspot from:', 'meloo-toolkit' ),
                                'name'    => 'adspot',
                                'type'    => 'select',
                                'value'   => '',
                                'options' => array(
                                    ''               => esc_html__( '- Select -', 'meloo-toolkit' ),
                                    'sidebar'        => esc_html__( 'Sidebar', 'meloo-toolkit' ),
                                    'header'         => esc_html__( 'Header', 'meloo-toolkit' ),
                                    'footer'         => esc_html__( 'Footer', 'meloo-toolkit' ),
                                    'article_top'    => esc_html__( 'Article Top', 'meloo-toolkit' ),
                                    'article_bottom' => esc_html__( 'Article Bottom', 'meloo-toolkit' ),
                                    'tracklist'      => esc_html__( 'Tracklit Inline', 'meloo-toolkit' ),
                                    'custom1'        => esc_html__( 'Custom 1', 'meloo-toolkit' ),
                                    'custom2'        => esc_html__( 'Custom 2', 'meloo-toolkit' ),
                                    'custom3'        => esc_html__( 'Custom 3', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Choose the adspot from list.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        'styling' => array(
                            array(
                                'label'   => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        'Box' => array(
                                            array( 'property' => 'padding', 'label' => 'Box Padding', 'selector' => '.adspot' ),
                                            array( 'property' => 'margin', 'label' => 'Box Margin', 'selector' => '.adspot' ),
                                        ),
                                        
                                    ),
                                ),
                                'description' => esc_html__( 'Box wrapper CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                    )
                ),  // End of element kc
                

                /* Parallax Container
                 -------------------------------- */
                'kc_parallax_el'  => array(
                    'name'         => esc_html__( 'Parallax Container', 'meloo-toolkit' ),
                    'description'  => esc_html__( 'Display parallax container with smooth animation.', 'meloo-toolkit' ),
                    'icon'         => 'fa-star',
                    'category'     => 'Premium',
                    'nested'       => true,
                    //'accept_child' => 'kc_detail',
                    'params'       => array(
                        'general' => array(
                             array(
                                'label'       => esc_html__( 'Parallax Y', 'meloo-toolkit' ),
                                'name'        => 'parallax_y',
                                'type'        => 'text',
                                'value'       => '40',
                                'admin_label' => false,
                                'description' => esc_html__( 'Enter parallax value e.g: 40 or -40.', 'meloo-toolkit' ),
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' ),
                            ),
                        ),
                        'styling' => array(
                            array(
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Box' => array(
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-parallax-wrap' ),
                                        ),
                                    ),
                                ),
                                'description' => esc_html__( 'Box CSS', 'meloo-toolkit' ),
                            ),
                        ),        
                    )
                ),  // End of element kc


                /* Details List
                 -------------------------------- */
                'kc_details_list'  => array(
                    'name'         => esc_html__( 'Details List', 'meloo-toolkit' ),
                    'description'  => esc_html__( 'Display details list.', 'meloo-toolkit' ),
                    'icon'         => 'fa-list',
                    'category'     => 'Premium',
                    'nested'       => true,
                    'accept_child' => 'kc_detail',
                    'params'       => array(
                        'general' => array(
                             array(
                                'label'   => esc_html__( 'Style:', 'meloo-toolkit' ),
                                'name'    => 'list_style',
                                'type'    => 'select',
                                'value'   => 'horizontal',
                                'options' => array(
                                    'horizontal' => esc_html__( 'Horizontal', 'meloo-toolkit' ),
                                    'vertical'   => esc_html__( 'Vertical', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Choose the list style.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),     
                    )
                ),  // End of element kc
                

                    /* <---- Detail
                     -------------------------------- */
                    'kc_detail'    => array(
                        'name'          => esc_html__( 'Detail', 'meloo-toolkit' ),
                        'description'   => esc_html__( 'Display details.', 'meloo-toolkit' ),
                        'icon'          => 'fa-star',
                        'category'      => 'Premium',
                        'accept_parent' => 'kc_details_list',
                        'params'        => array(
                            'general' => array(
                                array(
                                    'label'       => esc_html__( 'Detail Label', 'meloo-toolkit' ),
                                    'name'        => 'label',
                                    'type'        => 'text',
                                    'admin_label' => true,
                                    'description' => esc_html__( 'Enter name of your detail.', 'meloo-toolkit' )
                                ),
                                array(
                                    'label'   => esc_html__( 'Detail Type', 'meloo-toolkit' ),
                                    'name'    => 'type',
                                    'type'    => 'select',
                                    'value'   => '',
                                    'options' => array(
                                        'text'         => esc_html__( 'Text', 'meloo-toolkit' ),
                                        'links'        => esc_html__( 'Links', 'meloo-toolkit' ),
                                        'buttons'      => esc_html__( 'Buttons', 'meloo-toolkit' ),
                                        'share_buttons'      => esc_html__( 'Share Buttons', 'meloo-toolkit' ),
                                    ),
                                    'description'   => esc_html__( 'Choose the detail type.', 'meloo-toolkit' ),
                                    'admin_label'   => false
                                ),
                                array(
                                    'label'       => esc_html__( 'Detail Text', 'meloo-toolkit' ),
                                    'name'        => 'text',
                                    'type'        => 'text',
                                    'admin_label' => false,
                                    'description' => esc_html__( 'Enter detail text.', 'meloo-toolkit' ),
                                    'relation'    => array(
                                        'parent'    => 'type',
                                        'show_when' => array('text' )
                                    )
                                ), 
                                array(
                                    'label'       => esc_html__( 'Links', 'meloo-toolkit' ),
                                    'name'        => 'links',
                                    'type'        => 'textarea',
                                    'admin_label' => false,
                                    'description' => esc_html__( 'Add custom buttons divided with linebreaks (Enter) e.g.: Google|http://google.com|_blank Note: Target parameter can be used: "_self" (open link in same window) or "_blank" (open link in new tab).', 'meloo-toolkit' ),
                                    'relation'    => array(
                                        'parent'    => 'type',
                                        'show_when' => array( 'links' )
                                    )
                                ),
                                array(
                                    'label'       => esc_html__( 'Buttons', 'meloo-toolkit' ),
                                    'name'        => 'buttons',
                                    'type'        => 'textarea',
                                    'admin_label' => false,
                                    'description' => esc_html__( 'Add custom buttons divided with linebreaks (Enter) e.g.: Google|http://google.com|_blank|icon_name Note: Target parameter can be used: "_self" (open link in same window) or "_blank" (open link in new tab).', 'meloo-toolkit' ),
                                    'relation'    => array(
                                        'parent'    => 'type',
                                        'show_when' => array( 'shop_buttons', 'buttons' )
                                    )
                                ),
                            )
                        )
                    ),  // End of element kc
                

                 /* Layers Slider
                 -------------------------------- */
                'kc_testi_slider'    => array(
                    'name'        => esc_html__( 'Testimonial Slider', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display layers in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-layers',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            
                            array(
                                'label'   => esc_html__( 'Pause Time (s)', 'meloo-toolkit' ),
                                'name'    => 'pause_time',
                                'type'    => 'number_slider',
                                'value'   => 0,
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the pause time for the slides ("0" disable timer).', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Use Parallax Effect?', 'meloo-toolkit' ),
                                'name'        => 'parallax',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Use parallax effect.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        
                        // --------- > Slide 1
                        'slide 1' => array(
                            array(
                                'label'         => esc_html__( 'Image', 'meloo-toolkit' ),
                                'name'          => 'slide1__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__('Name', 'meloo-toolkit'),
                                'name'        => 'slide1__name',
                                'type'        => 'text',
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Testimonial', 'meloo-toolkit'),
                                'name'        => 'slide1__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Short testimonial text.', 'meloo-toolkit' )
                            ),
                        ),

                        // --------- > Slide 2
                        'slide 2' => array(
                            array(
                                'label'         => esc_html__( 'Image', 'meloo-toolkit' ),
                                'name'          => 'slide2__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__('Name', 'meloo-toolkit'),
                                'name'        => 'slide2__name',
                                'type'        => 'text',
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Testimonial', 'meloo-toolkit'),
                                'name'        => 'slide2__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Short testimonial text.', 'meloo-toolkit' )
                            ),
                        ),

                        // --------- > Slide 3
                        'slide 3' => array(
                            array(
                                'label'         => esc_html__( 'Image', 'meloo-toolkit' ),
                                'name'          => 'slide3__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__('Name', 'meloo-toolkit'),
                                'name'        => 'slide3__name',
                                'type'        => 'text',
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Testimonial', 'meloo-toolkit'),
                                'name'        => 'slide3__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Short testimonial text.', 'meloo-toolkit' )
                            ),
                        ),

                         // --------- > Slide 4
                        'slide 4' => array(
                            array(
                                'label'         => esc_html__( 'Image', 'meloo-toolkit' ),
                                'name'          => 'slide4__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__('Name', 'meloo-toolkit'),
                                'name'        => 'slide4__name',
                                'type'        => 'text',
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Testimonial', 'meloo-toolkit'),
                                'name'        => 'slide4__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Short testimonial text.', 'meloo-toolkit' )
                            ),
                        ),

                         // --------- > Slide 5
                        'slide 5' => array(
                            array(
                                'label'         => esc_html__( 'Image', 'meloo-toolkit' ),
                                'name'          => 'slide5__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                            array(
                                'label'       => esc_html__('Name', 'meloo-toolkit'),
                                'name'        => 'slide5__name',
                                'type'        => 'text',
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Testimonial', 'meloo-toolkit'),
                                'name'        => 'slide5__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Short testimonial text.', 'meloo-toolkit' )
                            ),
                        ),

                    )
                ),  // End of element kc


                /* Layers Slider
                 -------------------------------- */
                'kc_layers_slider'    => array(
                    'name'        => esc_html__( 'Layers Slider', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display layers in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-layers',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            
                            array(
                                'label'   => esc_html__( 'Pause Time (s)', 'meloo-toolkit' ),
                                'name'    => 'pause_time',
                                'type'    => 'number_slider',
                                'value'   => 0,
                                'options' => array(
                                    'min'        => 0,
                                    'max'        => 10,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the pause time for the slides ("0" disable timer).', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'       => esc_html__( 'Use Parallax Effect?', 'meloo-toolkit' ),
                                'name'        => 'parallax',
                                'type'        => 'toggle',
                                'value'       => 'yes',
                                'description' => esc_html__( 'Use parallax effect.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Extra Class Name', 'meloo-toolkit'),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        
                        // --------- > Slide 1
                        'slide 1' => array(
                            array(
                                'label'         => esc_html__( 'Square Image', 'meloo-toolkit' ),
                                'name'          => 'slide1__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                             array(
                                'label'         => esc_html__( 'Background Image', 'meloo-toolkit' ),
                                'name'          => 'slide1__bg',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select background image image.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide1__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide1__subtitle',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide subtitle.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'        => 'slide1__ca',
                                'type'        => 'select',
                                'options'     => array(
                                    ''         => esc_html__( 'None', 'meloo-toolkit' ),
                                    'link'     => esc_html__( 'Custom Link', 'meloo-toolkit' ),
                                    'audio_id' => esc_html__( 'Play Link', 'meloo-toolkit' ),
                                ),
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide1__link',
                                'type'        => 'text',
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide1__ca',
                                    'show_when' => array( 'link' )
                                )
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide1__audio_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide1__ca',
                                    'show_when' => array( 'audio_id' )
                                )
                            ),

                        ),

                        // --------- > Slide 2
                        'slide 2' => array(
                             array(
                                'label'         => esc_html__( 'Square Image', 'meloo-toolkit' ),
                                'name'          => 'slide2__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                             array(
                                'label'         => esc_html__( 'Background Image', 'meloo-toolkit' ),
                                'name'          => 'slide2__bg',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select background image image.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide2__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide2__subtitle',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide subtitle.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'        => 'slide2__ca',
                                'type'        => 'select',
                                'options'     => array(
                                    ''         => esc_html__( 'None', 'meloo-toolkit' ),
                                    'link'     => esc_html__( 'Custom Link', 'meloo-toolkit' ),
                                    'audio_id' => esc_html__( 'Play Link', 'meloo-toolkit' ),
                                ),
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide2__link',
                                'type'        => 'text',
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide2__ca',
                                    'show_when' => array( 'link' )
                                )
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide2__audio_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide2__ca',
                                    'show_when' => array( 'audio_id' )
                                )
                            ),
                        ),

                        // --------- > Slide 3
                        'slide 3' => array(
                            array(
                                'label'         => esc_html__( 'Square Image', 'meloo-toolkit' ),
                                'name'          => 'slide3__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                             array(
                                'label'         => esc_html__( 'Background Image', 'meloo-toolkit' ),
                                'name'          => 'slide3__bg',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select background image image.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide3__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide3__subtitle',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide subtitle.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'        => 'slide3__ca',
                                'type'        => 'select',
                                'options'     => array(
                                    ''         => esc_html__( 'None', 'meloo-toolkit' ),
                                    'link'     => esc_html__( 'Custom Link', 'meloo-toolkit' ),
                                    'audio_id' => esc_html__( 'Play Link', 'meloo-toolkit' ),
                                ),
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide3__link',
                                'type'        => 'text',
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide3__ca',
                                    'show_when' => array( 'link' )
                                )
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide3__audio_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide3__ca',
                                    'show_when' => array( 'audio_id' )
                                )
                            ),
                        ),

                        // --------- > Slide 4
                        'slide 4' => array(
                            array(
                                'label'         => esc_html__( 'Square Image', 'meloo-toolkit' ),
                                'name'          => 'slide4__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                             array(
                                'label'         => esc_html__( 'Background Image', 'meloo-toolkit' ),
                                'name'          => 'slide4__bg',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select background image image.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide4__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide4__subtitle',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide subtitle.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'        => 'slide4__ca',
                                'type'        => 'select',
                                'options'     => array(
                                    ''         => esc_html__( 'None', 'meloo-toolkit' ),
                                    'link'     => esc_html__( 'Custom Link', 'meloo-toolkit' ),
                                    'audio_id' => esc_html__( 'Play Link', 'meloo-toolkit' ),
                                ),
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide4__link',
                                'type'        => 'text',
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide4__ca',
                                    'show_when' => array( 'link' )
                                )
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide4__audio_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide4__ca',
                                    'show_when' => array( 'audio_id' )
                                )
                            ),
                        ),

                        // --------- > Slide 5
                        'slide 5' => array(
                            array(
                                'label'         => esc_html__( 'Square Image', 'meloo-toolkit' ),
                                'name'          => 'slide5__image',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select image square image.', 'meloo-toolkit' ),
                                'admin_label'   => true
                            ),
                             array(
                                'label'         => esc_html__( 'Background Image', 'meloo-toolkit' ),
                                'name'          => 'slide5__bg',
                                'type'          => 'attach_image',
                                'description'   => esc_html__( 'Select background image image.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide5__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide5__subtitle',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide subtitle.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__( 'Click Action', 'meloo-toolkit' ),
                                'name'        => 'slide5__ca',
                                'type'        => 'select',
                                'options'     => array(
                                    ''         => esc_html__( 'None', 'meloo-toolkit' ),
                                    'link'     => esc_html__( 'Custom Link', 'meloo-toolkit' ),
                                    'audio_id' => esc_html__( 'Play Link', 'meloo-toolkit' ),
                                ),
                                'admin_label' => false,
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide5__link',
                                'type'        => 'text',
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide5__ca',
                                    'show_when' => array( 'link' )
                                )
                            ),
                            array(
                                'label'       => esc_html__('Link URL', 'meloo-toolkit'),
                                'name'        => 'slide5__audio_id',
                                'type'        => 'select',
                                'value'       => 'none',
                                'options'     => $this->getTracks(),
                                'description' => esc_html__( 'Select tracklist post. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left.', 'meloo-toolkit' ),
                                'admin_label' => false,
                                'relation'    => array(
                                    'parent'    => 'slide5__ca',
                                    'show_when' => array( 'audio_id' )
                                )
                            ),
                        ),

                    )
                ),  // End of element kc


                /* Text Slider
                 -------------------------------- */
                'kc_text_slider'    => array(
                    'name'        => esc_html__( 'Text Slider', 'meloo-toolkit' ),
                    'description' => esc_html__( 'Display text in a nice sliding manner.', 'meloo-toolkit' ),
                    'icon'        => 'sl-layers',
                    'category'    => 'Premium',
                    'params'      => array(
                        'general' => array(
                            
                            array(
                                'label'   => esc_html__( 'Pause Time (s)', 'meloo-toolkit' ),
                                'name'    => 'pause_time',
                                'type'    => 'number_slider',
                                'value'   => 5,
                                'options' => array(
                                    'min'        => 5,
                                    'max'        => 30,
                                    'unit'       => '',
                                    'show_input' => true
                                ),
                                'description' => esc_html__( 'Set the pause time for the slides.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Align', 'meloo-toolkit' ),
                                'name'    => 'align',
                                'type'    => 'select',
                                'value'   => 'onleft',
                                'options' => array(
                                    'onleft'   => esc_html__( 'Left', 'meloo-toolkit' ),
                                    'oncenter' => esc_html__( 'Horizontal Center', 'meloo-toolkit' ),
                                    'vcenter'  => esc_html__( 'Horizontal and Vertical Center', 'meloo-toolkit' ),
                                ),
                                'description' => esc_html__( 'Set the pause time for the slides.', 'meloo-toolkit' ),
                                'admin_label' => false
                            ),
                            array(
                                'label'   => esc_html__( 'Background Color', 'meloo-toolkit' ),
                                'name'    => 'color_scheme',
                                'type'    => 'select',
                                'value'   => get_theme_mod( 'color_scheme', 'dark' ),
                                'options' => array(
                                    'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
                                    'light' => esc_html__( 'Light', 'meloo-toolkit' ),
                                ),
                                'description'   => esc_html__( 'Select color scheme.', 'meloo-toolkit' ),
                                'admin_label'   => false
                            ),
                            array(
                                'label'       => esc_html__( 'Extra Class Name', 'meloo-toolkit' ),
                                'name'        => 'classes',
                                'type'        => 'text',
                                'admin_label' => false,
                                'description' => esc_html__( 'If you wish to style a particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'meloo-toolkit' )
                            ),
                        ),
                        
                        // --------- > Slide 1
                        'slide 1' => array(
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide1__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide1__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide text.', 'meloo-toolkit' )
                            ),
                        ),
                        // --------- > Slide 2
                        'slide 2' => array(
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide2__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide2__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide text.', 'meloo-toolkit' )
                            ),
                        ),
                        // --------- > Slide 3
                        'slide 3' => array(
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide3__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide3__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide text.', 'meloo-toolkit' )
                            ),
                        ),
                        // --------- > Slide 4
                        'slide 4' => array(
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide4__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide4__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide text.', 'meloo-toolkit' )
                            ),
                        ),
                        // --------- > Slide 5
                        'slide 5' => array(
                            array(
                                'label'       => esc_html__('Slide Title', 'meloo-toolkit'),
                                'name'        => 'slide5__title',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide title.', 'meloo-toolkit' )
                            ),
                            array(
                                'label'       => esc_html__('Slide Text', 'meloo-toolkit'),
                                'name'        => 'slide5__text',
                                'type'        => 'textarea',
                                'admin_label' => false,
                                'description' => esc_html__( 'Slide text.', 'meloo-toolkit' )
                            ),
                        ),

                        'styling' => array(
                            array(
                                'name'    => 'custom_css',
                                'type'    => 'css',
                                'options' => array(
                                    array(
                                        "screens" => "any,1024,999,767,479",
                                        'Slider' => array(
                                            array( 'property' => 'margin', 'label' => 'Margin', 'selector' => '.kc-text-slider' ),
                                        ),
                                        'Title' => array(
                                            array( 'property' => 'color', 'label' => 'Color', 'selector' => '.text-slide h2' ),
                                            array( 'property' => 'font-family', 'label' => 'Font Family', 'selector' => '.text-slide h2' ),
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.text-slide h2' ),
                                            array( 'property' => 'line-height', 'label' => 'Line Height', 'selector' => '.text-slide h2' ),
                                            array( 'property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.text-slide h2' ),
                                        ),
                                        'Text' => array(
                                            array( 'property' => 'color', 'label' => 'Color', 'selector' => '.text-slide h6' ),
                                            array( 'property' => 'font-family', 'label' => 'Font Family', 'selector' => '.text-slide h6' ),
                                            array( 'property' => 'font-size', 'label' => 'Font Size', 'selector' => '.text-slide h6' ),
                                            array( 'property' => 'line-height', 'label' => 'Line Height', 'selector' => '.text-slide h6' ),
                                            array( 'property' => 'font-weight', 'label' => 'Font Weight', 'selector' => '.text-slide h6' ),
                                        ),
                                    ),
                                ),
                                'description' => esc_html__( 'Slide CSS', 'meloo-toolkit' ),
                            ),
                        ),                  
                       
                    )
                ),  // End of element kc
                
            )

        );
	}





	////////////////////////////////////////
	// FUNCTIONS ONLY FOR SPECIFIED THEME //
	////////////////////////////////////////

	/**
	 * Get blog filter
	 * @return array
	 */
	public function getBlogFilter() {
		return array(              
		    array(
		        'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
		        'name'    => 'limit',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 40,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Sort Order', 'meloo-toolkit' ),
		        'name'    => 'sort_order',
		        'type'    => 'select',
		        'value'   => 'post_date',
		        'options' => array(
		            'post_date'     => esc_html__( 'Latest (By date)', 'meloo-toolkit' ),
		            'title'         => esc_html__( 'Alphabetical A - Z', 'meloo-toolkit' ),
		            'rand'          => esc_html__( 'Random Posts', 'meloo-toolkit' ),
		            'rand_today'    => esc_html__( 'Random Posts Today', 'meloo-toolkit' ),
		            'rand_week'     => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ),
		            'comment_count' => esc_html__( 'Most Commented', 'meloo-toolkit' ),
		            'highest_rated' => esc_html__( 'Highest rated (reviews)', 'meloo-toolkit' )
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'How to sort the posts.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Category', 'meloo-toolkit' ),
		        'name'        => 'category_ids',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( 'category' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Category Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Post ID', 'meloo-toolkit' ),
		        'name'        => 'post_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Tag Slug', 'meloo-toolkit' ),
		        'name'        => 'tag_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter tags by slugs. Enter the tag slugs separated by commas (ex: tag1,tag2,tag3)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Author ID', 'meloo-toolkit' ),
		        'name'        => 'author_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple authors by ID. Enter the author IDs separated by commas (ex: 32,11,899)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
		        'name'    => 'offset',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 99,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' )
		    )
		);

	}


	/**
	 * Get artists filter
	 * @return array
	 */
	public function getArtistsFilter() {
		return array(              
		    array(
		        'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
		        'name'    => 'limit',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 40,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Sort Order', 'meloo-toolkit' ),
		        'name'    => 'sort_order',
		        'type'    => 'select',
		        'value'   => 'post_date',
		        'options' => array(
		            'menu_order'    => esc_html__( 'Drag and Drop', 'meloo-toolkit' ),
		            'post_date'     => esc_html__( 'Latest (By date)', 'meloo-toolkit' ),
		            'title'         => esc_html__( 'Alphabetical A - Z', 'meloo-toolkit' ),
		            'rand'          => esc_html__( 'Random Posts', 'meloo-toolkit' ),
		            'rand_today'    => esc_html__( 'Random Posts Today', 'meloo-toolkit' ),
		            'rand_week'     => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ),
		            'comment_count' => esc_html__( 'Most Commented', 'meloo-toolkit' ),
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'How to sort the posts.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Post ID', 'meloo-toolkit' ),
		        'name'        => 'post_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
		        'name'    => 'offset',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 99,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' )
		    ),

		    /* Filters */ 
		    array(
		        'label'       => esc_html__( 'Filters Order', 'meloo-toolkit' ),
		        'name'        => 'filters_order',
		        'type'        => 'text',
		        'value'       => '1,2,3,4',
		        'admin_label' => false,
		        'description' => esc_html__( 'Enter the filters order number separated by commas e.g.: 2,1 (Display only two filters, the second will be displayed first)', 'meloo-toolkit' )
		    ),

		    /* Filter 1 */ 
		    array(
		        'label'       => esc_html__( 'Filter 1 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_artists_cats' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 2 */ 
		    array(
		        'label'       => esc_html__( 'Filter 2 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label2',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids2',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_artists_cats2' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs2',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 3 */ 
		    array(
		        'label'       => esc_html__( 'Filter 3 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label3',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids3',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_artists_cats3' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs3',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 4 */ 
		    array(
		        'label'       => esc_html__( 'Filter 4 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label4',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids4',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_artists_cats4' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs4',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),
		);
	}


	/**
	 * Get music filter
	 * @return array
	 */
	public function getMusicFilter() {
		return array(              
		    array(
		        'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
		        'name'    => 'limit',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 40,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Sort Order', 'meloo-toolkit' ),
		        'name'    => 'sort_order',
		        'type'    => 'select',
		        'value'   => 'post_date',
		        'options' => array(
		            'menu_order'    => esc_html__( 'Drag and Drop', 'meloo-toolkit' ),
		            'post_date'     => esc_html__( 'Latest (By date)', 'meloo-toolkit' ),
		            'title'         => esc_html__( 'Alphabetical A - Z', 'meloo-toolkit' ),
		            'rand'          => esc_html__( 'Random Posts', 'meloo-toolkit' ),
		            'rand_today'    => esc_html__( 'Random Posts Today', 'meloo-toolkit' ),
		            'rand_week'     => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ),
		            'comment_count' => esc_html__( 'Most Commented', 'meloo-toolkit' ),
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'How to sort the posts.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Post ID', 'meloo-toolkit' ),
		        'name'        => 'post_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
		        'name'    => 'offset',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 99,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' )
		    ),

		    /* Filters */ 
		    array(
		        'label'       => esc_html__( 'Filters Order', 'meloo-toolkit' ),
		        'name'        => 'filters_order',
		        'type'        => 'text',
		        'value'       => '1,2,3,4',
		        'admin_label' => false,
		        'description' => esc_html__( 'Enter the filters order number separated by commas e.g.: 2,1 (Display only two filters, the second will be displayed first)', 'meloo-toolkit' )
		    ),

		    /* Filter 1 */ 
		    array(
		        'label'       => esc_html__( 'Filter 1 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_music_cats' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 2 */ 
		    array(
		        'label'       => esc_html__( 'Filter 2 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label2',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids2',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_music_cats2' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs2',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 3 */ 
		    array(
		        'label'       => esc_html__( 'Filter 3 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label3',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids3',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_music_cats3' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs3',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 4 */ 
		    array(
		        'label'       => esc_html__( 'Filter 4 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label4',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids4',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_music_cats4' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs4',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),
		);
	}


	/**
	 * Get events filter
	 * @return array
	 */
	public function getEventsFilter() {
		return array(              
		    array(
		        'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
		        'name'    => 'limit',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 40,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Post ID', 'meloo-toolkit' ),
		        'name'        => 'post_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' ),
		        'relation'    => array(
		            'parent'    => 'event_type',
		            'show_when' => array( 'future-events','past-events')
		        )
		    ),
		    array(
		        'label'   => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
		        'name'    => 'offset',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 99,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' ),
		        'relation'    => array(
		            'parent'    => 'event_type',
		            'show_when' => array( 'future-events','past-events')
		        )
		    ),

		    /* Filters */ 
		    array(
		        'label'       => esc_html__( 'Filters Order', 'meloo-toolkit' ),
		        'name'        => 'filters_order',
		        'type'        => 'text',
		        'value'       => '1,2,3,4',
		        'admin_label' => false,
		        'description' => esc_html__( 'Enter the filters order number separated by commas e.g.: 2,1 (Display only two filters, the second will be displayed first)', 'meloo-toolkit' )
		    ),

		    /* Filter 1 */ 
		    array(
		        'label'       => esc_html__( 'Filter 1 - Name', 'meloo-toolkit' ),
		        'name'        => 'event_type_label',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Filter 1 - Type', 'meloo-toolkit' ),
		        'name'    => 'event_type',
		        'type'    => 'select',
		        'value'   => 'future-events',
		        'options' => array(
		            'future-events' => esc_html__( 'Future', 'meloo-toolkit' ),
		            'past-events'   => esc_html__( 'Past', 'meloo-toolkit' ),
		            'all'           => esc_html__( 'Future + Past', 'meloo-toolkit' ),
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Select event type.', 'meloo-toolkit' )
		    ),

		    /* Filter 2 */ 
		    array(
		        'label'       => esc_html__( 'Filter 2 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_events_cats' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 3 */ 
		    array(
		        'label'       => esc_html__( 'Filter 3 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label2',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids2',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_events_cats2' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs2',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 4 */ 
		    array(
		        'label'       => esc_html__( 'Filter 4 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label3',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids3',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_events_cats3' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs3',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),
		);
	}
	

	/**
	 * Get gallery filter
	 * @return array
	 */
	public function getGalleryFilter() {
		return array(              
		    array(
		        'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
		        'name'    => 'limit',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 40,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Sort Order', 'meloo-toolkit' ),
		        'name'    => 'sort_order',
		        'type'    => 'select',
		        'value'   => 'post_date',
		        'options' => array(
		            'post_date'     => esc_html__( 'Latest (By date)', 'meloo-toolkit' ),
		            'title'         => esc_html__( 'Alphabetical A - Z', 'meloo-toolkit' ),
		            'rand'          => esc_html__( 'Random Posts', 'meloo-toolkit' ),
		            'rand_today'    => esc_html__( 'Random Posts Today', 'meloo-toolkit' ),
		            'rand_week'     => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ),
		            'comment_count' => esc_html__( 'Most Commented', 'meloo-toolkit' ),
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'How to sort the posts.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Post ID', 'meloo-toolkit' ),
		        'name'        => 'post_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
		        'name'    => 'offset',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 99,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' )
		    ),

		    /* Filters */ 
		    array(
		        'label'       => esc_html__( 'Filters Order', 'meloo-toolkit' ),
		        'name'        => 'filters_order',
		        'type'        => 'text',
		        'value'       => '1,2,3,4',
		        'admin_label' => false,
		        'description' => esc_html__( 'Enter the filters order number separated by commas e.g.: 2,1 (Display only two filters, the second will be displayed first)', 'meloo-toolkit' )
		    ),

		    /* Filter 1 */ 
		    array(
		        'label'       => esc_html__( 'Filter 1 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_gallery_cats' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 2 */ 
		    array(
		        'label'       => esc_html__( 'Filter 2 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label2',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids2',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_gallery_cats2' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs2',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 3 */ 
		    array(
		        'label'       => esc_html__( 'Filter 3 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label3',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids3',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_gallery_cats3' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs3',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 4 */ 
		    array(
		        'label'       => esc_html__( 'Filter 4 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label4',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids4',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_gallery_cats4' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs4',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),
		);
	}
	

	/**
	 * Get vidoes filter
	 * @return array
	 */
	public function getVideosFilter() {
		return array(              
		    array(
		        'label'   => esc_html__( 'Limit post number', 'meloo-toolkit' ),
		        'name'    => 'limit',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 40,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'If the field is set at "0" the limit post number will be the default number.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Sort Order', 'meloo-toolkit' ),
		        'name'    => 'sort_order',
		        'type'    => 'select',
		        'value'   => 'menu_order',
		        'options' => array(
		            'menu_order'    => esc_html__( 'Drag and Drop', 'meloo-toolkit' ),
		            'post_date'     => esc_html__( 'Latest (By date)', 'meloo-toolkit' ),
		            'title'         => esc_html__( 'Alphabetical A - Z', 'meloo-toolkit' ),
		            'rand'          => esc_html__( 'Random Posts', 'meloo-toolkit' ),
		            'rand_today'    => esc_html__( 'Random Posts Today', 'meloo-toolkit' ),
		            'rand_week'     => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ),
		            'comment_count' => esc_html__( 'Most Commented', 'meloo-toolkit' ),
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'How to sort the posts.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Post ID', 'meloo-toolkit' ),
		        'name'        => 'post_ids',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' )
		    ),
		    array(
		        'label'   => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
		        'name'    => 'offset',
		        'type'    => 'number_slider',
		        'value'   => '0',
		        'options' => array(
		            'min'        => 0,
		            'max'        => 99,
		            'unit'       => '',
		            'show_input' => true
		        ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' )
		    ),

		    /* Filters */ 
		    array(
		        'label'       => esc_html__( 'Filters Order', 'meloo-toolkit' ),
		        'name'        => 'filters_order',
		        'type'        => 'text',
		        'value'       => '1,2,3,4',
		        'admin_label' => false,
		        'description' => esc_html__( 'Enter the filters order number separated by commas e.g.: 2,1 (Display only two filters, the second will be displayed first)', 'meloo-toolkit' )
		    ),

		    /* Filter 1 */ 
		    array(
		        'label'       => esc_html__( 'Filter 1 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_videos_cats' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 1 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 2 */ 
		    array(
		        'label'       => esc_html__( 'Filter 2 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label2',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids2',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_videos_cats2' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 2 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs2',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 3 */ 
		    array(
		        'label'       => esc_html__( 'Filter 3 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label3',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids3',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_videos_cats3' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 3 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs3',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),

		    /* Filter 4 */ 
		    array(
		        'label'       => esc_html__( 'Filter 4 - Name', 'meloo-toolkit' ),
		        'name'        => 'category_label4',
		        'type'        => 'text',
		        'value'       => esc_html__( 'All', 'meloo-toolkit' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter name.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - IDS', 'meloo-toolkit' ),
		        'name'        => 'category_ids4',
		        'type'        => 'multiple',
		        'options'     => $this->getTax( $this->theme . '_videos_cats4' ),
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories.', 'meloo-toolkit' )
		    ),
		    array(
		        'label'       => esc_html__( 'Filter 4 - Slug', 'meloo-toolkit' ),
		        'name'        => 'category_slugs4',
		        'type'        => 'text',
		        'admin_label' => true,
		        'description' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' )
		    ),
		);
	}


	/////////////
	// ASSETS //
	/////////////

	/**
	 * Load scripts
	 * @return array
	 */
	public function enqueue() {

        global $post, $wp_query;


	    // Custom BG
		wp_register_style( 'kc-bg-custom', false );
		wp_enqueue_style( 'kc-bg-custom' );

        // If inline CSS styles are enabled
        if ( $this->inline_css === true ) {

            $custom_css = '';

            if ( isset( $wp_query ) && isset( $post ) ) {

                $bg1 = get_post_meta( $wp_query->post->ID, '_bg_1', true );
                $bg2 = get_post_meta( $wp_query->post->ID, '_bg_2', true );

                if ( $bg1 || $bg2 ) {

                    if ( $this->generateBG( $bg1 ) ) {
                        $custom_css .= "
                        html body {
                               " . esc_attr( $this->generateBG( $bg1 ) ) . "
                        }";

                    }
                    if ( $this->generateBG( $bg1 ) ) {
                        $custom_css .= "
                        body #site {
                               " . esc_attr( $this->generateBG( $bg2 ) ) . "
                        }";

                    }
                }

            }

            wp_add_inline_style( 'kc-bg-custom', $custom_css );
        }       
	}


	/////////////
	// HELPERS //
	/////////////


	/**
	 * Add supports for posts
	 * @return void
	 */
	public function addSupportedCPT() {
		global $kc;
		$kc->add_content_type( $this->supported_cpt );
	}


	/**
	 * Set default fonts 
	 * @return void
	 */
	public function setFonts() {

		//var_dump( json_encode( $fonts_json ) );

		$kc_fonts = get_option('kc-fonts');

		if ( !is_array( $kc_fonts ) ) {
		    update_option('kc-fonts', json_decode( $this->default_fonts, true ) );
		} 
		// delete_option('kc-fonts');

	}


	/**
	 * Remove not supported KC elements
	 * @param  array $atts 
	 * @param  array $base 
	 * @return void      
	 */
	function removeKCElements( $atts, $base ){
    
	    if ( in_array( $base, array( 'kc_instagram_feed', 'kc_fb_recent_post', 'kc_post_type_list', 'kc_blog_posts', 'kc_counter_box', 'kc_coundown_timer', 'kc_carousel_post' ) ) ){
	        return null;
	    }
	    return $atts; // required
	}


	/**
	 * Get list of all registered images sizes
	 * @param  array  $extra_opts 
	 * @return array
	 */
	function getImageSizes( $extra_opts = array() ){
	    $image_sizes = get_intermediate_image_sizes();
	    $sizes_a = array();
	    if ( is_array( $extra_opts ) && ! empty( $extra_opts ) ) {
	        $sizes_a = array_merge( $sizes_a, $extra_opts );
	    }
	    foreach ( $image_sizes as $size_name ) {
	        $sizes_a[$size_name] = $size_name;
	    }
	    return $sizes_a;
	}


    /**
     * Get Background Code
     * @param  $bg json
     * @return false|string
     */
    function generateBG( $bg ) {

        if ( json_decode( $bg ) !== null ) {
            
            $css = '';            
            $data = json_decode( $bg, true );
            
            // Image
            if ( isset( $data['image'] ) ) {
                $image = wp_get_attachment_image_src( $data['image'], 'full' );
                $image = $image[0];
                // If image exists
                if ( $image ) {
                    $css .= 'background-image: url( ' . esc_url( $image ) . ');'."\n";
                }
            } 

            // Color
            if ( isset( $data['color'] ) ) {
                $css .= 'background-color:' . esc_attr( $data['color'] ) . ';'."\n";
            }

            // Position
            if ( isset( $data['position'] ) ) {
                $css .= 'background-position:' . esc_attr( $data['position'] ) . ';'."\n";
            }

            // Repeat
            if ( isset( $data['repeat'] ) ) {
                $css .= 'background-repeat:' . esc_attr( $data['repeat'] ) . ';'."\n";
            }

            // Attachment
            if ( isset( $data['attachment'] ) ) {
                $css .= 'background-attachment:' . esc_attr( $data['attachment'] ) . ';'."\n";
            }

            // Size
            if ( isset( $data['size'] ) ) {
                $css .= 'background-size:' . esc_attr( $data['size'] ) . ';'."\n";
            }

            return $css;
        } else {
            return false;
        }
    }


	/**
     * Get Revo Slider list
     * @param  null
     * @version 1.1.0 [compatible with Revo Slider 6+]
     * @return array
     */
    public function getRevoSliders(){
        $intro_revslider = array( '' => esc_html__( 'Select slider...', 'meloo-toolkit' ) );
        if ( class_exists( 'RevSlider' ) && function_exists( 'rev_slider_shortcode' ) ) {
            if ( defined('RS_REVISION') && version_compare( RS_REVISION, '6.0.0' ) >= 0 ) {
                $rev_slider = new RevSlider();
                $slides = $rev_slider->get_sliders();

                if ( ! empty( $slides ) ) {
                    $count = 0;
                    foreach ($slides as $slide) {
                        $alias = $slide->alias;
                        $title = $slide->title;
                        $intro_revslider[$alias] = $title;
                        $count++;
                    }
                }
            }
        } 
        return $intro_revslider;
    }


	/**
	 * Get taxonomies 
	 * @param  string $tax_name 
	 * @return array
	 */
	function getTax( $tax_name ){
	   
	    $tax_a = array();
	    $args = array(
	        'hide_empty' => false
	    );

	    if ( taxonomy_exists( $tax_name ) ) {
	        $taxonomies = get_terms( $tax_name, $args );
	        
	        foreach ( $taxonomies as $taxonomy ) {
	            $tax_a[$taxonomy->term_id] = $taxonomy->name;
	        }
	    }
	    return $tax_a;
	}


	/**
	 * Get posts 
	 * @param  string $post_type 
	 * @return array
	 */
	function getPosts( $post_type = 'post' ){
	    global $wpdb;

	    /* Get Audio Tracks  */
	    $posts = array( 'none' => esc_html__( 'Select...', 'meloo-toolkit' ) );
	    $posts_query = $wpdb->prepare(
	        "
	        SELECT
	            {$wpdb->posts}.id,
	            {$wpdb->posts}.post_title
	        FROM 
	            {$wpdb->posts}
	        WHERE
	            {$wpdb->posts}.post_type = %s
	        AND 
	            {$wpdb->posts}.post_status = 'publish'
	        ",
	        $post_type
	    );

	    $sql_posts = $wpdb->get_results( $posts_query );
	      
	    if ( $sql_posts ) {
	        $count = 1;
	        foreach( $sql_posts as $track_post ) {
	            $posts[$track_post->id] = $track_post->post_title;
	            $count++;
	        }
	    }

	    return $posts;
	}


	/**
	 * Get Events
	 * @return array
	 */
	public function getEvents() {

		 $future_tax = array(
	        array(
				'taxonomy' => $this->theme . '_event_type',
				'field'    => 'slug',
				'terms'    => 'future-events'
	         )
	    );
	    $future_events = get_posts( array(
	        'post_type' => $this->theme . '_events',
	        'showposts' => -1,
	        'tax_query' => $future_tax,
	        'orderby'   => 'meta_value',
	        'meta_key'  => '_event_date_start',
	        'order'     => 'ASC'
	    ));

	    $events = array();
	    foreach( $future_events as $event ) {
	        $date = get_post_meta( $event->ID, '_event_date_start', true );
	        $events[$event->ID] = $event->post_title . ' ' . $date;
	    }
	    return $events;

	}


	/**
	 * Get all sliders in array
	 * @return array
	 */
	public function getSliders() {

		global $wpdb;

		$slider = array();
	    $slider_post_type = $this->theme . '_slider';
	    $slider_query = $wpdb->prepare(
	        "
	        SELECT
	            {$wpdb->posts}.id,
	            {$wpdb->posts}.post_title
	        FROM 
	            {$wpdb->posts}
	        WHERE
	            {$wpdb->posts}.post_type = %s
	        AND 
	            {$wpdb->posts}.post_status = 'publish'
	        ",
	        $slider_post_type
	    );

	    $sql_slider = $wpdb->get_results( $slider_query );
	    $slider[''] = '';
	    if ( $sql_slider ) {
	        $count = 0;
	        foreach( $sql_slider as $track_post ) {
	            $slider[$track_post->post_title] = $track_post->id;
	            $count++;
	        }
	    }
	    return $slider;
	}


	/**
	 * Get all tracks in array
	 * @return array
	 */
	public function getTracks() {

		 global $wpdb;

	    /* Get Audio Tracks  */
	    $tracks = array( 'none' => esc_html__( 'Select tracks...', 'meloo-toolkit' ) );
	    $tracks_post_type = $this->theme . '_tracks';
	    $tracks_query = $wpdb->prepare(
	        "
	        SELECT
	            {$wpdb->posts}.id,
	            {$wpdb->posts}.post_title
	        FROM 
	            {$wpdb->posts}
	        WHERE
	            {$wpdb->posts}.post_type = %s
	        AND 
	            {$wpdb->posts}.post_status = 'publish'
	        ",
	        $tracks_post_type
	    );

	    $sql_tracks = $wpdb->get_results( $tracks_query );
	      
	    if ( $sql_tracks ) {
	        $count = 1;
	        foreach( $sql_tracks as $track_post ) {
	            $tracks[$track_post->id] = $track_post->post_title;
	            $count++;
	        }
	    }

	    return $tracks;
	}


	/**
	 * Get the theme option
	 * @return string|bool|array
	 */
	public function option( $option, $default = null ) {

		if ( $this->theme_panel === false || ! is_array( $this->theme_panel )  || ! isset( $option ) ) {
			return false;
		}
		if ( isset( $this->theme_panel[ $option ] ) ) {
			return $this->theme_panel[ $option ];
		} elseif ( $default !== null ) {
			return $default;
		} else {	
			return false;
		}
	
	}


}