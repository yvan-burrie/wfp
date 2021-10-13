<?php
/**
 *
 * Translates
 *
 *
 * @author Rascals Themes
 * @version 1.0.0
 * @category Core
 * @package Toolkit Core
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * All Core Translates
 * @version 1.0.0
 * @return string
 */
function rascals_esc_strings( ) {


	// All Core Strings
	return array(

		// Admin pages
		'Welcome' => 
			__( 'Welcome', 'meloo-toolkit' ),
		'System Status' => 
			__( 'System Status', 'meloo-toolkit' ),
		'Theme Plugins' => 
			__( 'Theme Plugins', 'meloo-toolkit' ),
		'Install Demos' => 
			__( 'Install Demos', 'meloo-toolkit' ),
		'Theme Panel' => 
			__( 'Theme Panel', 'meloo-toolkit' ),
		'System Status' => 
			__( 'System Status', 'meloo-toolkit' ),
		'Check that all the requirements below.' => 
			__( 'Check that all the requirements below.', 'meloo-toolkit' ),
		'WordPress environment' => 
			__( 'WordPress environment', 'meloo-toolkit' ),
		'It is recommended to update WordPress to the latest version' => 
			__( 'It is recommended to update WordPress to the latest version', 'meloo-toolkit' ),
		'The version of WordPress installed on your site.' => 
			__( 'The version of WordPress installed on your site.', 'meloo-toolkit' ),
		'It is recommended to increase your WP memory limit to %s at least' => 
			__( 'It is recommended to increase your WP memory limit to %s at least', 'meloo-toolkit' ),
		'WP Memory Limit' => 
			__( 'WP Memory Limit', 'meloo-toolkit' ),
		'The maximum amount of memory (RAM) that your site can use at one time.' => 
			__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'meloo-toolkit' ),
		'Server environment' => 
			__( 'Server environment', 'meloo-toolkit' ),
		'The theme needs at least PHP 7 installed on your server.' => 
			__( 'The theme needs at least PHP 7 installed on your server.', 'meloo-toolkit' ),
		'We recommend using PHP version 7.2 or above for greater performance and security.' => 
			__( 'We recommend using PHP version 7.2 or above for greater performance and security.', 'meloo-toolkit' ),
		'PHP Version' => 
			__( 'PHP Version', 'meloo-toolkit' ),
		'The version of PHP installed on your hosting server.' => 
			__( 'The version of PHP installed on your hosting server.', 'meloo-toolkit' ),
		'It is recommended to increase your max_input_var value to %s at least' => 
			__( 'It is recommended to increase your max_input_var value to %s at least', 'meloo-toolkit' ),
		'Max Input Vars' => 
			__( 'Max Input Vars', 'meloo-toolkit' ),
		'The maximum amount of variable your server can use for a single function.' => 
			__( 'The maximum amount of variable your server can use for a single function.', 'meloo-toolkit' ),
		'It is recommended to increase your max_execution_time value to %s at least' => 
			__( 'It is recommended to increase your max_execution_time value to %s at least', 'meloo-toolkit' ),
		'PHP Time Limit' => 
			__( 'PHP Time Limit', 'meloo-toolkit' ),
		'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).' => 
			__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups).', 'meloo-toolkit' ),
		'PHP Post Max Size' => 
			__( 'PHP Post Max Size', 'meloo-toolkit' ),
		'The largest filesize that can be contained in one post.' => 
			__( 'The largest filesize that can be contained in one post.', 'meloo-toolkit' ),
		'It is recommended to increase your server memory limit to %s at least' => 
			__( 'It is recommended to increase your server memory limit to %s at least', 'meloo-toolkit' ),
		'Server Memory Limit' => 
			__( 'Server Memory Limit', 'meloo-toolkit' ),
		'The maximum amount of memory (RAM) that your server can use at one time.' => 
			__( 'The maximum amount of memory (RAM) that your server can use at one time.', 'meloo-toolkit' ),
		'Max Upload Size' => 
			__( 'Max Upload Size', 'meloo-toolkit' ),
		'The largest filesize that can be uploaded to your WordPress installation.' => 
			__( 'The largest filesize that can be uploaded to your WordPress installation.', 'meloo-toolkit' ),
		'Install Demos' => 
			__( 'Install Demos', 'meloo-toolkit' ),
		'WordPress version' => 
			__( 'WordPress version', 'meloo-toolkit' ),

		// CPT
		'Sort Items' => 
			__( 'Sort Items', 'meloo-toolkit' ),
		'Edit This Post' => 
			__( 'Edit Post', 'meloo-toolkit' ),

		// Importer
		'Demos' => 
			__( 'Demos', 'meloo-toolkit' ),
		'Before you begin, you need to install and activate the following plugins' => 
			__( 'Before you begin, you need to install and activate the following plugins', 'meloo-toolkit' ),
		'Install Plugins' => 
			__( 'Install Plugins', 'meloo-toolkit' ),
		'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. Before running the importer, make sure that you have installed and activated the required and recommended plugins. You will see a message at the bottom of this page if you have not yet done so. When you import the data following things will happen:' => 
			__( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. Before running the importer, make sure that you have installed and activated the required and recommended plugins. You will see a message at the bottom of this page if you have not yet done so. When you import the data following things will happen:', 'meloo-toolkit' ),
		'All widgets located in primary sidebar will be removed, please move them to another sidebar.' => 
			__( 'All widgets located in primary sidebar will be removed, please move them to another sidebar.', 'meloo-toolkit' ),
		'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.' => 
			__( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'meloo-toolkit' ),
		'No WordPress settings will be modified.' => 
			__( 'No WordPress settings will be modified.', 'meloo-toolkit' ),
		'Posts, pages, some images, some widgets and menus will get imported.' => 
			__( 'Posts, pages, some images, some widgets and menus will get imported.', 'meloo-toolkit' ),
		'Images will be downloaded from our server.' => 
			__( 'Images will be downloaded from our server.', 'meloo-toolkit' ),
		'Please click import only once and wait.' => 
			__( 'Please click import only once and wait.', 'meloo-toolkit' ),
		'Please be patient and wait for the import process to complete. It can take up to 5-7 minutes.' => 
			__( 'Be patient and wait for the import process to complete. It can take up to 5-7 minutes.', 'meloo-toolkit' ),
		'I agree that all media elements of demo content like images, videos and mp3 files will be downloaded from the third-party server (rascalsthemes.com).' => 
			__( 'I agree that all media elements of demo content like images, videos and mp3 files will be downloaded from the third-party server (rascalsthemes.com).', 'meloo-toolkit' ),
		'Import Again' => 
			__( 'Import Again', 'meloo-toolkit' ),
		'Import' => 
			__( 'Import', 'meloo-toolkit' ),
		'Well Done! Demo content has been imported.' => 
			__( 'Well Done! Demo content has been imported.', 'meloo-toolkit' ),
		"The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755. If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually." => 
			__( "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755. If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually.", 'meloo-toolkit' ),
		'Theme options Import file could not be found. Please try again.' => 
			__( 'Theme options Import file could not be found. Please try again.', 'meloo-toolkit' ),
		'Widget Import file could not be found. Please try again.' => 
			__( 'Widget Import file could not be found. Please try again.', 'meloo-toolkit' ),
		'Sidebar does not exist in theme (using Inactive)' => 
			__( 'Sidebar does not exist in theme (using Inactive)', 'meloo-toolkit' ),
		'Site does not support widget' => 
			__( 'Site does not support widget', 'meloo-toolkit' ),
		'Widget already exists' => 
			__( 'Widget already exists', 'meloo-toolkit' ),
		'Imported' => 
			__( 'Imported', 'meloo-toolkit' ),
		'Imported to Inactive' => 
			__( 'Imported to Inactive', 'meloo-toolkit' ),
		'No Title' => 
			__( 'No Title', 'meloo-toolkit' ),

		// class-parsers.php 
		'There was an error when reading this WXR file' => 
			__( 'There was an error when reading this WXR file', 'meloo-toolkit' ),
		'Details are shown above. The importer will now try again with a different parser...' => 
			__( 'Details are shown above. The importer will now try again with a different parser...', 'meloo-toolkit' ),
		'This does not appear to be a WXR file, missing/invalid WXR version number' => 
			__( 'This does not appear to be a WXR file, missing/invalid WXR version number', 'meloo-toolkit' ),

		// class-wordpress-importer.php
		'Sorry, there has been an error.' => 
			__( 'Sorry, there has been an error.', 'meloo-toolkit' ),
		'The file does not exist, please try again.' => 
			__( 'The file does not exist, please try again.', 'meloo-toolkit' ),
		'All done.' => 
			__( 'All done.', 'meloo-toolkit' ),
		'Have fun!' => 
			__( 'Have fun!', 'meloo-toolkit' ),	
		'Remember to update the passwords and roles of imported users.' => 
			__( 'Remember to update the passwords and roles of imported users.', 'meloo-toolkit' ),
		'Sorry, there has been an error.' => 
			__( 'Sorry, there has been an error.', 'meloo-toolkit' ),
		'The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.' => 
			__( 'The export file could not be found at <code>%s</code>. It is likely that this was caused by a permissions problem.', 'meloo-toolkit' ),
		'This WXR file (version %s) may not be supported by this version of the importer. Please consider updating.' => 
			__( 'This WXR file (version %s) may not be supported by this version of the importer. Please consider updating.', 'meloo-toolkit' ),
		'Failed to import author %s. Their posts will be attributed to the current user.' => 
			__( 'Failed to import author %s. Their posts will be attributed to the current user.', 'meloo-toolkit' ),
		'Assign Authors' => 
			__( 'Assign Authors', 'meloo-toolkit' ),
		'To make it simpler for you to edit and save the imported content, you may want to reassign the author of the imported item to an existing user of this site, such as your primary administrator account.' => 
			__( 'To make it simpler for you to edit and save the imported content, you may want to reassign the author of the imported item to an existing user of this site, such as your primary administrator account.', 'meloo-toolkit' ),
		'If a new user is created by WordPress, a new password will be randomly generated and the new user&#8217;s role will be set as %s. Manually changing the new user&#8217;s details will be necessary.' => 
			__( 'If a new user is created by WordPress, a new password will be randomly generated and the new user&#8217;s role will be set as %s. Manually changing the new user&#8217;s details will be necessary.', 'meloo-toolkit' ),
		'Import Attachments' => 
			__( 'Import Attachments', 'meloo-toolkit' ),
		'Download and import file attachments' => 
			__( 'Download and import file attachments', 'meloo-toolkit' ),
		'Submit' => 
			__( 'Submit', 'meloo-toolkit' ),
		'Import author:' => 
			__( 'Import author:', 'meloo-toolkit' ),
		'or create new user with login name:' => 
			__( 'or create new user with login name:', 'meloo-toolkit' ),
		'as a new user:' => 
			__( 'as a new user:', 'meloo-toolkit' ),
		'assign posts to an existing user:' => 
			__( 'assign posts to an existing user:', 'meloo-toolkit' ),
		'or assign posts to an existing user:' => 
			__( 'or assign posts to an existing user:', 'meloo-toolkit' ),
		'- Select -' => 
			__( '- Select -', 'meloo-toolkit' ),
		'Failed to create new user for %s. Their posts will be attributed to the current user.' => 
			__( 'Failed to create new user for %s. Their posts will be attributed to the current user.', 'meloo-toolkit' ),
		'Failed to import category %s' => 
			__( 'Failed to import category %s', 'meloo-toolkit' ),
		'Failed to import post tag %s' => 
			__( 'Failed to import post tag %s', 'meloo-toolkit' ),
		'Failed to import %s %s' => 
			__( 'Failed to import %s %s', 'meloo-toolkit' ),
		'Failed to import &#8220;%s&#8221;: Invalid post type %s' => 
			__( 'Failed to import &#8220;%s&#8221;: Invalid post type %s', 'meloo-toolkit' ),
		'%s &#8220;%s&#8221; already exists.' => 
			__( '%s &#8220;%s&#8221; already exists.', 'meloo-toolkit' ),
		'Failed to import %s &#8220;%s&#8221;' => 
			__( 'Failed to import %s &#8220;%s&#8221;', 'meloo-toolkit' ),
		'Menu item skipped due to missing menu slug' => 
			__( 'Menu item skipped due to missing menu slug', 'meloo-toolkit' ),
		'Menu item skipped due to invalid menu slug: %s' => 
			__( 'Menu item skipped due to invalid menu slug: %s', 'meloo-toolkit' ),
		'Could not create temporary file.' => 
			__( 'Could not create temporary file.', 'meloo-toolkit' ),
		'Request failed due to an error: %1$s (%2$s)' => 
			__( 'Request failed due to an error: %1$s (%2$s)', 'meloo-toolkit' ),
		'Remote server returned the following unexpected result: %1$s (%2$s)' => 
			__( 'Remote server returned the following unexpected result: %1$s (%2$s)', 'meloo-toolkit' ),
		'Remote server did not respond' => 
			__( 'Remote server did not respond', 'meloo-toolkit' ),
		'Zero size file downloaded' => 
			__( 'Zero size file downloaded', 'meloo-toolkit' ),
		'Downloaded file has incorrect size' => 
			__( 'Downloaded file has incorrect size', 'meloo-toolkit' ),
		'Remote file is too large, limit is %s' => 
			__( 'Remote file is too large, limit is %s', 'meloo-toolkit' ),
		'Sorry, this file type is not permitted for security reasons.' => 
			__( 'Sorry, this file type is not permitted for security reasons.', 'meloo-toolkit' ),
		'The uploaded file could not be moved' => 
			__( 'The uploaded file could not be moved', 'meloo-toolkit' ),
		'Import WordPress' => 
			__( 'Import WordPress', 'meloo-toolkit' ),
		'A new version of this importer is available. Please update to version %s to ensure compatibility with newer export files.' => 
			__( 'A new version of this importer is available. Please update to version %s to ensure compatibility with newer export files.', 'meloo-toolkit' ),
		'Howdy! Upload your WordPress eXtended RSS (WXR) file and we&#8217;ll import the posts, pages, comments, custom fields, categories, and tags into this site.' => 
			__( 'Howdy! Upload your WordPress eXtended RSS (WXR) file and we&#8217;ll import the posts, pages, comments, custom fields, categories, and tags into this site.', 'meloo-toolkit' ),
		'Choose a WXR (.xml) file to upload, then click Upload file and import.' => 
			__( 'Choose a WXR (.xml) file to upload, then click Upload file and import.', 'meloo-toolkit' ),
		'Invalid file type' => 
			__( 'Invalid file type', 'meloo-toolkit' ),

		// class-metabox.php 
		
		// add_image.php
		'Media libary' => 
			__( 'Media libary', 'meloo-toolkit' ),
		'External link' => 
			__( 'External link', 'meloo-toolkit' ),
		'Preview Image' => 
			__( 'Preview Image', 'meloo-toolkit' ),

		// bg_generator.php	
		'Add Background' => 
			__( 'Add Background', 'meloo-toolkit' ),
		'Edit Background' => 
			__( 'Edit Background', 'meloo-toolkit' ),
		'Remove' => 
			__( 'Remove', 'meloo-toolkit' ),
		'Preview Image' => 
			__( 'Preview Image', 'meloo-toolkit' ),
		'Set your background again, because current is not compatible with latest framework version.' => 
			__( 'Set your background again, because current is not compatible with latest framework version.', 'meloo-toolkit' ),
		'Background Color' => 
			__( 'Background Color', 'meloo-toolkit' ),
		'Background Image' => 
			__( 'Background Image', 'meloo-toolkit' ),
		'Preview Image' => 
			__( 'Preview Image', 'meloo-toolkit' ),
		'Background Position' => 
			__( 'Background Position', 'meloo-toolkit' ),
		'The background-position property sets the starting position of a background image. The first value is the horizontal position and the second value is the vertical. The top left corner is 0 0.' => 
			__( 'The background-position property sets the starting position of a background image. The first value is the horizontal position and the second value is the vertical. The top left corner is 0 0.', 'meloo-toolkit' ),
		'Background Repeat' => 
			__( 'Background Repeat', 'meloo-toolkit' ),
		'The background-repeat property sets if/how a background image will be repeated.' => 
			__( 'The background-repeat property sets if/how a background image will be repeated.', 'meloo-toolkit' ),
		'Background Attachment' => 
			__( 'Background Attachment', 'meloo-toolkit' ),
		'The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.' => 
			__( 'The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'meloo-toolkit' ),
		'Background Size' => 
			__( 'Background Size', 'meloo-toolkit' ),
		'The background-size property specifies the size of the background images.' => 
			__( 'The background-size property specifies the size of the background images.', 'meloo-toolkit' ),

		// easy_link.php
		'Open link in new window/tab: ' => 
			__( 'Open link in new window/tab: ', 'meloo-toolkit' ),
		'Insert Link' => 
			__( 'Insert Link', 'meloo-toolkit' ),
		'Search' => 
			__( 'Search', 'meloo-toolkit' ),

		// iframe_generator.php
		'Generate Iframe' => 
			__( 'Generate Iframe', 'meloo-toolkit' ),
		'Remove' => 
			__( 'Remove', 'meloo-toolkit' ),
		'Error: Content does not contain the iframe.' => 
			__( 'Error: Content does not contain the iframe.', 'meloo-toolkit' ),
		'Iframe Code' => 
			__( 'Iframe Code', 'meloo-toolkit' ),
		'Paste Iframe code here.' => 
			__( 'Paste Iframe code here.', 'meloo-toolkit' ),
		
		// media_manager.php
		'Select All' => 
			__( 'Select All', 'meloo-toolkit' ),
		'Error: Image file doesn\'t exists.' => 
			__( 'Error: Image file doesn\'t exists.', 'meloo-toolkit' ),
		'Error: AJAX Transport' => 
			__( 'Error: AJAX Transport', 'meloo-toolkit' ),
		'Remove Selected Items' => 
			__( 'Remove Selected Items', 'meloo-toolkit' ),
		'Remove Selected' => 
			__( 'Remove Selected', 'meloo-toolkit' ),
		'Save' => 
			__( 'Save', 'meloo-toolkit' ),
		'Edit/Close' => 
			__( 'Edit/Close', 'meloo-toolkit' ),
		'Select' => 
			__( 'Select', 'meloo-toolkit' ),
		'Search' => 
			__( 'Search', 'meloo-toolkit' ),
		'Select All:' => 
			__( 'Select All:', 'meloo-toolkit' ),
		'Load Next 30 Items' => 
			__( 'Load Next 30 Items', 'meloo-toolkit' ),
		'Error!' => 
			__( 'Error!', 'meloo-toolkit' ),

		// select_tracks.php
		'Error: ID: Is not defined!' => 
			__( 'Error: ID: Is not defined!', 'meloo-toolkit' ),
		'Edit original tracklist here.' => 
			__( 'Edit original tracklist here.', 'meloo-toolkit' ),
		'Remove Track' => 
			__( 'Remove Track', 'meloo-toolkit' ),

	);

}


function rascals_esc_( $string = '' ) {

	// All Core Strings
	$strings = rascals_esc_strings();

	if ( $string === '' || ! isset($strings[$string]) ) {
		return $string;
	}

	return $strings[$string];

}

function rascals_esc_e( $string = '' ) {

	// All Core Strings
	$strings = rascals_esc_strings();

	if ( $string === '' || ! isset($strings[$string]) ) {
		echo rascals_esc_($string);
	} else {
		echo rascals_esc_($strings[$string]);
	}

}