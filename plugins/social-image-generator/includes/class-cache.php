<?php

namespace Social_Image_Generator;

class Cache {
	/**
	 * The name of the cache cleanup hook.
	 */
	const CACHE_CLEANUP_HOOK = 'social_image_generator_clean_outdated_cache';

	/**
	 * Get the cache directory.
	 *
	 * @return string
	 */
	public static function get_cache_dir() {
		$uploads_info = wp_upload_dir();

		return $uploads_info['basedir'] . DIRECTORY_SEPARATOR . SOCIAL_IMAGE_GENERATOR_SLUG . DIRECTORY_SEPARATOR;
	}

	/**
	 * Check if the cache directory is writable.
	 *
	 * @return bool
	 */
	public static function is_writable() {
		return is_dir( self::get_cache_dir() ) && wp_is_writable( self::get_cache_dir() );
	}

	/**
	 * Get number of cached images.
	 */
	public static function count() {
		return is_dir( self::get_cache_dir() ) ? count( glob( self::get_cache_dir() . '*' ) ) : 0;
	}

	/**
	 * Create the cache directory and schedule regular cleanup when activating
	 * the plugin.
	 */
	public static function create() {
		$cache_cleanup_recurrence = apply_filters( 'sig_cache_cleanup_recurrence', 'daily' );

		if ( ! is_dir( self::get_cache_dir() ) ) {
			wp_mkdir_p( self::get_cache_dir() );
		}

		wp_schedule_event( time(), $cache_cleanup_recurrence, self::CACHE_CLEANUP_HOOK );
	}

	/**
	 * Remove the cache directory and cleanup when deactivating the plugin.
	 */
	public static function destroy() {
		wp_clear_scheduled_hook( self::CACHE_CLEANUP_HOOK );

		rmdir( self::get_cache_dir() );
	}

	/**
	 * Initialize all cache-related functionality.
	 */
	public static function init() {
		add_action( self::CACHE_CLEANUP_HOOK, [ __CLASS__, 'flush' ] );
		add_action( 'rest_api_init', [ __CLASS__, 'register_endpoint' ] );
		add_action( 'social_image_generator_generate_cached_image', [ __CLASS__, 'flush_by_id' ], 10, 2 );
		add_action( 'save_post', [ __CLASS__, 'flush_after_saving' ] );
	}

	/**
	 * Flush by post id.
	 *
	 * @param int  $post_id Post ID.
	 * @param bool $regenerate True to regenerate a new image. Default false.
	 * @return bool True on success, false on failure.
	 */
	public static function flush_by_id( $post_id, $regenerate = false ) {
		$file    = self::get_cache_dir() . self::get_filename_by_id( $post_id );
		$success = file_exists( $file ) ? unlink( $file ) : true;

		if ( $regenerate ) {
			$image = Helpers::generate_social_image( $post_id );

			self::save( $post_id, $image );
		}

		return $success;
	}

	/**
	 * Flush after saving a post.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function flush_after_saving( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		wp_schedule_single_event(
			time(),
			'social_image_generator_generate_cached_image',
			[ $post_id, true ]
		);
	}

	/**
	 * Flush the cache.
	 *
	 * @param bool $force Force delete all items, even if they're not outdated.
	 * @return bool True on success, false on failure.
	 */
	public static function flush( $force = false ) {
		$max_age = apply_filters( 'sig_cache_files_max_age', WEEK_IN_SECONDS );
		$success = true;

		foreach ( glob( self::get_cache_dir() . '*' ) as $file ) {
			if ( $force || filemtime( $file ) < time() - $max_age ) {
				$success = unlink( $file );
			}
		}

		return $success;
	}

	/**
	 * Get the filename of an image by post ID.
	 *
	 * @param int $post_id Post ID.
	 */
	private static function get_filename_by_id( $post_id ) {
		return md5( SOCIAL_IMAGE_GENERATOR_SLUG . ':' . intval( $post_id ) ) . '.jpg';
	}

	/**
	 * Check if a specific post has a cached image.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function has( $post_id ) {
		return file_exists( self::get_cache_dir() . self::get_filename_by_id( $post_id ) );
	}

	/**
	 * Get a cached image.
	 *
	 * @param int $post_id Post ID.
	 * @return array
	 */
	public static function get( $post_id ) {
		$path = self::get_cache_dir() . self::get_filename_by_id( $post_id );

		// Update the timestamp.
		touch( $path );

		$file = file_get_contents( $path );

		return [
			'file'   => $file,
			'mime'   => wp_check_filetype( $path ),
			'length' => strlen( $file ),
		];
	}

	/**
	 * Save an image to the cache.
	 *
	 * @param int                       $post_id Post ID.
	 * @param \Intervention\Image\Image $image Image instance.
	 */
	public static function save( $post_id, $image ) {
		$image->save( self::get_cache_dir() . self::get_filename_by_id( $post_id ) );
	}

	/**
	 * Private endpoint for clearing the cache.
	 */
	public static function register_endpoint() {
		register_rest_route(SOCIAL_IMAGE_GENERATOR_API_BASE, '/clear-cache', [
			'methods'             => 'GET',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' );
			},
			'callback'            => function ( $request ) {
				$success = self::flush( true );

				return new \WP_REST_Response( [ 'success' => $success ], $success ? 200 : 500 );
			},
		]);
	}
}
