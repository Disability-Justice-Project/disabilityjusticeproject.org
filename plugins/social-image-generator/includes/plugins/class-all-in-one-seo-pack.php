<?php

namespace Social_Image_Generator\Plugins;

use Social_Image_Generator\Helpers;

class All_In_One_SEO_Pack {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_filter( 'aioseo_social_meta_tags', [ $this, 'change_meta_tags' ] );
	}

	/**
	 * Change image URL if necessary.
	 *
	 * @param array $meta_tags Array of meta tags.
	 * @return array
	 */
	public function change_meta_tags( $meta_tags ) {
		if ( ! is_singular() || ! Helpers::is_sig_active() ) {
			return $meta_tags;
		}

		$custom_og_image      = \aioseo()->social->facebook->getImage();
		$custom_twitter_image = \aioseo()->social->twitter->getImage();

		if ( ! empty( $custom_og_image ) ) {
			add_filter( 'sig_render_og_image_tags', '__return_false' );
		}

		if ( ! empty( $custom_twitter_image ) ) {
			add_filter( 'sig_render_twitter_tags', '__return_false' );
		}

		return $meta_tags;
	}
}
