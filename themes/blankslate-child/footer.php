</div>
<footer
  id="footer"
  class="l-footer">

  <p>
    Logo TK
  </p>

  <?php
    $disabilityjusticeproject_description = get_bloginfo( 'description', 'display' );
    if ( $disabilityjusticeproject_description || is_customize_preview() ) :
    ?>
      <p class="c-footer__tagline"><?php echo $disabilityjusticeproject_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
  <?php endif; ?>

</footer>
<?php wp_footer(); ?>
</body>
</html>
