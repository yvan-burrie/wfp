<?php
/**
 * Rascals MetaBox
 *
 * Register Page Metabox
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
function meloo_toolkit_mb_page() {

	$rascals_mb = new Meloo_Toolkit_Metaboxes();

	/* ==================================================
	  Page 
	================================================== */

	/* Meta info */ 
	$meta_info = array(
		'title' => esc_html__( 'Page Options', 'meloo-toolkit'), 
		'id'    =>'rascals_mb_page', 
		'page'  => array(
			'page'
		), 
		'context'  => 'normal', 
		'priority' => 'high', 
		'callback' => '', 
		'template' => array( 
			'default'
		),
	);

	/* Box Filter */
	if ( has_filter( 'rascals_mb_page_box' ) ) {
		$meta_info = apply_filters( 'rascals_mb_page_box', $meta_info );
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
				'std'    => 'default',
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
				'name'      => esc_html__( 'Background', 'meloo-toolkit' ),
				'id'        => '_content_bg',
				'type'      => 'bg_generator',
				'std'       => '',
				'separator' => true,
				'desc'      => esc_html__( 'Add background image.', 'meloo-toolkit' ),
			),

		array(
			'type' => 'tab_close'
		),


		/* Import: Facebook Sharing */
		meloo_toolkit_mb_common( 'facebook_sharing_tab' ),
		
	);

	/* Options Filter */
	if ( has_filter( 'rascals_mb_page_opts' ) ) {
		$meta_options = apply_filters( 'rascals_mb_page_opts', $meta_options );
	}

	/* Add class instance */
	$rascals_mb_page = new RascalsBox( $meta_options, $meta_info );
		
}

return meloo_toolkit_mb_page();