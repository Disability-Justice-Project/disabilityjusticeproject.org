<?php
/**
* The Staff Template
*/

  get_header();
?>

<main id="content">
  <div class="l-landing">

  <div class="l-landing__hero"></div>

  <h1 id="title" class="l-landing__heading c-heading__large">
    Staff
  </h1>

  <?php
    $args = array(
      'category_name' => 'staff',
      'order'         => 'ASC',
      'no_found_rows' => true
    );
    $query = new WP_Query($args);

    while($query -> have_posts()) : $query -> the_post(); ?>
      <?php get_template_part('staff'); ?>
  <?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>
