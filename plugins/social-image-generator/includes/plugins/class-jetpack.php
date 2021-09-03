<?php

namespace Social_Image_Generator\Plugins;

use Social_Image_Generator\Helpers;

class Jetpack {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_filter( 'jetpack_open_graph_tags', [ $this, 'change_meta_tags' ], 100 );
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

		unset( $meta_tags['og:image'] );
		unset( $meta_tags['og:image:width'] );
		unset( $meta_tags['og:image:height'] );
		unset( $meta_tags['twitter:image'] );
		unset( $meta_tags['twitter:card'] );

		return $meta_tags;
	}
}
