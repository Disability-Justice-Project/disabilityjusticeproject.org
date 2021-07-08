<?php
  $associated_filmmaker = get_field('associated_filmmaker');
  $behind_the_scenes = get_field('behind_the_scenes');
  $transcript = get_field('transcript');
?>

  <div class="l-landing__byline">
    <aside class="l-landing__share">
      <?php get_template_part('buttons-share');?>
    </aside>
  </div>
  <div class="l-landing__content">
    <div class="c-content c-content--project">
      <?php the_content(); ?>

      <div class="c-tease-project__tools">
        <button
          data-transcript="button"
          aria-pressed="false"
          type="button"
          class="c-tease-project__transcript">
          Transcript<span class="screen-reader-text"> for <?php the_title(); ?></span>
        </button>
      </div>
    </div>

    <div class="c-tease-project__accordion-wrapper">
      <section
        aria-hidden="true"
        aria-label="Transcript for <?php the_title(); ?>"
        class="c-tease-project__accordion-content u-flow"
        data-transcript="content"
        tabindex="0">
      <?php echo $transcript; ?>
      </section>
    </div>

    <?php if ( ! empty($behind_the_scenes)) : ?>
      <div class="c-content c-content--behind-the-scenes">
        <h1 class="c-heading__large">
          Behind the scenes
        </h1>
        <?php echo $behind_the_scenes; ?>
      </div>
    <?php endif; ?>
  </div>

  <img
    alt="Photo of <?php echo esc_html( $associated_filmmaker->post_title ); ?>."
    class="c-filmmaker__photo"
    src="<?php echo get_the_post_thumbnail($associated_filmmaker, 'large'); ?>
  <div id="filmmaker" class="c-filmmaker__content">
    <h3 class="c-filmmaker__name">
      <?php echo esc_html( $associated_filmmaker->post_title ); ?>
    </h3>
    <div class="c-filmmaker__bio">
      <?php echo esc_html( $associated_filmmaker->post_excerpt ); ?>
    </div>
  </div>


