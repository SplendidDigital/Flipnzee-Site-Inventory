<?php
/**
 * Activity Provider.
 *
 * Provides publishing activity.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Activity Provider class.
 */
class Flipnzee_Activity_Provider {

	/**
	 * Return publishing activity.
	 *
	 * @return array
	 */
	public function get_data() {

		$latest_post = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		$latest_modified = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'modified',
				'order'          => 'DESC',
			)
		);

		return array(
			'last_published' => ! empty( $latest_post )
				? get_the_date( DATE_ATOM, $latest_post[0] )
				: null,

			'last_modified'  => ! empty( $latest_modified )
				? get_the_modified_date( DATE_ATOM, $latest_modified[0] )
				: null,
		);
	}
}