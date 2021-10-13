<?php
/**
 * Rascals MetaBox
 *
 * Register Tracks Libary Metabox
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
function meloo_toolkit_mb_tracks_libary() {

	$rascals_mb = new Meloo_Toolkit_Metaboxes();

	/* ==================================================
	  Tracks Manager 
	================================================== */

	/* Meta info */ 
	$meta_info = array(
		'title' => esc_html__( 'Options', 'meloo-toolkit'), 
		'id' =>'rascals_mb_tracks_box', 
		'page' => array(
			'meloo_tracks'
		), 
		'context' => 'normal', 
		'priority' => 'high', 
		'callback' => '', 
		'template' => array( 
			'post'
		),
		'admin_path'  => plugin_dir_url( __FILE__ ),
		'admin_uri'	 => plugin_dir_path( __FILE__ ),
		'admin_dir' => '',
		'textdomain' => 'meloo-toolkit'
	);

	/* Box Filter */
	if ( has_filter( 'rascals_mb_tracks_box' ) ) {
		$meta_info = apply_filters( 'rascals_mb_tracks_box', $meta_info );
	}

	/* Meta options */
	$meta_options = array(


		/* TAB: TRACKS
		 -------------------------------- */
		array(
			'name' => esc_html__( 'Tracklist', 'meloo-toolkit' ),
			'id' => 'tab-tracks',
			'type' => 'tab_open',
		),

			array( 
				'id' => '_audio_tracks',
				'type' => 'media_manager',
				'media_type' => 'audio', // images / audio / slider
				'layout' => 'list', // grid, list
				'display_fields' => array(
					array(
						'title' => esc_html__( 'Cover', 'meloo-toolkit' ),
						'name' => 'cover',
						'type' => 'image',
						'classes' => ''
					),
					array(
						'title' => esc_html__( 'Title', 'meloo-toolkit' ),
						'name' => 'title',
						'std' => esc_html__( 'Title', 'meloo-toolkit' ),
						'type' => 'text',
						'classes' => ''
					),
					array(
						'title' => esc_html__( 'ID', 'meloo-toolkit' ),
						'name' => 'id',
						'std' => '',
						'type' => 'text',
						'classes' => ''
					),

				),
				'buttons' => array(
					array(
						'type' => 'explorer', // explorer, custom
						'label' => esc_html__( 'Add Tracks', 'meloo-toolkit'),
						'title' => esc_html__( 'Add releases tracks from media libary', 'meloo-toolkit'),
						'color' => 'blue'
					),
					array(
						'type' => 'custom', // explorer, custom
						'label' => esc_html__( 'Add Custom Track', 'meloo-toolkit'),
						'title' => esc_html__( 'Add tracks from custom link', 'meloo-toolkit'),
						'color' => 'green'
					),
				),
				'msg_text' => esc_html__( 'Currently you don\'t have any audio tracks, you can add them by clicking on the button below.', 'meloo-toolkit'),
				'desc' => esc_html__( 'Add audio tracks.', 'meloo-toolkit' )
			),

		array(
			'type' => 'tab_close'
		),

	);

	/* Options Filter */
	if ( has_filter( 'rascals_mb_tracks_opts' ) ) {
		$meta_options = apply_filters( 'rascals_mb_tracks_opts', $meta_options );
	}

	/* Add class instance */
	$rascals_mb_tracks = new RascalsBox( $meta_options, $meta_info );
		
}

return meloo_toolkit_mb_tracks_libary();