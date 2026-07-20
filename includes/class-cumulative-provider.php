<?php
/**
 * Cumulative Inventory Provider.
 *
 * Collects inventory from multiple WordPress sites.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cumulative Provider class.
 */
class Flipnzee_Cumulative_Provider {

	/**
	 * Get cumulative inventory data.
	 *
	 * @return array
	 */
	public function get_data() {

		$sites_option = trim(
			get_option(
				'flipnzee_portfolio_sites',
				''
			)
		);

		$totals = array(
			'sites'      => 0,
			'online'     => 0,
			'offline'    => 0,
			'posts'      => 0,
			'pages'      => 0,
			'media'      => 0,
			'categories' => 0,
			'users'      => 0,
		);

		$sites = array();

		if ( empty( $sites_option ) ) {

			return array(
				'totals' => $totals,
				'sites'  => array(),
			);

		}

		$lines = preg_split(
			'/\r\n|\r|\n/',
			$sites_option
		);

		foreach ( $lines as $url ) {

			$url = trim( $url );

			if ( empty( $url ) ) {
				continue;
			}

			$totals['sites']++;

			$request = wp_remote_get(
				untrailingslashit( $url ) . '/wp-json/flipnzee/v1/inventory',
				array(
					'timeout' => 20,
				)
			);

			if ( is_wp_error( $request ) ) {

				$totals['offline']++;

				$sites[] = array(
					'name'            => parse_url( $url, PHP_URL_HOST ),
					'url'             => $url,
					'status'          => 'offline',
					'wordpress'       => '',
					'php'             => '',
					'posts'           => 0,
					'pages'           => 0,
					'media'           => 0,
					'users'           => 0,
					'categories'      => 0,
					'theme'           => '',
					'last_published'  => '',
				);

				continue;
			}

			$data = json_decode(
				wp_remote_retrieve_body( $request ),
				true
			);

			if ( empty( $data ) || ! is_array( $data ) ) {

				$totals['offline']++;

				continue;

			}

			$content = $data['content'] ?? array();
			$site    = $data['site'] ?? array();
			$env     = $data['environment'] ?? array();
			$activity = $data['activity'] ?? array();

			$posts      = (int) ( $content['published_posts'] ?? 0 );
			$pages      = (int) ( $content['pages'] ?? 0 );
			$media      = (int) ( $content['media'] ?? 0 );
			$categories = (int) ( $content['categories'] ?? 0 );

			/*
			 * New REST structure:
			 *
			 * users => array(
			 *     total => 2,
			 *     roles => ...
			 * )
			 */
			$users = 0;

			if ( isset( $content['users']['total'] ) ) {

				$users = (int) $content['users']['total'];

			} elseif ( isset( $content['users'] ) && is_numeric( $content['users'] ) ) {

				// Backward compatibility.
				$users = (int) $content['users'];

			}

			$totals['online']++;
			$totals['posts']      += $posts;
			$totals['pages']      += $pages;
			$totals['media']      += $media;
			$totals['categories'] += $categories;
			$totals['users']      += $users;

			$sites[] = array(
				'name'           => $site['name'] ?? parse_url( $url, PHP_URL_HOST ),
				'url'            => $site['site_url'] ?? $url,
				'status'         => 'online',
				'wordpress'      => $env['wordpress_version'] ?? '',
				'php'            => $env['php_version'] ?? '',
				'posts'          => $posts,
				'pages'          => $pages,
				'media'          => $media,
				'categories'     => $categories,
				'users'          => $users,
				'theme'          => $env['theme'] ?? '',
				'last_published' => $activity['last_published'] ?? '',
			);

		}

		return array(
			'totals' => $totals,
			'sites'  => $sites,
		);

	}

}