<?php
/**
 * Disability Justice Project functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Disability_Justice_Project
 */


// Restrict blocks available to site authors
function my_plugin_allowed_block_types( $allowed_block_types, $post ) {
  if ( $post->post_type !== 'post' ) {
    return $allowed_block_types;
  }
  return array(
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/quote',
    'core/image',
    'core/audio',
    'core/video',
    'core/image',
    'core/shortcode'
  );
}
add_filter( 'allowed_block_types', 'my_plugin_allowed_block_types', 10, 2 );

?>
