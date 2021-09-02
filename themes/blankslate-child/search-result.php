<article class="c-search-result">
  <h2>
    <a class="c-search-result__title" href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h2>
  <p class="c-search-result__excerpt">
    <?php if (has_category()): ?>
      <span class="c-search-result__category"><?php the_category( '</div><div>' ); ?></span>:
    <?php endif; ?>
  <?php echo excerpt(35); ?>
  </p>
</article>
