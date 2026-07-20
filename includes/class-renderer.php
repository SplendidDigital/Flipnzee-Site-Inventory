<?php
/**
 * Inventory Renderer.
 *
 * Responsible for rendering Website Inventory data into HTML.
 *
 * This class never collects data itself. It only receives an inventory
 * array and converts it into a frontend representation.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Website Inventory Renderer.
 */
class Flipnzee_Site_Inventory_Renderer {

	/**
	 * Inventory data.
	 *
	 * @var array
	 */
	private $inventory = array();

	/**
	 * Constructor.
	 *
	 * @param array $inventory Inventory array.
	 */
	public function __construct( array $inventory ) {
		$this->inventory = $inventory;
	}

	/**
	 * Render complete inventory.
	 *
	 * @return string
	 */
	/**
 * Render complete inventory.
 *
 * @return string
 */
public function render() {

	ob_start();

	?>

	<div class="flipnzee-site-inventory">

		<?php
		echo $this->render_header(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<div class="fsi-grid">

			<?php
			echo $this->render_general(); // phpcs:ignore
			echo $this->render_content(); // phpcs:ignore
			echo $this->render_environment(); // phpcs:ignore
			echo $this->render_activity(); // phpcs:ignore
			?>

		</div>

		<?php
		echo $this->render_footer(); // phpcs:ignore
		?>

	</div>

	<?php

	return ob_get_clean();
}
	/**
	 * Render header.
	 *
	 * @return string
	 */
	/**
 * Render header.
 *
 * @return string
 */
private function render_header() {

	$site = $this->get_section( 'site' );

	$name = $this->value( $site, 'name' );
	$url  = $this->value( $site, 'site_url' );
	$desc = $this->value( $site, 'description' );

	ob_start();

	?>

	<header class="fsi-hero">

		<div class="fsi-hero-icon">
			🌐
		</div>

		<div class="fsi-hero-content">

			<h1>

				<?php
				echo esc_html(
					$name
						? $name
						: __( 'Website Profile', 'flipnzee-site-inventory' )
				);
				?>

			</h1>

			<?php if ( ! empty( $url ) ) : ?>

				<p class="fsi-url">

					<a
						href="<?php echo esc_url( $url ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>

						<?php echo esc_html( $url ); ?>

					</a>

				</p>

			<?php endif; ?>

			<?php if ( ! empty( $desc ) ) : ?>

				<div class="fsi-description">

					<?php echo esc_html( $desc ); ?>

				</div>

			<?php endif; ?>

		</div>

	</header>

	<?php

	return ob_get_clean();
}
	/**
	 * Render general information.
	 *
	 * @return string
	 */
	private function render_general() {

		$site = $this->get_section( 'site' );

		return $this->render_table(
			__( 'General', 'flipnzee-site-inventory' ),
			array(
				__( 'Description', 'flipnzee-site-inventory' ) => $this->value( $site, 'description' ),
				__( 'Language', 'flipnzee-site-inventory' )    => $this->value( $site, 'language' ),
				__( 'Timezone', 'flipnzee-site-inventory' )    => $this->value( $site, 'timezone' ),
				__( 'Home URL', 'flipnzee-site-inventory' )    => $this->value( $site, 'home_url' ),
			)
		);
	}

	/**
	 * Render content information.
	 *
	 * @return string
	 */
	private function render_content() {

		$content = $this->get_section( 'content' );
		$users   = isset( $content['users'] ) && is_array( $content['users'] )
			? $content['users']
			: array();

		return $this->render_table(
			__( 'Content', 'flipnzee-site-inventory' ),
			array(
				__( 'Published Posts', 'flipnzee-site-inventory' ) => $this->value( $content, 'published_posts' ),
				__( 'Draft Posts', 'flipnzee-site-inventory' )     => $this->value( $content, 'draft_posts' ),
				__( 'Pages', 'flipnzee-site-inventory' )           => $this->value( $content, 'pages' ),
				__( 'Categories', 'flipnzee-site-inventory' )      => $this->value( $content, 'categories' ),
				__( 'Tags', 'flipnzee-site-inventory' )            => $this->value( $content, 'tags' ),
				__( 'Media', 'flipnzee-site-inventory' )           => $this->value( $content, 'media' ),
				__( 'Users', 'flipnzee-site-inventory' )           => $this->value( $users, 'total' ),
			)
		);
	}

	/**
	 * Render environment.
	 *
	 * @return string
	 */
	private function render_environment() {

		$environment = $this->get_section( 'environment' );

		return $this->render_table(
			__( 'Environment', 'flipnzee-site-inventory' ),
			array(
				__( 'WordPress', 'flipnzee-site-inventory' ) => $this->value( $environment, 'wordpress_version' ),
				__( 'PHP', 'flipnzee-site-inventory' )       => $this->value( $environment, 'php_version' ),
				__( 'Theme', 'flipnzee-site-inventory' )     => $this->value( $environment, 'theme' ),
				__( 'Theme Version', 'flipnzee-site-inventory' ) => $this->value( $environment, 'theme_version' ),
				__( 'SSL', 'flipnzee-site-inventory' )       => $this->boolean_label( $this->value( $environment, 'ssl' ) ),
				__( 'REST API', 'flipnzee-site-inventory' )  => $this->boolean_label( $this->value( $environment, 'rest_api' ) ),
				__( 'Multisite', 'flipnzee-site-inventory' ) => $this->boolean_label( $this->value( $environment, 'multisite' ) ),
			)
		);
	}

	/**
	 * Render activity.
	 *
	 * @return string
	 */
	private function render_activity() {

		$activity = $this->get_section( 'activity' );

		return $this->render_table(
			__( 'Activity', 'flipnzee-site-inventory' ),
			array(
				__( 'Last Published', 'flipnzee-site-inventory' ) => $this->value( $activity, 'last_published' ),
				__( 'Last Modified', 'flipnzee-site-inventory' )  => $this->value( $activity, 'last_modified' ),
			)
		);
	}

	/**
	 * Render footer.
	 *
	 * @return string
	 */
	private function render_footer() {

		ob_start();
		?>

		<div class="fsi-card-footer">

			<?php
			printf(
				/* translators: %s: plugin version */
				esc_html__( 'Generated by Flipnzee Site Inventory %s', 'flipnzee-site-inventory' ),
				esc_html( FLIPNZEE_SITE_INVENTORY_VERSION )
			);
			?>

		</div>

		<?php

		return ob_get_clean();
	}

	/**
	 * Render section table.
	 *
	 * @param string $title Section title.
	 * @param array  $rows  Rows.
	 *
	 * @return string
	 */
	/**
 * Render section card.
 *
 * @param string $title Section title.
 * @param array  $rows  Section rows.
 *
 * @return string
 */
/**
 * Render section card.
 *
 * @param string $title Section title.
 * @param array  $rows  Section rows.
 *
 * @return string
 */
private function render_table( $title, array $rows ) {

	ob_start();
	?>

	<section class="fsi-card">

		<div class="fsi-card-title">

			<h3><?php echo esc_html( $title ); ?></h3>

		</div>

		<div class="fsi-card-body">

			<?php foreach ( $rows as $label => $value ) : ?>

				<div class="fsi-item">

					<div class="fsi-item-label">

						<?php echo esc_html( $label ); ?>

					</div>

					<div class="fsi-item-value">

						<?php
						if ( '' === (string) $value ) {

							echo esc_html__(
								'Unavailable',
								'flipnzee-site-inventory'
							);

						} else {

							echo esc_html( (string) $value );

						}
						?>

					</div>

				</div>

			<?php endforeach; ?>

		</div>

	</section>

	<?php

	return ob_get_clean();
}
	/**
	 * Return inventory section.
	 *
	 * @param string $section Section key.
	 *
	 * @return array
	 */
	private function get_section( $section ) {

		if ( isset( $this->inventory[ $section ] ) && is_array( $this->inventory[ $section ] ) ) {
			return $this->inventory[ $section ];
		}

		return array();
	}

	/**
	 * Safe value lookup.
	 *
	 * @param array  $array Array.
	 * @param string $key   Key.
	 *
	 * @return mixed
	 */
	private function value( array $array, $key ) {

		return isset( $array[ $key ] ) ? $array[ $key ] : '';
	}

	/**
	 * Convert boolean to label.
	 *
	 * @param mixed $value Value.
	 *
	 * @return string
	 */
	private function boolean_label( $value ) {

		return $value
			? __( 'Yes', 'flipnzee-site-inventory' )
			: __( 'No', 'flipnzee-site-inventory' );
	}
}