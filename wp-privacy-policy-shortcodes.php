<?php
/*
Plugin Name: WP Privacy Policy Shortcodes
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Privacy_Policy_Shortcodes {

	public static function add_shortcodes() {

		$shortcodes = array(
			'privacy-what-personal-data-collected',
			'privacy-why-personal-data-collected',
			'privacy-sharing-personal-data',
			'privacy-storing-personal-data',
			'privacy-retaining-personal-data',
			'privacy-user-options-personal-data',
			'privacy-user-managing-personal-data',
		);

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( 'WP_Privacy_Policy_Shortcodes', 'do_shortcode' ) );
		}

	}

	public static function do_shortcode( $atts, $content, $name ) {
		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);

		$response = '';

		// First, get hooked contributors to provide their piece for the shortcode we're processing
		// TODO - allow contributors to pass up more complex objects, with things like modified_gmt

		$snippets = apply_filters( 'privacy_policy_section', array(), $name );

		// If we got nothing, return nothing
		if ( empty( $snippets ) ) {
			return $response;
		}

		// Otherwise, UL/LI the lot
		$response .= '<ul>';

		foreach ( $snippets as $snippet ) {
			$response .= '<li>';
			$response .= wp_kses( $snippet, $allowed_html );
			$response .= '</li>';
		}

		$response .= '</ul>';

		return $response;
	}

}

WP_Privacy_Policy_Shortcodes::add_shortcodes();
