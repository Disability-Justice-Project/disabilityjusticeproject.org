</div>
<footer
  id="footer"
  class="l-footer">

  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
    <img
      alt="Disability Justice Project."
      role="img"
      class="l-footer__logo"
      src="/wp-content/uploads/2021/06/logo-light-on-dark.svg" />
  </a>

  <?php
    $disabilityjusticeproject_description = get_bloginfo( 'description', 'display' );
    if ( $disabilityjusticeproject_description || is_customize_preview() ) :
    ?>
      <p class="c-footer__tagline"><?php echo $disabilityjusticeproject_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
  <?php endif; ?>

</footer>
  <?php wp_footer(); ?>
  <script src="/wp-content/themes/blankslate-child/js/main.js"></script>
</body>
</html>
