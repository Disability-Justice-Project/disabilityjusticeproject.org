<?php

namespace Social_Image_Generator\Plugins;

use Social_Image_Generator\Helpers;

class Rank_Math_SEO {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_filter( 'rank_math/opengraph/facebook/og_image', [ $this, 'change_image_url' ] );
		add_filter( 'rank_math/opengraph/facebook/og_image_secure_url', [ $this, 'change_image_url' ] );
		add_filter( 'rank_math/opengraph/facebook/og_image_width', [ $this, 'change_image_width' ] );
		add_filter( 'rank_math/opengraph/facebook/og_image_height', [ $this, 'change_image_height' ] );
		add_filter( 'rank_math/opengraph/twitter/image', [ $this, 'change_twitter_image_url' ] );
	}

	/**
	 * Check if the current post has a custom OpenGraph image set by Rank Math SEO.
	 */
	public function has_custom_og_image() {
		return ! empty( get_post_meta( get_the_ID(), 'rank_math_facebook_image', true ) );
	}

	/**
	 * Check if the current post has a custom Twitter image set by Rank Math SEO.
	 */
	public function has_custom_twitter_image() {
		return ! empty( get_post_meta( get_the_ID(), 'rank_math_twitter_image', true ) );
	}

	/**
	 * Change image URL if necessary.
	 *
	 * @param string $url URL of the image.
	 */
	public function change_image_url( $url ) {
		if ( ! is_singular() || ! Helpers::is_sig_active() || $this->has_custom_og_image() ) {
			add_filter( 'sig_render_og_image_tags', '__return_false' );

			return $url;
		}

		return Helpers::get_image_url();
	}

	/**
	 * Change image width if necessary
	 *
	 * @param int $width Width of the image.
	 */
	public function change_image_width( $width ) {
		return ( ! is_singular() || ! Helpers::is_sig_active() || $this->has_custom_og_image() ) ? $width : 1200;
	}

	/**
	 * Change image height if necessary
	 *
	 * @param int $height Height of the image.
	 */
	public function change_image_height( $height ) {
		return ( ! is_singular() || ! Helpers::is_sig_active() || $this->has_custom_og_image() ) ? $height : 630;
	}

	/**
	 * Change Twitter image URL if necessary.
	 *
	 * @param string $url URL of the image.
	 */
	public function change_twitter_image_url( $url ) {
		if ( ! is_singular() || ! Helpers::is_sig_active() || $this->has_custom_twitter_image() ) {
			add_filter( 'sig_render_twitter_tags', '__return_false' );

			return $url;
		}

		return Helpers::get_image_url();
	}
}
