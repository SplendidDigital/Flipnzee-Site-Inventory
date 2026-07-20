<?php
/**
 * REST API Controller.
 *
 * Registers and handles the Flipnzee Site Inventory REST API endpoints.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * REST API Controller class.
 */
class Flipnzee_Site_Inventory_REST_Controller {

	/**
	 * REST namespace.
	 *
	 * @var string
	 */
	const NAMESPACE = 'flipnzee/v1';

	/**
	 * Register REST routes.
	 *
	 * @return void
	 */
	public function register_routes() {

		register_rest_route(
			self::NAMESPACE,
			'/inventory',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_inventory' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Return the site inventory.
	 *
	 * Placeholder response for Version 1 development.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return WP_REST_Response
	 */
	/**
 * Return the site inventory.
 *
 * @param WP_REST_Request $request REST request.
 * @return WP_REST_Response
 */
public function get_inventory( WP_REST_Request $request ) {

	$inventory = new Flipnzee_Site_Inventory();

	return new WP_REST_Response(
		$inventory->get_inventory(),
		200
	);
}
}