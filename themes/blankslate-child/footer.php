</div>
<footer
  id="footer"
  class="l-footer">

  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
    <?php get_template_part('logo');?>
  </a>

  <?php
    $disabilityjusticeproject_description = get_bloginfo( 'description', 'display' );
    if ( $disabilityjusticeproject_description || is_customize_preview() ) :
    ?>
    <div class="l-footer__partnership c-partnership">
      <p class="c-footer__tagline"><?php echo $disabilityjusticeproject_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
      <div class="c-partnership__lockup">
        <p class="c-partnership__byline">
          A strategic partnership with
        </p>
        <a href="https://disabilityrightsfund.org/">
          <img
            alt="Disability Rights Fund."
            class="c-partnership__logo"
            src="/wp-content/themes/blankslate-child/images/logo-disability-rights-fund.png" />
        </a>
      </div>
    </div>
  <?php endif; ?>

</footer>
  <?php wp_footer(); ?>
  <script src="/wp-content/themes/blankslate-child/js/main.js"></script>
</body>
</html>
