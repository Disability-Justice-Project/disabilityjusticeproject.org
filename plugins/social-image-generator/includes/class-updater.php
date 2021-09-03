<?php

namespace Social_Image_Generator;

class Updater {
	/**
	 * @var string
	 */
	public $updates_url = 'https://socialimagegenerator.com/';

	/**
	 * @var string|false
	 */
	public $license_key;

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init_update_checker' ] );
	}

	public function get_valid_license_key() {
		$license_key = get_option( Admin::OPTION_KEY_LICENSE_KEY );
		$is_valid    = get_option( Admin::OPTION_KEY_LICENSE_KEY_VALID );

		return ( ! empty( $license_key ) && ! empty( $is_valid ) ) ? $license_key : false;
	}

	public function get_updates_url() {
		return add_query_arg(
			[
				'update_action' => 'get_metadata',
				'update_slug'   => SOCIAL_IMAGE_GENERATOR_SLUG,
				'license_key'   => $this->license_key,
			],
			$this->updates_url
		);
	}

	public function init_update_checker() {
		$this->license_key = $this->get_valid_license_key();

		if ( empty( $this->license_key ) ) {
			return;
		}

		\Puc_v4_Factory::buildUpdateChecker(
			$this->get_updates_url(),
			SOCIAL_IMAGE_GENERATOR_PATH . SOCIAL_IMAGE_GENERATOR_SLUG . '.php',
			SOCIAL_IMAGE_GENERATOR_SLUG
		);
	}
}
