<?php
  $featured_image = get_the_post_thumbnail_url();
  $byline = get_field('byline');
?>

<div class="c-tease-news">
  <?php if ( ! empty($featured_image)) : ?>
    <div class="u-effect-gold-screen" onclick="location.href='<?php the_permalink(); ?>'">
      <?php the_post_thumbnail('full', array('class' => 'u-effect-gold-screen c-tease-news__image')); ?>
    </div>
  <?php endif; ?>
  <h3 class="c-tease-news__title">
    <a class="c-tease-news__link" href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h3>
  <div class="c-tease-news__excerpt">
    <?php the_excerpt(); ?>
    <p>
      <a class="c-tease-news__read-more" href="<?php the_permalink(); ?>">Read more<span class="sr-only"> about <?php the_title(); ?></span></a>
    </p>
  </div>
</div>
