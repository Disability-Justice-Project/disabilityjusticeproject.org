<?php

namespace Social_Image_Generator;

class Helpers {
	/**
	 * Check if our debug mode is enabled.
	 */
	public static function is_debug_mode() {
		return defined( 'SOCIAL_IMAGE_GENERATOR_DEBUG_MODE' ) && SOCIAL_IMAGE_GENERATOR_DEBUG_MODE;
	}

	/**
	 * Check if a plugin is active.
	 *
	 * @param string $path Path to plugin file.
	 */
	public static function is_plugin_active( $path ) {
		return in_array(
			$path,
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) ),
			true
		);
	}

	/**
	 * Check if Social Image Generator is active for a specific post.
	 *
	 * @param int $post_id Post ID to check.
	 */
	public static function is_sig_active( $post_id = 0 ) {
		$post_id = ! empty( $post_id ) ? (int) $post_id : get_the_ID();

		if ( empty( $post_id ) ) {
			return false;
		}

		$post_type = get_post_type( $post_id );

		if ( ! is_post_type_viewable( $post_type ) || in_array( $post_type, [ 'attachment', 'revision', 'nav_menu_item' ] ) ) {
			return false;
		}

		$disabled = get_post_meta( $post_id, 'sig_is_disabled', true );
		$active   = empty( $disabled );

		return apply_filters( 'sig_is_enabled', $active, $post_id, get_post( $post_id ) );
	}

	/**
	 * Get the image URL for a post.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function get_image_url( $post_id = 0 ) {
		$post_id = ! empty( $post_id ) ? (int) $post_id : get_the_ID();

		if ( empty( $post_id ) ) {
			return '';
		}

		return get_rest_url( null, '/' . SOCIAL_IMAGE_GENERATOR_API_BASE . '/image/' . $post_id );
	}

	/**
	 * Generate the social image for a post.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function generate_social_image( $post_id ) {
		$custom_text      = get_post_meta( $post_id, 'sig_custom_text', true );
		$text             = ! empty( $custom_text ) ? wp_kses_post( $custom_text ) : get_the_title( $post_id );
		$image_type       = get_post_meta( $post_id, 'sig_image_type', true );
		$settings         = Admin::get_template_settings();
		$default_image_id = ( ! empty( $settings['default_image'] ) && ! empty( $settings['default_image']['id'] ) ) ? (int) $settings['default_image']['id'] : 0;

		switch ( $image_type ) {
			case 'featured-image':
				$thumbnail_id = get_post_thumbnail_id( $post_id );
				$image_id     = ! empty( $thumbnail_id ) ? $thumbnail_id : $default_image_id;
				break;
			case 'custom-image':
				$image_id = (int) get_post_meta( $post_id, 'sig_custom_image', true );
				break;
			case 'default-image':
				$image_id = $default_image_id;
				break;
			default:
				$image_id = 0;
				break;
		}

		$image     = wp_get_attachment_image_url( $image_id, 'large' );
		$generator = new Image_Generator\Generator( $text, $image );

		return $generator->generate( $post_id );
	}
}
