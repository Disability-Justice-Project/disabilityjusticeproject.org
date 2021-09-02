<?php
/**
 * Disability Justice Project functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Disability_Justice_Project
 */

 // Import shortcodes
include('custom-shortcodes.php');


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


// Filter except length
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}


// Limits search results to specific categories
// 11 = Film
// 13 = News
// function searchcategory($query) {
//   if ($query->is_search) {
//     $query->set('cat','11,4,6');
//   }
//   return $query;
// }
// add_filter('pre_get_posts','searchcategory');


// Get random posts
add_filter( 'the_posts', function( $posts, \WP_Query $query )
{
  if( $pick = $query->get( '_shuffle_and_pick' ) ) {
    shuffle( $posts );
    $posts = array_slice( $posts, 0, (int) $pick );
  }
  return $posts;
}, 10, 2 );


?>
