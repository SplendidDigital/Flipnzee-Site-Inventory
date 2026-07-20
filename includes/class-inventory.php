<?php
/**
 * Inventory class.
 *
 * Responsible for assembling the complete site inventory.
 *
 * @package FlipnzeeSiteInventory
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inventory class.
 */
class Flipnzee_Site_Inventory {

	/**
	 * Return the complete inventory.
	 *
	 * @return array
	 */
	public function get_inventory() {

		return array(
			'site'        => $this->get_site_data(),
			'content'     => $this->get_content_data(),
			'environment' => $this->get_environment_data(),
			'activity'    => $this->get_activity_data(),
		);
	}

	/**
	 * Return site information.
	 *
	 * Placeholder for Version 1 development.
	 *
	 * @return array
	 */
	private function get_site_data() {

	$provider = new Flipnzee_Site_Provider();

	return $provider->get_data();
}

	/**
	 * Return content inventory.
	 *
	 * Placeholder for Version 1 development.
	 *
	 * @return array
	 */
	private function get_content_data() {

	$provider = new Flipnzee_Content_Provider();

	return $provider->get_data();
}

	/**
	 * Return environment information.
	 *
	 * Placeholder for Version 1 development.
	 *
	 * @return array
	 */
	private function get_environment_data() {

	$provider = new Flipnzee_Environment_Provider();

	return $provider->get_data();
}

	/**
	 * Return publishing activity.
	 *
	 * Placeholder for Version 1 development.
	 *
	 * @return array
	 */
	private function get_activity_data() {

	$provider = new Flipnzee_Activity_Provider();

	return $provider->get_data();
}
}