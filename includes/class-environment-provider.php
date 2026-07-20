<?php
/**
 * Environment Provider.
 *
 * Provides WordPress environment information.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Environment Provider class.
 */
class Flipnzee_Environment_Provider {


	/**
 * Return environment information.
 *
 * @return array
 */


public function get_data() {

	$theme = wp_get_theme();

	$home_url = home_url();

	$ssl = (
		'https' === wp_parse_url(
			$home_url,
			PHP_URL_SCHEME
		)
	);

	$rest_api = rest_url();

	$data = array(

		'wordpress_version' => get_bloginfo( 'version' ),

		'php_version'       => PHP_VERSION,

		'theme'             => $theme->get( 'Name' ),

		'theme_version'     => $theme->get( 'Version' ),

		'multisite'         => is_multisite(),

		'ssl'               => $ssl,

		'rest_api'          => ! empty( $rest_api ),

	);

	error_log(
		'FLIPNZEE ENVIRONMENT: ' . print_r( $data, true )
	);

	return $data;
}
}