<div class="l-recommended-videos">
  <h2 class="l-recommended-videos__title c-heading__medium">
    More videos
  </h2>

  <div class="l-recommended-videos__list">
    <?php
      $args = array(
        'category_name' => 'film',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => 'true',
        '_shuffle_and_pick' => 6
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('recommended-video'); ?>
    <?php endwhile; ?>

    <a class="c-recommended-video__show-all" href="/category/film/">
      Show all videos
    </a>
  </div>
</div>
