<?php
  /*
  Template Name: About Template
  Template Post Type: page
  */

  get_header();
?>

<main id="content" class="u-dark-on-light">
  <div class="l-landing">

    <div class="l-landing__hero"></div>

    <p class="l-landing__topic c-content__topic">
      FAQ
    </p>
    <h1 id="title" class="l-landing__heading c-heading__large">
      About the Disability Justice Project
    </h1>

    <div class="l-landing__content">
      <div class="c-content">
        <?php the_content(); ?>
      </div>
    </div>

    <p class="l-landing__section l-landing__topic c-content__topic">
      Our team
    </p>
    <h2 class="l-landing__section l-landing__heading help c-heading__large">
      Mentors
    </h2>

    <?php
        $args = array(
          'category_name' => 'mentor',
          'orderby'       => 'title',
          'order'         => 'ASC',
          'no_found_rows' => true
        );
        $query = new WP_Query($args);

        while($query -> have_posts()) : $query -> the_post(); ?>
          <?php get_template_part('mentor'); ?>
      <?php endwhile; ?>

      <div class="l-landing__spacer"></div>
  </div>
</main>

<?php get_footer(); ?>
