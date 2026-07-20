<?php
/**
 * Admin page.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Flipnzee_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action(
			'admin_menu',
			array( $this, 'register_menu' )
		);
	}

	/**
	 * Register admin menus.
	 */
	public function register_menu() {

		add_menu_page(
			__( 'Site Inventory', 'flipnzee-site-inventory' ),
			__( 'Site Inventory', 'flipnzee-site-inventory' ),
			'manage_options',
			'flipnzee-site-inventory',
			array( $this, 'render_page' ),
			'dashicons-networking',
			56
		);

		add_submenu_page(
			'flipnzee-site-inventory',
			__( 'Cumulative Inventory', 'flipnzee-site-inventory' ),
			__( 'Cumulative Inventory', 'flipnzee-site-inventory' ),
			'manage_options',
			'flipnzee-cumulative-inventory',
			array( $this, 'render_cumulative_page' )
		);
	}

	/**
	 * Render settings page.
	 */
	public function render_page() {

		if ( isset( $_POST['flipnzee_sites'] ) ) {

			check_admin_referer( 'flipnzee_inventory_save' );

			update_option(
				'flipnzee_portfolio_sites',
				wp_unslash( $_POST['flipnzee_sites'] )
			);
		}

		$sites = get_option(
			'flipnzee_portfolio_sites',
			''
		);
		echo '<pre>';
var_dump( get_option( 'flipnzee_portfolio_sites' ) );
echo '</pre>';

		?>

		<div class="wrap">

			<h1>Portfolio Sites</h1>

			<form method="post">

				<?php wp_nonce_field( 'flipnzee_inventory_save' ); ?>

				<p>One website per line.</p>

				<textarea
					name="flipnzee_sites"
					rows="15"
					style="width:700px;"><?php echo esc_textarea( $sites ); ?></textarea>

				<?php submit_button(); ?>

			</form>

			<hr>

			<p>

				<a
					class="button button-primary button-hero"
					href="<?php echo esc_url( admin_url( 'admin.php?page=flipnzee-cumulative-inventory' ) ); ?>">

					View Cumulative Inventory

				</a>

			</p>

		</div>

		<?php
	}

	/**
	 * Render cumulative inventory page.
	 */
	public function render_cumulative_page() {

		echo '<div class="wrap">';

		echo '<h1>Cumulative Inventory</h1>';

		$provider = new Flipnzee_Cumulative_Provider();

		$data = $provider->get_data();

		$renderer = new Flipnzee_Cumulative_Renderer();

		echo $renderer->render( $data );

		echo '</div>';
	}
}