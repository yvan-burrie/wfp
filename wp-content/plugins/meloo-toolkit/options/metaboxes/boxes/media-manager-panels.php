<?php
/**
 * Rascals MetaBox Media Manger Extra Panels
 *
 * @author Rascals Themes
 * @category Metabox
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



/* Helpers */

/* Target options */
$target_options = array(
	array('name' => esc_html__( 'Same Window/Tab', 'meloo-toolkit' ), 'value' => '_self'),
	array('name' => esc_html__( 'New Window/Tab', 'meloo-toolkit' ), 'value' => '_blank')
);

/* Yes/No */
$yes_no_options = array(
	array('name' => esc_html__( 'No', 'meloo-toolkit' ), 'value' => 'no'),
	array('name' => esc_html__( 'Yes', 'meloo-toolkit' ), 'value' => 'yes')
);

$output = '';



/*
 AUDIO PANEL
 -------------------------------------------------------------------------- */ 
 /* Display only if the type matches */
	if ( $type === 'audio' ) {

		/* Output */
		$output = '';

		/* Defaults */
   	$defaults = array(
		'custom'           => $custom,
		'custom_url'       => '',
		'title'            => '',
		'artists'          => '',
		'artists_url'      => '',
		'artists_target'   => '',
		'buttons'          => '',
		'cover'            => '',
		'release_url'      => '',
		'release_target'   => '',
		'cart_url'         => '',
		'cart_target'      => '',
		'free_download'    => 'no',
		'track_length'     => '',
		'lyrics'           => '',
		'disable_playback' => 'no',
		'waveform'         => ''
	);

	/* Set default options */
	if ( isset( $options ) && is_array( $options ) ) {
		$options = array_merge( $defaults, $options );
	} else {
		$options = $defaults;
	}

	/* Helpers */

	/* Target options */
	$target_options = array(
		array('name' => esc_html__( 'Same Window/Tab', 'meloo-toolkit' ), 'value' => '_self'),
		array('name' => esc_html__( 'New Window/Tab', 'meloo-toolkit' ), 'value' => '_blank')
	);

	/* Yes/No */
	$yes_no_options = array(
		array('name' => esc_html__( 'No', 'meloo-toolkit' ), 'value' => 'no'),
		array('name' => esc_html__( 'Yes', 'meloo-toolkit' ), 'value' => 'yes')
	);


	/*  FIELDS
	 ------------------------------------------------------------------------------*/

	$output .= '<fieldset class="muttleybox">';
	/* Loading layer */
	$output .= '<div class="loading-layer"></div>';	
	/* Title */
	if ( $options['title'] == '' && ! $options['custom'] ) {
		$options['title'] = $item->post_title;
	}
	if ( $options['title'] == '' ) {
		$options['title'] = esc_html__( 'Track Title', 'meloo-toolkit' );
	}
	$output .= '

		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label>' . esc_html__( 'Track ID', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-audio-id" onfocus="this.select();" readonly="readonly" value="' . esc_attr( $id ) . '" />
					<p class="help-box">' . esc_html__( 'Track ID can be used to select tracks.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>

		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-audio-title">' . esc_html__( 'Track Title', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-audio-title" name="title" value="' . esc_attr( $options['title'] ) . '" />
					<p class="help-box">' . esc_html__( 'Enter track title.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';
	

	/* Custom url */
	if ( $options['custom'] ) {
		$output .= '
			<div class="box-row clearfix">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-audio-custom-url">' . esc_html__( 'Release/Track URL', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<input type="text" id="mm-audio-custom-url" name="custom_url" value="' . esc_attr( $options['custom_url'] ) . '" />
						<p class="help-box">' . esc_html__( 'Paste here link to the MP3 file or link to Soundcloud track, list, favorite tracks, or paste direct link of music track from following services like: hearthis.at and click on appropriate button. Then the fields will be automatically filled in with the data taken from the selected site.', 'meloo-toolkit' ) . '</p>
						<div class="sub-name services-label">' . esc_html__( 'Get track data from following services:', 'meloo-toolkit' ) . '</div>
						<div class="box-services-buttons">
							<button class="_button add-hearthis"><i class="fa icon fa-plus"></i>' . esc_html__( 'hearthis.at', 'meloo-toolkit' ) . '</button><button class="_button add-googledrive"><i class="fa icon fa-plus"></i>' . esc_html__( 'Google Drive', 'meloo-toolkit' ) . '</button>
						</div>
						
						<div class="services-messages">
							<p class="msg msg-warning msg-correct-link">' . esc_html__( 'Please enter a valid link, or select another service..', 'meloo-toolkit' ) . '</p>
							<p class="msg msg-warning msg-already-exists">' . esc_html__( 'Link is already converted, please enter a new link.', 'meloo-toolkit' ) . '</p>
							<p class="msg msg-error msg-track-error">' . esc_html__( 'Error! Data could not be retrieved. Please try later, service may now be disabled.', 'meloo-toolkit' ) . '</p>
							<p class="msg msg-success msg-done">' . esc_html__( 'Done! Data has been downloaded successfully.', 'meloo-toolkit' ) . '</p>
						</div>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';
	}

	/* Track Length */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-track_length">' . esc_html__( 'Length (optional)', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-track_length" name="track_length" value="' . esc_attr( $options['track_length'] ) . '" />
					<p class="help-box">' . esc_html__( 'Track length is displayed in content tracklist.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	/* Artists */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-track_artists">' . esc_html__( 'Artist', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-track_artists" name="artists" value="' . esc_attr( $options['artists'] ) . '" />
					<p class="help-box">' . esc_html__( 'Enter track artist(s) . ', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	/* Artists Link */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-artists_url">' . esc_html__( 'Artists URL', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-artists_url" name="artists_url" value="' . esc_attr( $options['artists_url'] ) . '" />
					<p class="help-box">' . esc_html__( 'Paste artist URL.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
		</div>';

	/* Artist Button target */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
				</div>
				<div class="box-tc box-tc-input">
					<div class="sub-name services-label">' . esc_html__( 'Artists Link Target', 'meloo-toolkit' ) . '</div>
					<select id="mm-artists_target" name="artists_target" size="1" class="box-select">';

		foreach ( $target_options as $option ) {
				
			if ( $options['artists_target'] == $option['value'] ) 
				$selected = 'selected';
			else 
				$selected = '';
			$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
		}

	$output .= '</select>';
	$output .= '<p class="help-box">' . esc_html__( 'Select window option.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	/* Track Buttons */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-audio_buttons">' . esc_html__( 'Track Buttons', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<textarea id="mm-audio_buttons" name="buttons" style="min-height:120px">' .  wp_kses_post( $options['buttons'] ) .'</textarea>
					<p class="help-box">' . esc_html__( 'Add player buttons (Note: divide links with linebreaks (Enter)). Button example:', 'meloo-toolkit' ) . '<br>[track_button title="Soundcloud" link="#" icon="soundcloud" target="_self"]</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	/* Cover */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label>' . esc_html__( 'Cover Image', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">';
					
					/* Source */
					if ( is_numeric( $options['cover'] ) || $options['cover'] == '' ) {
						$media_libary = 'selected="selected"';
						$input_type = 'hidden';
					} else {
						$external_link = 'selected="selected"';
						$input_type = 'text';
						$holder_classes .= ' hidden';
					}

					$output .= '<select size="1" class="image-source-select cover-source" >';

						$output .= "<option $media_libary value='media_libary'>" . esc_html__( 'Media libary', 'meloo-toolkit' ) . "</option>";
						$output .= "<option $external_link value='external_link'>" . esc_html__( 'External link', 'meloo-toolkit' ) . "</option>";
					
					$output .= '</select>';

					$output .= '<input type="' . esc_attr( $input_type ) . '" id="r-cover" name="cover" value="' . esc_attr( $options['cover'] ) . '" class="track-cover image-input" />';

					$image = wp_get_attachment_image_src( $options['cover'], 'thumbnail' );
					$image = $image[0];
					// If image exists
					if ( $image ) {
						$image_html = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Preview Image', 'meloo-toolkit' ) . '">';
						$is_image = 'is_image'; 
					} else {
						$image_html = '';
						$is_image = ''; 
					}

					$output .= '<div class="image-holder image-holder-cover ' . esc_attr( $is_image ) . ' ' . esc_attr( $holder_classes ) . '" data-placeholder="' . esc_url( $admin_path ) . '/assets/images/metabox/audio.png">';

					// Image
					$output .=  $image_html;

					// Button
					$output .= '<button class="upload-image"><i class="fa icon fa-plus"></i></button>';

					/* Remove image */
					$output .= '<a class="remove-image"><i class="fa icon fa-remove"></i></a>';
					$output .= '</div>';
					
	$output .= '<p class="help-box">' . esc_html__( 'Add image cover.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	/* Waveform */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label>' . esc_html__( 'Waveform Image', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">';
					
					/* Source */
					if ( is_numeric( $options['waveform'] ) || $options['waveform'] == '' ) {
						$media_libary = 'selected="selected"';
						$input_type = 'hidden';
					} else {
						$external_link = 'selected="selected"';
						$input_type = 'text';
						$holder_classes .= ' hidden';
					}

					$output .= '<select size="1" class="image-source-select" >';

						$output .= "<option $media_libary value='media_libary'>" . esc_html__( 'Media libary', 'meloo-toolkit' ) . "</option>";
						$output .= "<option $external_link value='external_link'>" . esc_html__( 'External link', 'meloo-toolkit' ) . "</option>";
					
					$output .= '</select>';

					$output .= '<input type="' . esc_attr( $input_type ) . '" id="r-waveform" name="waveform" value="' . esc_attr( $options['waveform'] ) . '" class="track-waveform image-input" />';

					$image = wp_get_attachment_image_src( $options['waveform'], 'thumbnail' );
					$image = $image[0];
					// If image exists
					if ( $image ) {
						$image_html = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Preview Image', 'meloo-toolkit' ) . '">';
						$is_image = 'is_image'; 
					} else {
						$image_html = '';
						$is_image = ''; 
					}

					$output .= '<div class="image-holder image-holder-waveform ' . esc_attr( $is_image ) . ' ' . esc_attr( $holder_classes ) . '" data-placeholder="' . esc_url( $admin_path ) . '/assets/images/metabox/audio.png">';

					// Image
					$output .=  $image_html;

					// Button
					$output .= '<button class="upload-image"><i class="fa icon fa-plus"></i></button>';

					/* Remove image */
					$output .= '<a class="remove-image"><i class="fa icon fa-remove"></i></a>';
					$output .= '</div>';
					
	$output .= '<p class="help-box">' . esc_html__( 'Add track waveform, best image is white or black PNG (depends on theme skin) with transparent background. Waveform can be generated on following site:', 'meloo-toolkit' ) . '<br><a href="http://convert.ing-now.com/mp3-audio-waveform-graphic-generator/" target="_blank">Waveform generator</a></p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';



	/* Release Link */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-release_url">' . esc_html__( 'Release URL', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-release_url" name="release_url" value="' . esc_attr( $options['release_url'] ) . '" />
					<p class="help-box">' . esc_html__( 'Paste release URL.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
		</div>';

	/* Release target */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
				</div>
				<div class="box-tc box-tc-input">
					<div class="sub-name services-label">' . esc_html__( 'Release Link Target', 'meloo-toolkit' ) . '</div>
					<select id="mm-release_target" name="release_target" size="1" class="box-select">';

		foreach ( $target_options as $option ) {
				
			if ( $options['release_target'] == $option['value'] ) 
				$selected = 'selected';
			else 
				$selected = '';
			$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
		}

	$output .= '</select>';
	$output .= '<p class="help-box">' . esc_html__( 'Select target link.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	/* Free download */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-free_download">' . esc_html__( 'Free Download?', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<select id="mm-free_download" name="free_download" size="1" class="box-select">';

		foreach ( $yes_no_options as $option ) {
				
			if ( $options['free_download'] == $option['value'] ) 
				$selected = 'selected';
			else 
				$selected = '';
			$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
		}

	$output .= '</select>';
	$output .= '<p class="help-box">' . esc_html__( 'If you choose this option, "Buy" icon will be replaced on "Download".', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	/* Cart Link */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-cart_url">' . esc_html__( 'Cart URL / Download URL', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-cart_url" name="cart_url" value="' . esc_attr( $options['cart_url'] ) . '" />
					<p class="help-box">' . esc_html__( 'Paste cart URL or download link.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
		</div>';


	/* Cart target */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
				</div>
				<div class="box-tc box-tc-input">
					<div class="sub-name services-label">' . esc_html__( 'Cart Link Target', 'meloo-toolkit' ) . '</div>
					<select id="mm-cart_target" name="cart_target" size="1" class="box-select">';

		foreach ( $target_options as $option ) {
				
			if ( $options['cart_target'] == $option['value'] ) 
				$selected = 'selected';
			else 
				$selected = '';
			$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
		}

	$output .= '</select>';
	$output .= '<p class="help-box">' . esc_html__( 'Select target link.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	/* Lyrics */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-lyrics">' . esc_html__( 'Track Lyrics (optional)', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<textarea id="mm-lyrics" name="lyrics" style="min-height:120px">' .  wp_kses_post( $options['lyrics'] ) .'</textarea>
					<p class="help-box">' . esc_html__( 'Track lyrics is displayed in content tracklist/track.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	/* Disable playable */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-disable_playback">' . esc_html__( 'Disable track playback?', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<select id="mm-disable_playback" name="disable_playback" size="1" class="box-select">';

		foreach ( $yes_no_options as $option ) {
				
			if ( $options['disable_playback'] == $option['value'] ) 
				$selected = 'selected';
			else 
				$selected = '';
			$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
		}

	$output .= '</select>';
	$output .= '<p class="help-box">' . esc_html__( 'If you choose this option, track will not be played, will only be visible in the content tracklist.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	$output .= '</fieldset>';

	return $output;
}



/*
 IMAGES PANEL
 -------------------------------------------------------------------------- */ 
if ( $type === 'images' ) {

		/* Output */
		$output = '';

		/* Defaults */
   	$defaults = array(
		'custom' => $custom,
		'title' => '',
		'custom_link' => ''
	);

	/* Set default options */
	if ( isset( $options ) && is_array( $options ) ) {
		$options = array_merge( $defaults, $options );
	} else {
		$options = $defaults;
	}

	/* Helpers */

	/* Target options */
	$target_options = array(
		array('name' => esc_html__( 'Same Window/Tab', 'meloo-toolkit' ), 'value' => '_self'),
		array('name' => esc_html__( 'New Window/Tab', 'meloo-toolkit' ), 'value' => '_blank')
	);

	/* Yes/No */
	$yes_no_options = array(
		array('name' => esc_html__( 'No', 'meloo-toolkit' ), 'value' => 'no'),
		array('name' => esc_html__( 'Yes', 'meloo-toolkit' ), 'value' => 'yes')
	);

	/*  IMAGE META 
	 ------------------------------------------------------------------------------*/
	/* Get Image Data */
	$meta = wp_get_attachment_metadata( $id );
	$image_data = wp_get_attachment_image_src( $id );

	$output .= '
		<div class="mm-item mm-item-editor" id="' . esc_attr( $id ) . '">
			<div class="mm-item-preview">
		    	<div class="mm-item-image">
		    		<div class="mm-centered">
		    			<a href="' . esc_url( $item->guid ) . '" target="_blank"><img src="' . esc_url( $image_data[0] ) . '" /></a>
		    		</div>
		    	</div>
			</div>
		</div>';
	
	/* Meta */
	$output .= '<div id="mm-editor-meta">';
		$output .= '<span><strong>' . esc_html__( 'File name:', 'meloo-toolkit' ) . '</strong> ' . esc_html( basename( $item->guid ) ) . '</span>';
		$output .= '<span><strong>' . esc_html__( 'File type:', 'meloo-toolkit' ) . '</strong> ' . esc_html( $item->post_mime_type ) . '</span>';
		$output .= '<span><strong>' . esc_html__( 'Upload date:', 'meloo-toolkit' ) . '</strong> ' . mysql2date( get_option( 'date_format' ), $item->post_date ) . '</span>';

		if ( is_array( $meta ) && array_key_exists( 'width', $meta ) && array_key_exists('height', $meta ) ) {
			$output .= '<span><strong>' . esc_html__( 'Dimensions:', 'meloo-toolkit' ) . '</strong> ' . esc_html( $meta['width'] ) . ' x ' . esc_html( $meta['height'] ) . '</span>';
		}

		$output .= '<span><strong>' . esc_html__( 'Image URL:', 'meloo-toolkit' ) . '</strong> <br>
		<a href="' . esc_url( $item->guid ) . '" target="_blank">' . esc_html__( '[IMAGE LINK]', 'meloo-toolkit' ) . '</a>
		</span>';

	$output .= '</div>';


	/*  FIELDS
	 ------------------------------------------------------------------------------*/

	 $output .= '<fieldset class="rascalsbox">';
			
	/* Title */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-image-title">' . esc_html__( 'Title', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-image-title" name="title" value="' . esc_attr( $options['title'] ) . '" />
					<p class="help-box">' . esc_html__( 'Image title.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';
	

	/* Custom Link */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-image-custom-link">' . esc_html__( 'Custom Link', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<textarea id="mm-custom-link" name="custom_link" style="min-height:40px">'. wp_kses_post( $options['custom_link'] ) .'</textarea>
					<p class="help-box">' . esc_html__( 'Add custom link to popup window.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	$output .= '</fieldset>';

	return $output;
}

/*
 SIMPLE SLIDER
 -------------------------------------------------------------------------- */ 
if ( $type === 'simple_slider' ) {

		/* Output */
		$output = '';

		/* Defaults */
   	$defaults = array(
		'custom'   => $custom,
		'title'    => '',
		'subtitle' => ''
	);

	/* Set default options */
	if ( isset( $options ) && is_array( $options ) ) {
		$options = array_merge( $defaults, $options );
	} else {
		$options = $defaults;
	}

	/* Helpers */

	/* Target options */
	$target_options = array(
		array('name' => esc_html__( 'Same Window/Tab', 'meloo-toolkit' ), 'value' => '_self'),
		array('name' => esc_html__( 'New Window/Tab', 'meloo-toolkit' ), 'value' => '_blank')
	);

	/* Yes/No */
	$yes_no_options = array(
		array('name' => esc_html__( 'No', 'meloo-toolkit' ), 'value' => 'no'),
		array('name' => esc_html__( 'Yes', 'meloo-toolkit' ), 'value' => 'yes')
	);


	/*  IMAGE META 
	 ------------------------------------------------------------------------------*/
	/* Get Image Data */
	$meta = wp_get_attachment_metadata( $id );
	$image_data = wp_get_attachment_image_src( $id );

	$output .= '
		<div class="mm-item mm-item-editor" id="' . esc_attr( $id ) . '">
			<div class="mm-item-preview">
		    	<div class="mm-item-image">
		    		<div class="mm-centered">
		    			<a href="' . esc_url( $item->guid ) . '" target="_blank"><img src="' . esc_url( $image_data[0] ) . '" /></a>
		    		</div>
		    	</div>
			</div>
		</div>';
	
	/* Meta */
	$output .= '<div id="mm-editor-meta">';
		$output .= '<span><strong>' . esc_html__( 'File name:', 'meloo-toolkit' ) . '</strong> ' . esc_html( basename( $item->guid ) ) . '</span>';
		$output .= '<span><strong>' . esc_html__( 'File type:', 'meloo-toolkit' ) . '</strong> ' . esc_html( $item->post_mime_type ) . '</span>';
		$output .= '<span><strong>' . esc_html__( 'Upload date:', 'meloo-toolkit' ) . '</strong> ' . mysql2date( get_option( 'date_format' ), $item->post_date ) . '</span>';

		if ( is_array( $meta ) && array_key_exists( 'width', $meta ) && array_key_exists('height', $meta ) ) {
			$output .= '<span><strong>' . esc_html__( 'Dimensions:', 'meloo-toolkit' ) . '</strong> ' . esc_html( $meta['width'] ) . ' x ' . esc_html( $meta['height'] ) . '</span>';
		}

		$output .= '<span><strong>' . esc_html__( 'Image URL:', 'meloo-toolkit' ) . '</strong> <br>
		<a href="' . esc_url( $item->guid ) . '" target="_blank">' . esc_html__( '[IMAGE LINK]', 'meloo-toolkit' ) . '</a>
		</span>';

	$output .= '</div>';


	/*  FIELDS
	 ------------------------------------------------------------------------------*/

	$output .= '<fieldset class="rascalsbox">';
		
	/* Title */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-image-title">' . esc_html__( 'Title', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<textarea id="mm-image-title" name="title" style="min-height:40px">'. wp_kses_post( $options['title'] ) .'</textarea>
					<p class="help-box">' . esc_html__( 'Image title.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';
	

	/* Subtitle */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-image-subtitle">' . esc_html__( 'Subtitle', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<textarea id="mm-image-subtitle" name="subtitle" style="min-height:40px">'. wp_kses_post( $options['subtitle'] ) .'</textarea>
					<p class="help-box">' . esc_html__( 'Image subtitle.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	$output .= '</fieldset>';

	return $output;
}


/*
 SLIDER
 -------------------------------------------------------------------------- */ 
if ( $type === 'slider' ) {

		$toolkit = melooToolkit();

		/* Output */
		$output = '';

		/* Defaults */
   	$defaults = array(
		'custom'        => $custom,
		'image_type'    => 'image', // image, lightbox, media, link, link_blank,
		'lightbox_link' => '',
		'link'          => '',
		'media_code'    => '',
		'media_link'    => '',
		'music'         => 'no', // no, yes
		'track_id'      => '', // track id
		'track_nr'      => '1',
		'title'         => '',
		'subtitle'      => '',
	);

	/* Set default options */
	if ( isset( $options ) && is_array( $options ) ) {
		$options = array_merge( $defaults, $options );
	} else {
		$options = $defaults;
	}

	/* Helpers */

	/* Target options */
	$target_options = array(
		array('name' => esc_html__( 'Same Window/Tab', 'meloo-toolkit' ), 'value' => '_self'),
		array('name' => esc_html__( 'New Window/Tab', 'meloo-toolkit' ), 'value' => '_blank')
	);

	/* Yes/No */
	$yes_no_options = array(
		array('name' => esc_html__( 'No', 'meloo-toolkit' ), 'value' => 'no'),
		array('name' => esc_html__( 'Yes', 'meloo-toolkit' ), 'value' => 'yes')
	);

	$image_type = array(
		array('name' => 'Image', 'value' => 'image'),
		array('name' => 'Image lightbox', 'value' => 'lightbox'),
		array('name' => 'Image with custom media', 'value' => 'media'),
		array('name' => 'Custom link', 'value' => 'link'),
		array('name' => 'Custom link (new window)', 'value' => 'link_blank'),
	);


	/*  IMAGE META 
	 ------------------------------------------------------------------------------*/
	/* Get Image Data */
	$meta = wp_get_attachment_metadata( $id );
	$image_data = wp_get_attachment_image_src( $id );

	$output .= '
		<div class="mm-item mm-item-editor" id="' . esc_attr( $id ) . '">
			<div class="mm-item-preview">
		    	<div class="mm-item-image">
		    		<div class="mm-centered">
		    			<a href="' . esc_url( $item->guid ) . '" target="_blank"><img src="' . esc_url( $image_data[0] ) . '" /></a>
		    		</div>
		    	</div>
			</div>
		</div>';
	
	/* Meta */
	$output .= '<div id="mm-editor-meta">';
		$output .= '<span><strong>' . esc_html__( 'File name:', 'meloo-toolkit' ) . '</strong> ' . esc_html( basename( $item->guid ) ) . '</span>';
		$output .= '<span><strong>' . esc_html__( 'File type:', 'meloo-toolkit' ) . '</strong> ' . esc_html( $item->post_mime_type ) . '</span>';
		$output .= '<span><strong>' . esc_html__( 'Upload date:', 'meloo-toolkit' ) . '</strong> ' . mysql2date( get_option( 'date_format' ), $item->post_date ) . '</span>';

		if ( is_array( $meta ) && array_key_exists( 'width', $meta ) && array_key_exists('height', $meta ) ) {
			$output .= '<span><strong>' . esc_html__( 'Dimensions:', 'meloo-toolkit' ) . '</strong> ' . esc_html( $meta['width'] ) . ' x ' . esc_html( $meta['height'] ) . '</span>';
		}

		$output .= '<span><strong>' . esc_html__( 'Image URL:', 'meloo-toolkit' ) . '</strong> <br>
		<a href="' . esc_url( $item->guid ) . '" target="_blank">' . esc_html__( '[IMAGE LINK]', 'meloo-toolkit' ) . '</a>
		</span>';

	$output .= '</div>';


	/*  FIELDS
	 ------------------------------------------------------------------------------*/

	$output .= '<fieldset class="rascalsbox">';
		
		/* Title */
		$output .= '
			<div class="box-row clearfix">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-image-title">' . esc_html__( 'Title', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<textarea id="mm-image-title" name="title" style="min-height:40px">'. wp_kses_post( $options['title'] ) .'</textarea>
						<p class="help-box">' . esc_html__( 'Image title.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';
		

		/* Subtitle */
		$output .= '
			<div class="box-row clearfix">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-image-subtitle">' . esc_html__( 'Subtitle', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<textarea id="mm-image-subtitle" name="subtitle" style="min-height:40px">'. wp_kses_post( $options['subtitle'] ) .'</textarea>
						<p class="help-box">' . esc_html__( 'Image subtitle.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';


		/* Video */
		$output .= '
			<div class="box-row clearfix">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-image-video">' . esc_html__( 'Video', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<textarea id="mm-image-video" name="video" style="min-height:40px">'. wp_kses_post( $options['video'] ) .'</textarea>
						<p class="help-box">' . esc_html__( 'Paste the full URL (include http://) of your Vimeo or Youtube movie. Video will be shown instead of the image.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';


		/* Image Type */
		$output .= '
			<div class="box-row clearfix">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-image-type">' . esc_html__( 'Image Type', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<select id="mm-image-type" name="image_type" size="1" data-main-group="mm-main-group-image-type" class="box-select mm-group">';

			foreach ( $image_type as $option ) {
					
				if ( $options['image_type'] == $option['value'] ) 
					$selected = 'selected';
				else 
					$selected = '';
				$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
			}

		$output .= '</select>';
		$output .= '<p class="help-box">' . esc_html__( 'Select image type.', 'meloo-toolkit' ) . '<br>' . esc_html__( 'NOTE: Displayed only on Intro slider section.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';


		/* Lightbox Link */
		$output .= '
			<div class="box-row clearfix mm-group-lightbox mm-main-group-image-type" style="display:none">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-lightbox_link">' . esc_html__( 'Lightbox Link', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<input type="text" id="mm-lightbox_link" name="lightbox_link" value="' . esc_attr( $options['lightbox_link'] ) . '" />
						<p class="help-box">' . esc_html__( 'Paste the full URL (include http://) of your image you would like to use for jQuery lightbox pop-up effect.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';


		/* Link */
		$output .= '
			<div class="box-row clearfix mm-group-link mm-group-link_blank mm-main-group-image-type" style="display:none">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-link">' . esc_html__( 'Link', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<input type="text" id="mm-link" name="link" value="' . esc_attr( $options['link'] ) . '" />
						<p class="help-box">' . esc_html__( 'Paste the full URL (include http://).', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';

		/* Media */
		$output .= '
			<div class="box-row clearfix media-embed mm-group-media mm-main-group-image-type" style="display:none">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-media-code">' . esc_html__( 'Media Code', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<textarea id="mm-media-code" name="media_code" style="min-height:40px">'. wp_kses_post( $options['media_code'] ) .'</textarea>
						<p class="help-box">' . esc_html__( 'Paste media embed code (iframe) of Soundcloud, Mixcloud or links to Youtube, Vimeo.', 'meloo-toolkit' ) . '</p>
						<input type="hidden" id="media_link" name="media_link" value="' . esc_attr( $options['media_link'] ) . '"/>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';


		/* Show Music Player? */
		$output .= '
			<div class="box-row clearfix">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-music">' . esc_html__( 'Show Music Player?', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<select id="mm-music" data-main-group="mm-main-group-music" name="music" size="1" class="box-select mm-group">';

			foreach ( $yes_no_options as $option ) {
					
				if ( $options['music'] == $option['value'] ) 
					$selected = 'selected';
				else 
					$selected = '';
				$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $option['value'] ) . "'>" . esc_attr( $option['name'] ) . "</option>";
			}

		$output .= '</select>';
		$output .= '<p class="help-box">' . esc_html__( 'Show music player.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';




		/* Track ID */
		$output .= '
			<div class="box-row clearfix mm-group-yes mm-main-group-music" style="display:none">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-track_id">' . esc_html__( 'Select Track(s)', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<select name="track_id" id="mm-track_id" data-main-group="mm-main-group-track_id" name="music" size="1" class="box-select mm-group">';

				/* Get Audio Tracks  */
				$type = 'meloo_tracks';
				$args = array(
					'post_type'      => $type,
					'post_status'    => 'publish',
					'posts_per_page' => -1
				);

				$tracks = "<option value='none'>" . esc_html__( 'Select tracks...', 'meloo-toolkit' ) . "</option>";
				$my_query = null;
				$my_query = new WP_Query($args);
				if ( $my_query->have_posts() ) {
  					while ( $my_query->have_posts() ) {
  						$my_query->the_post();

  						if ( get_the_id() == $options['track_id'] ) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
						$tracklist = $toolkit->scamp_player->getList( $id );
						if ( $toolkit->scamp_player->getList(  get_the_id() ) ) {

							$tracks .= "<option $selected value='" . esc_attr( get_the_id() ) . "'>" . get_the_title() . " (" . count( $toolkit->scamp_player->getList(  get_the_id() ) ) . ")</option>";
						} 
  					}
  				}

  				$output .= $tracks;
				wp_reset_query();  // Restore global post data stomped by the_post().
					
				
		$output .= '</select>';
		$output .= '<p class="help-box">' . esc_html__( 'Select tracklist or single track.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';


		/* Track Number */
		$output .= '
			<div class="box-row clearfix mm-group-yes mm-main-group-music" style="display:none">
				<div class="box-row-input">
					<div class="box-tc box-tc-label">
						<label for="mm-track_nr">' . esc_html__( 'Track Number', 'meloo-toolkit' ) . '</label>
					</div>
					<div class="box-tc box-tc-input">
						<input type="number" id="mm-track_nr" name="track_nr" value="' . esc_attr( $options['track_nr'] ) . '" />
						<p class="help-box">' . esc_html__( 'Select track.', 'meloo-toolkit' ) . '</p>
					</div>
				</div>
				<div class="box-row-line"></div>
			</div>';

	$output .= '</fieldset>';

	return $output;
}


/*
 BUTTONS PANEL
 -------------------------------------------------------------------------- */ 
if ( $type === 'buttons' ) {

	/* Output */
	$output = '';

	/* Defaults */
   	$defaults = array(
		'custom' => $custom,
		'id'     =>  $id,
		'icon'   => '',
		'title'  => '',
		'link'   => '',
	);

	/* Set default options */
	if ( isset( $options ) && is_array( $options ) ) {
		$options = array_merge( $defaults, $options );
	} else {
		$options = $defaults;
	}

	$social_media_a = array(
		'twitter'        => 'Twitter',
		'facebook'       => 'Facebook',
		'youtube'        => 'Youtube',
		'instagram'      => 'Instagram',
		'soundcloud'     => 'Soundcloud',
		'googleplay'     => 'GooglePlay',
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

	/* Box Filter */
	if ( has_filter( 'rascals_mb_buttons_socials_icons' ) ) {
		$social_media_a = apply_filters( 'rascals_mb_buttons_socials_icons', $social_media_a );
	}

	/*  FIELDS
	*/

	$output .= '<fieldset class="rascalsbox">';
	/* Loading layer */
	$output .= '<div class="loading-layer"></div>';	

	if ( $options['title'] === '' ) {
		$options['title'] = esc_html__( 'Custom title', 'meloo-toolkit' );
	}

	/* Title */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-buttons-title">' . esc_html__( 'Title', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-buttons-title" name="title" value="' . esc_attr( $options['title'] ) . '" />
					<p class="help-box">' . esc_html__( 'Enter title.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';
	
	/* Icon Website */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-icon">' . esc_html__( 'Icon', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<select id="mm-icon" name="icon" size="1" data-main-group="mm-main-group-icon" class="box-select mm-group">';
				
				foreach ( $social_media_a as $key => $option ) {
							
						if ( $options['icon'] === $key ) {
							$selected = 'selected';
						} else {
							$selected = '';
						}
						$output .= "<option " . esc_attr( $selected ) . " value='" . esc_attr( $key ) . "'>" . esc_attr( $option ) . "</option>";
					}
					$output .= '</select>';

					$output .= '<p class="help-box">' . esc_html__( 'Select website icon.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	/* Link */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-link">' . esc_html__( 'Link', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<input type="text" id="mm-link" name="link" value="' . esc_attr( $options['link'] ) . '" />
					<p class="help-box">' . esc_html__( 'Enter link.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	$output .= '</fieldset>';

	return $output;
}


/*
 ALBUMS SLIDER PANEL
 -------------------------------------------------------------------------- */ 
if ( $type === 'albums_slider' ) {

	/* Output */
	$output = '';

	/* Defaults */
   	$defaults = array(
		'custom'   => $custom,
		'id'       => $id,
		'album_id' => $album,
		'image'    => $image,
		'desc'     => $desc,
	);

	/* Set default options */
	if ( isset( $options ) && is_array( $options ) ) {
		$options = array_merge( $defaults, $options );
	} else {
		$options = $defaults;
	}

	/* Helpers */
	$post_type = 'meloo_albums';


	/*  FIELDS
	*/

	$output .= '<fieldset class="rascalsbox">';
	/* Loading layer */
	$output .= '<div class="loading-layer"></div>';	

	if ( $options['title'] === '' ) {
		$options['title'] = esc_html__( 'Custom title', 'meloo-toolkit' );
	}


	/* Album */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-album">' . esc_html__( 'Select Album', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<select id="mm-album" name="album" size="1" data-main-group="mm-main-group-album" class="box-select mm-group">';
				
				if ( post_type_exists( $post_type ) ) {

						$posts = get_posts( array('post_type' => $post_type, 'showposts' => -1 ) ); 
						if ( isset( $posts ) && is_array( $posts ) ) {
							foreach ( $posts as $post ) {

								// Multiple or single
								if ( $post->ID === intval( $options['album'] ) ) $selected = 'selected';
								else $selected = '';

								$output .= '<option ' . esc_attr( $selected ) . ' value="' . esc_attr( $post->ID ). '">';
								$output .= esc_html( $post->post_title );
								$output .= '</option>';
							}
						}
					}
				
					$output .= '</select>';

					$output .= '<p class="help-box">' . esc_html__( 'Select music album.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';

	/* Slider background */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label>' . esc_html__( 'Background Image', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">';
					
					/* Source */
					$input_type = 'hidden';
					$output .= '<input type="' . esc_attr( $input_type ) . '" id="r-image" name="image" value="' . esc_attr( $options['image'] ) . '" class="track-image image-input" />';

					$image = wp_get_attachment_image_src( $options['image'], 'thumbnail' );
					$image = $image[0];

					// If image exists
					if ( $image ) {
						$image_html = '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Preview Image', 'meloo-toolkit' ) . '">';
						$is_image = 'is_image'; 
					} else {
						$image_html = '';
						$is_image = ''; 
					}

					$output .= '<div class="image-holder image-holder-image ' . esc_attr( $is_image ) . ' ' . esc_attr( $holder_classes ) . '" data-placeholder="' . esc_url( $admin_path ) . '/core/metabox/assets/images/metabox/audio.png">';

					// Image
					$output .=  $image_html;

					// Button
					$output .= '<button class="upload-image"><i class="fa icon fa-plus"></i></button>';

					/* Remove image */
					$output .= '<a class="remove-image"><i class="fa icon fa-remove"></i></a>';
					$output .= '</div>';
					
	$output .= '<p class="help-box">' . esc_html__( 'Add slider background image.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	/* Description  */
	$output .= '
		<div class="box-row clearfix">
			<div class="box-row-input">
				<div class="box-tc box-tc-label">
					<label for="mm-desc">' . esc_html__( 'Description', 'meloo-toolkit' ) . '</label>
				</div>
				<div class="box-tc box-tc-input">
					<textarea id="mm-desc" name="desc" style="min-height:120px">'. esc_textarea( $options['desc'] ) .'</textarea>
					<p class="help-box">' . esc_html__( 'Short description for the slider.', 'meloo-toolkit' ) . '</p>
				</div>
			</div>
			<div class="box-row-line"></div>
		</div>';


	$output .= '</fieldset>';

	return $output;
}