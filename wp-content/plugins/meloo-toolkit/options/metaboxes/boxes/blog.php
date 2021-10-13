<?php
/**
 * Rascals MetaBox
 *
 * Register Blog Metabox
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
function meloo_toolkit_mb_blog() {

	$rascals_mb = new Meloo_Toolkit_Metaboxes();


	/* ==================================================
	  Latest Articles 
	================================================== */

	/* Meta info */ 
	$meta_info = array(
		'title' => esc_html__( 'Articles Options', 'meloo-toolkit'), 
		'id'    =>'rt_blog', 
		'page'  => array(
			'page'
		), 
		'context'  => 'normal', 
		'priority' => 'high', 
		'callback' => '', 
		'template' => array( 
			'template-blog.php'
		),
	);

	/* Box Filter */
	if ( has_filter( 'rascals_mb_blog_box' ) ) {
		$meta_info = apply_filters( 'rascals_mb_blog_box', $meta_info );
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
				'name'   => esc_html__( 'Page Builder', 'meloo-toolkit' ),
				'id'     => '_page_builder',
				'type'   => 'select_image',
				'std'    => 'off',
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
				'name'    => esc_html__( 'Header Over Content', 'meloo-toolkit' ),
				'id'      => '_show_header_above',
				'type'    => 'switch_button',
				'std'     => '0',
				'options' => array(
					array( 'name' => 'On', 'value' => true ), // ON
					array( 'name' => 'Off', 'value' => '0' ) // OFF
				),
				'separator'  => true,
				'desc'       => esc_html__( 'Show header over content.', 'meloo-toolkit' ),
				'dependency' => array(
					"element" => '_page_builder',
					"value"   => array( 'on' )
		    	)
			),

			/* Articles layout */
			array(
				'name'   => esc_html__( 'Articles Layout', 'meloo-toolkit' ),
				'id'     => '_articles_layout',
				'type'   => 'select_image',
				'std'    => 'right_sidebar',
				'images' => array(
					array( 
						'id' => 'left_sidebar', 
						'title' => esc_html__( 'Sidebar Left', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/left-sidebar.png'
					),
					array( 
						'id' => 'narrow', 
						'title' => esc_html__( 'Narrow Layout', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/narrow.png'
					),
					array( 
						'id' => 'wide', 
						'title' => esc_html__( 'Wide Layout', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/wide.png'
					),
					array( 
						'id' => 'right_sidebar', 
						'title' => esc_html__( 'Sidebar Right', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/right-sidebar.png'
					),

				),
				'desc' => esc_html__( 'Choose the recent articles layout. the settings from this panel applies to the bottom of the page, where the loop and sidebar is.', 'meloo-toolkit' )
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
					"element" => '_articles_layout',
					"value"   => array( 'left_sidebar', 'right_sidebar', 'hero_left_sidebar', 'hero_right_sidebar' )
			    )
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
				'name'   => esc_html__( 'Select Block', 'meloo-toolkit' ),
				'id'     => '_block',
				'type'   => 'select_image',
				'std'    => 'block',
				'images' => array(
					array( 
						'id'    => 'block', 
						'title' => esc_html__( 'Block 1', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block1.png'
					),
					array( 
						'id'    => 'block2', 
						'title' => esc_html__( 'Block 2', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block2.png'
					),
					array( 
						'id'    => 'block3', 
						'title' => esc_html__( 'Block 3', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block3.png'
					),
					array( 
						'id'    => 'block4', 
						'title' => esc_html__( 'Block 4', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block8.png'
					),
					array( 
						'id'    => 'block5', 
						'title' => esc_html__( 'Block 5', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block9.png'
					),
					array( 
						'id'    => 'block6', 
						'title' => esc_html__( 'Block 6', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block10.png'
					),
					array( 
						'id'    => 'block7', 
						'title' => esc_html__( 'Block 7', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block11.png'
					),
					array( 
						'id'    => 'block8', 
						'title' => esc_html__( 'Block 8', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block4.png'
					),
					array( 
						'id'    => 'block9', 
						'title' => esc_html__( 'Block 9', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block5.png'
					),
					array( 
						'id'    => 'block10', 
						'title' => esc_html__( 'Block 10', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block6.png'
					),
					array( 
						'id'    => 'block11', 
						'title' => esc_html__( 'Block 11', 'meloo-toolkit' ), 
						'image' => esc_url( RASCALS_TOOLKIT_URL ) . '/options/metaboxes/boxes/images/blocks/block7.png'
					),
				
					

				),
				'desc' => esc_html__( 'Select a block to be used in the loop of this page.', 'meloo-toolkit' )
			),

			/* Pagination Method */
			array(
				'name'    => esc_html__( 'Pagination Method', 'meloo-toolkit' ),
				'id'      => '_pagination',
				'type'    => 'select',
				'std'     => 'next_prev',
				'options' => array(
					array( 'name' => esc_html__( 'Next/Prev Pagination', 'meloo-toolkit' ), 'value' => 'next_prev' ),
					array( 'name' => esc_html__( 'Load More Button', 'meloo-toolkit' ), 'value' => 'load_more' ),
					array( 'name' => esc_html__( 'Infinite Load', 'meloo-toolkit' ), 'value' => 'infinite' )
				),
				'desc' => esc_html__( 'Select pagination method.', 'meloo-toolkit' )
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
				'group' => '_filter_atts',
				'id'    => 'limit',
				'type'  => 'range',
				'max'   => '999',
				'min'   => '1',
				'unit'  => 'posts',
				'step'  => '1',
				'std'   => '8',
				'desc'  => esc_html__('If the field is empty the limit post number will be the number from Wordpress settings -> Reading', 'meloo-toolkit' ),
			), 

			/* Sort Order */
			array(
				'name'    => esc_html__( 'Sort Order', 'meloo-toolkit' ),
				'group'   => '_filter_atts',
				'id'      => 'sort_order',
				'type'    => 'select',
				'std'     => 'post_date',
				'options' => array(
					array( 'name' => esc_html__( 'Latest (By date)', 'meloo-toolkit' ), 'value' => 'post_date' ),
					array( 'name' => esc_html__( 'Alphabetical A -> Z', 'meloo-toolkit' ), 'value' => 'title' ),
					array( 'name' => esc_html__( 'Random Posts', 'meloo-toolkit' ), 'value' => 'rand' ),
					array( 'name' => esc_html__( 'Random Posts Today', 'meloo-toolkit' ), 'value' => 'rand_today' ),
					array( 'name' => esc_html__( 'Random Posts From Last 7 Days', 'meloo-toolkit' ), 'value' => 'rand_week' ),
					array( 'name' => esc_html__( 'Most Commented', 'meloo-toolkit' ), 'value' => 'comment_count' ),
					array( 'name' => esc_html__( 'Highest rated (reviews)', 'meloo-toolkit' ), 'value' => 'highest_rated' ),
				),
				'separator' => false,
				'desc'      => esc_html__( 'How to sort the posts.', 'meloo-toolkit' ),
			),
			array(
				'name'      => esc_html__( 'Post ID', 'meloo-toolkit' ),
				'group'     => '_filter_atts',
				'id'        => 'post_ids',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple posts by ID. Enter the post IDs separated by commas (ex: 333,18,643). To exclude posts add them with "-" (ex: -30,-486,-12)', 'meloo-toolkit' ),
			),
			array(
				'name'      => esc_html__( 'Multiple Category ID', 'meloo-toolkit' ),
				'group'     => '_filter_atts',
				'id'        => 'category_ids',
				'type'      => 'taxonomy',
				'taxonomy'  => 'category',
				'multiple'  => true,
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple categories. Hold the CTRL key (PC) or COMMAND key (Mac) and click the items in a list to choose them. Click all the items you want to select. They don’t have to be next to each other.
Click any item again to deselect it, e.g. if you have made a mistake. Remember to keep the CTRL or COMMAND key pressed.', 'meloo-toolkit' ),
			),
			array(
				'name'      => esc_html__( 'Category Slug', 'meloo-toolkit' ),
				'group'     => '_filter_atts',
				'id'        => 'category_slugs',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple categories by category slug name separated by commas (ex: news,interviews,reviews). To exclude posts add them with "-" (ex: -news,-interviews,-reviews)', 'meloo-toolkit' ),
			),
			array(
				'name'      => esc_html__( 'Tag Slug', 'meloo-toolkit' ),
				'group'     => '_filter_atts',
				'id'        => 'tag_slugs',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter tags by slugs. Enter the tag slugs separated by commas (ex: tag1,tag2,tag3)', 'meloo-toolkit' ),
			),
			array(
				'name'      => esc_html__( 'Author ID', 'meloo-toolkit' ),
				'group'     => '_filter_atts',
				'id'        => 'author_ids',
				'type'      => 'text',
				'std'       => '',
				'separator' => false,
				'desc'      => esc_html__( 'Filter multiple authors by ID. Enter the author IDs separated by commas (ex: 32,11,899)', 'meloo-toolkit' ),
			),
			array(
				'name'      => esc_html__( 'Offset Posts', 'meloo-toolkit' ),
				'group'     => '_filter_atts',
				'id'        => 'offset',
				'type'      => 'range',
				'max'       => '999',
				'min'       => '0',
				'unit'      => 'posts nr',
				'step'      => '1',
				'std'       => '0',
				'separator' => false,
				'desc'      => esc_html__( 'Start the count with an offset. If you have a block that shows 10 posts before this one, you can make this one start from the 11\'th post (by using offset 10)', 'meloo-toolkit' ),
			),
		
		array(
			'type' => 'tab_close'
		),


		/* Import: Facebook Sharing */
		meloo_toolkit_mb_common( 'facebook_sharing_tab' ),
		

	);

	/* Options Filter */
	if ( has_filter( 'rascals_mb_blog_opts' ) ) {
		$meta_options = apply_filters( 'rascals_mb_blog_opts', $meta_options );
	}

	/* Add class instance */
	$rascals_mb_blog = new RascalsBox( $meta_options, $meta_info );
		
}

return meloo_toolkit_mb_blog();