<?php

namespace Social_Image_Generator\Image_Generator;

use Intervention\Image\ImageManagerStatic as Image;
use Social_Image_Generator\Admin;

class Generator {
	/**
	 * Instance of Intervention Image.
	 *
	 * @var \Intervention\Image\Image|false
	 */
	public $image;

	/**
	 * Text on the image.
	 *
	 * @var string
	 */
	public $text;

	/**
	 * URL to the featured image.
	 *
	 * @var string
	 */
	public $featured_image;

	/**
	 * Array of settings.
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Initialize generator.
	 *
	 * @param string $text Text to show on the image.
	 * @param string $featured_image URL of the featured image.
	 */
	public function __construct( $text = '', $featured_image = '' ) {
		$this->text           = $text;
		$this->featured_image = $featured_image;
		$this->settings       = Admin::get_template_settings();
		$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );

		$background  = isset( $this->settings['colors']['background'] ) ? $this->settings['colors']['background'] : '#000';
		$this->image = Image::canvas( 1200, 630, $background );

		$driver = apply_filters( 'sig_image_processing_library', 'gd' );
		Image::configure( [ 'driver' => $driver ] );
	}

	/**
	 * Set the font that will be used for rendering text/
	 *
	 * @param string $path Path to the font file.
	 * @param string $context Context where the font is used.
	 */
	public function use_font( $path, $context = 'title' ) {
		$this->font_file = apply_filters( 'sig_template_font_file', $path, $context );
	}

	/**
	 * Remove special characters such as smart quotes and emdashes since they
	 * don't render correctly.
	 *
	 * @param string $text Text to change.
	 */
	private function remove_special_characters( $text ) {
		$chr_map = [
			"\xE2\x80\x91" => '-', // U+2011 non-breaking hyphen.
			"\xE2\x80\x92" => '-', // U+2012 figure dash.
			"\xE2\x80\x93" => '-', // U+2013 en dash.
			"\xE2\x80\x94" => '-', // U+2014 em dash.
			"\xC2\xAB"     => '"', // U+00AB left-pointing double angle quotation mark.
			"\xC2\xBB"     => '"', // U+00BB right-pointing double angle quotation mark.
			"\xE2\x80\x98" => "'", // U+2018 left single quotation mark.
			"\xE2\x80\x99" => "'", // U+2019 right single quotation mark.
			"\xE2\x80\x9A" => "'", // U+201A single low-9 quotation mark.
			"\xE2\x80\x9B" => "'", // U+201B single high-reversed-9 quotation mark.
			"\xE2\x80\x9C" => '"', // U+201C left double quotation mark.
			"\xE2\x80\x9D" => '"', // U+201D right double quotation mark.
			"\xE2\x80\x9E" => '"', // U+201E double low-9 quotation mark.
			"\xE2\x80\x9F" => '"', // U+201F double high-reversed-9 quotation mark.
			"\xE2\x80\xB9" => "'", // U+2039 single left-pointing angle quotation mark.
			"\xE2\x80\xBA" => "'", // U+203A single right-pointing angle quotation mark.
		];

		return str_replace(
			array_keys( $chr_map ),
			array_values( $chr_map ),
			html_entity_decode( $text, ENT_QUOTES, 'UTF-8' )
		);
	}

	/**
	 * Given a string, font size and max width, return the string shortened
	 * so it fits in the max width, as well as the width of the string.
	 *
	 * @param string $string String to analyze.
	 * @param int    $size Size of the text.
	 * @param int    $max_width Max width of the string.
	 * @param int    $attempts Number of attempts.
	 * @return array
	 */
	private function get_words_by_max_width( $string, $size, $max_width, $attempts = 1 ) {
		$words = explode( ' ', $string );

		$box   = \imagettfbbox( $size * ( 3 / 4 ), 0, $this->font_file, $string );
		$width = abs( $box[6] - $box[4] );

		// Add extra attempts check to prevent infinite loop.
		if ( $attempts > 50 || $width <= $max_width || count( $words ) === 1 ) {
			return [
				'width'  => $width,
				'string' => $string,
			];
		}

		$attempts++;

		array_pop( $words );

		return $this->get_words_by_max_width( implode( ' ', $words ), $size, $max_width, $attempts );
	}

	/**
	 * Given a string, font size and max width, split up the string into lines
	 * that fit in the max width.
	 *
	 * @param string $string String to analyze.
	 * @param int    $size Size of the text.
	 * @param int    $max_width Max width of the string.
	 * @param int    $attempts Number of attempts.
	 * @return array
	 */
	private function wrap_string_by_width( $string, $size, $max_width, $attempts = 1 ) {
		$sentence  = $this->get_words_by_max_width( $string, $size, $max_width );
		$remainder = trim( substr( $string, strlen( $sentence['string'] ) ) );

		if ( ! empty( $remainder ) && $attempts < 50 ) {
			$attempts++;

			return array_merge( [ $sentence ], $this->wrap_string_by_width( $remainder, $size, $max_width, $attempts ) );
		}

		return [ $sentence ];
	}

	/**
	 * Add a gradient.
	 *
	 * @param array $args {
	 *     Optional. Array of parameters.
	 *
	 *     @type int   $x         X-coordinate of the top-left point of the gradient. Default 0.
	 *     @type int   $y         Y-coordinate of the top-left point of the gradient. Default 0.
	 *     @type int   $width     Width of the gradient. Default 1200.
	 *     @type int   $height    Height of the gradient. Default 630.
	 *     @type int   $opacity   Opacity of the gradient between 10 and 100, in steps of 10. Default 100.
	 * }
	 */
	public function gradient( $args = [] ) {
		$args = wp_parse_args($args, [
			'x'       => 0,
			'y'       => 0,
			'width'   => 1200,
			'height'  => 630,
			'opacity' => 100,
		]);

		// Get a value between 10 and 100 in multiples of 10.
		$opacity = min( max( 10, ceil( $args['opacity'] / 10 ) * 10 ), 100 );

		$gradient = Image::make( SOCIAL_IMAGE_GENERATOR_IMG_PATH . "gradients/vertical-{$opacity}.png" );
		$gradient->resize( $args['width'], $args['height'] );

		$this->image->insert( $gradient, 'top-left', (int) $args['x'], (int) $args['y'] );
	}

	/**
	 * Add an overlay.
	 *
	 * @param array $args {
	 *     Optional. Array of parameters.
	 *
	 *     @type int   $x         X-coordinate of the top-left point of the overlay. Default 0.
	 *     @type int   $y         Y-coordinate of the top-left point of the overlay. Default 0.
	 *     @type int   $width     Width of the overlay. Default 1200.
	 *     @type int   $height    Height of the overlay. Default 630.
	 *     @type int   $opacity   Opacity of the overlay between 0 and 100. Default 50.
	 * }
	 */
	public function overlay( $args = [] ) {
		$args = wp_parse_args($args, [
			'x'       => 0,
			'y'       => 0,
			'width'   => 1200,
			'height'  => 630,
			'opacity' => 50,
			'color'   => '#000',
		]);

		// See: https://stackoverflow.com/a/17115500.
		list( $r, $g, $b ) = array_map(
			function ( $color ) {
				return hexdec( str_pad( $color, 2, $color ) );
			},
			str_split( ltrim( $args['color'], '#' ), strlen( $args['color'] ) > 4 ? 2 : 1 )
		);

		// Get a value between 10 and 100 in multiples of 10.
		$opacity = min( max( 0, round( $args['opacity'] / 100, 1 ) ), 1 );

		$overlay = Image::canvas( $args['width'], $args['height'], "rgba({$r}, {$g}, {$b}, {$opacity})" );

		$this->image->insert( $overlay, 'top-left', (int) $args['x'], (int) $args['y'] );
	}

	/**
	 * Get the URL of the image.
	 *
	 * @return string|false
	 */
	private function get_image_url() {
		if ( ! empty( $this->featured_image ) ) {
			return $this->featured_image;
		}

		return false;
	}

	/**
	 * Check if there's an image to add.
	 *
	 * @return bool
	 */
	private function has_image() {
		return ! empty( $this->get_image_url() );
	}

	/**
	 * Add an image.
	 *
	 * @param array $args {
	 *     Optional. Array of parameters.
	 *
	 *     @type string   $image       Path or URL of the image to insert. Defaults to the featured image.
	 *     @type int      $x           X-coordinate of the image. Default 0.
	 *     @type int      $y           Y-coordinate of the image. Default 0.
	 *     @type int      $width       Width of the image. Default 400.
	 *     @type int      $height      Height of the image. If left empty, scales with the width.
	 * }
	 * @return false|array Array with dimensions of image on success, false on failure.
	 */
	public function image( $args = [] ) {
		$args = wp_parse_args($args, [
			'image'      => $this->get_image_url(),
			'x'          => 0,
			'y'          => 0,
			'width'      => 400,
			'height'     => null,
			'max_height' => null,
			'align'      => 'left',
			'valign'     => 'top',
			'render'     => true,
		]);

		if ( empty( $args['image'] ) ) {
			return false;
		}

		try {
			$image = Image::make( $args['image'] );
		} catch ( \Exception $e ) {
			return false;
		}

		if ( ! empty( $args['height'] ) ) {
			$image->fit( $args['width'], $args['height'] );
		} else {
			$image->resize( $args['width'], $args['max_height'], function ( $constraint ) {
				$constraint->aspectRatio();
			});
		}

		$positions = [ $args['valign'], $args['align'] !== 'center' ? $args['align'] : null ];
		$position  = join( '-', array_filter( $positions ) );

		if ( $args['render'] ) {
			$this->image->insert( $image, $position, (int) $args['x'], (int) $args['y'] );
		}

		return [
			'width'  => round( $image->width() ),
			'height' => round( $image->height() ),
		];
	}

	/**
	 * Get text info.
	 *
	 * @param array $args {
	 *     Optional. Array of parameters.
	 *
	 *     @type string   $text          Text to add. Defaults to the post title or custom text if applicable.
	 *     @type int      $size          Size in pixels of the text. Default 64.
	 *     @type float    $line_height   Line height of the text. Default 1.2.
	 *     @type int      $max_width     Max width of the text. Default 1200.
	 * }
	 * @return false|array Array with dimensions of image on success, false on failure.
	 */
	public function get_text_info( $args = [] ) {
		$args = wp_parse_args($args, [
			'text'        => $this->text,
			'size'        => 64,
			'line_height' => 1.2,
			'max_width'   => 1200,
		]);

		if ( empty( $args['text'] ) ) {
			return false;
		}

		$text  = $this->remove_special_characters( $args['text'] );
		$text  = str_replace( [ '&nbsp;', '&NBSP;' ], ' ', $text );
		$lines = $this->wrap_string_by_width( $text, $args['size'], $args['max_width'] );

		return [
			'lines'  => wp_list_pluck( $lines, 'string' ),
			'width'  => max( wp_list_pluck( $lines, 'width' ) ),
			'height' => ( $args['line_height'] * $args['size'] * ( count( $lines ) - 1 ) ) + $args['size'],
		];
	}

	/**
	 * Add text.
	 *
	 * @param array $args {
	 *     Optional. Array of parameters.
	 *
	 *     @type string   $text          Text to add. Defaults to the post title or custom text if applicable.
	 *     @type int      $size          Size in pixels of the text. Default 64.
	 *     @type float    $line_height   Line height of the text. Default 1.2.
	 *     @type int      $max_width     Max width of the text. Default 1200.
	 *     @type int      $x             X-coordinate of the text. If text is left-aligned, it is counted from the left.
	 *                                   If text is right-aligned it's counted from the right. If text is centered, it
	 *                                   is the center of text. Default 0.
	 *     @type int      $y             Y-coordinate of the text. If text is top-aligned, it is counted from the top.
	 *                                   If text is bottom-aligned it's counted from the bottom. If text is centered, it
	 *                                   is the center of text. Default 0.
	 *     @type string   $align         Horizontal alignment of text. Left, center, or right. Default left.
	 *     @type string   $valign        Vertical alignment of text. Top, center, or bottom. Default top.
	 * }
	 * @return false|array Array with dimensions of text on success, false on failure.
	 */
	public function text( $args = [] ) {
		$args = wp_parse_args($args, [
			'text'        => '',
			'size'        => 64,
			'line_height' => 1.2,
			'max_width'   => 1200,
			'max_height'  => 630,
			'x'           => 0,
			'y'           => 0,
			'align'       => 'left',
			'valign'      => 'top',
			'color'       => isset( $this->settings['colors']['text'] ) ? $this->settings['colors']['text'] : '#000',
		]);

		if ( empty( $args['text'] ) ) {
			$args['text'] = $this->text;
		}

		$text = $this->get_text_info( $args );

		if ( empty( $text ) ) {
			return false;
		}

		// Make sure the text doesn't exceed max height.
		if ( $text['height'] > $args['max_height'] && $args['size'] > 8 ) {
			return $this->text(array_merge($args, [
				'size' => max( $args['size'] - 4, 8 ), // Minimum font size is 8px.
			]));
		}

		foreach ( $text['lines'] as $i => $line ) {
			$current_x = $args['x'];
			$current_y = $args['y'] + ( $args['line_height'] * $args['size'] * $i );

			if ( $args['align'] === 'right' ) {
				$current_x = 1200 - $args['x'];
			}

			if ( $args['valign'] === 'center' ) {
				$current_y = $args['y'] + ( $args['line_height'] * $args['size'] * $i ) - ( $text['height'] / 2 );
			}

			// If we align from the bottom, the text needs to start at $y from
			// the bottom and work its way up.
			if ( $args['valign'] === 'bottom' ) {
				$offset    = $args['size'] * $args['line_height'] - $args['size'];
				$current_y = ( 630 - $args['y'] ) - ( $args['size'] * $args['line_height'] * ( count( $text['lines'] ) - $i ) ) + $offset;
			}

			$this->image->text($line, $current_x, $current_y, function ( $font ) use ( $args ) {
				$font->file( $this->font_file );
				$font->size( $args['size'] );
				$font->color( $args['color'] );
				$font->align( $args['align'] );
				$font->valign( 'top' );
			});
		}

		return [
			'width'  => round( $text['width'] ),
			'height' => round( $text['height'] ),
		];
	}

	/**
	 * Return an Intervention instance of the logo.
	 */
	private function get_logo_image() {
		$id    = isset( $this->settings['logo']['id'] ) ? $this->settings['logo']['id'] : 0;
		$width = (int) $this->settings['logo']['width'];
		$url   = wp_get_attachment_image_url( $id, 'large' );

		if ( empty( $url ) || empty( $width ) ) {
			return false;
		}

		$uploads = wp_upload_dir();
		$path    = str_replace( $uploads['baseurl'], $uploads['basedir'], $url );

		return Image::make( $path )->widen( $width * 2 );
	}

	/**
	 * Get info about a logo.
	 *
	 * @param array $args Arguments of the logo image.
	 * @return false|array
	 */
	public function get_logo_info( $args = [] ) {
		$args = wp_parse_args($args, [
			'size' => 32,
		]);

		$type = isset( $this->settings['logo']['type'] ) ? $this->settings['logo']['type'] : 'title';

		if ( $type === 'none' ) {
			return false;
		}

		if ( $type === 'image' ) {
			$image = $this->get_logo_image();

			return empty( $image ) ? false : [
				'logo'   => $image,
				'width'  => $image->width(),
				'height' => $image->height(),
			];
		}

		if ( empty( $args['size'] ) ) {
			return false;
		}

		$texts = [
			'title' => get_bloginfo( 'name' ),
			'text'  => isset( $this->settings['logo']['text'] ) ? $this->settings['logo']['text'] : '',
			'link'  => strtoupper( str_replace( [ 'https://', 'http://', 'www.' ], '', get_site_url() ) ),
		];

		$box = \imagettfbbox( $args['size'] * ( 3 / 4 ), 0, $this->font_file, $texts[ $type ] );

		return [
			'logo'   => $texts[ $type ],
			'width'  => abs( $box[6] - $box[4] ),
			'height' => abs( $box[7] - $box[1] ),
		];
	}

	/**
	 * Render a logo.
	 *
	 * @param array $args Arguments of the logo.
	 * @return false|void
	 */
	public function logo( $args = [] ) {
		$args = wp_parse_args($args, [
			'size'   => 32,
			'x'      => 0,
			'y'      => 0,
			'align'  => 'left',
			'valign' => 'top',
		]);

		$logo = $this->get_logo_info( $args );

		if ( empty( $logo ) ) {
			return false;
		}

		if ( $logo['logo'] instanceof \Intervention\Image\Image ) {
			$this->image(array_merge($args, [
				'image'  => $logo['logo'],
				'width'  => $logo['width'],
				'height' => $logo['height'],
			]));
		} else {
			$this->text(array_merge($args, [
				'text'  => $logo['logo'],
				'color' => $this->settings['colors']['logo'],
			]));
		};
	}

	/**
	 * Get the image with a specific template
	 *
	 * @param string $template Name of the template.
	 */
	private function get_from_template( $template ) {
		switch ( $template ) {
			case 'blueberry':
				$this->image([
					'width'  => 1200,
					'height' => 630,
				]);

				$padding       = 60;
				$logo          = $this->get_logo_info();
				$max_height    = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );
				$text_settings = [
					'size'        => 64,
					'line_height' => 1.1,
					'max_width'   => 800,
					'x'           => 600,
					'y'           => $padding,
					'max_height'  => $max_height,
					'align'       => 'center',
					'valign'      => 'bottom',
				];


				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/lato/lato-400-italic.ttf' );

				$text = $this->text( $text_settings );

				$this->image->rectangle(
					( ( 1200 - $text['width'] ) / 2 ) - $padding,
					630 - $text['height'] - ( $padding * 2 ),
					( ( 1200 - $text['width'] ) / 2 ) + $text['width'] + $padding,
					630,
					function ( $draw ) {
						$draw->background( $this->settings['colors']['background'] );
					}
				);

				$this->text( $text_settings );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'bold-splash':
				$bg = Image::make( SOCIAL_IMAGE_GENERATOR_IMG_PATH . 'templates/bold-splash/bg.png' )->fit( 1200, 630 );
				$this->image->insert( $bg );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900-italic.ttf' );
				$this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => 60,
					'y'           => 60,
					'size'        => 64,
					'line_height' => 1.1,
					'max_width'   => 880,
					'max_height'  => ( 630 - 120 ),
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x'      => 60,
					'y'      => 60,
					'align'  => 'right',
					'valign' => 'bottom',
				]);

				break;
			case 'brand':
				$this->image([
					'width'  => 1200,
					'height' => 630,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'cupcake':
				$this->image([
					'width'  => 600,
					'height' => 630,
				]);

				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - ( ( $logo['height'] + 40 ) * 2 ) - 80 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/gochi-hand/gochi-hand.ttf' );
				$this->text([
					'x'           => 900,
					'y'           => 315,
					'size'        => 72,
					'line_height' => 0.86,
					'max_width'   => 480,
					'max_height'  => $max_height,
					'align'       => 'center',
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/gochi-hand/gochi-hand.ttf', 'logo' );
				$this->logo([
					'x' => 640,
					'y' => 40,
				]);

				break;
			case 'dois':
				$this->image([
					'width'  => 600,
					'height' => 630,
					'x'      => 600,
				]);

				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 120 ) : ( 630 - 120 );
				$y          = ! empty( $logo ) ? ( $max_height / 2 ) + 60 : 315;

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/hk-grotesk/hk-grotesk-700.otf' );
				$this->text([
					'x'           => $this->has_image() ? 300 : 600,
					'y'           => $y,
					'size'        => 54,
					'line_height' => 1.15,
					'max_width'   => $this->has_image() ? 440 : 1040,
					'max_height'  => $max_height,
					'align'       => 'center',
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/hk-grotesk/hk-grotesk-700.otf', 'logo' );
				$this->logo([
					'x'      => 40,
					'y'      => 40,
					'valign' => 'bottom',
				]);

				break;
			case 'duotone':
				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/oswald/oswald-700.ttf' );
				$text = $this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => 600,
					'y'           => 60,
					'size'        => 64,
					'line_height' => 1.1,
					'max_width'   => 600,
					'max_height'  => 315,
					'align'       => 'center',
				]);

				$offset = $text['height'] + ( $this->has_image() ? 180 : 120 );
				$this->image->rectangle(0, $offset, 1200, 630, function ( $draw ) {
					$draw->background( $this->settings['colors']['accent'] );
				});

				$this->image([
					'x'      => 250,
					'y'      => $text['height'] + 120,
					'width'  => 700,
					'height' => 630 - $text['height'] - 120,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/oswald/oswald-700.ttf', 'logo' );
				$this->logo([
					'x'      => 60,
					'y'      => 60,
					'valign' => 'bottom',
				]);

				break;
			case 'edge':
				$this->image([
					'width'  => 450,
					'height' => 630,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/oswald/oswald-700.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/oswald/oswald-700.ttf' );
				$this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => 510,
					'y'           => 315,
					'size'        => 48,
					'line_height' => 1.08,
					'max_width'   => 600,
					'max_height'  => $max_height,
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/oswald/oswald-700.ttf', 'logo' );
				$this->logo([
					'x' => 510,
					'y' => 60,
				]);

				break;
			case 'elegance':
				$this->image([
					'width'  => 1200,
					'height' => 630,
				]);

				$this->overlay( [ 'opacity' => 40 ] );

				// If there's a logo, we move the text up more to the top.
				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo        = $this->get_logo_info();
				$text_offset = ! empty( $logo ) ? ( ( 630 - $logo['height'] - 60 ) / 2 ) : 315;
				$max_height  = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/eb-garamond/eb-garamond-400-italic.ttf' );
				$this->text([
					'size'       => 84,
					'max_width'  => 840,
					'max_height' => $max_height,
					'align'      => 'center',
					'valign'     => 'center',
					'x'          => 600,
					'y'          => $text_offset,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x'      => 600,
					'y'      => 60,
					'align'  => 'center',
					'valign' => 'bottom',
				]);

				break;
			case 'executive':
				$this->image([
					'x'      => 600,
					'width'  => 600,
					'height' => 630,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo          = $this->get_logo_info();
				$border_offset = ! empty( $logo ) ? ( ( 630 - $logo['height'] - 120 ) ) : 570;
				$text_offset   = ! empty( $logo ) ? ( ( 630 - $logo['height'] - 60 ) / 2 ) : 315;
				$max_height    = ! empty( $logo ) ? ( 630 - $logo['height'] - 240 ) : ( 630 - 180 );

				$this->logo([
					'x'      => 300 - ( $logo['width'] / 2 ),
					'y'      => 60,
					'align'  => 'left',
					'valign' => 'bottom',
				]);

				$this->image->rectangle(60 - 3, 60 - 3, 540 - 3, $border_offset - 3, function ( $draw ) {
					$draw->border( 6, $this->settings['colors']['accent'] );
				});

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => 300,
					'y'           => $text_offset,
					'size'        => 56,
					'line_height' => 1.1,
					'max_width'   => 420,
					'max_height'  => $max_height,
					'align'       => 'center',
					'valign'      => 'center',
				]);

				break;
			case 'fullscreen':
				$this->image([
					'width'  => 1200,
					'height' => 630,
				]);

				$this->gradient();

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->text([
					'x'           => 60,
					'y'           => 60,
					'line_height' => 1.3,
					'max_width'   => 1080,
					'max_height'  => $max_height,
					'valign'      => 'bottom',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'highway':
				$this->image([
					'width'  => 1200,
					'height' => 630,
				]);

				$this->overlay();

				// If there's a logo, we move the text up more to the top.
				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo        = $this->get_logo_info();
				$text_offset = ! empty( $logo ) ? ( ( 630 - $logo['height'] - 60 ) / 2 ) : 315;
				$max_height  = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->text([
					'size'       => 72,
					'max_width'  => 720,
					'max_height' => $max_height,
					'align'      => 'center',
					'valign'     => 'center',
					'x'          => 600,
					'y'          => $text_offset,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x'      => 600,
					'y'      => 60,
					'align'  => 'center',
					'valign' => 'bottom',
				]);

				break;
			case 'outline':
				$this->image([
					'x'      => 600,
					'width'  => 600,
					'height' => 630,
				]);

				$this->image->rectangle(60 - 3, 60 - 3, 660 - 3, 570 - 3, function ( $draw ) {
					$draw->border( 6, $this->settings['colors']['accent'] );
				});

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/viga/viga-400.ttf' );
				$this->text([
					'x'           => 330,
					'y'           => 315,
					'size'        => 56,
					'line_height' => 1.3,
					'max_width'   => 420,
					'max_height'  => 390,
					'align'       => 'center',
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x'      => 60,
					'y'      => 60,
					'align'  => 'right',
					'valign' => 'bottom',
				]);

				break;
			case 'panel':
				$this->image([
					'x'      => 800,
					'width'  => 400,
					'height' => 630,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->text([
					'x'           => 60,
					'y'           => 60,
					'size'        => 60,
					'line_height' => 1.2,
					'max_width'   => 680,
					'max_height'  => $max_height,
					'valign'      => 'bottom',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'spiral':
				$bg = Image::make( SOCIAL_IMAGE_GENERATOR_IMG_PATH . 'templates/spiral/bg.png' )->fit( 1200, 630 );
				$this->image->insert( $bg );

				if ( $this->has_image() ) {
					$image_args = [
						'x'          => 80,
						'y'          => 80,
						'width'      => 360,
						'align'      => 'right',
						'valign'     => 'bottom',
						'max_height' => 630 - 60 - 80,
					];

					$image_info = $this->image( array_merge( $image_args, [ 'render' => false ] ) );

					$this->image->rectangle(1200 - $image_info['width'] - 60, 630 - $image_info['height'] - 60, 1140, 570, function ( $draw ) {
						$draw->background( $this->settings['colors']['accent'] );
					});

					$this->image( $image_args );
				}

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/bungee/bungee-400.ttf' );
				$this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => 60,
					'y'           => 60,
					'size'        => 80,
					'line_height' => 1.1,
					'max_width'   => 620,
					'max_height'  => $max_height,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x'      => 60,
					'y'      => 60,
					'valign' => 'bottom',
				]);

				break;
			case 'sunflower':
				$bg = Image::make( SOCIAL_IMAGE_GENERATOR_IMG_PATH . 'templates/sunflower/bg.png' )->fit( 1200, 630 );
				$this->image->insert( $bg );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/alegreya/alegreya-700.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 300 ) : ( 630 - 200 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/alegreya/alegreya-700.ttf' );
				$this->text([
					'x'           => 600,
					'y'           => 315,
					'size'        => 72,
					'line_height' => 1.3,
					'max_width'   => 700,
					'max_height'  => $max_height,
					'align'       => 'center',
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/alegreya/alegreya-700.ttf', 'logo' );
				$this->logo([
					'x' => 100,
					'y' => 100,
				]);

				break;
			case 'taco':
				$this->image([
					'width'  => 700,
					'height' => 630,
				]);

				$this->overlay([
					'x'       => 560,
					'y'       => 80,
					'width'   => 600,
					'height'  => 510,
					'opacity' => 40,
				]);

				$this->image->rectangle(540, 60, 1140, 570, function ( $draw ) {
					$draw->background( $this->settings['colors']['accent'] );
				});

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/alfa-slab-one/alfa-slab-one.ttf' );
				$this->text([
					'x'           => 840,
					'y'           => 310,
					'size'        => 64,
					'line_height' => 1.1,
					'max_width'   => 480,
					'max_height'  => 380,
					'align'       => 'center',
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'touchdown':
				$this->image->rectangle(0, 0, 1200, 20, function ( $draw ) {
					$draw->background( $this->settings['colors']['text'] );
				});

				if ( $this->has_image() ) {
					$this->image->rectangle(80, 135, 580, 535, function ( $draw ) {
						$draw->background( $this->settings['colors']['text'] );
					});

					$this->image([
						'x'      => 100,
						'y'      => 115,
						'width'  => 500,
						'height' => 400,
					]);
				}

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = min( ! empty( $logo ) ? ( 630 - ( $logo['height'] * 2 ) - 180 ) : 300, 300 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900-italic.ttf' );
				$this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => $this->has_image() ? 540 : 60,
					'y'           => 315,
					'size'        => 72,
					'line_height' => 1.1,
					'max_width'   => 600,
					'max_height'  => $max_height,
					'valign'      => 'center',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x'      => 60,
					'y'      => 60,
					'align'  => 'right',
					'valign' => 'bottom',
				]);

				break;
			case 'twentytwentyone':
				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-400.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-400.ttf' );
				$text = $this->text([
					'size'        => 84,
					'line_height' => 1.2,
					'max_width'   => 1080,
					'max_height'  => $max_height,
					'valign'      => 'bottom',
					'x'           => 60,
					'y'           => 60,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-400.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'twentytwenty':
				$this->image->rectangle(0, 530, 1200, 630, function ( $draw ) {
					$draw->background( $this->settings['colors']['accent'] );
				});

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo )
					? ( 630 - $logo['height'] - 60 - 60 - 140 )
					: ( 630 - 60 - 140 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->text([
					'size'        => 72,
					'line_height' => 1.3,
					'max_width'   => 1080,
					'max_height'  => $max_height,
					'valign'      => 'bottom',
					'x'           => 60,
					'y'           => 140,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'twentynineteen':
				$accent_distance_from_text = 48;

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/roboto/roboto-700.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo )
					? ( 630 - $logo['height'] - 180 - $accent_distance_from_text )
					: ( 630 - 120 - $accent_distance_from_text );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/roboto/roboto-700.ttf' );
				$text = $this->text([
					'size'        => 72,
					'line_height' => 1.1,
					'max_width'   => 1080,
					'max_height'  => $max_height,
					'valign'      => 'bottom',
					'x'           => 60,
					'y'           => 60,
				]);

				// Add accent.
				$accent_position = 630 - 60 - $text['height'] - $accent_distance_from_text;
				$this->image->rectangle(60, ( $accent_position - 6 ), 200, $accent_position, function ( $draw ) {
					$draw->background( $this->settings['colors']['accent'] );
				});

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/roboto/roboto-700.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;
			case 'twentyseventeen':
				$this->image->rectangle(0, 510, 1200, 630, function ( $draw ) {
					$draw->background( $this->settings['colors']['background'] );
				});

				$this->image([
					'width'  => 1200,
					'height' => 510,
				]);

				$this->gradient([
					'width'   => 1200,
					'height'  => 510,
					'opacity' => 40,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/roboto/roboto-700.ttf' );
				$this->text([
					'text'        => strtoupper( $this->text ),
					'x'           => 60,
					'y'           => 180,
					'size'        => 56,
					'line_height' => 1.1,
					'max_width'   => 1080,
					'max_height'  => ( 630 - 60 - 180 ),
					'valign'      => 'bottom',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/roboto/roboto-700.ttf', 'logo' );
				$this->logo([
					'x'      => 60,
					'y'      => $this->settings['logo']['type'] === 'image' ? 40 : 570,
					'valign' => $this->settings['logo']['type'] === 'image' ? 'bottom' : 'center',
				]);

				break;
			case 'typewriter':
				$bg = Image::make( SOCIAL_IMAGE_GENERATOR_IMG_PATH . 'templates/typewriter/bg.png' )->fit( 1200, 630 );
				$this->image->insert( $bg );

				$this->image->rectangle(30 + 4, 30 + 4, 1170 - 4, 600 - 4, function ( $draw ) {
					$draw->border( 8, $this->settings['colors']['text'] );
				});

				// If there's a logo, we move the text up more to the top.
				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo        = $this->get_logo_info();
				$text_offset = ! empty( $logo ) ? ( ( 630 - $logo['height'] - 40 ) / 2 ) : 315;
				$max_height  = ! empty( $logo ) ? ( 630 - $logo['height'] - 60 - 98 - 98 ) : ( 630 - 98 - 98 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/eb-garamond/eb-garamond-700.ttf' );
				$this->text([
					'size'        => 72,
					'line_height' => 1.27,
					'max_width'   => 800,
					'max_height'  => $max_height,
					'align'       => 'center',
					'valign'      => 'center',
					'x'           => 600,
					'y'           => $text_offset,
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->logo([
					'x'      => 600,
					'y'      => 80,
					'align'  => 'center',
					'valign' => 'bottom',
				]);

				break;
			case 'window':
				$this->image([
					'width'  => 1200,
					'height' => 630,
				]);

				$this->overlay([
					'width'   => 700,
					'opacity' => 60,
					'color'   => $this->settings['colors']['accent'],
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$logo       = $this->get_logo_info();
				$max_height = ! empty( $logo ) ? ( 630 - $logo['height'] - 180 ) : ( 630 - 120 );

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf' );
				$this->text([
					'x'          => 60,
					'y'          => 60,
					'max_width'  => 580,
					'max_height' => $max_height,
					'valign'     => 'bottom',
				]);

				$this->use_font( SOCIAL_IMAGE_GENERATOR_ASSETS_PATH . 'fonts/inter/inter-900.ttf', 'logo' );
				$this->logo([
					'x' => 60,
					'y' => 60,
				]);

				break;

		}

		return $this->image;
	}

	/**
	 * Generate the image.
	 *
	 * @param int $post_id ID of the post. Optional.
	 * @return \Intervention\Image\Image
	 */
	public function generate( $post_id = 0 ) {
		$image = apply_filters( 'sig_generated_image', null, $this, $post_id );

		if ( ! empty( $image ) ) {
			return $image;
		}

		return $this->get_from_template( isset( $this->settings['template'] ) ? $this->settings['template'] : 'twentytwenty' );
	}
}
