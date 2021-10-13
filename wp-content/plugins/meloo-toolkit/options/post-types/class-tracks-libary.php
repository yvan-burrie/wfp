<?php
/**
 * Rascals Register Tracks
 *
 * @author Rascals Themes
 * @category Core
 * @package Angio Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class MelooToolkitTracksLibary extends RascalsCPT {

	/**
	 * Instance of RascalsCPT 
	 * @var class
	 */
	private $cpt;

	/*
	Public variables
	 */
	public $post_name = 'meloo_tracks';
	public $icon = 'dashicons-format-audio';
	public $supports = array('title', 'editor' );

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
				'name'               => esc_html__( 'Tracks Libary', 'meloo-toolkit' ),
				'singular_name'      => esc_html__( 'Track', 'meloo-toolkit' ),
				'add_new'            => esc_html__( 'Add New', 'meloo-toolkit' ),
				'add_new_item'       => esc_html__( 'Add New Tracks', 'meloo-toolkit' ),
				'edit_item'          => esc_html__( 'Edit Tracks', 'meloo-toolkit' ),
				'new_item'           => esc_html__( 'New Tracks', 'meloo-toolkit' ),
				'view_item'          => esc_html__( 'View Tracks', 'meloo-toolkit' ),
				'search_items'       => esc_html__( 'Search', 'meloo-toolkit' ),
				'not_found'          => esc_html__( 'No tracks found', 'meloo-toolkit' ),
				'not_found_in_trash' => esc_html__( 'No tracks found in Trash', 'meloo-toolkit' ), 
				'parent_item_colon'  => ''
			),
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'capability_type'   => 'post',
			'hierarchical'      => false,
			'rewrite'           => array(
				'slug'       => rascals_core_get_option( 'tracks_slug', 'tracks' ),
				'with_front' => false
			),
			'supports'          => $this->supports,
			'menu_icon'         => $this->icon
		);

		// Add Class instance
		$this->cpt = new RascalsCPT( $args, $post_options );

		// Add columns filter
		$columns_filter_args = array(
			'post_name'    => $this->post_name,
			'filter_label' => esc_html__( 'Filter', 'meloo-toolkit' ),
			'filters'      => array(),
			'extra_cols'   => array(
				'cb'      => '<input type="checkbox" />',
				'title'   => esc_html__( 'Title', 'meloo-toolkit' ),
				'date'    => esc_html__( 'Date', 'meloo-toolkit' ),
				'id' => esc_html__( 'ID', 'meloo-toolkit' ),
			)
		);

		$this->cpt->addAdminColumns( $columns_filter_args );
		
	}

}
