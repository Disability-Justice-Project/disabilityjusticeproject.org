<?php
  /*
  Template Name: Person
  Template Post Type: post
  */

  get_header();
?>

<main id="content">
  <div id="post-<?php the_ID(); ?>" class="l-landing">
    <div class="l-landing__hero"></div>

    <p class="l-landing__topic c-content__topic">
      <?php the_category( '</div><div>' ); ?>
    </p>
    <h1 class="l-landing__heading c-heading__large">
      <?php the_title(); ?>
    </h1>

    <div class="l-landing__content">
      <div class="c-content c-content--project">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
