<?php

namespace Social_Image_Generator;

class Classic_Editor {
	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
		add_action( 'save_post', [ $this, 'save_meta_box_data' ] );
	}

	public function add_meta_box() {
		$custom_post_types = get_post_types( [
			'public' => true,
			'_builtin' => false,
		] );

		$custom_post_types = array_filter( array_values( $custom_post_types ), function ( $custom_post_type ) {
			return post_type_supports( $custom_post_type, 'custom-fields' );
		} );

		add_meta_box(
			'sig-meta-box',
			__( 'Social Image Generator', 'social-image-generator' ),
			[ $this, 'render_meta_box' ],
			array_merge( [ 'post', 'page' ], $custom_post_types ),
			'side',
			'default',
			[
				'__back_compat_meta_box' => true,
			]
		);
	}

	/**
	 * @param \WP_Post $post
	 */
	public function render_meta_box( $post ) {
		$disabled   = ! empty( get_post_meta( $post->ID, 'sig_is_disabled', true ) );
		$text       = get_post_meta( $post->ID, 'sig_custom_text', true );
		$image_type = get_post_meta( $post->ID, 'sig_image_type', true );
		$image_id   = get_post_meta( $post->ID, 'sig_custom_image', true );
		$image_url  = wp_get_attachment_image_url( $image_id, 'large' );
		$post_type  = get_post_type_object( get_post_type( $post ) );

		$image_types = [
			'featured-image' => __( 'Featured Image', 'social-image-generator' ),
			'custom-image'   => __( 'Custom Image', 'social-image-generator' ),
			'default-image'  => __( 'Default Image', 'social-image-generator' ),
			'no-image'       => __( 'No Image', 'social-image-generator' ),
		];

		wp_nonce_field( 'sig_classic_editor', 'sig_classic_editor_nonce' );
		?>

		<div class="sig-classic-editor <?php echo $disabled ? 'sig-classic-editor--disabled' : ''; ?>">
			<label data-sig-classic-editor-disabled>
				<input type="checkbox" name="sig_is_disabled" id="sig_is_disabled" <?php checked( $disabled ); ?> >
				<?php
				printf(
					/* translators: %s is the name of the post type */
					esc_html__( 'Check this to disable the Social Image for this %s.', 'social-image-generator' ),
					esc_html( strtolower( $post_type->labels->singular_name ) )
				);
				?>
			</label>

			<hr>

			<label for="sig_custom_text"><?php esc_html_e( 'Custom Text', 'social-image-generator' ); ?></label>
			<textarea type="text" name="sig_custom_text" id="sig_custom_text"><?php echo esc_html( $text ); ?></textarea>
			<p><small><em><?php esc_html_e( 'By default the post title is used for the image. You can use this field to set your own text.', 'social-image-generator' ); ?></em></small></p>
			<hr>

			<label for="sig_image_type"><?php esc_html_e( 'Image Type', 'social-image-generator' ); ?></label>
			<select name="sig_image_type" id="sig_image_type">
				<?php foreach ( $image_types as $key => $label ) : ?>
					<option <?php echo selected( $image_type, $key ); ?> value="<?php echo esc_attr( $key ); ?>">
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<div class="sig-classic-editor__custom-image" data-sig-classic-editor-custom-image <?php echo $image_type !== 'custom-image' ? 'hidden' : ''; ?>>
				<label for="sig_custom_image"><?php esc_html_e( 'Custom Image', 'social-image-generator' ); ?></label>
				<img data-sig-classic-editor-image-preview src="<?php echo ! empty( $image_url ) ? esc_url( $image_url ) : ''; ?>" <?php echo empty( $image_url ) ? 'hidden' : ''; ?>>
				<button class="button button-secondary" data-sig-classic-editor-set-image><?php esc_html_e( 'Set Custom Image', 'social-image-generator' ); ?></button>
				<input type="hidden" name="sig_custom_image" id="sig_custom_image" value="<?php echo esc_attr( $image_id ); ?>" />
				<a data-sig-classic-editor-remove-image href="#" <?php echo empty( $image_url ) ? 'hidden' : ''; ?>><?php esc_html_e( 'Remove Custom Image', 'social-image-generator' ); ?></a>
			</div>

			<hr>

			<a class="sig-classic-editor__link" target="_blank" href="<?php echo esc_url( admin_url( 'options-general.php?page=social-image-generator' ) ); ?>">
				<?php esc_html_e( 'Edit Social Image template', 'social-image-generator' ); ?>
			</a>
		</div>

		<?php
	}

	public function save_meta_box_data( $post_id ) {
		if ( ! isset( $_POST['sig_classic_editor_nonce'] ) || ! wp_verify_nonce( $_POST['sig_classic_editor_nonce'], 'sig_classic_editor' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$fields = [
			'sig_custom_text'  => 'string',
			'sig_image_type'   => 'string',
			'sig_custom_image' => 'integer',
			'sig_is_disabled'  => 'boolean',
		];

		foreach ( $fields as $key => $type ) {
			switch ( $type ) {
				case 'string':
					$value = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
					break;
				case 'integer':
					$value = isset( $_POST[ $key ] ) ? (int) $_POST[ $key ] : 0;
					break;
				case 'boolean':
					$value = ! empty( $_POST[ $key ] );
					break;
			}

			if ( ! empty( $value ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	}
}
