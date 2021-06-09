<?php get_header(); ?>
<main id="content">

<div class="c-update-banner">
  <p class="c-update-banner__message">
    New videos <span class="color-text-gray-brick">Documentaries from Kenya and South Africa</span>
  </p>
</div>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php comments_template(); ?>
<?php endwhile; endif; ?>
<?php get_template_part( 'nav', 'below' ); ?>
</main>

<?php get_footer(); ?>
