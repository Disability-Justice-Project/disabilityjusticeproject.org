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
      <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    <?php
    else :
    ?>
      <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
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
