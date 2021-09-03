<?php

namespace Social_Image_Generator\Plugins;

use Social_Image_Generator\Helpers;

class SEOPress {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_filter( 'seopress_social_og_thumb', [ $this, 'change_image_url' ] );
		add_filter( 'seopress_social_twitter_card_thumb', [ $this, 'change_twitter_image_url' ] );
	}

	/**
	 * Check if the current post has a custom OpenGraph image set by SEOPress.
	 */
	public function has_custom_og_image() {
		return ! empty( get_post_meta( get_the_ID(), '_seopress_social_fb_img', true ) );
	}

	/**
	 * Check if the current post has a custom Twitter image set by SEOPress.
	 */
	public function has_custom_twitter_image() {
		return ! empty( get_post_meta( get_the_ID(), '_seopress_social_twitter_img', true ) );
	}

	/**
	 * Change image URL if necessary.
	 *
	 * @param string $meta HTML meta tag.
	 */
	public function change_image_url( $meta ) {
		if ( ! is_singular() || ! Helpers::is_sig_active() || $this->has_custom_og_image() ) {
			add_filter( 'sig_render_og_image_tags', '__return_false' );

			return $meta;
		}

		return false;
	}

	/**
	 * Change Twitter image URL if necessary.
	 *
	 * @param string $meta HTML meta tag.
	 */
	public function change_twitter_image_url( $meta ) {
		if ( ! is_singular() || ! Helpers::is_sig_active() || $this->has_custom_twitter_image() ) {
			add_filter( 'sig_render_twitter_tags', '__return_false' );

			return $meta;
		}

		// Make sure we respect the Twitter card size setting of SEOPress.
		add_filter( 'sig_meta_twitter_card', '__return_false' );

		return false;
	}
}
