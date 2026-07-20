<?php
/**
 * Plugin Name:       Flipnzee Site Inventory
 * Plugin URI:        https://github.com/SplendidDigital/Flipnzee-Site-Inventory
 * Description:       Exposes WordPress site metadata and content inventory through a standardized REST API.
 * Version:           1.2.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Splendid Digital Solutions
 * Author URI:        https://displendid.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       flipnzee-site-inventory
 * Domain Path:       /languages
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin version.
 */
define( 'FLIPNZEE_SITE_INVENTORY_VERSION', '1.2.0' );

/**
 * Plugin directory path.
 */
define( 'FLIPNZEE_SITE_INVENTORY_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin directory URL.
 */
define( 'FLIPNZEE_SITE_INVENTORY_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin basename.
 */
define( 'FLIPNZEE_SITE_INVENTORY_BASENAME', plugin_basename( __FILE__ ) );

/*
|--------------------------------------------------------------------------
| Load Core Plugin
|--------------------------------------------------------------------------
*/

require_once FLIPNZEE_SITE_INVENTORY_PATH . 'includes/class-plugin.php';

/*
|--------------------------------------------------------------------------
| Run Plugin
|--------------------------------------------------------------------------
*/

$flipnzee_site_inventory = new Flipnzee_Site_Inventory_Plugin();
$flipnzee_site_inventory->run();