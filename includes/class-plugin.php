<?php
/**
 * Main plugin class.
 *
 * Responsible for initializing the plugin and loading all core components.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class Flipnzee_Site_Inventory_Plugin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Constructor intentionally left empty.
	}

	/**
	 * Run the plugin.
	 *
	 * Loads all required components and hooks.
	 *
	 * @return void
	 */
	public function run() {

		$this->load_textdomain();
		$this->load_dependencies();
		$this->register_hooks();
	}

	/**
	 * Load plugin dependencies.
	 *
	 * @return void
	 */
	private function load_dependencies() {

		// Future classes will be loaded here.
		//
		// Example:
		// require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-rest-controller.php';
	}

	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	private function register_hooks() {

		// Future hooks will be registered here.
	}

	/**
	 * Load plugin translations.
	 *
	 * @return void
	 */
	private function load_textdomain() {

		load_plugin_textdomain(
			'flipnzee-site-inventory',
			false,
			dirname( FLIPNZEE_SITE_INVENTORY_BASENAME ) . '/languages'
		);
	}
}