<?php
/**
 * Rascals Customizer
 *
 * Register slider post type
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed diCustomizer
}


class RascalsCustomizer {

	/**
	 * Social Media Array
	 * @var array
	 */
	public $social_media_a = array(
		'twitter'        => 'Twitter',
		'facebook'       => 'Facebook',
		'youtube'        => 'Youtube',
		'instagram'      => 'Instagram',
		'soundcloud'     => 'Soundcloud',
		'mixcloud'       => 'Mixcloud',
		'bandcamp'       => 'Bandcamp',
		'Beatport'       => 'Beatport',
		'spotify'        => 'Spotify',
		'itunes-filled'  => 'iTunes',
		'lastfm'         => 'lastfm',
		'vimeo'          => 'Vimeo',
		'vk'             => 'VK',
		'flickr'         => 'Flickr',
		'snapchat-ghost' => 'Snapchat',
		'dribbble'       => 'Dribbble',
		'deviantart'     => 'Deviantart',
		'github'         => 'Github',
		'blogger'        => 'Blogger',
		'yahoo'          => 'Yahoo',
		'finder'         => 'Finder',
		'skype'          => 'Skype',
		'reddit'         => 'Reddit',
		'linkedin'       => 'Linkedin',
		'amazon'         => 'Amazon',
		'telegram'       => 'Telegram',
		'qq'             => 'QQ',
		'weibo'          => 'Weibo',
		'wechat'         => 'Wechat',
	);


	/**
	 * Rascals Customizer Constructor.
	 * @return void
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize class
	 * @return void
	 */
	public function init() {
		
		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		// Config Kirki
		Kirki::add_config( 'rascals_customizer', array(
		    'capability'    => 'edit_theme_options',
		    'option_type'   => 'theme_mod',
		) );

		// Load customizer style
		add_action( 'customize_controls_print_styles', array( $this, 'registerStyles' ) );

		// Kirki styling
		add_action( 'kirki/config', array( $this, 'configurationSampleStyling' ) );

		// Remove a pre exising customizer setting.
		add_action( 'customize_register', array( $this, 'removeCustomizeRegister' ) );

		// Add Kirki Options
		$this->addOptions();
	}


	/**
	 * Kriki Options
	 * @return void
	 */
	public function addOptions() {

		// Set default logo based on header color scheme 
		$header_color_scheme = get_theme_mod( 'header_color_scheme', 'dark' );
		$logo_path = get_template_directory_uri() . '/images';

		if ( $header_color_scheme == 'dark' ) {
			$default_logo_img =  $logo_path . '/logo-light.svg';
			$default_logo_hero = $logo_path . '/logo-light.svg';
		} else {
			$default_logo_img =  $logo_path . '/logo-dark.svg';
			$default_logo_hero = $logo_path . '/logo-light.svg';
		}

		$layout_a = array(
			'narrow'        => esc_html__( 'Narrow', 'meloo-toolkit' ),
			'wide'          => esc_html__( 'Wide', 'meloo-toolkit' ),
			'left_sidebar'  => esc_html__( 'Sidebar Left', 'meloo-toolkit' ),
			'right_sidebar' => esc_html__( 'Sidebar Right', 'meloo-toolkit' )
		);

		$block_a = array(
			'block1'  => esc_html__( 'Block 1', 'meloo-toolkit' ),
			'block2'  => esc_html__( 'Block 2', 'meloo-toolkit' ),
			'block3'  => esc_html__( 'Block 3', 'meloo-toolkit' ),
			'block4'  => esc_html__( 'Block 4', 'meloo-toolkit' ),
			'block5'  => esc_html__( 'Block 5', 'meloo-toolkit' ),
			'block6'  => esc_html__( 'Block 6', 'meloo-toolkit' ),
			'block7'  => esc_html__( 'Block 7', 'meloo-toolkit' ),
		);

		$term_block_a = array(
			'term'    => esc_html__( 'Term', 'meloo-toolkit' ),
			'block1'  => esc_html__( 'Block 1', 'meloo-toolkit' ),
			'block2'  => esc_html__( 'Block 2', 'meloo-toolkit' ),
			'block3'  => esc_html__( 'Block 3', 'meloo-toolkit' ),
			'block4'  => esc_html__( 'Block 4', 'meloo-toolkit' ),
			'block5'  => esc_html__( 'Block 5', 'meloo-toolkit' ),
			'block6'  => esc_html__( 'Block 6', 'meloo-toolkit' ),
			'block7'  => esc_html__( 'Block 7', 'meloo-toolkit' ),
			'block8'  => esc_html__( 'Block 8', 'meloo-toolkit' ),
			'block9'  => esc_html__( 'Block 9', 'meloo-toolkit' ),
			'block10' => esc_html__( 'Block 10', 'meloo-toolkit' ),
			'block11' => esc_html__( 'Block 11', 'meloo-toolkit' )
		);


		/* ==================================================
		  Section: Colors 
		================================================== */
		Kirki::add_section( 'colors', array(
		    'title'          => esc_html__( 'Colors', 'meloo-toolkit' ),
		    'description'    => false,
		    'priority'       => 1,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		) );


			/** 
			* ------------- Control: Color Scheme
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Main Color Scheme', 'meloo-toolkit' ),
				'section'  => 'colors',
				'settings' => 'color_scheme',
				'type'     => 'select',
				'priority' => 1,
				'default'  => 'dark',
				'choices'  => array(
					'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
					'light' => esc_html__( 'Light', 'meloo-toolkit' ),
				),
			) );


			/** 
			* ------------- Control: Header Color Scheme
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Header Scheme', 'meloo-toolkit' ),
				'section'  => 'colors',
				'settings' => 'header_color_scheme',
				'type'     => 'select',
				'priority' => 2,
				'default'  => 'dark',
				'choices'  => array(
					'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
					'light' => esc_html__( 'Light', 'meloo-toolkit' ),
				),
			) );

			/** 
			* ------------- Control: Mobile Menu Color Scheme
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Mobile Menu Scheme', 'meloo-toolkit' ),
				'section'  => 'colors',
				'settings' => 'mobile_nav_color_scheme',
				'type'     => 'select',
				'priority' => 2,
				'default'  => 'dark',
				'choices'  => array(
					'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
					'light' => esc_html__( 'Light', 'meloo-toolkit' ),
				),
			) );


			/** 
			* ------------- Control: Footer Color Scheme
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Footer Scheme', 'meloo-toolkit' ),
				'section'  => 'colors',
				'settings' => 'footer_color_scheme',
				'type'     => 'select',
				'priority' => 2,
				'default'  => 'dark',
				'choices'  => array(
					'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
					'light' => esc_html__( 'Light', 'meloo-toolkit' ),
				),
			) );


			/** 
			* ------------- Control: Preloader Color Scheme
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Preloader Scheme', 'meloo-toolkit' ),
				'section'  => 'colors',
				'settings' => 'loader_color_scheme',
				'type'     => 'select',
				'priority' => 3,
				'default'  => 'dark',
				'choices'  => array(
					'dark'  => esc_html__( 'Dark', 'meloo-toolkit' ),
					'light' => esc_html__( 'Light', 'meloo-toolkit' ),
				),
			) );


			/** 
			* ------------- Control: Accent Color
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Accent Color', 'meloo-toolkit' ),
				'section'  => 'colors',
				'settings' => 'accent_color',
				'type'     => 'color',
				'priority' => 8,
				'default'  => '#4063e6', //#68b0c8
				'choices'  => array(
					'alpha' => false,
				),
				'output' => array(
					array(
						'property' => 'color',
						'element'  => array( 
							'a',
							'.color',
							'.sticky .post-title:before',
							'.error404 .big-text',
							'#nav-sidebar ul li a:hover',
							'.logged-in-as a:hover',
							'.comment .author a:hover',
							'.comment .reply a',
							'#reply-title small:hover',
							'.widget a:hover',
							'.widget li a:hover',
							'.widget table#wp-calendar #next a:hover',
							'.widget table#wp-calendar #prev a:hover',
							'.widget_archive li a:hover',
							'.widget_categories li a:hover',
							'.widget_links li a:hover',
							'.widget_meta li a:hover',
							'.widget_pages li a:hover',
							'.widget_recent_comments li a:hover',
							'.widget_recent_entries li a:hover',
							'.widget_nav_menu_2 li a:before',
							'.widget_search #searchform #searchsubmit i:hover',
							'.rt-newsletter-input-wrap:after',
							'.mfp-arrow:hover',
							'.mfp-close:hover:after',
							'.post-header.hero .post-meta-bottom a:hover',
							'.testi-slider li .front-layer .text .name', /* Addons */
							'.rt-recent-posts.rt-show-thumbs .rp-caption',
							'.rt-recent-posts .rp-caption h4 a:hover',
							'div.wpcf7-validation-errors',
							'div.wpcf7-acceptance-missing',
							'.sp-tracklist .track.sp-error .status-icon',
						)
					),
					array(
						'property' => 'background-color',
						'element'  => array( 
							'.attachment-post-link a:hover',
							'#icon-nav .shop-items-count',
							'#search-block #searchform #s',
							'.post-meta-top .date:before',
							'.meta-tags a:hover',
							'.single-meloo_gallery .page-header .gallery-cats:after',
							'.form-submit #submit',
							'.widget button',
							'.widget .button',
							'.widget input[type="button"]',
							'.widget input[type="reset"]',
							'.widget input[type="submit"]',
							'.widget_tag_cloud .tagcloud a:hover',
							'.module-event-2 .event-name:before',
							'.module.module-gallery-1 .images-number:before',
							'.module .post-date:before',
							'.badge.free',
							'.button-hidden-layer',
							'input[type="submit"]',
							'button',
							'.btn',
							'input[type="submit"].btn-dark:hover',
							'button.btn-dark:hover',
							'.btn.btn-dark:hover',
							'input[type="submit"].btn-light:hover',
							'button.btn-light:hover',
							'.btn.btn-light:hover',
							'input[type="submit"].btn-grey:hover',
							'button.btn-grey:hover',
							'.btn.btn-grey:hover',
							'.sp-track.playing',
							'.sp-track.paused',
							'#sp-empty-queue',
							'.sp-progress .sp-position',
							'#scamp_player.paused .sp-position',
							'.woocommerce #respond input#submit.alt', /* Woocommerce */
							'.woocommerce a.button.alt',
							'.woocommerce button.button.alt',
							'.woocommerce input.button.alt', 
							'#payment ul li input[type="radio"]:checked:after',
							'.woocommerce #respond input#submit', 
							'.woocommerce a.button', 
							'.woocommerce button.button', 
							'.woocommerce input.button',
							'.woocommerce div.product form.cart .button',
							'.subscribe-form .subscribe-submit:hover', /* Addons */
							'.kc-event-countdown-header span:first-child:after',
							'.kc-share-buttons a.micro-share:hover',
							'.track-details-1 li .value a.micro-share:hover',
							'a.micro-btn',
							'.kc-posts-slider.owl-theme .owl-pagination .owl-page:hover',
							'.wft-actions .sp-play-track:hover',
							'.sp-content-progress .sp-content-position',
							'.subscribe-form .subscribe-email',
						)
					),
					array(
						'property' => 'background',
						'element'  => array( 
							'.module-event-1 .module-inner:hover',
							'.arrow-nav',
							'#nprogress .bar',
							'.testi-slider li .front-layer:before',  /* Addons */
							'.owl-nav-arrows.owl-theme .owl-controls .owl-buttons div'
						)
					),
					array(
						'property' => 'background',
						'element'  => array( 
							'::selection'
						)
					),
					array(
						'property' => 'stroke',
						'element'  => array( 
							'#icon-nav .nav-player-btn.status-playing .circle'
						)
					),
					array(
						'property' => 'border-color',
						'element'  => array( 
							'input:focus',
							'textarea:focus',
							'select:focus',
							'#nav-main > ul > li > a:not(.module-link):before',
							'.post-meta-top .date:before',
							'.module-4:hover',
							'.module-music-2:hover',
							'.cats-style .cat:before',
							'.woocommerce div.product .woocommerce-tabs ul.tabs li.active a', /* Woocommerce */
							'div.wpcf7-validation-errors', /* Addons */
							'div.wpcf7-acceptance-missing',
						)
					),
					array(
						'property' => 'border-left-color',
						'element'  => array( 
							'.testi-slider li .front-layer .text',
						)
					),
				)
			) );


		/* ==================================================
		  Section: One Page 
		================================================== */

		Kirki::add_section( 'one_page_options', array(
		    'title'          => esc_html__( 'One Page Options', 'meloo-toolkit' ),
		    'description'    => false,
		    'priority'       => 2,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		) );


			/** 
			* ------------- Control: Loading Animations
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Select One Page', 'meloo-toolkit' ),
				'section'  => 'one_page_options',
				'settings' => 'one_page_id',
				'type'     => 'dropdown-pages',
				'priority' => 1,
			) );


		/* ==================================================
		  Section: Loading Options 
		================================================== */
		Kirki::add_section( 'loading_options', array(
		    'title'          => esc_html__( 'Loading Options', 'meloo-toolkit' ),
		    'description'    => false,
		    'priority'       => 3,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		) );


			/** 
			* ------------- Control: Loading Animations
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Loading Animation', 'meloo-toolkit' ),
				'section'  => 'loading_options',
				'settings' => 'loading_animation',
				'type'     => 'toggle',
				'priority' => 2,
				'default'  => '1',
			) );


			/** 
			* ------------- Control: Loading Image
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Loader Image', 'meloo-toolkit' ),
				'section'  => 'loading_options',
				'settings' => 'loader_img',
				'type'     => 'image',
				'priority' => 1,
				'default'  =>  '',
			) );

			/** 
			* ------------- Control: Pagination
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Loader Style', 'meloo-toolkit' ),
				'section'  => 'loading_options',
				'settings' => 'loader_style',
				'type'     => 'select',
				'priority' => 1,
				'default'  => 'bars',
				'choices'  => array(
					'stripes' => esc_html__( 'Stripes', 'meloo-toolkit' ),
					'bars' => esc_html__( 'Bars Curtain', 'meloo-toolkit' ),
				),
				'description' => esc_html__( 'Select loader animation style.', 'meloo-toolkit' ),
			) );


		/* ==================================================
		  Panel: Header 
		================================================== */
		Kirki::add_section( 'header', array(
		    'title'       => esc_html__( 'Header', 'meloo-toolkit' ),
		    'priority'       => 3,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		    'description' => esc_html__( 'This panel will provide all the options of the header.', 'meloo-toolkit' ),
		) );
			

			/** 
			* ------------- Control: Header Styles
			*/

			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Header Style', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'header_style',
				'type'     => 'select',
				'priority' => 1,
				'default'  => 'header-style1',
				'choices'  => array(
					'header-style1' => esc_html__( 'Left Black', 'meloo-toolkit' ),
				),
			) );


			/** 
			* ------------- Control: Logo
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Logo', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'logo',
				'type'     => 'image',
				'priority' => 1,
				'default'  =>  $default_logo_img,
			) );


			/** 
			* ------------- Control: Logo Hero
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Logo (Hero Image)', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'logo_hero',
				'type'     => 'image',
				'priority' => 2,
				'default'  =>  $default_logo_hero,
				'description' => esc_html__( 'This Logo image will be displayed on transparent background on hero header image.', 'meloo-toolkit' )
			) );


			/** 
			* ------------- Control: Logo Mobile
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Logo (Mobile Menu)', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'logo_mobile',
				'type'     => 'image',
				'priority' => 2,
				'default'  =>  $default_logo_img,
				'description' => esc_html__( 'This Logo image will be displayed on mobile (responsive) menu.', 'meloo-toolkit' )
			) );


			/** 
			* ------------- Control: Search button
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Display Search Button', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'search_button',
				'type'     => 'toggle',
				'priority' => 3,
				'default'  => '1'
			) );

			/** 
			* ------------- Control: Search button
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Display Search Button', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'search_button',
				'type'     => 'toggle',
				'priority' => 4,
				'default'  => ''
			) );

			/** 
			* ------------- Control: Cart Button
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Display Cart', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'cart_button',
				'type'     => 'toggle',
				'priority' => 5,
				'default'  => '',
				'description' => esc_html__( 'Display cart icon in header. Please note WOOCOMMERCE plugin must be installed.', 'meloo-toolkit' )
			) );


			/** 
			* ------------- Control: Social Buttons
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Social Buttons', 'meloo-toolkit' ),
				'section'  => 'header',
				'settings' => 'header_social_buttons',
				'type'     => 'repeater',
				'priority' => 6,
				'row_label' => array(
					'type'  => 'field',
					'value' => esc_html__('Social Button:', 'meloo-toolkit' ),
					'field' => 'social_type',
				),
				'default'     => array(
					array(
						'social_type' => 'facebook',
						'social_link'  => '#',
					),
					array(
						'social_type' => 'twitter',
						'social_link'  => '#',
					),
					array(
						'social_type' => 'soundcloud',
						'social_link'  => '#',
					),
					array(
						'social_type' => 'mixcloud',
						'social_link'  => '#',
					),
					array(
						'social_type' => 'spotify',
						'social_link'  => '#',
					)
				),
				'fields' => array(
					'social_type' => array(
						'type'        => 'select',
						'label'       => esc_html__( 'Social Media', 'meloo-toolkit' ),
						'description' => esc_html__( 'Select your social media button', 'meloo-toolkit' ),
						'default'     => '',
						'choices'     => $this->social_media_a,
					),
					'social_link' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Link', 'meloo-toolkit' ),
						'description' => esc_html__( 'Type your social link', 'meloo-toolkit' ),
						'default'     => '',
					),
				),
			) );
			

		/* ==================================================
		  Panel: Sidebars 
		================================================== */
		Kirki::add_panel( 'sidebars', array(
		    'priority'    => 4,
		    'title'       => esc_html__( 'Sidebars', 'meloo-toolkit' ),
		    'description' => esc_html__( 'This panel will provide all the options of the sidebar and slidebar.', 'meloo-toolkit' ),
		) );
			

			/**
			 * ------------- Section: Sidebar
			 *
			 */

			Kirki::add_section( 'sidebar', array(
			    'title'          => esc_html__( 'Sidebar', 'meloo-toolkit' ),
			    'description'    => false,
			    'panel'          => 'sidebars',
			    'priority'       => 1,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			) );


					/** 
					* ------------- Control: Sticky Sidebar
					*/
				
					Kirki::add_field( 'rascals_customizer', array(
						'label'       => esc_html__( 'Sticky Sidebar', 'meloo-toolkit' ),
						'section'     => 'sidebar',
						'settings'    => 'sticky_sidebar',
						'type'        => 'toggle',
						'priority'    => 2,
						'default'     => '1',
						'description' => esc_html__( 'From here you can enable and disable the sticky sidebar on all the templates. The sticky sidebar that has auto resize and it scrolls with the content. The sticky_sidebar reverts back to a normal sidebar on iOS (iPad) and on mobile devices. If you plan to use Google AdSense in the sidebar don\'t enable this feature. Google\'s policy doesn\'t allow placing the ad in a "floating box", you can read more about it ', 'meloo-toolkit' ). '<a href="https://support.google.com/adsense/answer/1354742?hl=en">'.esc_html__( 'here', 'meloo-toolkit' ).'</a>',
					) );


		/* ==================================================
		  Section: Single Post   
		================================================== */
		Kirki::add_section( 'single_post', array(
		    'title'          => esc_html__( 'Single Post', 'meloo-toolkit' ),
		    'description'    => false,
		    'priority'       => 4,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '',
		    'description' => esc_html__( 'Single Post default options.', 'meloo-toolkit' ),
		) );


			/** 
			* ------------- Control: Show Sharing Posts
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Share Buttons', 'meloo-toolkit' ),
				'section'     => 'single_post',
				'settings'    => 'share_buttons',
				'type'        => 'toggle',
				'priority'    => 1,
				'default'     => '1',
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Enable or disable the share block.', 'meloo-toolkit' ),
			) );

			/** 
			* ------------- Control: Author Box
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Show Author Box', 'meloo-toolkit' ),
				'section'     => 'single_post',
				'settings'    => 'author_box',
				'type'        => 'toggle',
				'priority'    => 1,
				'default'     => '1',
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Enable or disable the author box (bottom of single post pages).', 'meloo-toolkit' ),
			) );

			/** 
			* ------------- Control: Show Related Posts
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Related Posts', 'meloo-toolkit' ),
				'section'     => 'single_post',
				'settings'    => 'related_posts',
				'type'        => 'toggle',
				'priority'    => 1,
				'default'     => '1',
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Enable or disable the related posts section (bottom of single post pages).', 'meloo-toolkit' ),
			) );

			/** 
			* ------------- Control: Related Posts - Display By
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'     => esc_html__( 'Related Posts - Display By', 'meloo-toolkit' ),
				'section'   => 'single_post',
				'settings'  => 'rp_display_by',
				'type'      => 'select',
				'priority'  => 1,
				'default'   => 'tags',
				'transport' => 'postMessage',
				'choices'  => array(
					'tags'       => esc_html__( 'Tags', 'meloo-toolkit' ),
					'categories' => esc_html__( 'Categories', 'meloo-toolkit' )
				),
				'description' => esc_html__('How to display the related posts:', 'meloo-toolkit' ) . '<br>' . esc_html__('by category - display posts from that have at least one category in common with the current post.', 'meloo-toolkit' ) . '<br>' . esc_html__('by tags - display posts that have at least one tag in common with the current post.', 'meloo-toolkit' ),
			) );

			/** 
			* ------------- Control: Related Posts - Show Navigation
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Related Posts - Show Navigation', 'meloo-toolkit' ),
				'section'     => 'single_post',
				'settings'    => 'rp_show_nav',
				'type'        => 'toggle',
				'priority'    => 1,
				'default'     => '1',
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Enable or disable related posts navigatio arrows.', 'meloo-toolkit' ),
			) );

			/** 
			* ------------- Control: Facebook Sharing
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Show Facebook Sharing', 'meloo-toolkit' ),
				'section'     => 'single_post',
				'settings'    => 'fb_sharing',
				'type'        => 'toggle',
				'priority'    => 1,
				'default'     => '1',
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Show or hide Facebook share options (head tags).', 'meloo-toolkit' ),
			) );


		/* ==================================================
		  Section: Terms 
		================================================== */
		Kirki::add_section( 'terms', array(
			'title'          => esc_html__( 'Categories', 'meloo-toolkit' ),
			'description'    => false,
			'priority'       => 4,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'description'    => esc_html__( 'Options for Category, Tags, Author, Archives, Search pages.', 'meloo-toolkit' ),
		) );


			/** 
			* ------------- Control: Pagination
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Pagination Method', 'meloo-toolkit' ),
				'section'  => 'terms',
				'settings' => 'term_pagination',
				'type'     => 'select',
				'priority' => 1,
				'default'  => 'next_prev',
				'choices'  => array(
					'next_prev' => esc_html__( 'Next/Prev Pagination', 'meloo-toolkit' ),
					'load_more' => esc_html__( 'Load More Button', 'meloo-toolkit' ),
					'infinite'  => esc_html__( 'Infinite Load', 'meloo-toolkit' )
				),
				'description' => esc_html__( 'Select pagination method.', 'meloo-toolkit' ),
			) );


			/** 
			* ------------- Control: Category layout
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Category Layout', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'category_layout',
				'type'        => 'select',
				'priority'    => 1,
				'default'     => 'wide',
				'choices'     => $layout_a,
				'description' => esc_html__( 'Select category layout.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Category Display View', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'category_block',
				'type'        => 'select',
				'priority'    => 2,
				'default'     => 'block8',
				'choices'     => $term_block_a,
				'description' => esc_html__( 'Select display view block.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Category: Number Posts', 'meloo-toolkit' ),
				'section'  => 'terms',
				'settings' => 'category_limit',
				'type'     => 'number',
				'priority' => 3,
				'default'  => 9,
				'choices'  => array(
					'min'  => 1,
					'max'  => 80,
					'step' => 1,
				),
				'description' => esc_html__( 'Set the number posts to show.', 'meloo-toolkit' ),
			) );
			

			/** 
			* ------------- Control: Tag layout
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Tag Layout', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'tag_layout',
				'type'        => 'select',
				'priority'    => 4,
				'default'     => 'wide',
				'choices'     => $layout_a,
				'description' => esc_html__( 'Select tag layout.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Tag Display View', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'tag_block',
				'type'        => 'select',
				'priority'    => 5,
				'default'     => 'block8',
				'choices'     => $term_block_a,
				'description' => esc_html__( 'Select display view block.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Tags: Number Posts', 'meloo-toolkit' ),
				'section'  => 'terms',
				'settings' => 'tag_limit',
				'type'     => 'number',
				'priority' => 6,
				'default'  => 9,
				'choices'  => array(
					'min'  => 1,
					'max'  => 80,
					'step' => 1,
				),
				'description' => esc_html__( 'Set the number posts to show.', 'meloo-toolkit' ),
			) );


			/** 
			* ------------- Control: Author layout
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Author Layout', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'author_layout',
				'type'        => 'select',
				'priority'    => 7,
				'default'     => 'wide',
				'choices'     => $layout_a,
				'description' => esc_html__( 'Select author layout.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Author Display View', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'author_block',
				'type'        => 'select',
				'priority'    => 8,
				'default'     => 'block8',
				'choices'     => $term_block_a,
				'description' => esc_html__( 'Select display view block.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Author: Number Posts', 'meloo-toolkit' ),
				'section'  => 'terms',
				'settings' => 'author_limit',
				'type'     => 'number',
				'priority' => 9,
				'default'  => 8,
				'choices'  => array(
					'min'  => 1,
					'max'  => 80,
					'step' => 1,
				),
				'description' => esc_html__( 'Set the number posts to show.', 'meloo-toolkit' ),
			) );


			/** 
			* ------------- Control: Archive layout
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Archive Layout', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'archive_layout',
				'type'        => 'select',
				'priority'    => 10,
				'default'     => 'wide',
				'choices'     => $layout_a,
				'description' => esc_html__( 'Select layout.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Archive Display View', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'archive_block',
				'type'        => 'select',
				'priority'    => 11,
				'default'     => 'block8',
				'choices'     => $term_block_a,
				'description' => esc_html__( 'Select display view block.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Archive: Number Posts', 'meloo-toolkit' ),
				'section'  => 'terms',
				'settings' => 'archive_limit',
				'type'     => 'number',
				'priority' => 12,
				'default'  => 8,
				'choices'  => array(
					'min'  => 1,
					'max'  => 80,
					'step' => 1,
				),
				'description' => esc_html__( 'Set the number posts to show.', 'meloo-toolkit' ),
			) );


			/** 
			* ------------- Control: Search layout
			*/
			Kirki::add_field( 'rascals_customizer', array(
				'label'       => esc_html__( 'Search Layout', 'meloo-toolkit' ),
				'section'     => 'terms',
				'settings'    => 'search_layout',
				'type'        => 'select',
				'priority'    => 13,
				'default'     => 'wide',
				'choices'     => $layout_a,
				'description' => esc_html__( 'Select search layout.', 'meloo-toolkit' ),
			) );

			Kirki::add_field( 'rascals_customizer', array(
				'label'    => esc_html__( 'Search: Number Posts', 'meloo-toolkit' ),
				'section'  => 'terms',
				'settings' => 'search_limit',
				'type'     => 'number',
				'priority' => 15,
				'default'  => 8,
				'choices'  => array(
					'min'  => 1,
					'max'  => 80,
					'step' => 1,
				),
				'description' => esc_html__( 'Set the number posts to show.', 'meloo-toolkit' ),
			) );


		/* ==================================================
		  Panel: Footer 
		================================================== */
		Kirki::add_panel( 'footer', array(
		    'priority'    => 10,
		    'title'       => esc_html__( 'Footer', 'meloo-toolkit' ),
		    'description' => esc_html__( 'This panel will provide all the options of the footer.', 'meloo-toolkit' ),
		) );

			
			/**
			 * ------------- Section: Section
			 */
			Kirki::add_section( 'footer_section', array(
			    'title'          => esc_html__( 'Footer Sections/Widgets', 'meloo-toolkit' ),
			    'description'    => false,
			    'panel'          => 'footer',
			    'priority'       => 3,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			) );

				/** 
				* ------------- Control: Footer Section
				*/
				Kirki::add_field( 'rascals_customizer', array(
					'label'       => esc_html__( 'Select Section', 'meloo-toolkit' ),
					'section'     => 'footer_section',
					'settings'    => 'footer_section',
					'type'        => 'select',
					'default'     => 'none',
					'choices'     => $this->getKCSections(),
					'priority'    => 1,
					'description' => esc_html__( 'You can add your own King Composer Section here. Sections are created in King Composer > Sections Manager.', 'meloo-toolkit' )
				) );


			/**
			 * ------------- Section: Copyright Text
			 *
			 */

			Kirki::add_section( 'footer_copyright', array(
			    'title'          => esc_html__( 'Copyright Text', 'meloo-toolkit' ),
			    'description'    => false,
			    'panel'          => 'footer',
			    'priority'       => 3,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			) );

				/** 
				* ------------- Control: Social Buttons
				*/
				Kirki::add_field( 'rascals_customizer', array(
					'label'    => esc_html__( 'Copyright Text', 'meloo-toolkit' ),
					'section'  => 'footer_copyright',
					'settings' => 'copyright_note',
					'type'     => 'textarea',
					'priority' => 1,
					'default' => '&copy; Copyright 2018 Meloo. Powered by <a href="#" target="_blank">Rascals Themes</a>. Handcrafted in Europe.',
				) );


			/**
			 * ------------- Section: Social Media 
			 *
			 */

			Kirki::add_section( 'footer_social', array(
			    'title'          => esc_html__( 'Social Media', 'meloo-toolkit' ),
			    'description'    => false,
			    'panel'          => 'footer',
			    'priority'       => 4,
			    'capability'     => 'edit_theme_options',
			    'theme_supports' => '',
			) );

				/** 
				* ------------- Control: Social Buttons
				*/
				Kirki::add_field( 'rascals_customizer', array(
					'label'    => esc_html__( 'Social Buttons', 'meloo-toolkit' ),
					'section'  => 'footer_social',
					'settings' => 'footer_social_buttons',
					'type'     => 'repeater',
					'priority' => 1,
					'row_label' => array(
						'type'  => 'field',
						'value' => esc_html__('Social Button:', 'meloo-toolkit' ),
						'field' => 'social_type',
					),
					'default'     => array(
						array(
							'social_type' => 'facebook',
							'social_link'  => '#',
						),
						array(
							'social_type' => 'twitter',
							'social_link'  => '#',
						),
						array(
							'social_type' => 'soundcloud',
							'social_link'  => '#',
						),
						array(
							'social_type' => 'mixcloud',
							'social_link'  => '#',
						),
						array(
							'social_type' => 'spotify',
							'social_link'  => '#',
						)
					),
					'fields' => array(

						'social_type' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Social Media', 'meloo-toolkit' ),
							'description' => esc_html__( 'Select your social media button', 'meloo-toolkit' ),
							'default'     => '',
							'choices'  => $this->social_media_a,
						),
						'social_link' => array(
							'type'        => 'text',
							'label'       => esc_html__( 'Link', 'meloo-toolkit' ),
							'description' => esc_html__( 'Type your social link', 'meloo-toolkit' ),
							'default'     => '',
						),
					)
				) );
	}



	/**
	 * Get all registered KC sections
	 * @return array
	 */
	public function getKCSections( ) {
		$kc_sections = array(
			'none' => esc_html__( 'Select Section', 'meloo-toolkit' )
		);
		if ( function_exists('kc_add_map') ) {
			$kc_posts = get_posts( array('post_type' => 'kc-section', 'post_status'=> 'publish', 'suppress_filters' => false, 'posts_per_page'=>-1 ) ); 
			if ( isset( $kc_posts ) && is_array( $kc_posts ) ) {
				foreach ( $kc_posts as $post ) {
					$kc_sections[$post->ID] = $post->post_title;
				}
			}
		}

		return $kc_sections;
	}


	/**
	 * Kriki styling
	 * @return void
	 */
	public function configurationSampleStyling( $config ) {

		return wp_parse_args( array(
			'logo_image'   => false,
			'description'  => false,
			'color_accent' => '#f86239',
			'color_back'   => '#ffffff',
		), $config );
	}


	/**
	 * Register styles only on customizer page
	 * @return void
	 */
	public function registerStyles() {

		wp_enqueue_style( 'rascals-customizer-layout', esc_url( RASCALS_TOOLKIT_URL ) . '/options/customizer/css/admin-customizer.css' );
	}


	/**
	 * Register styles only on customizer page
	 * @return void
	 */
	public function removeCustomizeRegister( $wp_customize ) {;
		$wp_customize->remove_section("active_theme");
	}

}