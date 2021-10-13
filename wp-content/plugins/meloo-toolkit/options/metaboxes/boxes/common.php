<?php
/**
 * Rascals MetaBox
 *
 * Register Post Metabox
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
 * Return Intro options depend on displayed page or post
 * @return array
 */
function meloo_toolkit_mb_intro_opts(){
 	global $post, $title, $action, $current_screen;

	/* Get post/page data */
	$template_name = '';
	$post_type = '';

	if ( isset( $_GET['post'] ) ) { 
		$template_name = get_post_meta( $_GET['post'], '_wp_page_template', true );
		$post_type = get_post_type( $_GET['post'] );
	} elseif ( isset( $_GET['post_type'] ) ) {
		$post_type = $_GET['post_type'];
	} 

	// Intro type
	$intro_type = array(
		array( 'name' => esc_html__( 'Image', 'meloo-toolkit' ), 'value' => 'image' ),
		array( 'name' => esc_html__( 'Image With Link', 'meloo-toolkit' ), 'value' => 'image_link' ),
		array( 'name' => esc_html__( 'Image With Lightbox', 'meloo-toolkit' ), 'value' => 'image_lightbox' ),
		array( 'name' => esc_html__( 'Slider', 'meloo-toolkit' ), 'value' => 'slider' ),
		array( 'name' => esc_html__( 'YouTube Movie', 'meloo-toolkit' ), 'value' => 'youtube' ),
		array( 'name' => esc_html__( 'Vimeo Movie', 'meloo-toolkit' ), 'value' => 'vimeo' ),
		array( 'name' => esc_html__( 'Google Map', 'meloo-toolkit' ), 'value' => 'gmap' ),
		array( 'name' => esc_html__( 'Disabled', 'meloo-toolkit' ), 'value' => 'disabled' )
	);

	/* Special options for posts and pages templates */
	if ( $template_name == 'page-templates/test.php' ) {
		$intro_type[] = array( 
			array( 'name' => esc_html__( 'Full Screen Image', 'meloo-toolkit' ), 'value' => 'intro_full_image' ),
			array( 'name' => esc_html__( 'Full Screen Image with Content', 'meloo-toolkit' ), 'value' => 'intro_full_image_content' ),
			array( 'name' => esc_html__( 'Full Screen Slider', 'meloo-toolkit' ), 'value' => 'intro_full_slider' ),
			array( 'name' => esc_html__( 'Full Screen YouTube Background', 'meloo-toolkit' ), 'value' => 'intro_youtube_fullscreen' )

		 );
	};

	if ( $post_type == 'test' ) {
		$intro_type[] = array( 'name' => esc_html__( 'Artist Profile', 'meloo-toolkit' ), 'value' => 'artist_profile' );
	};

	
	return $intro_type;
}


/**
 * Display common metaboxes
 * @param  string $tab_name
 * @return array   
 */
function meloo_toolkit_mb_common( $tab_name = null ) {

	$rascals_mb = new Meloo_Toolkit_Metaboxes();
	
	$common_metaboxes = array(

		/* Page layout
		 -------------------------------- */
		'page_layout' => array(

			// Page layout
			array(
				'name'   => esc_html__( 'Page Layout', 'meloo-toolkit' ),
				'id'     => '_page_layout',
				'type'   => 'select_image',
				'std'    => 'narrow',
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
					array( 
						'id'    => 'page_builder', 
						'title' => esc_html__( 'Create page through The Page Builder', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/page-builder.png'
					),

				),
				'desc' => esc_html__( 'Choose the page layout. When is selected "Page Builder", it will switch to a full width layout (with no sidebar and title). If you want to use a sidebar with the page builder please use the Widget Sidebar block', 'meloo-toolkit' )
			),

			// Sidebars  
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
					"element" => '_page_layout',
					"value"   => array( 'left_sidebar', 'right_sidebar' )
			    )
			), 

		),

		
		/* TAB: FACEBOOK SHARING
		 -------------------------------- */
		'facebook_sharing_tab' => array(
			array(
				'name' => esc_html__( 'Facebook Sharing', 'meloo-toolkit' ),
				'id'   => 'tab-share',
				'type' => 'tab_open',
			),
				/* Is Facebook sharing */
				array(
					'name'    => esc_html__( 'Facebook Sharing', 'meloo-toolkit' ),
					'id'      => '_fb_sharing',
					'type'    => 'switch_button',
					'std'     => get_theme_mod( 'fb_sharing', true ),
					'options' => array(
						array( 'name' => 'On', 'value' => true ), // ON
						array( 'name' => 'Off', 'value' => false ) // OFF
					),
					'separator' => true,
					'desc'      => esc_html__( 'Show or hide Facebook share options (head tags). Tip: This option can be set as the default in Theme Customizer > Single Post', 'meloo-toolkit' ),
				),

				/* Image */
				array(
					'name'       => esc_html__( 'Image', 'meloo-toolkit' ),
					'id'         => 'share_image',
					'type'       => 'add_image',
					'source'     => 'media_libary', // all, media_libary, external_link
					'desc'       => esc_html__('Use images that are at least 1200 x 630 pixels for the best display on high resolution devices. At the minimum, you should use images that are 600 x 315 pixels to display link page posts with larger images. If share data isn\'t visible on Facebook, please use this link:', 'meloo-toolkit' ) . '<br>'.'<a href="https://developers.facebook.com/tools/debug/" target="_blank">Facbook Debuger</a>',
					'dependency' => array(
						"element" => '_fb_sharing',
						"value"   => array( true )
			    	)
				),

				/* Title */
				array(
					'name'       => esc_html__( 'Title', 'meloo-toolkit' ),
					'id'         => '_share_title',
					'type'       => 'text',
					'std'        => '',
					'desc'       => esc_html__( 'A clear title without branding or mentioning the domain itself.', 'meloo-toolkit' ),
					'dependency' => array(
						"element" => '_fb_sharing',
						"value"   => array( true )
			    	)
				),

				/* Video */
				array(
					'name'       => esc_html__( 'Video', 'meloo-toolkit' ),
					'id'         => '_share_video',
					'type'       => 'text',
					'std'        => '',
					'desc'       => esc_html__( 'Video URL.', 'meloo-toolkit' ),
					'dependency' => array(
						"element" => '_fb_sharing',
						"value"   => array( true )
			    	)
				),

				/* Short Description */
				array(
					'name'       => esc_html__( 'Short Description', 'meloo-toolkit' ),
					'id'         => '_share_description',
					'type'       => 'textarea',
					'tinymce'    => 'false',
					'std'        => '',
					'height'     => '80',
					'desc'       => esc_html__( 'A clear description, at least two sentences long.', 'meloo-toolkit' ),
					'dependency' => array(
						"element" => '_fb_sharing',
						"value"   => array( true )
			    	)
				),

			array(
				'type' => 'tab_close'
			),
		)

	);

	if ( isset( $common_metaboxes[$tab_name] ) ) {
		return  $common_metaboxes[$tab_name];
	} 

	return;
		
}