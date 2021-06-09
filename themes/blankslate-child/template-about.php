<?php
  /*
  Template Name: About Template
  Template Post Type: page
  */

  get_header();
?>

<main id="content">
  <div class="l-about">
    <div class="l-about__content">

      <h1 id="title" class="c-heading__large">
        <?php bloginfo( 'name' ); ?>
      </h1>

      <div class="c-content">
        <?php the_content(); ?>
      </div>
    </div>

    <div class="l-about__content">
      <h2 id="mentors" class="c-heading__large">
        Mentors
      </h2>

      <div class="c-mentor">
          <img
            alt="Photo of Name Here."
            class="c-mentor__photo"
            src="https://raw.githubusercontent.com/Disability-Justice-Project/disabilityjusticeproject.org/main/uploads/2021/05/andrew-pulrang.jpg" />
          <div class="c-mentor__content">
            <h3 class="c-mentor__name">
              Name Here
            </h3>
            <p class="c-mentor__bio">
              Snout snout sodium for the ensnare bosom of the genus pathos and missing. Tundra tundra tocsin for the nutmeg isotope of the peasant ingot and ottoman. Uncle uncle udder for the dunes cloud of the hindu thou and continuum. Vulcan vulcan vocal for the alluvial ovoid of the yugoslav chekhov and revved. Whale whale woman for the meanwhile blowout of the forepaw meadow and glowworm.
            </p>
        </div>
      </div>

    </div>
  </div>
</main>

<?php get_footer(); ?>
