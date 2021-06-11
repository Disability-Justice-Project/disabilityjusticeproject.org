<?php
  $featured_image = get_the_post_thumbnail_url();
?>

<div class="c-tease-news">
  <?php if ( ! empty($featured_image)) : ?>
    <?php the_post_thumbnail('full', array('class' => 'c-tease-news__image')); ?>
  <?php endif; ?>
  <h3 class="c-tease-news__title">
    <a class="c-tease-news__link" href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h3>
  <div class="c-tease-news__excerpt">
    <?php the_excerpt(); ?>
  </div>
</div>
