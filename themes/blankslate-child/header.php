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

<a
  class="c-skipnav"
  href="#title">
  <?php esc_html_e( 'Skip to main content', 'disabilityjusticeproject' ); ?>
</a>

<header
  id="masthead"
  class="l-header">
  <?php
    the_custom_logo();
    if ( is_front_page() && is_home() ) :
    ?>
      <div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <?php get_template_part('logo');?>
        </a>
      </div>
    <?php
    else :
    ?>
      <div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <?php get_template_part('logo');?>
        </a>
      </div>
    <?php
  endif; ?>

  <div class="l-header__accessibility-settings">
    <button
      aria-expanded="false"
      id="accessibility-settings-toggle"
      class="c-accessibility-settings__toggle"
      type="button">
      <svg
        class="c-accessibility-settings__toggle-icon"
        aria-hidden="true"
        focusable="false"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M49.86,0A49.87,49.87,0,1,0,99.73,49.86,49.86,49.86,0,0,0,49.86,0Zm-.75,9.9a6.46,6.46,0,1,1-6.44,6.44A6.45,6.45,0,0,1,49.11,9.9ZM77.05,30.73,57.87,33.15V52.36l9.3,31a3.61,3.61,0,0,1-2.63,4.4,3.56,3.56,0,0,1-4.4-2.54L50.62,57H47.68L38.93,85.83a3.6,3.6,0,0,1-4.71,2A3.74,3.74,0,0,1,32,83.12l8-30.45V33.15l-17.67-2.4a3.21,3.21,0,0,1-2.9-3.56,3.33,3.33,0,0,1,3.59-3L44.5,26h9.41l22.87-1.89a3.31,3.31,0,0,1,.27,6.62Z"/></svg>
      <span class="c-accessibility-settings__toggle-label"><span class="c-accessibility-settings__phrase-switch">Accessibility </span>Settings</span>
    </button>
  </div>

  <nav
    id="primary-navigation"
    class="main-navigation l-header__nav c-nav-primary"
    aria-label="Primary">
    <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
    <?php get_search_form(); ?>
  </nav>
</header>

<?php get_template_part('accessibility-settings-modal');?>

</div>
