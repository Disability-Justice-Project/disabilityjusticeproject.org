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
    <div class="l-footer__donate c-donate">
      <p class="c-footer__tagline"><?php echo $disabilityjusticeproject_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
      <p class="c-footer__donate-message">Help us shift the narrative on disability justice&nbsp;<a class="c-footer__donate-button" href="https://secure.donationpay.org/documentaries/film_no_stats.php?f=disabilityjusticeproject">Donate</a></p>
    </div>
  <?php endif; ?>

  <nav class="l-footer__social" aria-label="Social">
    <p class="c-footer-social__follow-us">Follow us</p>
    <ul class="c-footer-social__list">
      <li><a class="c-footer-social__list__link" href="https://twitter.com/TheDJP_">Twitter</a></li>
      <li><a class="c-footer-social__list__link" href="https://www.instagram.com/disabilityjusticeproject/">Instagram</a></li>
      <li><a class="c-footer-social__list__link" href="https://www.facebook.com/disabilityjusticeproject">Facebook</a></li>
      <li><a class="c-footer-social__list__link" href="https://www.youtube.com/channel/UCs2FCoVoUXTjZkNFwo2thmw">YouTube</a></li>
      <li><a class="c-footer-social__list__link" href="https://www.linkedin.com/company/disability-justice-project">LinkedIn</a></li>
      <!-- <li><a class="c-footer-social__list__link c-footer-social__list__link--howto" href="">How to use this site</a></li> -->
    </ul>
  </nav>

  <div class="l-footer__partnership c-partnership">
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

</footer>
  <?php wp_footer(); ?>
  <script src="/wp-content/themes/blankslate-child/js/main.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/wp-content/themes/blankslate-child/vendor/ableplayer/thirdparty/js.cookie.js"></script>
  <script src="/wp-content/themes/blankslate-child/vendor/ableplayer/build/ableplayer.min.js"></script>
</body>
</html>
