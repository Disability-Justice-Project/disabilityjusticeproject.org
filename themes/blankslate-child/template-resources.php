<?php
  /*
  Template Name: Resources Template
  Template Post Type: page
  */

  get_header();
?>

<main id="content" class="u-dark-on-light">
  <div class="l-landing">

  <div class="l-landing__hero"></div>

    <p class="l-landing__topic c-content__topic">
      Tips and tricks
    </p>
    <h1 id="title" class="l-landing__heading c-heading__large">
      Resources
    </h1>

    <div class="l-landing__content">
      <div class="c-content">
        <?php the_content(); ?>
      </div>
    </div>

    <div class="l-landing__spacer"></div>
  </div>
</main>

<?php get_footer(); ?>
