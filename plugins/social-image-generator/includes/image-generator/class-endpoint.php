<?php

namespace Social_Image_Generator\Image_Generator;

use Social_Image_Generator\Cache;
use Social_Image_Generator\Helpers;

class Endpoint {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_image_endpoint' ] );
		add_action( 'rest_api_init', [ $this, 'register_generator_endpoint' ] );
	}

	/**
	 * Register endpoint for retrieving images.
	 */
	public function register_image_endpoint() {
		register_rest_route(
			SOCIAL_IMAGE_GENERATOR_API_BASE,
			'/image/(?P<id>\d+)',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'permission_callback' => '__return_true',
				'callback'            => function ( \WP_REST_Request $request ) {
					$post_id = (int) $request['id'];

					if ( empty( $post_id ) || get_post_status( $post_id ) !== 'publish' || ! Helpers::is_sig_active( $post_id ) ) {
						return new \WP_Error(
							'invalid_id',
							__( 'Invalid post ID.', 'social-image-generator' ),
							[ 'status' => 404 ]
						);
					}

					$active = Helpers::is_sig_active( $post_id );

					if ( ! $active ) {
						return new \WP_Error(
							'not_enabled',
							__( 'Social Image Generator is not enabled for this post.', 'social-image-generator' ),
							[ 'status' => 404 ]
						);
					}

					$cache_enabled = apply_filters( 'sig_enable_cache', ! Helpers::is_debug_mode() );

					if ( $cache_enabled && Cache::has( $post_id ) ) {
						$image = Cache::get( $post_id );

						header( 'Content-Type: image/jpeg' );
						header( 'Content-Length: ' . $image['length'] );

						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $image['file'];
					} else {
						$image        = Helpers::generate_social_image( $post_id );
						$cached_image = Cache::save( $post_id, $image );

						if ( isset( $cached_image['error'] ) ) {
							return new \WP_Error(
								'social_image_generator_cache_unknown_error',
								$cached_image['error'],
								[ 'status' => 500 ]
							);
						}

						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $image->response();
					}

					exit;
				},
			]
		);
	}

	/**
	 * Private generator endpoint for creating images with custom text.
	 */
	public function register_generator_endpoint() {
		register_rest_route(
			SOCIAL_IMAGE_GENERATOR_API_BASE,
			'/generator',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
				'callback'            => function ( \WP_REST_Request $request ) {
					$generator = new Generator(
						wp_kses_post( $request['text'] ?: '' ),
						$request['image'] ?: ''
					);

					$post_id = (int) isset( $request['postId'] ) ? $request['postId'] : 0;

					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $generator->generate( $post_id )->response();

					exit;
				},
			]
		);
	}
}
