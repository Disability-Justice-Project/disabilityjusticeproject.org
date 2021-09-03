<?php

namespace Social_Image_Generator\Plugins;

use Social_Image_Generator\Helpers;

class The_SEO_Framework {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_filter( 'the_seo_framework_image_generation_params', [ $this, 'add_custom_image_generator' ], 10, 3 );
		add_filter( 'the_seo_framework_image_details', [ $this, 'add_image_size' ] );

		// We use The SEO Framework filters to render all image URLs, so we
		// don't need our own.
		if ( Helpers::is_plugin_active( 'autodescription/autodescription.php' ) ) {
			add_filter( 'sig_render_meta_tags', '__return_false' );
		}
	}

	/**
	 * Adjusts image generation parameters.
	 *
	 * @param array      $params : [
	 *    string  size:     The image size to use.
	 *    boolean multi:    Whether to allow multiple images to be returned.
	 *    array   cbs:      The callbacks to parse. Ideally be generators, so we can halt remotely.
	 *    array   fallback: The callbacks to parse. Ideally be generators, so we can halt remotely.
	 * ];.
	 * @param array|null $args The query arguments. Contains 'id' and 'taxonomy'.
	 *                         Is null when query is autodetermined.
	 * @param string     $context Context of the generator.
	 * @return array $params
	 */
	public function add_custom_image_generator( $params = [], $args = null, $context = 'social' ) {
		if ( $context !== 'social' || ! Helpers::is_sig_active() ) {
			return $params;
		}

		if ( ( $args === null && is_singular() ) || ( $args && ! $args['taxonomy'] ) ) {
			$id               = isset( $args['id'] ) ? $args['id'] : \the_seo_framework()->get_the_real_ID();
			$has_custom_image = ! empty( get_post_meta( $id, '_social_image_url', true ) );

			if ( ! empty( $id ) && ! $has_custom_image ) {
				$params['cbs'] = [ 'social_image_generator' => get_class() . '::image_generator' ];
			}
		}

		return $params;
	}

	/**
	 * Generates image URL.
	 *
	 * @generator
	 *
	 * @param array|null $args The query arguments. Accepts 'id' and 'taxonomy'.
	 *                         Leave null to autodetermine query.
	 * @yield array : {
	 *    string url: The image URL location,
	 *    int    id:  The image ID,
	 * }
	 */
	public static function image_generator( $args = null ) {
		$post_id = isset( $args['id'] ) ? $args['id'] : \the_seo_framework()->get_the_real_ID();

		yield [
			'url' => Helpers::get_image_url( $post_id ),
			'id'  => 0,
		];
	}

	/**
	 * Add image size if we're using our own image.
	 *
	 * @param array $details Details of the image.
	 * @return array
	 */
	public function add_image_size( $details ) {
		return array_map( function( $detail ) {
			if ( strpos( $detail['url'], SOCIAL_IMAGE_GENERATOR_API_BASE ) !== false ) {
				$detail['width']  = 1200;
				$detail['height'] = 630;
			}

			return $detail;
		}, $details );
	}
}
