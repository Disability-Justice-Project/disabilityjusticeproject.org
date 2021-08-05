<?php
/**
* The Film Archive Template
*/

  get_header();
?>

<main id="content">
  <div id="news" class="l-tease-news">
  <h1 class="l-tease-news__title">
    News <span class="l-tease-news__emphasis">From the Global Frontlines of Disability Justice</span>
  </h1>
  <div class="l-tease-news__posts">
    <?php
      $args = array(
        'category_name' => 'news',
        'order'         => 'ASC',
        'no_found_rows' => true
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('tease-news'); ?>
    <?php endwhile; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
