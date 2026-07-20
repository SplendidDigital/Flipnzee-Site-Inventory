<?php
/**
 * Portfolio Dashboard Renderer.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cumulative Renderer.
 */
class Flipnzee_Cumulative_Renderer {

	/**
	 * Render dashboard.
	 *
	 * @param array $dashboard Dashboard data.
	 *
	 * @return string
	 */
	public function render( $dashboard ) {

		$totals = isset( $dashboard['totals'] ) ? $dashboard['totals'] : array();
		$sites  = isset( $dashboard['sites'] ) ? $dashboard['sites'] : array();

		ob_start();
		?>

		<div class="fsi-portfolio">

			<?php if ( is_admin() ) : ?>

    <?php if ( is_admin() ) : ?>

	<h1>Portfolio Inventory Dashboard</h1>

	<p>
		Cumulative inventory across all connected WordPress websites.
	</p>

<?php else : ?>

	<div class="fsi-hero">

		<div class="fsi-hero-content">

			<h2>WordPress Portfolio Inventory</h2>

			<p class="fsi-description">
				Live inventory statistics collected from all connected WordPress websites.
			</p>

		</div>

	</div>

<?php endif; ?>

<?php else : ?>

    <div class="fsi-hero">

        <h2>WordPress Portfolio Inventory</h2>

        <p>
            Live inventory statistics collected from all connected WordPress websites.
        </p>

    </div>

<?php endif; ?>

			<div class="fsi-summary-grid">

				<?php
				$this->summary_card(
					'Connected Sites',
					$totals['sites'] ?? 0
				);

				$this->summary_card(
					'Online',
					$totals['online'] ?? 0
				);

				$this->summary_card(
					'Offline',
					$totals['offline'] ?? 0
				);

				$this->summary_card(
					'Posts',
					number_format_i18n( $totals['posts'] ?? 0 )
				);

				$this->summary_card(
					'Pages',
					number_format_i18n( $totals['pages'] ?? 0 )
				);

				$this->summary_card(
					'Media',
					number_format_i18n( $totals['media'] ?? 0 )
				);

				$this->summary_card(
					'Categories',
					number_format_i18n( $totals['categories'] ?? 0 )
				);

				$this->summary_card(
					'Users',
					number_format_i18n( $totals['users'] ?? 0 )
				);
				?>

			</div>

			<div class="fsi-table-wrapper">

				<table class="fsi-portfolio-table">

					<thead>

						<tr>

							<th>Website</th>
							<th>Status</th>
							<th>WP</th>
							<th>PHP</th>
							<th>Posts</th>
							<th>Pages</th>
							<th>Media</th>
							<th>Users</th>
							<th>Theme</th>
							<th>Last Published</th>

						</tr>

					</thead>

					<tbody>

						<?php if ( empty( $sites ) ) : ?>

							<tr>

								<td colspan="10">

									No portfolio websites configured.

								</td>

							</tr>

						<?php else : ?>

							<?php foreach ( $sites as $site ) : ?>

								<tr>

									<td>

										<strong>

											<a
												href="<?php echo esc_url( $site['url'] ?? '#' ); ?>"
												target="_blank"
												rel="noopener noreferrer">

												<?php echo esc_html( $site['name'] ?? '-' ); ?>

											</a>

										</strong>

									</td>

									<td>

										<?php
										if ( ( $site['status'] ?? '' ) === 'online' ) {
											echo '<span style="color:green;font-weight:bold;">Online</span>';
										} else {
											echo '<span style="color:red;font-weight:bold;">Offline</span>';
										}
										?>

									</td>

									<td><?php echo esc_html( $site['wordpress'] ?? '-' ); ?></td>

									<td><?php echo esc_html( $site['php'] ?? '-' ); ?></td>

									<td><?php echo esc_html( $site['posts'] ?? 0 ); ?></td>

									<td><?php echo esc_html( $site['pages'] ?? 0 ); ?></td>

									<td><?php echo esc_html( $site['media'] ?? 0 ); ?></td>

									<td><?php echo esc_html( $site['users'] ?? 0 ); ?></td>

									<td><?php echo esc_html( $site['theme'] ?? '-' ); ?></td>
									<td>

										<?php
										if ( ! empty( $site['last_published'] ) ) {

											echo esc_html(
												date_i18n(
													get_option( 'date_format' ),
													strtotime( $site['last_published'] )
												)
											);

										} else {

											echo '&mdash;';

										}
										?>

									</td>

								</tr>

							<?php endforeach; ?>

						<?php endif; ?>

					</tbody>

				</table>

			</div>

		</div>

		<?php

		return ob_get_clean();

	}

	/**
	 * Render summary card.
	 *
	 * @param string $label Card label.
	 * @param mixed  $value Card value.
	 *
	 * @return void
	 */
	private function summary_card( $label, $value ) {
		?>

		<div class="fsi-summary-card">

			<div class="fsi-summary-number">

				<?php echo esc_html( $value ); ?>

			</div>

			<div class="fsi-summary-label">

				<?php echo esc_html( $label ); ?>

			</div>

		</div>

		<?php
	}

}