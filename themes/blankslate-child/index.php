<?php get_header(); ?>
<main id="content">

<div class="c-update-banner">
  <p class="c-update-banner__message">
    New videos <span class="color-text-gray-brick">Documentaries from Kenya and South Africa</span>
  </p>
</div>

<div class="c-project-tease">
  <div class="c-project-tease__video">
    <div class="embed-responsive">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/qdQsx7LCIlI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
  <div class="c-project-tease__content">
    <h2 class="c-project-tease__title">
      Documentary title headline
    </h2>
    <p class="c-project-tease__excerpt">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pulvinar aliquam erat nec egestas. Vestibulum sed ultricies odio.
    </p>
    <div class="c-creator">
      <h3 class="c-creator__name">
        Creator Name Here
      </h3>
      <div class="c-creator__bio">
        <img
          alt="Photo of Creator Name."
          class="c-creator__photo"
          src="https://raw.githubusercontent.com/Disability-Justice-Project/disabilityjusticeproject.org/main/uploads/2021/05/britt-young-300x300.jpg" />
        <p class="c-creator__excerpt">
          Nam id iaculis justo. Duis dignissim est metus. Nam placerat turpis ut bibendum venenatis. In in egestas purus. <a class="c-creator__read-more" href="#">Read more</a>
        </p>
      </div>
    </div>
    <div class="c-project-tease__tools">
      <button type="button" class="c-project-tease__transcript">
        Transcript
      </button>
      <button type="button" class="c-share__facebook">
        <span class="screen-reader-text">Share on Facebook</span>
      </button>
      <button type="button" class="c-share__twitter">
        <span class="screen-reader-text">Share on Twitter</span>
      </button>
      <button type="button" class="c-share__email">
        <span class="screen-reader-text">Share via Email</span>
      </button>
    </div>
  </div>
</div>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php comments_template(); ?>
<?php endwhile; endif; ?>
<?php get_template_part( 'nav', 'below' ); ?>
</main>

<?php get_footer(); ?>
