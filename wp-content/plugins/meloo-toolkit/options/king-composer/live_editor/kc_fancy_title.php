<#
var output 		= '',
	wrap_class 	= [],
	classes 	= [],
	color_scheme = '',
	wrp_class 	= [],
	style 		= 'h-style-3',
	size		= 'h1',
	back_layer_title = 'Back layer Title',
	back_layer_parallax = 40,
	align 		= 'left',
	atts 		= ( data.atts !== undefined ) ? data.atts : {},
	title		= ( atts['title'] !== undefined )? kc.tools.base64.decode( atts['title'] ) : '',
	post_title	= ( atts['post_title'] !== undefined )? atts['post_title'] : 'no',


wrap_class  = kc.front.el_class( atts );
wrap_class.push( 'kc-fancy-title-wrap' );
wrap_class.push( 'kc-fancy-title' );


if( atts['color_scheme'] !== undefined && atts['color_scheme'] !== '' ) {
	color_scheme = atts['color_scheme'];
}

if( atts['style'] !== undefined && atts['style'] !== '' ) {
	style = atts['style'];

	switch (style) {
		case 'style1':
			style = 'h-style-1';
			break;
		case 'style2':
			style = 'h-style-2';
			break;
		case 'style3':
			style = 'h-style-4';
			break;
		case 'style4':
			style = 'h-style-5';
			break;
	}
}

if( atts['back_layer_title'] !== undefined && atts['back_layer_title'] !== '' )
	back_layer_title = atts['back_layer_title'];

if( atts['size'] !== undefined && atts['size'] !== '' )
	size = atts['size'];

if( atts['back_layer_parallax'] !== undefined && atts['back_layer_parallax'] !== '' )
	back_layer_parallax = atts['back_layer_parallax'];

if( atts['align'] !== undefined && atts['align'] !== '' )
	align = atts['align'];
	
if ( post_title === 'yes')
	title = kc_post_title;



#>
<div class="{{{wrap_class.join(' ')}}}">
	<div class="kc-inner-wrap {{{classes.join(' ')}}} {{{color_scheme}}}-scheme-el">
		<div class="kc-fancy-title-block on-{{{align}}}">
		<{{{size}}} class="kc-h-style {{{style}}}">{{{title}}}</{{{size}}}>
		<# if ( atts['style'] === 'style4' && atts['back_layer_title'] !== '' ) { #>
			<h6 class="h-style-5-back" data-parallax='{"y": {{{atts['back_layer_parallax']}}} }'>{{{atts['back_layer_title']}}}</h6>
		<# } #>
		</div>
	</div>
</div>
