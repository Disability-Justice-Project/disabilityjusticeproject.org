<?php
  /*
  Template Name: About Template
  Template Post Type: page
  */

  get_header();
  $mentor_last_name = get_field('mentor_last_name');
?>

<main id="content" class="u-dark-on-light">
  <div class="l-landing">

    <div class="l-landing__hero"></div>

    <p id="faq" class="l-landing__topic c-content__topic">
      FAQ
    </p>
    <h1 id="title" class="l-landing__heading c-heading__large">
      About the Disability Justice Project
    </h1>

    <div class="l-landing__content">
      <div class="c-content">
        <nav class="c-content__toc" aria-label="Table of contents">
          <ul>
            <li><a href="#what-is-the-disability-justice-project">What is the Disability Justice Project?</a></li>
            <li><a href="#what-is-participatory-media">What is participatory media?</a></li>
            <li><a href="#what-is-the-disability-justice-project-fellowship">What is the Disability Justice Project Fellowship?</a>
              <ul>
                <li><a href="#who-can-apply-to-djp">Who can apply to DJP?</a></li>
                <li><a href="#what-is-required-of-the-fellows-and-opds">What is required of the fellows and OPDs?</a></li>
              </ul>
            </li>
            <li><a href="#why-the-disability-justice-project-now">Why the Disability Justice Project now?</a></li>
            <li><a href="#accessibility-statement">Accessibility statement</a></li>
            <li><a href="#mentors">Mentors</a></li>
            <li><a href="#staff">Staff</a></li>
          </ul>
        </nav>
        <?php the_content(); ?>
      </div>
    </div>

    <p id="mentors" class="l-landing__section l-landing__topic c-content__topic">
      Our team
    </p>
    <h2 class="l-landing__section l-landing__heading help c-heading__large">
      Mentors
    </h2>

    <?php
      $args = array(
        'category_name' => 'mentor',
        'orderby'       => '$mentor_last_name',
        'order'         => 'ASC',
        'no_found_rows' => true
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('mentor'); ?>
    <?php endwhile; ?>

    <h2 id="staff" class="l-landing__section l-landing__heading help c-heading__large">
      Staff
    </h2>

    <?php
      $args = array(
        'category_name' => 'staff',
        'order'         => 'ASC',
        'no_found_rows' => true
      );
      $query = new WP_Query($args);

      while($query -> have_posts()) : $query -> the_post(); ?>
        <?php get_template_part('staff'); ?>
    <?php endwhile; ?>

      <div class="l-landing__spacer"></div>
  </div>
</main>

<?php get_footer(); ?>
