<?php

namespace Social_Image_Generator;

class Templates {
	/**
	 * Get all templates.
	 *
	 * @return array
	 */
	public static function all() {
		$default_logo_color = '#ef4949';

		return [
			'fullscreen'      => [
				'name'   => __( 'Fullscreen', 'social-image-generator' ),
				'slug'   => 'fullscreen',
				'image'  => true,
				'colors' => [
					'logo'       => '#fff',
					'background' => '#333',
					'text'       => '#fff',
				],
			],
			'panel'           => [
				'name'   => __( 'Panel', 'social-image-generator' ),
				'slug'   => 'panel',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#dee7ef',
					'background' => '#29323a',
				],
			],
			'bold-splash'     => [
				'name'   => __( 'Bold Splash', 'social-image-generator' ),
				'slug'   => 'bold-splash',
				'image'  => false,
				'colors' => [
					'logo'       => '#fff',
					'text'       => '#fff',
					'background' => '#298d4c',
				],
			],
			'highway'         => [
				'name'   => __( 'Highway', 'social-image-generator' ),
				'slug'   => 'highway',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#fff',
					'background' => '#333',
				],
			],
			'blueberry'       => [
				'name'   => __( 'Blueberry', 'social-image-generator' ),
				'slug'   => 'blueberry',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#2c2f4e',
					'background' => '#fff',
				],
			],
			'dois'            => [
				'name'   => __( 'Dois', 'social-image-generator' ),
				'slug'   => 'dois',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'background' => '#fff',
					'text'       => '#000',
				],
			],
			'brand'           => [
				'name'   => __( 'Brand', 'social-image-generator' ),
				'slug'   => 'brand',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'background' => '#fff',
				],
			],
			'window'          => [
				'name'   => __( 'Window', 'social-image-generator' ),
				'slug'   => 'window',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#fff',
					'background' => '#333',
					'accent'     => '#000',
				],
			],
			'duotone'         => [
				'name'   => __( 'Duotone', 'social-image-generator' ),
				'slug'   => 'duotone',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#000',
					'background' => '#fff',
					'accent'     => '#212121',
				],
			],
			'elegance'        => [
				'name'   => __( 'Elegance', 'social-image-generator' ),
				'slug'   => 'elegance',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#fff',
					'background' => '#333',
				],
			],
			'executive'       => [
				'name'   => __( 'Executive', 'social-image-generator' ),
				'slug'   => 'executive',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#fff',
					'background' => '#2f4979',
					'accent'     => '#efe4c7',
				],
			],
			'touchdown'       => [
				'name'   => __( 'Touchdown', 'social-image-generator' ),
				'slug'   => 'touchdown',
				'image'  => true,
				'colors' => [
					'logo'       => '#000',
					'text'       => '#d52c1f',
					'background' => '#fcf9f9',
				],
			],
			'outline'         => [
				'name'   => __( 'Outline', 'social-image-generator' ),
				'slug'   => 'outline',
				'image'  => true,
				'colors' => [
					'logo'       => '#fff',
					'text'       => '#fff',
					'background' => '#544c48',
					'accent'     => '#fff',
				],
			],
			'taco'            => [
				'name'   => __( 'Taco', 'social-image-generator' ),
				'slug'   => 'taco',
				'image'  => true,
				'colors' => [
					'logo'       => '#fff',
					'text'       => '#48749d',
					'background' => '#ecbd7f',
					'accent'     => '#fff',
				],
			],
			'spiral'          => [
				'name'   => __( 'Spiral', 'social-image-generator' ),
				'slug'   => 'spiral',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#ceef72',
					'background' => '#1f2573',
					'accent'     => '#9d15cd',
				],
			],
			'edge'            => [
				'name'   => __( 'Edge', 'social-image-generator' ),
				'slug'   => 'edge',
				'image'  => true,
				'colors' => [
					'logo'       => '#ec008a',
					'text'       => '#fff',
					'background' => '#000',
				],
			],
			'cupcake'         => [
				'name'   => __( 'Cupcake', 'social-image-generator' ),
				'slug'   => 'cupcake',
				'image'  => true,
				'colors' => [
					'logo'       => '#7d5a4f',
					'text'       => '#c50403',
					'background' => '#efddd1',
				],
			],
			'typewriter'      => [
				'name'   => __( 'Typewriter', 'social-image-generator' ),
				'slug'   => 'typewriter',
				'image'  => false,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#fcf0b6',
					'background' => '#2a3d56',
				],
			],
			'sunflower'       => [
				'name'   => __( 'Sunflower', 'social-image-generator' ),
				'slug'   => 'sunflower',
				'image'  => false,
				'colors' => [
					'logo' => $default_logo_color,
					'text' => '#322e25',
				],
			],
			'twentytwentyone'    => [
				'name'   => __( 'TwentyTwentyOne', 'social-image-generator' ),
				'slug'   => 'twentytwentyone',
				'image'  => false,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#28303d',
					'background' => '#d1e4dd',
				],
			],
			'twentytwenty'    => [
				'name'   => __( 'TwentyTwenty', 'social-image-generator' ),
				'slug'   => 'twentytwenty',
				'image'  => false,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#111',
					'background' => '#fff',
					'accent'     => '#f7f1e7',
				],
			],
			'twentynineteen'  => [
				'name'   => __( 'TwentyNineteen', 'social-image-generator' ),
				'slug'   => 'twentynineteen',
				'image'  => false,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#111',
					'background' => '#fff',
					'accent'     => '#767676',
				],
			],
			'twentyseventeen' => [
				'name'   => __( 'TwentySeventeen', 'social-image-generator' ),
				'slug'   => 'twentyseventeen',
				'image'  => true,
				'colors' => [
					'logo'       => $default_logo_color,
					'text'       => '#fff',
					'background' => '#fff',
				],
			],
		];
	}

	/**
	 * Get a specific template
	 *
	 * @param string $slug Name of the template.
	 * @return array
	 */
	public static function get( $slug ) {
		return self::all()[ $slug ];
	}
}
