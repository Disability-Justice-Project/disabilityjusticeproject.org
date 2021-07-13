<?php
  /*
  Template Name: Homepage Template
  Template Post Type: page
  */

  // Get homepage template data
  $new_video = get_post_meta( get_the_ID(), 'new_video', true);

  get_header();
?>

<main id="content">

<?php
  set_query_var('new_video', $new_video);
  get_template_part('update-banner');
?>

<?php
  $args = array(
    'category_name' => 'film',
    'posts_per_page' => 3,
    'no_found_rows' => true
  );
  $query = new WP_Query($args);

  while($query -> have_posts()) : $query -> the_post(); ?>
    <?php get_template_part('tease-project'); ?>
<?php endwhile; ?>

<?php get_template_part('recent-news');?>

</main>

<?php get_footer(); ?>
