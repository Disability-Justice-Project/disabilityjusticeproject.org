<div class="l-tease-news">
  <h2 class="l-tease-news__title">
    News <span class="u-color-text-brick">From the Global Frontlines of Disability Justice</span>
  </h2>
  <div class="l-tease-news__posts">
    <?php
      $args = array(
        'category_name' => 'news',
        'posts_per_page' => 3,
        'no_found_rows' => true
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('tease-news'); ?>
    <?php endwhile; ?>
  </div>
</div>
