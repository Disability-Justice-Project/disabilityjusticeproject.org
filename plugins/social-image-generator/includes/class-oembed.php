<?php

namespace Social_Image_Generator;

class OEmbed {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'oembed_response_data', [ $this, 'update_oembed_data' ], 9999, 2 );
	}

	/**
	 * Update oEmbed data to include social images.
	 *
	 * @param array    $data oEmbed data.
	 * @param \WP_Post $post Relevant post.
	 * @return array
	 */
	public function update_oembed_data( $data, $post ) {
		if ( empty( $post ) || ! Helpers::is_sig_active( $post->ID ) ) {
			return $data;
		}

		$data['thumbnail_url']    = Helpers::get_image_url( $post->ID );
		$data['thumbnail_width']  = 1200;
		$data['thumbnail_height'] = 630;

		return $data;
	}
}
