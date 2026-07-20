<?php
/**
 * Content Provider.
 *
 * Provides WordPress content inventory.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content Provider class.
 */
class Flipnzee_Content_Provider {

	/**
	 * Return content inventory.
	 *
	 * @return array
	 */
	/**
 * Return content inventory.
 *
 * @return array
 */
public function get_data() {

	$post_counts       = wp_count_posts( 'post' );
	$page_counts       = wp_count_posts( 'page' );
	$attachment_counts = wp_count_posts( 'attachment' );

	$categories = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
			'fields'     => 'ids',
		)
	);

	$tags = get_terms(
		array(
			'taxonomy'   => 'post_tag',
			'hide_empty' => false,
			'fields'     => 'ids',
		)
	);

	return array(
		'published_posts' => isset( $post_counts->publish ) ? (int) $post_counts->publish : 0,
		'draft_posts'     => isset( $post_counts->draft ) ? (int) $post_counts->draft : 0,
		'pages'           => isset( $page_counts->publish ) ? (int) $page_counts->publish : 0,
		'categories'      => is_array( $categories ) ? count( $categories ) : 0,
		'tags'            => is_array( $tags ) ? count( $tags ) : 0,
		'media'           => isset( $attachment_counts->inherit ) ? (int) $attachment_counts->inherit : 0,
		'users'           => $this->get_user_statistics(),
	);
}
	/**
	 * Return user statistics.
	 *
	 * @return array
	 */
	private function get_user_statistics() {

		$counts = count_users();

		return array(
			'total' => $counts['total_users'],
			'roles' => $counts['avail_roles'],
		);
	}
}