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
      <p class="c-footer__tagline">Help us shift the narrative on disability justice <a class="c-footer_donate-button" href="">Donate</a></p>
      <div class="c-partnership__lockup">
        <p class="c-partnership__byline">
          A strategic partnership with
        </p>
        <a class="c-partnership__link" href="https://disabilityrightsfund.org/">
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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/wp-content/themes/blankslate-child/vendor/ableplayer/thirdparty/js.cookie.js"></script>
  <script src="/wp-content/themes/blankslate-child/vendor/ableplayer/build/ableplayer.min.js"></script>
</body>
</html>
