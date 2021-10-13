<?php
/**
 * Rascals MetaBox
 *
 * Register Artists Metabox
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/* ==================================================
  Metaboxes options
================================================== */
function meloo_toolkit_mb_artists() {

	$rascals_mb = new Meloo_Toolkit_Metaboxes();


	/* ==================================================
	  Single Artists
	================================================== */

	/* Meta info */ 
	$meta_info = array(
		'title' => esc_html__( 'Artist Options', 'meloo-toolkit'), 
		'id'    =>'rascals_mb_artist_post', 
		'page'  => array(
			'meloo_artists'
		), 
		'context'  => 'normal', 
		'priority' => 'high', 
		'callback' => '', 
		'template' => array( 
			'post'
		),
	);

	/* Box Filter */
	if ( has_filter( 'rascals_mb_artist_post_box' ) ) {
		$meta_info = apply_filters( 'rascals_mb_artist_post_box', $meta_info );
	}

	/* Meta options */
	$meta_options = array(


		/* TAB: CONTENT
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Content', 'meloo-toolkit' ),
			'id'   => 'tab-content',
			'type' => 'tab_open',
		),

			/* Import: Page layout */
			meloo_toolkit_mb_common( 'page_layout' ),
			
			/* Header Layout */
			array(
				'name'   => esc_html__( 'Header Layout', 'meloo-toolkit' ),
				'id'     => '_header_layout',
				'type'   => 'select_image',
				'std'    => 'transparent',
				'images' => array(
					array( 
						'id'    => 'default', 
						'title' => esc_html__( 'Transparnet header with default image background', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/header-type-1.png'
					),
					array( 
						'id'    => 'simple_title', 
						'title' => esc_html__( 'Simple header with solid background color and page title', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/header-type-2.png'
					),
					array( 
						'id'    => 'transparent', 
						'title' => esc_html__( 'Transparnet header with custom background created via page builder', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/header-type-3.png'
					),
					array( 
						'id'    => 'simple', 
						'title' => esc_html__( 'Simple header with solid background color', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/header-type-4.png'
					),

				),
				'desc' => esc_html__( 'Choose the page layout. When is selected "Page Builder", it will switch to a full width layout (with no sidebar and title). If you want to use a sidebar with the page builder please use the Widget Sidebar block', 'meloo-toolkit' ),
			),

			/* Content Background */
			array(
				'name' => esc_html__( 'Background', 'meloo-toolkit' ),
				'id' => '_content_bg',
				'type' => 'bg_generator',
				'std' => '',
				'separator' => true,
				'desc' => esc_html__( 'Add background image.', 'meloo-toolkit' ),
			),

		array(
			'type' => 'tab_close'
		),


		/* TAB: LOOP
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Loop Options', 'meloo-toolkit' ),
			'id'   => 'tab-loop',
			'type' => 'tab_open',
		),

			/* Tracks */
			array(
				'name' => esc_html__( 'Thumbnail Tracks', 'meloo-toolkit' ),
				'id'   => array(
					array( 'id' => '_track_id', 'std' => ''),
					array( 'id' => '_tracks_ids', 'std' => '') 
				),
				'type'      => 'select_tracks',
				'options'   => $rascals_mb->getTracks( 'meloo_tracks' ),
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Select tracklist post and drag and drop tracks to set the order. Tracks will be added to release thumbnail. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left. Tip: Modifying this list does not affect on the original tracklist in Tracks Manager', 'meloo-toolkit' ),
			),

			/* Badge */
			array(
				'name' => esc_html__( 'Thumbnail Badge', 'meloo-toolkit' ),
				'id'   => '_badge',
				'type' => 'select',
				'std'  => '',
				'options' => array(
					array( 'name' => esc_html__( 'None', 'meloo-toolkit' ), 'value' => '' ),
					array( 'name' => esc_html__( 'New', 'meloo-toolkit' ), 'value' => 'new' ),
					array( 'name' => esc_html__( 'Free', 'meloo-toolkit' ), 'value' => 'free' )
				),
				'desc' => esc_html__( 'Select badge.', 'meloo-toolkit' )
			),


		array(
			'type' => 'tab_close'
		),

		/* Import: Facebook Sharing */
		meloo_toolkit_mb_common( 'facebook_sharing_tab' ),

	);

	/* Options Filter */
	if ( has_filter( 'rascals_mb_artist_post_opts' ) ) {
		$meta_options = apply_filters( 'rascals_mb_artist_post_opts', $meta_options );
	}

	/* Add class instance */
	$rascals_mb_artist_post = new RascalsBox( $meta_options, $meta_info );


	/* ==================================================
	  Artists Template
	================================================== */

	/* Meta info */ 
	$meta_info = array(
		'title' => esc_html__( 'Artists Options', 'meloo-toolkit'), 
		'id'    =>'rascals_mb_artist_template', 
		'page'  => array(
			'page'
		), 
		'context'  => 'normal', 
		'priority' => 'high', 
		'callback' => '', 
		'template' => array( 
			'template-artists.php'
		),
		'textdomain' => 'meloo-toolkit'
	);

	/* Box Filter */
	if ( has_filter( 'rascals_mb_artist_template_box' ) ) {
		$meta_info = apply_filters( 'rascals_mb_artist_template_box', $meta_info );
	}

	/* Meta options */
	$meta_options = array(
		

		/* TAB: GENERAL
		 -------------------------------- */
		array(
			'name' => esc_html__( 'General', 'meloo-toolkit' ),
			'id'   => 'tab-general',
			'type' => 'tab_open',
		),

			/* Page Builder */
			array(
				'name' => esc_html__( 'Page Builder', 'meloo-toolkit' ),
				'id'   => '_page_builder',
				'type' => 'select_image',
				'std'  => 'off',
				'images' => array(
					array( 
						'id' => 'off', 
						'title' => esc_html__( 'Disabled', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/none.png'
					),
					array( 
						'id' => 'on', 
						'title' => esc_html__( 'Create page through The Page Builder', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/page-builder.png'
					),
				),
				'desc' => esc_html__( 'Enable or disable page builder above main posts loop. When is enabled "Page Builder", it will switch to a full width layout (with no title).', 'meloo-toolkit' )
			),

			/* Show Header Over Content */
			array(
				'name' => esc_html__( 'Header Over Content', 'meloo-toolkit' ),
				'id'   => '_show_header_above',
				'type' => 'switch_button',
				'std'  => '0',
				'options' => array(
					array( 'name' => 'On', 'value' => true ), // ON
					array( 'name' => 'Off', 'value' => '0' ) // OFF
				),
				'separator' => true,
				'desc' => esc_html__( 'Show header over content.', 'meloo-toolkit' ),
				'dependency' => array(
		        	"element" => '_page_builder',
		        	"value" => array( 'on' )
		    	)
			),

			/* Artists layout */
			array(
				'name' => esc_html__( 'Releases Layout', 'meloo-toolkit' ),
				'id'   => '_artist_layout',
				'type' => 'select_image',
				'std'  => 'wide',
				'images' => array(
					array( 
						'id'    => 'left_sidebar', 
						'title' => esc_html__( 'Sidebar Left', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/left-sidebar.png'
					),
					array( 
						'id'    => 'narrow', 
						'title' => esc_html__( 'Narrow Layout', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/narrow.png'
					),
					array( 
						'id'    => 'wide', 
						'title' => esc_html__( 'Wide Layout', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/wide.png'
					),
					array( 
						'id'    => 'right_sidebar', 
						'title' => esc_html__( 'Sidebar Right', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/right-sidebar.png'
					),

				),
				'desc' => esc_html__( 'Choose the recent artists layout. The settings from this panel applies to the bottom of the page, where the loop and sidebar is.', 'meloo-toolkit' )
			),

			/* Sidebars */ 
			array(
				'name'       => esc_html__( 'Custom Sidebar', 'meloo-toolkit' ),
				'id'         => '_custom_sidebar',
				'type'       => 'select_array',
				'std'        => '',
				'options'	 => array(
					array( 'name' => esc_html__( 'Primary Sidebar', 'meloo-toolkit' ), 'value' => '_default' ),
				),
				'array' 	 => $rascals_mb->getSidebars( 'meloo_panel_opts' ),
				'key' 		 => 'value',
				'separator'  => true,
				'desc'       => esc_html__( 'Select custom or primary sidebar.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_artist_layout',
					"value"   => array( 'left_sidebar', 'right_sidebar', 'hero_left_sidebar', 'hero_right_sidebar' )
			    )
			), 

			/* Fullwidth */
			array(
				'name'    => esc_html__( 'Full width?', 'meloo-toolkit' ),
				'id'      => '_fullwidth',
				'type'    => 'switch_button',
				'std'     => '0',
				'options' => array(
					array( 'name' => 'On', 'value' => 'full-width' ), // ON
					array( 'name' => 'Off', 'value' => '0' ) // OFF
				),
				'separator' => true,
				'desc'      => esc_html__( 'Show full width images grid.', 'meloo-toolkit' ),
			),	

		array(
			'type' => 'tab_close'
		),


		/* TAB: LOOP SETTINGS
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Loop Settings', 'meloo-toolkit' ),
			'id'   => 'tab-loop',
			'type' => 'tab_open',
		),


			/* Block */
			array(
				'name' => esc_html__( 'Select Block', 'meloo-toolkit' ),
				'id'   => '_block',
				'type' => 'select_image',
				'std'  => 'artists-block1',
				'images' => array(
					array( 
						'id'    => 'artists-block1', 
						'title' => esc_html__( 'Block 1', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block8.png'
					),
					array( 
						'id'    => 'artists-block2', 
						'title' => esc_html__( 'Block 2', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block9.png'
					),
					array( 
						'id'    => 'artists-block3', 
						'title' => esc_html__( 'Block 3', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block10.png'
					),
					
				),
				'desc' => esc_html__( 'Select a block to be used in the loop of this page.', 'meloo-toolkit' )
			),


			/* Pagination Method */
			array(
				'name' => esc_html__( 'Pagination Method', 'meloo-toolkit' ),
				'id'   => '_pagination',
				'type' => 'select',
				'std'  => 'next_prev',
				'options' => array(
					array( 'name' => esc_html__( 'Next/Prev Pagination', 'meloo-toolkit' ), 'value' => 'next_prev' ),
					array( 'name' => esc_html__( 'Load More Button', 'meloo-toolkit' ), 'value' => 'load_more' ),
					array( 'name' => esc_html__( 'Infinite Load', 'meloo-toolkit' ), 'value' => 'infinite' )
				),
				'desc' => esc_html__( 'Select pagination method.', 'meloo-toolkit' )
			),


			/* Ajax Filter */
			array(
				'name'  => esc_html__( 'Ajax Filter', 'meloo-toolkit' ),
				'id'    => '_ajax_filter',
				'type'  => 'select',
				'std'   => '',
				'options' => array(
					array( 'name' => esc_html__( 'None', 'meloo-toolkit' ), 'value' => '' ),
					array( 'name' => esc_html__( 'On Left', 'meloo-toolkit' ), 'value' => 'on-left' ),
					array( 'name' => esc_html__( 'Center', 'meloo-toolkit' ), 'value' => 'center' ),
					array( 'name' => esc_html__( 'On Right', 'meloo-toolkit' ), 'value' => 'on-right' ),
					array( 'name' => esc_html__( 'Multiple Filters', 'meloo-toolkit' ), 'value' => 'multiple-filters' ),
				),
				'separator' => false,
				'desc' => esc_html__( 'Show or hide Ajax filter.', 'meloo-toolkit' ),
				'dependency' => array(
		        	"element" => '_pagination',
		        	"value" => array( 'load_more', 'infinite' )
		    	)
			),

			/* Filter Selection method */ 
			array(
				'name'       => esc_html__( 'Selection Method', 'meloo-toolkit' ),
				'id'         => '_filter_sel_method',
				'type'       => 'select',
				'std'        => 'filter-sel-multiple',
				'options'    => array(
					array( 'name' => 'Multiple', 'value' => 'filter-sel-multiple' ), 
					array( 'name' => 'Single', 'value' => 'filter-sel-single' ) 
				),
				'separator'  => false,
				'desc'       => esc_html__( 'Select filter selection method.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_ajax_filter',
					"value"   => array( 'on-left', 'center', 'on-right', 'multiple-filters' )
			    )
			),  

			/* Visible filter on startup */ 
			array(
				'name'       => esc_html__( 'Show filters on Start', 'meloo-toolkit' ),
				'id'         => '_show_filters',
				'type'       => 'switch_button',
				'std'        => 'hide-filters',
				'options'    => array(
					array( 'name' => 'On', 'value' => 'show-filters' ), // ON
					array( 'name' => 'Off', 'value' => 'hide-filters' ) // OFF
				),
				'separator'  => false,
				'desc'       => esc_html__( 'Show filters when page is loaded. Otherwise the filters are shown after clicking the "Filters" button.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_ajax_filter',
					"value"   => array( 'multiple-filters' )
			    )
			),  

		array(
			'type' => 'tab_close'
		),


		/* TAB: LOOP FILTERS
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Filter', 'meloo-toolkit' ),
			'id'   => 'tab-filter',
			'type' => 'tab_open',
		),

			/* Limit */
			array(
				'name'  => esc_html__( 'Limit post number', 'meloo-toolkit' ),
				'group' => '_filter_atts_artists',
				'id'    => 'limit',
				'type'  => 'range',
				'max'   => '999',
				'min'   => '1',
				'unit'  => 'posts',
				'step'  => '1',
				'std'   => '8',
				'separator' => true,
				'desc'  => esc_html__('If the field is empty the limit post number will be the number from Wordpress settings -> Reading', 'meloo-toolkit' ),
			), 

			/* Sort Order */
			array(
				'name'  => esc_html__( 'Sort Order', 'meloo-toolkit' ),
				'group' => '_filter_atts_artists',
				'id'    => 'sort_order',
				'type'  => 'select',
				'std'   => 'menu_order',
				'options' => array(
					array( 'name' => esc_html__( 'Drag and Drop', 'meloo-toolkit' ), 'value' => 'menu_order' ),
					array( 'name' => esc_html__( 'Latest (By date)', 'meloo-toolkit' ), 'value' => 'post_date' ),
					array( 'name' => esc_html__( 'Alphabetical A -> Z', 'meloo-toolkit' ), 'value' => 'title' ),
					array( 'name' => esc_html__( 'Random Posts', 'meloo-toolkit' ), 'value' => 'rand' ),
					array( 'name' => esc_html__( 'Random Posts Today', 'meloo-toolkit' ), 'value' => 'rand_today' ),
					array( 'name' => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ), 'value' => 'rand_week' ),
					array( 'name' => esc_html__( 'Most Commented', 'meloo-toolkit' ), 'value' => 'comment_count' ),
				),
				'separator' => true,
				'desc' => esc_html__( 'How to sort the posts.', 'meloo-toolkit' ),
			),

			/* Post IDS */ 
			array(
				'name'      => esc_html__( 'Post ID', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'post_ids',
				'type'      => 'text',
				'std'       => '',
				'separator' => true,
				'desc'      => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' ),
			),

			/* Offset */ 
			array(
				'name'      => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'offset',
				'type'      => 'range',
				'max'       => '999',
				'min'       => '0',
				'unit'      => 'posts nr',
				'step'      => '1',
				'std'       => '0',
				'separator' => true,
				'desc'      => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' ),
			),

			/* Filters
			  -------------------------------- */ 
			
			/* Order */ 
			array(
				'name'      => esc_html__( 'Filters Order', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'filters_order',
				'type'      => 'text',
				'std'       => '1,2',
				'separator' => true,
				'desc'      => esc_html__( 'Enter the filters order number separated by commas e.g.: 2,1 (Display only two filters, the second will be displayed first)', 'meloo-toolkit' ),
			),

			/* Filter 1 */ 
			array(
				'name'      => esc_html__( 'Filter 1', 'meloo-toolkit' ),
				'sub_name'  => esc_html__( 'Name', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_label',
				'type'      => 'text',
				'std'       => esc_html__( 'All', 'meloo-toolkit' ),
				'separator' => false,
				'desc'      => esc_html__( 'Filter name.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Categories', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_ids',
				'type'      => 'taxonomy',
				'taxonomy'  => 'meloo_artists_cats',
				'multiple'  => true,
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple categories. Hold the CTRL key (PC) or COMMAND key (Mac) and click the items in a list to choose them. Click all the items you want to select. They don’t have to be next to each other.
				Click any item again to deselect it, e.g. if you have made a mistake. Remember to keep the CTRL or COMMAND key pressed.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Slugs', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_slugs',
				'type'      => 'text',
				'std'       => '',
				'separator' => true,
				'desc' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: dubstep,hip-hop,glitch). Please note: Categories above have a higher priority than slugs names, so if you selected categories names, slugs will not be processed.', 'meloo-toolkit' ),
			),

			/* Filter 2 */
			array(
				'name'      => esc_html__( 'Filter 2', 'meloo-toolkit' ),
				'sub_name'  => esc_html__( 'Name', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_label2',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter name.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Categories', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_ids2',
				'type'      => 'taxonomy',
				'taxonomy'  => 'meloo_artists_cats2',
				'multiple'  => true,
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple categories. Hold the CTRL key (PC) or COMMAND key (Mac) and click the items in a list to choose them. Click all the items you want to select. They don’t have to be next to each other.
				Click any item again to deselect it, e.g. if you have made a mistake. Remember to keep the CTRL or COMMAND key pressed.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Slugs', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_slugs2',
				'type'      => 'text',
				'std'       => '',
				'separator' => true,
				'desc' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: dubstep,hip-hop,glitch). Please note: Categories above have a higher priority than slugs names, so if you selected categories names, slugs will not be processed.', 'meloo-toolkit' ),
			),

			/* Filter 3 */
			array(
				'name'      => esc_html__( 'Filter 3', 'meloo-toolkit' ),
				'sub_name'  => esc_html__( 'Name', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_label3',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter name.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Categories', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_ids3',
				'type'      => 'taxonomy',
				'taxonomy'  => 'meloo_artists_cats3',
				'multiple'  => true,
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple categories. Hold the CTRL key (PC) or COMMAND key (Mac) and click the items in a list to choose them. Click all the items you want to select. They don’t have to be next to each other.
				Click any item again to deselect it, e.g. if you have made a mistake. Remember to keep the CTRL or COMMAND key pressed.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Slugs', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_slugs3',
				'type'      => 'text',
				'std'       => '',
				'separator' => true,
				'desc' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: dubstep,hip-hop,glitch). Please note: Categories above have a higher priority than slugs names, so if you selected categories names, slugs will not be processed.', 'meloo-toolkit' ),
			),


			/* Filter 4 */
			array(
				'name'      => esc_html__( 'Filter 4', 'meloo-toolkit' ),
				'sub_name'  => esc_html__( 'Name', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_label4',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter name.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Categories', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_ids4',
				'type'      => 'taxonomy',
				'taxonomy'  => 'meloo_artists_cats4',
				'multiple'  => true,
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple categories. Hold the CTRL key (PC) or COMMAND key (Mac) and click the items in a list to choose them. Click all the items you want to select. They don’t have to be next to each other.
				Click any item again to deselect it, e.g. if you have made a mistake. Remember to keep the CTRL or COMMAND key pressed.', 'meloo-toolkit' ),
			),
			array(
				'sub_name'  => esc_html__( 'Slugs', 'meloo-toolkit' ),
				'group'     => '_filter_atts_artists',
				'id'        => 'category_slugs4',
				'type'      => 'text',
				'std'       => '',
				'separator' => true,
				'desc' => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: dubstep,hip-hop,glitch). Please note: Categories above have a higher priority than slugs names, so if you selected categories names, slugs will not be processed.', 'meloo-toolkit' ),
			),
			
		
		array(
			'type' => 'tab_close'
		),


		/* Import: Facebook Sharing */
		meloo_toolkit_mb_common( 'facebook_sharing_tab' ),

		

	);

	/* Options Filter */
	if ( has_filter( 'rascals_mb_artist_template_opts' ) ) {
		$meta_options = apply_filters( 'rascals_mb_artist_template_opts', $meta_options );
	}

	/* Add class instance */
	$rascals_mb_artist_template = new RascalsBox( $meta_options, $meta_info );
		
}

return meloo_toolkit_mb_artists();