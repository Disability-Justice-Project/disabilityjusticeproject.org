<?php
  /*
  Template Name: Filmmakers Template
  Template Post Type: page
  */

  get_header();
?>

<main id="content">
  <div class="l-about l-about--dark-on-light">
    <div class="l-about__content">

      <h1 id="title" class="c-heading__large">
        <?php the_title(); ?>
      </h1>

      <?php
        $args = array(
          'category_name' => 'filmmaker',
          'orderby'       => 'title',
          'order'         => 'ASC',
          'no_found_rows' => true
        );
        $query = new WP_Query($args);

        while($query -> have_posts()) : $query -> the_post(); ?>
          <?php get_template_part('tease-person'); ?>
      <?php endwhile; ?>

    </div>
  </div>
</main>

<?php get_footer(); ?>
