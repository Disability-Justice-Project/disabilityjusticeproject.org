<?php
  get_header();
?>

<main id="content">
  <div class="l-search-results">
    <div class="l-search-results__title">
      <h1>
        <?php printf( '<span class="u-color-text-brick">Search results:</span> %s', get_search_query() ); ?>
      </h1>
    </div>
    <div class="l-search-results__results">
      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'search-result' ); ?>
        <?php endwhile; ?>
        <?php else : ?>
          <p><?php esc_html_e( 'Sorry, nothing matched your search. Please try another term.', 'blankslate' ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
