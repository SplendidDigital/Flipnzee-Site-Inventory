<?php
/**
 * Shortcodes.
 *
 * Registers frontend shortcodes and retrieves Website Inventory data.
 *
 * Responsibilities:
 * - Register shortcodes
 * - Obtain local inventory
 * - Obtain remote inventory
 * - Validate URLs
 * - Fetch remote REST data
 * - Cache remote responses
 * - Handle errors
 * - Invoke renderer
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Website Inventory Shortcodes.
 */
class Flipnzee_Site_Inventory_Shortcodes {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_shortcode(
			'flipnzee_site_inventory',
			array( $this, 'local_shortcode' )
		);

		add_shortcode(
			'flipnzee_remote_inventory',
			array( $this, 'remote_shortcode' )
		);

		add_shortcode(
    'flipnzee_portfolio_inventory',
    array( $this, 'portfolio_shortcode' )
);
	}

	/**
	 * Local inventory shortcode.
	 *
	 * Usage:
	 *
	 * [flipnzee_site_inventory]
	 *
	 * @return string
	 */
	public function local_shortcode() {

		if ( ! class_exists( 'Flipnzee_Site_Inventory' ) ) {
			return $this->notice(
				__( 'Website Inventory is unavailable.', 'flipnzee-site-inventory' )
			);
		}

		$inventory = new Flipnzee_Site_Inventory();

		$data = $inventory->get_inventory();

		return $this->render_inventory( $data );
	}

	/**
	 * Remote inventory shortcode.
	 *
	 * Usage:
	 *
	 * [flipnzee_remote_inventory url="https://example.com"]
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string
	 */
	public function remote_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'url' => '',
			),
			$atts,
			'flipnzee_remote_inventory'
		);

		$url = trim( $atts['url'] );

		if ( empty( $url ) ) {
			return $this->notice(
				__( 'Please provide a website URL.', 'flipnzee-site-inventory' )
			);
		}

		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return $this->notice(
				__( 'Invalid website URL.', 'flipnzee-site-inventory' )
			);
		}

		$data = $this->get_remote_inventory( $url );

		if ( is_wp_error( $data ) ) {
			return $this->notice( $data->get_error_message() );
		}

		return $this->render_inventory( $data );
	}

	/**
	 * Fetch remote inventory.
	 *
	 * Uses transient caching for 12 hours.
	 *
	 * @param string $url Site URL.
	 *
	 * @return array|WP_Error
	 */
	private function get_remote_inventory( $url ) {

		$url = untrailingslashit( esc_url_raw( $url ) );

		$cache_key = 'flipnzee_inventory_' . md5( $url );

		$cached = get_transient( $cache_key );

		if ( false !== $cached ) {
			return $cached;
		}

		$endpoint = $url . '/wp-json/flipnzee/v1/inventory';

		$response = wp_remote_get(
			$endpoint,
			array(
				'timeout'     => 15,
				'redirection' => 3,
				'user-agent'  => 'Flipnzee Site Inventory',
			)
		);

		if ( is_wp_error( $response ) ) {

			return new WP_Error(
				'fsi_connection_failed',
				__( 'Unable to connect to the remote website.', 'flipnzee-site-inventory' )
			);
		}

		$status = wp_remote_retrieve_response_code( $response );

		if ( 200 !== $status ) {

			return new WP_Error(
				'fsi_http_error',
				sprintf(
					/* translators: %d HTTP response code */
					__( 'Remote server returned HTTP %d.', 'flipnzee-site-inventory' ),
					intval( $status )
				)
			);
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {

			return new WP_Error(
				'fsi_empty_response',
				__( 'The remote server returned an empty response.', 'flipnzee-site-inventory' )
			);
		}

		$data = json_decode( $body, true );

		if ( JSON_ERROR_NONE !== json_last_error() ) {

			return new WP_Error(
				'fsi_invalid_json',
				__( 'The remote server returned invalid JSON.', 'flipnzee-site-inventory' )
			);
		}

		if ( ! is_array( $data ) ) {

			return new WP_Error(
				'fsi_invalid_inventory',
				__( 'The Website Inventory endpoint returned unexpected data.', 'flipnzee-site-inventory' )
			);
		}

		$required = array(
			'site',
			'content',
			'environment',
			'activity',
		);

		foreach ( $required as $section ) {

			if ( ! array_key_exists( $section, $data ) ) {

				return new WP_Error(
					'fsi_missing_section',
					sprintf(
						/* translators: %s section name */
						__( 'Missing inventory section: %s.', 'flipnzee-site-inventory' ),
						esc_html( $section )
					)
				);
			}
		}

		set_transient(
			$cache_key,
			$data,
			12 * HOUR_IN_SECONDS
		);

		return $data;
	}

	/**
 * Portfolio inventory shortcode.
 *
 * Usage:
 *
 * [flipnzee_portfolio_inventory]
 *
 * @return string
 */
public function portfolio_shortcode() {

	if ( ! class_exists( 'Flipnzee_Cumulative_Provider' ) ) {

		return $this->notice(
			__( 'Portfolio provider is unavailable.', 'flipnzee-site-inventory' )
		);

	}

	if ( ! class_exists( 'Flipnzee_Cumulative_Renderer' ) ) {

		return $this->notice(
			__( 'Portfolio renderer is unavailable.', 'flipnzee-site-inventory' )
		);

	}

	$provider = new Flipnzee_Cumulative_Provider();

$dashboard = $provider->get_data();

$renderer = new Flipnzee_Cumulative_Renderer();

return $renderer->render( $dashboard );
}

	/**
	 * Render inventory.
	 *
	 * @param array $inventory Inventory array.
	 *
	 * @return string
	 */
	private function render_inventory( array $inventory ) {

		if ( ! class_exists( 'Flipnzee_Site_Inventory_Renderer' ) ) {

			return $this->notice(
				__( 'Renderer could not be loaded.', 'flipnzee-site-inventory' )
			);
		}

		$renderer = new Flipnzee_Site_Inventory_Renderer(
			$inventory
		);

		return $renderer->render();
	}

	/**
	 * Render frontend notice.
	 *
	 * @param string $message Notice text.
	 *
	 * @return string
	 */
	private function notice( $message ) {

		ob_start();
		?>

		<div class="flipnzee-site-inventory-notice">

			<?php echo esc_html( $message ); ?>

		</div>

		<?php

		return ob_get_clean();
	}
}