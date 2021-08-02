<?php
  /*
  Template Name: News Post
  Template Post Type: post
  */

  get_header();
  $byline = get_field('byline');
  $audio_version = get_field('audio_version');
  $hero = get_the_post_thumbnail_url();
?>

<main id="content" class="u-dark-on-light">
  <div class="l-landing">

    <?php if ( ! empty($hero)) : ?>
      <div id="title" class="l-landing__hero">
        <figure
          class="c-content__hero"
          role="figure"
          aria-label="<?php the_post_thumbnail_caption() ?>">
          <?php the_post_thumbnail('full'); ?>
          <figcaption>
            <?php the_post_thumbnail_caption() ?>
          </figcaption>
        </figure>
      </div>
    <?php endif; ?>

    <p class="l-landing__topic c-content__topic">
      News
    </p>
    <h1 <?php if ( ! ($hero)) : ?>id="title"<?php endif; ?> class="l-landing__heading c-heading__large">
      <?php the_title(); ?>
    </h1>


    <div class="l-landing__byline">
      <?php if ( ! empty($byline)) : ?>
        <p>
          By <?php echo $byline; ?>
        </p>
      <?php endif; ?>
      <aside class="l-landing__share">
        <?php get_template_part('buttons-share');?>
      </aside>
    </div>


    <div class="l-landing__content">
      <div class="c-content">
        <?php if ( ! empty($audio_version)) : ?>
          <h2 class="c-audio-player__title">
            Listen now
          </h2>
          <?php get_template_part('audio-player'); ?>
        <?php endif; ?>
        <?php the_content(); ?>
      </div>
    </div>



  </div>
  <?php get_template_part('recent-news');?>
</main>

<?php get_footer(); ?>
