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


/* ==================================================
  Metaboxes options
================================================== */
function meloo_toolkit_mb_post() {

	$rascals_mb = new Meloo_Toolkit_Metaboxes();


	/* ==================================================
	  Single Post 
	================================================== */

	/* Meta info */ 
	$meta_info = array(
		'title' => esc_html__( 'Post Options', 'meloo-toolkit'), 
		'id'    =>'rascals_mb_post', 
		'page'  => array(
			'post'
		), 
		'context'  => 'normal', 
		'priority' => 'high', 
		'callback' => '', 
		'template' => array( 
			'default'
		),
	);

	/* Box Filter */
	if ( has_filter( 'rascals_mb_post_box' ) ) {
		$meta_info = apply_filters( 'rascals_mb_post_box', $meta_info );
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

			/* Post Template */
			array(
				'name'   => esc_html__( 'Post Template', 'meloo-toolkit' ),
				'id'     => '_post_template',
				'type'   => 'select_image',
				'std'    => 'simple',
				'images' => array(
					array( 
						'id'    => 'left_sidebar', 
						'title' => esc_html__( 'Sidebar Left', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/post-templates/left-sidebar.png'
					),
					array( 
						'id'    => 'simple', 
						'title' => esc_html__( 'Simple Layout', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/post-templates/simple.png'
					),
					array( 
						'id'    => 'right_sidebar', 
						'title' => esc_html__( 'Sidebar Right', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/post-templates/right-sidebar.png'
					),
					array( 
						'id'    => 'hero_left_sidebar', 
						'title' => esc_html__( 'Title on Hero Image with Sidebar', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/post-templates/hero-sidebar-left.png'
					),
					array( 
						'id'    => 'hero_center', 
						'title' => esc_html__( 'Title on Hero Image', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/post-templates/hero-center.png'
					),
					array( 
						'id'    => 'hero_right_sidebar', 
						'title' => esc_html__( 'Title on Hero Image with Sidebar', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/post-templates/hero-sidebar-right.png'
					),

				),
				'desc' => esc_html__( 'Choose the post template.', 'meloo-toolkit' )
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
					"element" => '_post_template',
					"value"   => array( 'left_sidebar', 'right_sidebar', 'hero_left_sidebar', 'hero_right_sidebar' )
			    )
			), 

			/* Hero Image */
			array(
				'name'   => esc_html__( 'Hero Image', 'meloo-toolkit' ),
				'id'     => '_hero_image',
				'type'   => 'add_image',
				'source' => 'media_libary', // all, media_libary, external_link
				'desc'   => esc_html__('Use image that are at least 1920 x 1080 pixels or higher for the best display. Note: If this field is empty then will be displayed by default.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_post_template',
					"value"   => array( 'hero_left_sidebar', 'hero_center', 'hero_right_sidebar' )
		    	),
		    	'separator' => false
			),

			/* Hero Margin */
			array(
				'name'       => esc_html__( 'Hero Image Margin', 'meloo-toolkit' ),
				'id'         => '_hero_margin',
				'type'       => 'range',
				'max'        => '600',
				'min'        => '0',
				'unit'       => 'px',
				'step'       => '10',
				'std'        => '400',
				'desc'       => esc_html__('Set margin between title and top of the page. Tip: Hero can be displayed under Hero section (Theme Customizer > Header > Header Style > Show Header Above Hero )', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_post_template',
					"value"   => array( 'hero_left_sidebar', 'hero_center', 'hero_right_sidebar' )
		    	)
			),

			/* Hero Margin */
			array(
				'name'    => esc_html__( 'Hero Image Position', 'meloo-toolkit' ),
				'id'      => '_hero_bg_position',
				'type'    => 'select',
				'std'     => 'center',
				'options' => array(
					array( 'name' => 'Top', 'value' => 'top' ), 
					array( 'name' => 'Center', 'value' => 'center' ),
					array( 'name' => 'Bottom', 'value' => 'bottom' ),
				),
				'desc'       => esc_html__( 'Set background vertical position.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_post_template',
					"value"   => array( 'hero_left_sidebar', 'hero_center', 'hero_right_sidebar' )
		    	)
			),

			/* Featured Content */
			array(
				'name'   => esc_html__( 'Featured Content', 'meloo-toolkit' ),
				'id'     => '_featured_content',
				'type'   => 'select_image',
				'std'    => 'image',
				'size'   => 'medium', // original, medium, small
				'images' => array(
					array( 
						'id'    => 'none', 
						'title' => esc_html__( 'Disabled', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/none.png'
					),
					array( 
						'id'    => 'image', 
						'title' => esc_html__( 'Image', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/image.png'
					),
					array( 
						'id'    => 'youtube', 
						'title' => esc_html__( 'YouTube Video', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/youtube.png'
					),
					array( 
						'id'    => 'vimeo', 
						'title' => esc_html__( 'Vimeo Video', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/vimeo.png'
					),
					array( 
						'id'    => 'soundcloud', 
						'title' => esc_html__( 'Soundcloud', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/soundcloud.png'
					),
					array( 
						'id'    => 'spotify', 
						'title' => esc_html__( 'Spotify', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/spotify.png'
					),
					array( 
						'id'    => 'bandcamp', 
						'title' => esc_html__( 'Bandcamp', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/bandcamp.png'
					),
					array( 
						'id'    => 'tracks', 
						'title' => esc_html__( 'Music Tracks', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/scamp-player.png'
					),
					
				),
				'desc' => esc_html__( 'Choose featured content.', 'meloo-toolkit' )
			),

			/* Media Link */
			array(
				'name'       => esc_html__( 'Media Link', 'meloo-toolkit' ),
				'id'         => '_media_link',
				'type'       => 'text',
				'std'        => '',
				'desc'       => esc_html__( 'Paste media link.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'youtube', 'vimeo', 'soundcloud', 'spotify' )
		    	)
			),

			/* Bandcamp Link */
			array(
				'name'   => esc_html__( 'Bandcamp Embed Code', 'meloo-toolkit' ),
				'id'     => '_bandcamp_code',
				'type'   => 'textarea',
				'height' => '100',
				'std'    => '',
				'desc'   => esc_html__( 'Paste iframe embed code.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'bandcamp' )
		    	)
			),

			/* Source name */
			array(
				'name'       => esc_html__( 'Source Name', 'meloo-toolkit' ),
				'id'         => '_source_name',
				'type'       => 'textarea',
				'height'     => '50',
				'std'        => '',
				'desc'       => esc_html__( 'Source name, this will appear at the bottom of the featured content.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'image', 'youtube', 'vimeo', 'soundcloud', 'spotify', 'bandcamp', 'tracks' )
		    	)
			),

			/* Tracks */
			array(
				'name' => esc_html__( 'Select Tracks', 'meloo-toolkit' ),
				'id'   => array(
					array( 'id' => '_track_id', 'std' => ''),
					array( 'id' => '_tracks_ids', 'std' => '') 
				),
				'type'       => 'select_tracks',
				'options'    => $rascals_mb->getTracks( 'meloo_tracks' ),
				'std'        => '',
				'separator'  => false,
				'desc'       => esc_html__( 'Select tracklist post and drag and drop tracks to set the order. If there are no tracks available, then you can add a audio tracks using Tacks Manager menu on the left. Tip: Modifying this list does not affect on the original tracklist in Tracks Manager', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'tracks' )
		    	)
			),

			/* Fixed height */
			array(
				'name'       => esc_html__( 'Fixed Height', 'meloo-toolkit' ),
				'id'         => '_fixed_height',
				'type'       => 'range',
				'min'        => 0,
				'max'        => 999,
				'std'        => '0',
				'separator'  => false,
				'desc'       => esc_html__( 'Set fixed height (px) of tracklist. If the value is set at "0" then the height of the list is set to automatic and the scroll on right is invisible.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'tracks' )
		    	)
			),

			/* Covers Images */
			array(
				'name'    => esc_html__( 'Show Cover Images', 'meloo-toolkit' ),
				'id'      => '_show_covers',
				'type'    => 'switch_button',
				'std'     => 'yes',
				'options' => array(
					array( 'name' => 'On', 'value' => 'yes' ), // ON
					array( 'name' => 'Off', 'value' => 'no' ) // OFF
				),
				'separator'  => false,
				'desc'       => esc_html__( 'Show or hide tracks cover images in tracklist', 'meloo-toolkit' ),
				'dependency' => array(
		        	"element" => '_featured_content',
		        	"value" => array( 'tracks' )
		    	)
			),

			/* Limit */
			array(
				'name'      => esc_html__( 'Display Limit', 'meloo-toolkit' ),
				'id'        => '_limit',
				'type'      => 'range',
				'min'       => 0,
				'max'       => 999,
				'std'       => 0,
				'separator' => false,
				'desc' => esc_html__( 'How many tracks will be visibile. If the value is set at "0" then all tracks will be shown.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'tracks' )
		    	)
			),

			/* Size */
			array(
				'name'    => esc_html__( 'Size', 'meloo-toolkit' ),
				'id'      => '_size',
				'type'    => 'select',
				'std'     => 'medium',
				'options' => array(
					array( 'name' => esc_html__( 'Medium', 'meloo-toolkit' ), 'value' => 'medium' ),
					array( 'name' => esc_html__( 'Large', 'meloo-toolkit' ), 'value' => 'large' ),
					array( 'name' => esc_html__( 'Extra Large', 'meloo-toolkit' ), 'value' => 'xlarge' ),
				),
				'separator'  => false,
				'desc'       => esc_html__( 'Select tracklist size.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'tracks' )
		    	)
			),

			/* AD */
			array(
				'name'    => esc_html__( 'Show Advertisement', 'meloo-toolkit' ),
				'id'      => '_show_ad',
				'type'    => 'switch_button',
				'std'     => 'yes',
				'options' => array(
					array( 'name' => 'On', 'value' => 'yes' ), // ON
					array( 'name' => 'Off', 'value' => '' ) // OFF
				),
				'separator' => false,
				'desc'      => esc_html__( 'Show or hide advertisement tracklist. AD can be set in Theme Panel > ADS > Tracklist Inline.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_featured_content',
					"value"   => array( 'tracks' )
		    	)
			),


		array(
			'type' => 'tab_close'
		),


		/* TAB: RELATED POSTS
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Related Posts', 'meloo-toolkit' ),
			'id'   => 'tab-related-posts',
			'type' => 'tab_open',
		),
			/* Is Related Posts */
				array(
				'name' => esc_html__( 'Related Posts', 'meloo-toolkit' ),
				'id' => '_related_posts',
				'type' => 'switch_button',
				'std' => get_theme_mod( 'related_posts', true ),
				'options' => array(
					array( 'name' => 'On', 'value' => true ), // ON
					array( 'name' => 'Off', 'value' => false ) // OFF
				),
				'separator' => true,
				'desc'      => esc_html__( 'Enable or disable the related posts section (bottom of single post pages). Tip: This option can be set as the default in Theme Customizer > Single Post', 'meloo-toolkit' ),
			),

			/* Display related posts by */
			array(
				'name'    => esc_html__( 'Display By', 'meloo-toolkit' ),
				'id'      => '_rp_display_by',
				'type'    => 'select',
				'std'     => get_theme_mod( 'rp_display_by', true ),
				'options' => array(
			  		array( 'name' => 'Tags', 'value' => 'tags' ),
					array( 'name' => 'Categories', 'value' => 'categories' ),
				),
				'desc'       => esc_html__('How to display the related posts:', 'meloo-toolkit' ) . '<br>' . esc_html__('by category - display posts from that have at least one category in common with the current post.', 'meloo-toolkit' ) . '<br>' . esc_html__('by tags - display posts that have at least one tag in common with the current post.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_related_posts',
					"value"   => array( true )
		    	)
			),

			/* Is Related Posts */
			array(
				'name'    => esc_html__( 'Show navigation', 'meloo-toolkit' ),
				'id'      => '_rp_show_nav',
				'type'    => 'switch_button',
				'std'     => get_theme_mod( 'rp_show_nav', true ),
				'options' => array(
					array( 'name' => 'On', 'value' => true ), // ON
					array( 'name' => 'Off', 'value' => false ) // OFF
				),
				'separator'  => true,
				'desc'       => esc_html__( 'Enable or disable related posts navigation arrows. Tip: This option can be set as the default in Theme Customizer > Single Post', 'meloo-toolkit' ),
				'dependency' => array(
		        	"element" => '_related_posts',
		        	"value" => array( true )
		    	)
			),


		array(
			'type' => 'tab_close'
		),


		/* TAB: REVIEWS
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Reviews', 'meloo-toolkit' ),
			'id'   => 'tab-reviews',
			'type' => 'tab_open',
		),
			/* Enable reviews? */
			array(
				'name'    => esc_html__( 'Product Review', 'meloo-toolkit' ),
				'id'      => '_has_reviews',
				'type'    => 'switch_button',
				'std'     => '0',
				'options' => array(
					array( 'name' => 'On', 'value' => true ), // ON
					array( 'name' => 'Off', 'value' => '0' ) // OFF
				),
				'separator' => true,
				'desc'      => esc_html__( 'Show or hide product reviews.', 'meloo-toolkit' ),
			),

			/* Reviews */
			array(
				'name'       => esc_html__( 'Rating', 'meloo-toolkit' ),
				'id'         => '_rating',
				'type'       => 'range',
				'max'        => '5',
				'min'        => '0.5',
				'step'       => '0.5',
				'unit'       => '',
				'std'        => '2.5',
				'desc'       => esc_html__( 'Add points ratings for this product. Note: The points range is between 1 and 5.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_has_reviews',
					"value"   => array( true )
		    	)
			),

		array(
			'type' => 'tab_close'
		),


		/* Import: Facebook Sharing */
		meloo_toolkit_mb_common( 'facebook_sharing_tab' ),


	);

	/* Options Filter */
	if ( has_filter( 'rascals_mb_post_opts' ) ) {
		$meta_options = apply_filters( 'rascals_mb_post_opts', $meta_options );
	}

	/* Add class instance */
	$rascals_mb_post = new RascalsBox( $meta_options, $meta_info );
		
}

return meloo_toolkit_mb_post();