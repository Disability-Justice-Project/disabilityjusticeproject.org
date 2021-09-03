<?php

namespace Social_Image_Generator;

use Social_Image_Generator\Cache;

class Setup {
	/**
	 * Set the main plugin slug.
	 *
	 * @var string
	 */
	public $slug = 'social-image-generator';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		$this->set_constants();
	}

	/**
	 * Get the version number of the plugin from the main file.
	 *
	 * @return string
	 */
	private function get_version_number() {
		$data = get_file_data(
			plugin_dir_path( __DIR__ ) . $this->slug . '.php',
			[ 'Version' => 'Version' ],
			false
		);

		return $data['Version'];
	}

	/**
	 * Set constants.
	 */
	private function set_constants() {
		define( 'SOCIAL_IMAGE_GENERATOR_VERSION', $this->get_version_number() );
		define( 'SOCIAL_IMAGE_GENERATOR_SLUG', $this->slug );
		define( 'SOCIAL_IMAGE_GENERATOR_API_BASE', SOCIAL_IMAGE_GENERATOR_SLUG . '/v1' );
		define( 'SOCIAL_IMAGE_GENERATOR_PATH', plugin_dir_path( __DIR__ ) );
		define( 'SOCIAL_IMAGE_GENERATOR_ASSETS_PATH', SOCIAL_IMAGE_GENERATOR_PATH . 'assets/' );
		define( 'SOCIAL_IMAGE_GENERATOR_IMG_PATH', SOCIAL_IMAGE_GENERATOR_PATH . 'assets/img/' );
		define( 'SOCIAL_IMAGE_GENERATOR_TEMPLATES_PATH', SOCIAL_IMAGE_GENERATOR_PATH . 'templates/' );
		define( 'SOCIAL_IMAGE_GENERATOR_ASSETS_URL', plugin_dir_url( __DIR__ ) . 'assets/' );
		define( 'SOCIAL_IMAGE_GENERATOR_IMG_URL', SOCIAL_IMAGE_GENERATOR_ASSETS_URL . 'img/' );
	}

	/**
	 * Activate plugin.
	 */
	public static function activate() {
		set_transient( 'sig-render-activation-notice', true, 5 );
		flush_rewrite_rules();
		Cache::create();
	}

	/**
	 * Deactivate plugin.
	 */
	public static function deactivate() {
		Cache::destroy();
	}

	/**
	 * Check if the installation meets the requirements.
	 *
	 * @return bool
	 */
	public static function check_requirements() {
		global $wp_version;

		$activate = true;

		if ( ! extension_loaded( 'gd' ) ) {
			Admin::render_gd_not_installed_notice();
			$activate = false;
		} elseif ( empty( gd_info()['FreeType Support'] ) ) {
			Admin::render_freetype_not_installed_notice();
			$activate = false;
		}

		if ( ! version_compare( $wp_version, '5.4', '>=' ) ) {
			Admin::render_wp_version_too_low();
			$activate = false;
		}

		return $activate;
	}

	/**
	 * Initialize plugin.
	 */
	public function init() {
		if ( ! self::check_requirements() ) {
			return;
		}

		Cache::init();
		new Assets();
		new Admin();
		new Classic_Editor();
		new Meta_Tags();
		new OEmbed();
		new Updater();
		new Image_Generator\Endpoint();
		new Plugins\Yoast();
		new Plugins\The_SEO_Framework();
		new Plugins\Rank_Math_SEO();
		new Plugins\All_In_One_SEO_Pack();
		new Plugins\SEOPress();
		new Plugins\Jetpack();
	}
}
