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
      <p class="c-footer__tagline"><?php echo $disabilityjusticeproject_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
  <?php endif; ?>

</footer>
  <?php wp_footer(); ?>
  <script src="/wp-content/themes/blankslate-child/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/inert-polyfill@0.2.5/inert-polyfill.min.js" integrity="sha256-Eyd34WbRWISxSokarNMU5jEfiZNTno6r8zrbV/CFHrE=" crossorigin="anonymous"></script>
  <script src="/wp-content/themes/blankslate-child/js/aria.modal.min.js"></script>
</body>
</html>
