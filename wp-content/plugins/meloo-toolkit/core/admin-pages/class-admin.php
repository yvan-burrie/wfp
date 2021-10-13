<?php
/**
 * Rascals Admin Pages
 *
 * Show Admin Pages
 *
 * @author Rascals Themes
 * @category Core
 * @package Toolkit Core
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class RascalsAdminPages {

	/*
	Private variables
	 */
	private $theme_required = array(
		'PHP_VERSION'         => '7',
		'WP_VERSION'          => '5.0.0',
		'WP_MEMORY_LIMIT'     => '40M',
		'SERVER_MEMORY_LIMIT' => '96M',
		'SERVER_TIME_LIMIT'   => 300,
		'MAX_INPUT_VARS'      => 1000,
	);


	/*
	Public variables
	 */
	public $admin_pages = array();

	// @var Single instance of the class
	private static $_instance;

	/**
	 * Instance
	 *
	 * Ensures only one instance of Angio Toolkit is loaded or can be loaded.
	 *
	 * @static
	 * @return Angio Toolkit - Main instance
	 */
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Rascals CPT Constructor.
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize class
	 * @return void
	 */
	public function init() {

		// Set admin pages
		$pages = array(
			array(
				'title' => rascals_esc_( 'Welcome' ),
				'title_attr' => rascals_esc_( 'Welcome' ),
				'id' => 'admin-welcome'
			),
			array(
				'title' => rascals_esc_( 'System Status' ),
				'title_attr' => rascals_esc_( 'System Status' ),
				'id' => 'admin-system'
			),
			array(
				'title' => rascals_esc_( 'Theme Plugins' ),
				'title_attr' => rascals_esc_( 'Theme Plugins' ),
				'id' => 'admin-plugins'
			),
			array(
				'title' => rascals_esc_( 'Install Demos' ),
				'title_attr' => rascals_esc_( 'Install Demos' ),
				'id' => 'admin-demos'
			),
			array(
				'title' => rascals_esc_( 'Theme Panel' ),
				'title_attr' => rascals_esc_( 'Theme Panel' ),
				'id' => 'theme-panel'
			)

		);


		$this->admin_pages = $pages;


		// Change admin menu
		add_filter( 'rascals_admin_menu', array( $this, 'changeAdminMenu' ) );


		// Change admin menu
		add_filter( 'rascals_admin_menu', array( $this, 'changeAdminMenu' ) );


		/* Call method to create the sidebar menu items */
		add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
		
	}


	/**
	 * Create the sidebar menu
	 * @return void
	 */
	public function addAdminMenu() {

		add_theme_page( rascals_esc_( 'System Status' ), rascals_esc_( 'System Status' ), 'edit_theme_options', 'admin-system', array( $this, 'adminPageSystem' ) );

	}


	/**
	 * Change admin menu
	 * @return array
	 */
	public function changeAdminMenu( $pages ) {

		$pages = $this->admin_pages;

		return $pages;
	
	}


	/**
	 * Render admin menu
	 * @version 1.1
	 * @return void
	 */
	public function renderAdminMenu() {

		$pages = $this->admin_pages;
		$page_link = 'admin.php?page=';

		$theme = wp_get_theme();
	?>

	<h3 class="rascals-theme-name"><?php echo esc_html( $theme->get( 'Name' ) ); ?><span class="rascals-version"> v <?php echo esc_html( $theme->get( 'Version' ) ); ?></span></h3>

	<div class="wrap about-wrap rascals-admin-header">
	    <h2 class="nav-tab-wrapper"> 
			<?php
			foreach ( $pages as $mp_page ) {
			    $extra_classes = '';

			    $title_attr = $mp_page['title_attr']; 

		        /* Redirect */ 
		        if ( $mp_page['id'] === 'inactive' ) {
		        	$page_link = '#';
		        	$extra_classes .= ' inactive';
		        } elseif ( strpos( $mp_page['id'], '.php' ) !== false ) {
		        	$page_link = $mp_page['id'];
		        } else {
		        	$page_link = 'admin.php?page=' . esc_attr( $mp_page['id'] );
		        }
		        
		        if ( isset( $_GET['page'] ) && ( $_GET['page'] === $mp_page['id'] ) ) { 
		        	$extra_classes .= ' nav-tab-active';
		        }

		        ?>	
		        <a href="<?php echo esc_url( $page_link ) ?>" title="<?php echo esc_attr( $title_attr ) ?>" class="nav-tab rascals-nav-tab <?php echo esc_attr( $extra_classes ); ?> "><?php echo esc_html( $mp_page['title'] ) ?></a>
		        <?php
		    }
		    ?>
		</h2>
	</div>
    <?php

	}


	/**
	 * Admin page that shows system status 
	 * @return void
	 */
	public function adminPageSystem() {

		// Render admin menu
		$this->renderAdminMenu(); 
		
	?>
		<div class="rascals-admin-wrap system-wrap">

		    <div class="feature-section clear">
		        <p><?php rascals_esc_e( 'Check that all the requirements below.' ) ?></p>
		    </div>

		    <?php 
		    /* ==================================================
		       WordPress environment
		    ================================================== */
		     ?>
		    <table class="widefat rascals-system" cellspacing="0">

		        <thead>
		            <tr>
		                <th colspan="3"><h2><?php rascals_esc_e( 'WordPress environment' ) ?></h2></th>
		            </tr>
		        </thead>
		        <tbody>

		            <tr>
		                <?php

		                /* ==================================================
		                   WP Version
		                ================================================== */
		                $wp_version = get_bloginfo( 'version' );
		                $req_wp_version = $this->theme_required['WP_VERSION'];
		                $check = ( version_compare( $wp_version, $req_wp_version, '>=' ) );
		                $error_msg = ( ! $check ) ? ' - ' . rascals_esc_( 'It is recommended to update WordPress to the latest version' ) : '';
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'WordPress version' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The version of WordPress installed on your site.' ); ?>"  target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status <?php echo ( esc_attr($check) ) ? 'good' : 'bad'; ?>">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo ( esc_attr($check) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $wp_version . $error_msg ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>

		            <tr>
		                <?php

		                /* ==================================================
		                   WP Memory Limit
		                ================================================== */
		                $wp_memory_limit = WP_MEMORY_LIMIT;
		                $req_wp_memory_limit = $this->theme_required['WP_MEMORY_LIMIT'];
		                $check = ( wp_convert_hr_to_bytes( $wp_memory_limit ) >= wp_convert_hr_to_bytes( $req_wp_memory_limit ) );
		                $error_msg = ( ! $check ) ? ' - ' . sprintf( rascals_esc_( 'It is recommended to increase your WP memory limit to %s at least' ), $this->theme_required['WP_MEMORY_LIMIT'] ) : '';
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'WP Memory Limit' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The maximum amount of memory (RAM) that your site can use at one time.' ); ?>"  href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status <?php echo ( esc_attr($check) ) ? 'good' : 'bad'; ?>">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo ( esc_attr($check) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?>

		                    <?php 
		                    
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $wp_memory_limit . $error_msg ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>
		        </tbody>
		    </table>

		    <?php 
		    /* ==================================================
		       Server environment
		    ================================================== */
		     ?>
		    <table class="widefat rascals-system" cellspacing="0">
		        
		        <thead>
		            <tr>
		                <th colspan="3"><h2><?php rascals_esc_e( 'Server environment' ) ?></h2></th>
		            </tr>
		        </thead>
		        <tbody>

		            <tr>
		                <?php

		                /* ==================================================
		                   PHP Version
		                ================================================== */
		                $php_version = phpversion();
		                $req_wp_version = $this->theme_required['PHP_VERSION'];
		                if ( version_compare( $php_version, '5.6', '<' ) ) {
		                     $error_msg =  ' - ' . rascals_esc_( 'The theme needs at least PHP 7 installed on your server.' );
		                     $check = false;
		                } elseif ( version_compare( $php_version, '7.2', '<' ) ) {
		                    $error_msg = ' - ' . rascals_esc_( 'We recommend using PHP version 7.2 or above for greater performance and security.' );
		                    $check = true;
		                } else {
		                    $check = true;
		                    $error_msg = '';
		                }

		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'PHP Version' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The version of PHP installed on your hosting server.' ); ?>"  target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status <?php echo ( esc_attr($check) ) ? 'good' : 'bad'; ?>">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo ( esc_attr($check) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $php_version . $error_msg  ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>

		            <tr>
		                <?php

		                /* ==================================================
		                   Max Input Vars
		                ================================================== */
		                $max_input_vars = @ini_get( 'max_input_vars' );
		                $req_max_input_vars = $this->theme_required['MAX_INPUT_VARS'];
		                $check = ( wp_convert_hr_to_bytes( $max_input_vars ) >= wp_convert_hr_to_bytes( $req_max_input_vars ) );
		                $error_msg = ( ! $check ) ? ' - ' . sprintf( rascals_esc_( 'It is recommended to increase your max_input_var value to %s at least' ), $this->theme_required['MAX_INPUT_VARS'] ) : '';
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'Max Input Vars' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The maximum amount of variable your server can use for a single function.' ); ?>"   target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status <?php echo ( esc_attr($check) ) ? 'good' : 'bad'; ?>">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo ( esc_attr($check) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $max_input_vars . $error_msg ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>

		            <tr>
		                <?php

		                /* ==================================================
		                   PHP Time Limit
		                ================================================== */
		                $max_input_vars = @ini_get( 'max_execution_time' );
		                $req_max_input_vars = $this->theme_required['SERVER_TIME_LIMIT'];
		                $check = ( wp_convert_hr_to_bytes( $max_input_vars ) >= wp_convert_hr_to_bytes( $req_max_input_vars ) );
		                $error_msg = ( ! $check ) ? ' - ' . sprintf( rascals_esc_( 'It is recommended to increase your max_execution_time value to %s at least' ), $this->theme_required['SERVER_TIME_LIMIT'] ) : '';
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'PHP Time Limit' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).' ); ?>"   target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status <?php echo ( esc_attr($check) ) ? 'good' : 'bad'; ?>">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo ( esc_attr($check) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $max_input_vars . $error_msg ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>

		            <tr>
		                <?php

		                /* ==================================================
		                   PHP Post Max Size
		                ================================================== */
		                $post_max_size = size_format( wp_convert_hr_to_bytes( @ini_get( 'post_max_size' ) ) );
		             
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'PHP Post Max Size' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The largest filesize that can be contained in one post.' ); ?>"   target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status good">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo '<span class="dashicons dashicons-yes"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $post_max_size ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>

		            <tr>
		                <?php

		                /* ==================================================
		                   Server Memory Limit
		                ================================================== */
		                $server_memory_limit = @ini_get( 'memory_limit' );
		                $req_server_memory_limit = $this->theme_required['SERVER_MEMORY_LIMIT'];
		                $check = ( wp_convert_hr_to_bytes( $server_memory_limit ) >= wp_convert_hr_to_bytes( $req_server_memory_limit ) );
		                $error_msg = ( ! $check ) ? ' - ' . sprintf( rascals_esc_( 'It is recommended to increase your server memory limit to %s at least' ), $this->theme_required['SERVER_MEMORY_LIMIT'] ) : '';
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'Server Memory Limit' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The maximum amount of memory (RAM) that your server can use at one time.' ); ?>"  target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status <?php echo ( esc_attr($check) ) ? 'good' : 'bad'; ?>">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo ( esc_attr($check) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $server_memory_limit . $error_msg ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>

		            <tr>
		                <?php

		                /* ==================================================
		                  Max Upload Size
		                ================================================== */
		                $wp_max_upload_size = size_format( wp_max_upload_size() );
		             
		                ?>
		                <td class="label">
		                    <?php 
		                    /* Label
		                     -------------------------------- */
		                    rascals_esc_e( 'Max Upload Size' ); ?> 
		                </td>

		                <td class="help">
		                    <?php 
		                    /* Help 
		                     -------------------------------- */ ?>
		                    <a class="help-tip" title="<?php rascals_esc_e( 'The largest filesize that can be uploaded to your WordPress installation.' ); ?>"   target="_blank"><span class="dashicons dashicons-editor-help"></span></a>
		                </td>

		                <td class="status good">
		                    <?php 
		                    /* Status
		                     -------------------------------- */
		                    echo '<span class="dashicons dashicons-yes"></span>'; ?>

		                    <?php 
		                    /* Status Info
		                     -------------------------------- */
		                    echo esc_attr( $wp_max_upload_size ); ?>

		                </td>
		                <?php unset( $check, $error_msg ) ?>
		            </tr>
		        </tbody>
		    </table>
		</div>
	<?php

	}

}

function RascalsAdminPages() {
	return RascalsAdminPages::getInstance();
}

RascalsAdminPages(); // Run