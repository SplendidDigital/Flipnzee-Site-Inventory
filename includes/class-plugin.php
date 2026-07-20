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
	/**
 * Load plugin dependencies.
 *
 * @return void
 */
private function load_dependencies() {

	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-rest-controller.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-inventory.php';

	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-site-provider.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-content-provider.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-environment-provider.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-activity-provider.php';

	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-cumulative-provider.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-cumulative-renderer.php';

	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-renderer.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-admin.php';
	require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-shortcodes.php';
}
	/**
	 * Register WordPress hooks.
	 *
	 * @return void
	 */
	/**
 * Register WordPress hooks.
 *
 * @return void
 */
private function register_hooks() {

	/*
	 * Register REST API routes.
	 */
	
	$rest_controller = new Flipnzee_Site_Inventory_REST_Controller();

	add_action(
		'rest_api_init',
		array(
			$rest_controller,
			'register_routes',
		)
	);

	/*
	 * Register frontend shortcodes.
	 */
	new Flipnzee_Site_Inventory_Shortcodes();

	new Flipnzee_Admin();

	/*
	 * Load frontend stylesheet.
	 */
	add_action(
		'wp_enqueue_scripts',
		array( $this, 'enqueue_assets' )
	);
}

/**
 * Enqueue frontend assets.
 *
 * @return void
 */
public function enqueue_assets() {

	wp_enqueue_style(
		'flipnzee-site-inventory',
		FLIPNZEE_SITE_INVENTORY_URL . 'assets/css/frontend.css',
		array(),
		FLIPNZEE_SITE_INVENTORY_VERSION
	);
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