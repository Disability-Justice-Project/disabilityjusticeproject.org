<?php
  /*
  Template Name: Filmmakers Template
  Template Post Type: page
  */

  get_header();
  $order_by = get_field('order_by');
?>

<main id="content">
  <div class="l-landing">

    <div class="l-landing__hero"></div>

    <h1 id="title" class="l-landing__heading c-heading__large">
      <?php the_title(); ?>
    </h1>

    <h2 id="2021" class="l-landing__heading c-heading__medium">
      2021
    </h2>

    <?php
      $args = array(
        'category_name' => 'filmmaker',
        'orderby'       => '$order_by',
        'order'         => 'DSC',
        'no_found_rows' => true
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('filmmaker'); ?>
    <?php endwhile; ?>

    <div class="l-landing__spacer"></div>
  </div>
</main>

<?php get_footer(); ?>
