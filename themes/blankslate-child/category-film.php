<?php
/**
* The Film Archive Template
*/

  get_header();
?>

<main id="content">
  <h1 id="title" class="sr-only">
    <?php
      $category = get_the_category();
      echo $category[0]->cat_name;
    ?>
  </h1>

  <div class="l-grid">

    <?php
      $args = array(
        'category_name' => 'film',
        'orderby' => 'title',
        'order'   => 'DSC',
        'no_found_rows' => true,
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('tease-project'); ?>
    <?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>
