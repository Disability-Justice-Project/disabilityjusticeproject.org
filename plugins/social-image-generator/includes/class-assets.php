<?php

namespace Social_Image_Generator;

class Assets {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_assets' ] );
	}

	/**
	 * Get the hashed filename of a CSS file.
	 *
	 * @param string $name Name of the CSS file.
	 */
	private static function get_css_filename( $name ) {
		if ( Helpers::is_debug_mode() ) {
			return $name;
		}

		$map      = SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'css/manifest.json';
		$manifest = file_exists( $map ) ? json_decode( file_get_contents( $map ), true ) : [];

		return isset( $manifest[ $name ] ) ? $manifest[ $name ] : $name;
	}

	/**
	 * Registers and enqueues a style.
	 *
	 * @param string $name Name of the style.
	 * @param array  $dependencies Array of dependencies.
	 */
	private function add_style( $name, $dependencies = [] ) {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_style(
			"social-image-generator-{$name}-style",
			SOCIAL_IMAGE_GENERATOR_ASSETS_URL . 'css/' . self::get_css_filename( $name . '.css' ),
			$dependencies
		);
	}

	/**
	 * Registers and enqueues a script.
	 *
	 * @param string $name Name of the script.
	 * @param array  $l10n Internationalization array.
	 * @param array  $dependencies Array of dependencies.
	 */
	private function add_script( $name, $l10n = [], $dependencies = [] ) {
		$asset_filepath = SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'js/' . $name . '.asset.php';
		$asset_file     = file_exists( $asset_filepath ) ? include $asset_filepath : [
			'dependencies' => [],
			'version'      => SOCIAL_IMAGE_GENERATOR_VERSION,
		];

		wp_register_script(
			"social-image-generator-{$name}-script",
			SOCIAL_IMAGE_GENERATOR_ASSETS_URL . 'js/' . $name . '.js',
			array_merge( $asset_file['dependencies'], $dependencies ),
			$asset_file['version'],
			true
		);

		if ( ! empty( $l10n ) && is_array( $l10n ) ) {
			wp_localize_script( "social-image-generator-{$name}-script", 'socialImageGenerator', $l10n );
		}

		wp_enqueue_script( "social-image-generator-{$name}-script" );
	}

	/**
	 * Register admin assets.
	 */
	public function register_admin_assets() {
		// No need to load these assets anywhere but our own pages.
		if ( in_array( get_current_screen()->base, [ 'post', 'settings_page_social-image-generator' ], true ) && ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		};

		$this->add_style( 'admin', [ 'wp-components' ] );
		$this->add_script(
			'admin',
			[
				'siteTitle'              => get_bloginfo( 'name' ),
				'siteLink'               => str_replace( [ 'https://', 'http://', 'www.' ], '', get_site_url() ),
				'defaultApiUrl'          => rest_url( 'wp/v2' ),
				'apiUrl'                 => rest_url( SOCIAL_IMAGE_GENERATOR_API_BASE ),
				'nonce'                  => wp_create_nonce( 'wp_rest' ),
				'licenseKey'             => get_option( Admin::OPTION_KEY_LICENSE_KEY ),
				'isValidLicenseKey'      => get_option( Admin::OPTION_KEY_LICENSE_KEY_VALID ),
				'imgUrl'                 => SOCIAL_IMAGE_GENERATOR_IMG_URL,
				'cacheDirectory'         => Cache::get_cache_dir(),
				'cacheDirectoryWritable' => Cache::is_writable(),
				'cacheDirectoryCount'    => Cache::count(),
				'templates'              => Templates::all(),
				'templateSettings'       => Admin::get_template_settings(),
				'supportsCustomFields'   => ! empty( get_current_screen() ) && ! empty( get_current_screen()->post_type ) && post_type_supports( get_current_screen()->post_type, 'custom-fields' ),
			],
			[ 'jquery' ]
		);
	}
}
