<?php

namespace Social_Image_Generator;

class Admin {
	const LICENSE_ACTIVATION_ENDPOINT  = 'https://socialimagegenerator.com/wp-json/posty/v1/activate-license';
	const OPTIONS_GROUP                = 'sig';
	const OPTION_KEY_LICENSE_KEY       = 'sig_license_key';
	const OPTION_KEY_LICENSE_KEY_VALID = 'sig_license_key_valid';
	const OPTION_KEY_TEMPLATE_SETTINGS = 'sig_template_settings';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_meta' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'rest_api_init', [ $this, 'register_settings' ] );
		add_action( 'rest_api_init', [ $this, 'register_license_key_endpoint' ] );
		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_action( 'updated_option', [ $this, 'maybe_clear_cache' ] );
		add_action( 'admin_notices', [ $this, 'render_activation_notice' ] );
		add_filter( 'network_admin_plugin_action_links_social-image-generator/social-image-generator.php', [ $this, 'filter_plugin_action_links' ] );
		add_filter( 'plugin_action_links_social-image-generator/social-image-generator.php', [ $this, 'filter_plugin_action_links' ] );
	}

	/**
	 * Add Settings link to plugin page.
	 *
	 * @param array $actions Array of plugin actions.
	 */
	public function filter_plugin_action_links( $actions ) {
		return array_merge( [
			'settings' => '<a href="' . esc_url( admin_url( 'options-general.php?page=social-image-generator' ) ) . '">' . esc_html__( 'Settings', 'social-image-generator' ) . '</a>',
			'home'     => '<a href="https://socialimagegenerator.com">' . esc_html__( 'Home', 'social-image-generator' ) . '</a>',
		], $actions );
	}

	/**
	 * Register meta fields.
	 */
	public function register_meta() {
		register_meta( 'post', 'sig_custom_text', [
			'show_in_rest' => true,
			'type'         => 'string',
			'single'       => true,
		] );

		register_meta( 'post', 'sig_image_type', [
			'show_in_rest' => true,
			'type'         => 'string',
			'single'       => true,
			'default'      => 'featured-image',
		] );

		register_meta( 'post', 'sig_custom_image', [
			'show_in_rest' => true,
			'type'         => 'integer',
			'single'       => true,
		] );

		register_meta( 'post', 'sig_is_disabled', [
			'show_in_rest' => true,
			'type'         => 'boolean',
			'single'       => true,
			'default'      => false,
		] );
	}

	/**
	 * Register settings fields.
	 */
	public function register_settings() {
		add_option( static::OPTION_KEY_LICENSE_KEY );
		register_setting( static::OPTIONS_GROUP, static::OPTION_KEY_LICENSE_KEY, [
			'type'              => 'string',
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
		] );

		add_option( static::OPTION_KEY_LICENSE_KEY_VALID );
		register_setting( static::OPTIONS_GROUP, static::OPTION_KEY_LICENSE_KEY_VALID, [
			'type'              => 'boolean',
			'show_in_rest'      => true,
			'sanitize_callback' => 'boolval',
		] );

		add_option( static::OPTION_KEY_TEMPLATE_SETTINGS );
		register_setting( static::OPTIONS_GROUP, static::OPTION_KEY_TEMPLATE_SETTINGS, [
			'single'       => true,
			'type'         => 'object',
			'show_in_rest' => [
				'schema' => [
					'type'       => 'object',
					'properties' => [
						'template' => [
							'type' => 'string',
						],
						'colors'   => [
							'type'       => 'object',
							'properties' => [
								'logo'       => [ 'type' => 'string' ],
								'text'       => [ 'type' => 'string' ],
								'background' => [ 'type' => 'string' ],
								'accent'     => [ 'type' => 'string' ],
							],
						],
						'logo'     => [
							'type'       => 'object',
							'properties' => [
								'type'  => [ 'type' => 'string' ],
								'id'    => [ 'type' => 'number' ],
								'text'  => [ 'type' => 'string' ],
								'width' => [ 'type' => 'number' ],
							],
						],
						'default_image' => [
							'type'       => 'object',
							'properties' => [
								'id'  => [ 'type' => 'number' ],
								'url' => [ 'type' => 'string' ],
							],
						],
					],
				],
			],
		] );
	}

	/**
	 * Register admin page.
	 */
	public function register_page() {
		add_options_page(
			__( 'Social Image Generator', 'social-image-generator' ),
			__( 'Social Image Generator', 'social-image-generator' ),
			'manage_options',
			'social-image-generator',
			[ $this, 'render_page' ]
		);
	}

	/**
	 * Render admin page.
	 */
	public function render_page() {
		?>

		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<div id="social-image-generator-settings" class="sig"></div>
		</div>

		<?php
	}

	/**
	 * Clear cache if template is updated.
	 *
	 * @param string $option_name Name of the updated option.
	 */
	public function maybe_clear_cache( $option_name ) {
		if ( $option_name === self::OPTION_KEY_TEMPLATE_SETTINGS ) {
			Cache::flush( true );
		}
	}

	/**
	 * Get all template settings.
	 *
	 * @return array
	 */
	public static function get_template_settings() {
		$settings = get_option( self::OPTION_KEY_TEMPLATE_SETTINGS );

		// Return defaults.
		if ( empty( $settings ) ) {
			return Templates::get( 'twentytwenty' );
		}

		if ( ! empty( $settings['logo']['id'] ) ) {
			$src = wp_get_attachment_image_src( $settings['logo']['id'], 'large' );

			if ( ! empty( $src ) ) {
				$ratio = $src[2] / $src[1];
				$width = $settings['logo']['width'];

				$settings['logo']['url']    = $src[0];
				$settings['logo']['width']  = $width;
				$settings['logo']['height'] = $width * $ratio;
			}
		}

		if ( ! empty( $settings['default_image'] ) && ! empty( $settings['default_image']['id'] ) ) {
			$settings['default_image']['url'] = wp_get_attachment_image_url( $settings['default_image']['id'], 'full' );
		}

		return $settings;
	}

	/**
	 * Activate a license key.
	 *
	 * @param string $license_key License key to activate.
	 */
	public static function activate_license_key( $license_key = '' ) {
		$response = wp_remote_post(
			self::LICENSE_ACTIVATION_ENDPOINT,
			[
				'body' => [
					'license_key' => $license_key,
					'site_url'    => get_site_url(),
				],
			]
		);

		return json_decode( wp_remote_retrieve_body( $response ) );
	}

	/**
	 * Register endpoint for activating a license.
	 */
	public function register_license_key_endpoint() {
		register_rest_route(SOCIAL_IMAGE_GENERATOR_API_BASE, '/activate-license', [
			'methods'             => \WP_REST_Server::CREATABLE,
			'permission_callback' => function () {
				return current_user_can( 'manage_options' );
			},
			'callback'            => function ( \WP_REST_Request $request ) {
				$key      = $request->get_param( 'licenseKey' );
				$response = self::activate_license_key( $key );

				update_option( Admin::OPTION_KEY_LICENSE_KEY, $key );
				update_option( Admin::OPTION_KEY_LICENSE_KEY_VALID, $response->code === 'success' );

				return rest_ensure_response( $response );
			},
		]);
	}

	/** Render activation notice. */
	public function render_activation_notice(){
		if ( ! get_transient( 'sig-render-activation-notice' ) ) {
			return;
		}

		$message = sprintf(
			/* translators: %s is a link to the settings page */
			__( 'Social Image Generator has been activated successfully! Get started by designing your template in the %s.', 'social-image-generator' ),
			'<a href="' . esc_url( admin_url( 'options-general.php?page=social-image-generator' ) )  .'">Settings Page</a>'
		);

		printf( '<div class="notice is-dismissible updated"><p>%s</p></div>', wp_kses_post( $message ) );

		delete_transient( 'sig-render-activation-notice' );
	}

	/**
	 * Render a message if GD is not installed.
	 */
	public static function render_gd_not_installed_notice() {
		add_action('admin_notices', function () {
			$message = sprintf(
				/* translators: %s is a link to the GD Image Library */
				__( 'Social Image Generator relies on the %s to work. Please contact your host to install this library on your server.', 'social-image-generator' ),
				'<a href="https://www.php.net/manual/en/intro.image.php">GD Image Library</a>'
			);

			printf( '<div class="notice notice-error"><p>%s</p></div>', wp_kses_post( $message ) );
		});
	}

	/**
	 * Render a message if Freetype is not installed.
	 */
	public static function render_freetype_not_installed_notice() {
		add_action('admin_notices', function () {
			$message = sprintf(
				/* translators: %s is a link to the FreeType GD extension. */
				__( 'Social Image Generator relies on the %s to work. Please contact your host to install this library on your server.', 'social-image-generator' ),
				'<a href="https://www.php.net/manual/en/image.installation.php">FreeType font library</a>'
			);

			printf( '<div class="notice notice-error"><p>%s</p></div>', wp_kses_post( $message ) );
		});
	}

	/**
	 * Render a message if the WordPress version is too low.
	 */
	public static function render_wp_version_too_low() {
		add_action('admin_notices', function () {
			global $wp_version;

			$message = sprintf(
				/* translators: %s is the current WordPress version. */
				__( 'Social Image Generator needs WordPress 5.4 or higher to work. You currently have version %s installed. Please update your WordPress installation to use Social Image Generator.', 'social-image-generator' ),
				$wp_version
			);

			printf( '<div class="notice notice-error"><p>%s</p></div>', wp_kses_post( $message ) );
		});
	}
}
