<?php
/**
* The Mentor Template
*/

  get_header();
?>

<main id="content">
  <div class="l-landing">

  <div class="l-landing__hero"></div>

  <h1 id="title" class="l-landing__heading c-heading__large">
    Mentor
  </h1>

  <?php
    $args = array(
      'category_name' => 'mentor',
      'order'         => 'ASC',
      'no_found_rows' => true
    );
    $query = new WP_Query($args);

    while($query -> have_posts()) : $query -> the_post(); ?>
      <?php get_template_part('mentor'); ?>
  <?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>
