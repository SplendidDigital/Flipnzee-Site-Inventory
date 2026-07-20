<?php
/**
 * Site Provider.
 *
 * Provides general WordPress site information.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Site Provider class.
 */
class Flipnzee_Site_Provider {

	/**
	 * Return site information.
	 *
	 * @return array
	 */
	public function get_data() {

		return array(
	'name'            => get_bloginfo( 'name' ),
	'site_url'        => get_site_url(),
	'home_url'        => home_url(),
	'description'     => get_bloginfo( 'description' ),
	'language'        => get_bloginfo( 'language' ),
	'timezone'        => wp_timezone_string(),
	'charset'         => get_bloginfo( 'charset' ),
	'plugin_version'  => FLIPNZEE_SITE_INVENTORY_VERSION,
);
	}
}