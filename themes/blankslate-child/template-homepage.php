<?php
  /*
  Template Name: Homepage Template
  Template Post Type: page
  */

  get_header();
?>

<main id="content">

  <div class="l-grid">
    <div class="c-update-banner">
      <h1 id="title" class="c-update-banner__message">
        Documentaries <span class="u-color-text-gold">by</span> and <span class="u-color-text-gold">about</span> persons with disabilities
      </h1>
    </div>

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
  </div>

  <?php get_template_part('recent-news');?>
  <?php get_template_part('newsletter-signup');?>
</main>

<?php get_footer(); ?>
