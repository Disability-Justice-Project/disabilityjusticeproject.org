<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Disability_Justice_Project
 */

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="/wp-content/themes/blankslate-child/images/favicon.ico">
  <link rel="icon" href="/wp-content/themes/blankslate-child/images/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="/wp-content/themes/blankslate-child/images/apple-touch-icon.png">

  <meta property="og:type" content="website">
  <meta property="og:url" content="https://disabilityjusticeproject.com/">
  <meta property="og:title" content="Disability Justice Project">
  <meta property="og:description" content="A global grassroots media network centering the voices of persons with disabilities.">
  <meta property="og:image" content="/wp-content/themes/blankslate-child/images/share-image-facebook.png">

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://disabilityjusticeproject.com/">
  <meta property="twitter:title" content="Disability Justice Project">
  <meta property="twitter:description" content="A global grassroots media network centering the voices of persons with disabilities.">
  <meta property="twitter:image" content="/wp-content/themes/blankslate-child/images/share-image-twitter.png">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'disabilityjusticeproject' ); ?></a>

<header
  id="masthead"
  class="l-header">
  <?php
    the_custom_logo();
    if ( is_front_page() && is_home() ) :
    ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img
          alt="Disability Justice Project."
          role="img"
          class="l-header__logo"
          src="/wp-content/uploads/2021/06/logo-light-on-dark.svg" />
      </a>
    <?php
    else :
    ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img
          alt="Disability Justice Project."
          class="l-header__logo"
          src="/wp-content/uploads/2021/06/logo-light-on-dark.svg" />
      </a>
    <?php
  endif; ?>


  <nav
    id="primary-navigation"
    class="main-navigation c-nav-primary"
    aria-label="Primary">
<!--
    <button
      class="menu-toggle"
      aria-controls="primary-menu"
      aria-expanded="false">
        <?php esc_html_e( 'Primary Menu', 'blankslate-child' ); ?>
    </button>
-->
    <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
  </nav>
</header>
