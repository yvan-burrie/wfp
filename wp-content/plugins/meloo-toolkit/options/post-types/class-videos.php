<?php
/**
 * Rascals Register Videos
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class MelooToolkitVideos extends RascalsCPT {

	/**
	 * Instance of RascalsCPT 
	 * @var class
	 */
	private $cpt;

	/*
	Public variables
	 */
	public $post_name = 'meloo_videos';
	public $icon = 'dashicons-video-alt2';
	public $supports = array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields');

	/**
	 * Rascals CPT Constructor.
	 * @return void
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initialize class
	 * @return void
	 */
	public function init() {
		add_action( 'init', array( $this, 'regsiterPostType' ), 0 );
	}

	/**
	 * Register Post Type
	 * @return void
	 */
	public function regsiterPostType() {

		// Class arguments 
		$args = array( 
			'post_name' => $this->post_name, 
			'sortable' => true
		);

		// Post arguments
		$post_options = array(
			'labels' => array(
				'name'               => esc_html__( 'Videos', 'meloo-toolkit' ),
				'singular_name'      => esc_html__( 'Video', 'meloo-toolkit' ),
				'add_new'            => esc_html__( 'Add New', 'meloo-toolkit' ),
				'add_new_item'       => esc_html__( 'Add New Video', 'meloo-toolkit' ),
				'edit_item'          => esc_html__( 'Edit Video', 'meloo-toolkit' ),
				'new_item'           => esc_html__( 'New Video', 'meloo-toolkit' ),
				'view_item'          => esc_html__( 'View Video', 'meloo-toolkit' ),
				'search_items'       => esc_html__( 'Search', 'meloo-toolkit' ),
				'not_found'          => esc_html__( 'No videos found', 'meloo-toolkit' ),
				'not_found_in_trash' => esc_html__( 'No videos found in Trash', 'meloo-toolkit' ), 
				'parent_item_colon'  => ''
			),
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => true,
			'capability_type'   => 'post',
			'hierarchical'      => false,
			'rewrite'           => array(
				'slug'       => rascals_core_get_option( 'videos_slug', 'videos' ),
				'with_front' => false
			),
			'supports'          => $this->supports,
			'menu_icon'         => $this->icon
		);

		// Register taxonomy
		register_taxonomy( 'meloo_videos_cats', array($this->post_name), array(
			'hierarchical'   => true,
			'label'          => esc_html__( 'Filter 1', 'meloo-toolkit' ),
			'singular_label' => esc_html__( 'Filter 1', 'meloo-toolkit' ),
			'query_var'      => true,
			'show_in_rest'   => true,
			'rewrite'        => array(
				'slug'       => rascals_core_get_option( 'videos_cat_slug', 'videos-category' ),
				'with_front' => false
			),
		));

		// Register taxonomy 2
		register_taxonomy( 'meloo_videos_cats2', array($this->post_name), array(
			'hierarchical'   => true,
			'label'          => esc_html__( 'Filter 2', 'meloo-toolkit' ),
			'singular_label' => esc_html__( 'Filter 2', 'meloo-toolkit' ),
			'query_var'      => true,
			'show_in_rest'   => true,
			'rewrite'        => array(
				'slug'       => rascals_core_get_option( 'videos_cat_slug2', 'videos-category-2' ),
				'with_front' => false
			),
		));

		// Register taxonomy 3
		register_taxonomy( 'meloo_videos_cats3', array($this->post_name), array(
			'hierarchical'   => true,
			'label'          => esc_html__( 'Filter 3', 'meloo-toolkit' ),
			'singular_label' => esc_html__( 'Filter 3', 'meloo-toolkit' ),
			'query_var'      => true,
			'show_in_rest'   => true,
			'rewrite'        => array(
				'slug'       => rascals_core_get_option( 'videos_cat_slug3', 'videos-category-3' ),
				'with_front' => false
			),
		));

		// Register taxonomy 4
		register_taxonomy( 'meloo_videos_cats4', array($this->post_name), array(
			'hierarchical'   => true,
			'label'          => esc_html__( 'Filter 4', 'meloo-toolkit' ),
			'singular_label' => esc_html__( 'Filter 4', 'meloo-toolkit' ),
			'query_var'      => true,
			'show_in_rest'   => true,
			'rewrite'        => array(
				'slug'       => rascals_core_get_option( 'videos_cat_slug4', 'videos-category-4' ),
				'with_front' => false
			),
		));


		// Add Class instance
		$this->cpt = new RascalsCPT( $args, $post_options );

		// Add columns filter
		$columns_filter_args = array(
			'post_name'    => $this->post_name,
			'filter_label' => esc_html__( 'Filter', 'meloo-toolkit' ),
			'filters'      => array(
				'meloo_videos_cats',
				'meloo_videos_cats2',
				'meloo_videos_cats3',
				'meloo_videos_cats4'
			),
			'extra_cols'   => array(
				'cb'      => '<input type="checkbox" />',
				'title'   => esc_html__( 'Title', 'meloo-toolkit' ),
				'date'    => esc_html__( 'Date', 'meloo-toolkit' ),
				'preview' => esc_html__( 'Preview', 'meloo-toolkit' ),
			)
		);

		$this->cpt->addAdminColumns( $columns_filter_args );
		
	}

}
