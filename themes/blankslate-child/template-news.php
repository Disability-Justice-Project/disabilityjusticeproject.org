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
      <div class="l-landing__hero">
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
    <h1 id="title" class="l-landing__heading c-heading__large">
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
  <div class="l-tease-news">
    <h2 class="l-tease-news__title">
      News <span class="u-color-text-gray-brick">From the Frontlines of Disability Justice</span>
    </h2>
    <div class="l-tease-news__posts">
      <?php
        $args = array(
          'category_name' => 'news',
          'posts_per_page' => 3,
          'no_found_rows' => true
        );
        $query = new WP_Query($args);

        while($query -> have_posts()) : $query -> the_post(); ?>
          <?php get_template_part('tease-news'); ?>
      <?php endwhile; ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
