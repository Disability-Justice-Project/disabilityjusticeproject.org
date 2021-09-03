<?php

namespace Social_Image_Generator\Plugins;

use Social_Image_Generator\Helpers;

class Yoast {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_filter( 'wpseo_frontend_presenters', [ $this, 'maybe_remove_yoast_tags' ] );
	}

	/**
	 * Check if the current post has a custom OpenGraph image set by Yoast.
	 */
	public function has_custom_og_image() {
		return ! empty( get_post_meta( get_the_ID(), '_yoast_wpseo_opengraph-image', true ) );
	}

	/**
	 * Check if the current post has a custom Twitter image set by Yoast.
	 */
	public function has_custom_twitter_image() {
		return ! empty( get_post_meta( get_the_ID(), '_yoast_wpseo_twitter-image', true ) );
	}

	/**
	 * Remove Yoast OpenGraph and Twitter tags if the images are not explicitly
	 * set.
	 *
	 * @param array $presenters \Yoast\WP\SEO\Presenters\Abstract_Indexable_Presenter[].
	 * @return array \Yoast\WP\SEO\Presenters\Abstract_Indexable_Presenter[]
	 */
	public function maybe_remove_yoast_tags( $presenters ) {
		if ( ! is_singular() || ! Helpers::is_sig_active() ) {
			return $presenters;
		}

		$removed_presenters = [];

		if ( $this->has_custom_og_image() ) {
			add_filter( 'sig_render_og_image_tags', '__return_false' );
		} else {
			$removed_presenters[] = 'Yoast\WP\SEO\Presenters\Open_Graph\Image_Presenter';
		}

		if ( $this->has_custom_twitter_image() ) {
			add_filter( 'sig_render_twitter_tags', '__return_false' );
		} else {
			$removed_presenters[] = 'Yoast\WP\SEO\Presenters\Twitter\Image_Presenter';
			$removed_presenters[] = 'Yoast\WP\SEO\Presenters\Twitter\Card_Presenter';
		}

		return array_filter($presenters, function ( $presenter ) use ( $removed_presenters ) {
			return ! in_array( get_class( $presenter ), $removed_presenters, true );
		});
	}
}
