<?php
/*
 * TED Player embed code from Jetpack 2.8. Credit goes to Jetpack authors.
 * http://www.ted.com
 *
 * http://www.ted.com/talks/view/id/210
 * http://www.ted.com/talks/marc_goodman_a_vision_of_crimes_in_the_future.html
 * [ted id="210" lang="eng"]
 * [ted id="http://www.ted.com/talks/view/id/210" lang="eng"]
 * [ted id=1539 lang=fr width=560 height=315]
 */

wp_oembed_add_provider( '!https?://(www\.)?ted.com/talks/view/id/.+!i', 'http://www.ted.com/talks/oembed.json', true );
wp_oembed_add_provider( '!https?://(www\.)?ted.com/talks/[a-zA-Z\-\_]+\.html!i', 'http://www.ted.com/talks/oembed.json', true );

function tte_jetpack_shortcode_get_ted_id( $atts ) {
	return ( ! empty( $atts['id'] ) ? $atts['id'] : 0 );
}

add_shortcode( 'ted', 'tte_shortcode_ted' );
function tte_shortcode_ted( $atts, $content = '' ) {
	global $wp_embed;

	$options = get_option( 'tte_settings' ); // Gets TEDTalks Embedder settings if any

	$defaults = array(
			'id'          => '',
			'width'       => $options['tte_width'],
			'height'      => $options['tte_height'],
			'lang'        => $options['tte_lang'],
		);
	$atts = shortcode_atts( $defaults, $atts );

	if ( empty( $atts['id'] ) )
		return '<!-- Missing TED ID -->';

	if ( preg_match( "#^[\d]+$#", $atts['id'], $matches ) )
		$url = 'http://ted.com/talks/view/id/' . $matches[0];
	elseif ( preg_match( "#^https?://(www\.)?ted\.com/talks/view/id/[0-9]+$#", $atts['id'], $matches ) )
		$url = $matches[0];

	unset( $atts['id'] );

	$args = array();
	if ( is_numeric( $atts['width'] ) )
		$args['width'] = $atts['width'];
	else if ( $embed_size_w = get_option( 'embed_size_w' ) )
		$args['width'] = $embed_size_w;
	else if ( ! empty( $GLOBALS['content_width'] ) )
		$args['width'] = (int)$GLOBALS['content_width'];
	else
		$args['width'] = 500;

	// Default to a 16x9 aspect ratio if there's no height set
	if ( is_numeric( $atts['height'] ) )
		$args['height'] = $atts['height'];
	else
		$args['height'] = $args['width'] * 0.5625;

	if ( ! empty( $atts['lang'] ) ) {
		$args['lang'] = sanitize_key( $atts['lang'] );
		add_filter( 'oembed_fetch_url', 'tte_ted_filter_oembed_fetch_url', 10, 3 );
	}
	$retval = $wp_embed->shortcode( $args, $url );
	remove_filter( 'oembed_fetch_url', 'tte_ted_filter_oembed_fetch_url', 10 );
	return $retval;
}

/**
 * Filter the request URL to also include the $lang parameter
 */
function tte_ted_filter_oembed_fetch_url( $provider, $url, $args ) {
	return add_query_arg( 'lang', $args['lang'], $provider );
}