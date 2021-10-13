<?php
/**
 * Rascals King Composer Extensions
 *
 *
 * @author Rascals Themes
 * @category Core
 * @package Meloo Toolkit
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$text_title 	= $textbutton = $ex_class = $wrap_class = '';
$wrapper_class	= apply_filters( 'kc-el-class', $atts );
$wrapper_class[] = 'kc-fancy-button-wrap';
$button_attr 	= array();

extract( $atts );

$link	= ( '||' === $link ) ? '' : $link;
$link	= kc_parse_link($link);

if ( strlen( $link['url'] ) > 0 ) {
	$a_href 	= $link['url'];
	$a_title 	= $link['title'];
	$a_target 	= strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}

if( !isset( $a_href ) )
	$a_href = "#";

if ( !empty( $wrap_class ) )
	$wrapper_class[] = $wrap_class;

$el_class = array( 'kc-btn' );

switch ($style) {
	case 'default':
		$el_class[] = 'btn';
		break;
	case 'frame':
		$el_class[] = 'frame-button button-l with-hover';
		break;
	case 'line':
		$el_class[] = 'line-link';
		break;
}


if ( !empty( $ex_class ) )
	$el_class[] = $ex_class;

if( isset( $el_class ) )
	$button_attr[] = 'class="'. esc_attr( implode(' ', $el_class ) ) .'"';

if( isset( $a_href ) )
	$button_attr[] = 'href="'. esc_attr($a_href) .'"';

if( isset( $a_target ) )
	$button_attr[] = 'target="'. esc_attr($a_target) .'"';

if( isset( $a_title ) )
	$button_attr[] = 'title="'. esc_attr($a_title) .'"';

if( isset( $onclick ) )
	$button_attr[] = 'onclick="'. $onclick .'"';
?>

<?php 
// Set color scheme 
if ( isset( $atts['classes'] ) ) {
    $atts['classes'] .= ' ' . $atts['color_scheme'] . '-scheme-el';
}

?>

<div class="<?php echo implode( " ", $wrapper_class ); ?>">
	<div class="kc-fancy-button-inner <?php echo esc_attr( $atts['classes'] ); ?>" data-parallax='{"y": <?php echo esc_attr( $parallax_y ) ?>}'>
		<a <?php echo implode(' ', $button_attr); ?>>
			<?php
				if ( $style === 'default' || $style === 'line' ) {
					echo esc_html( $text_title );
				} else if ( $style === 'frame' ) {
		        echo '<div class="button-layer button-layer-shadow">
		                ' . esc_html( $text_title ) . '
		            </div>
		            <div class="button-inner">
		                <div class="button-inner-block">
		                    <div class="button-hidden-layer">
		                        ' . esc_html( $text_title ) . '
		                    </div>
		                </div>
		            </div>';
				}
			?>
		</a>
	</div>
</div>