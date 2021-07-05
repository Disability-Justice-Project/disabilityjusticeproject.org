<?php
  $transcript = get_field('transcript');
  $temp_filmmaker_name = get_field('temp_filmmaker_name');
  $temp_filmmaker_photo = get_field('temp_filmmaker_photo');
  $temp_filmmaker_bio = get_field('temp_filmmaker_bio');
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

  </div>

  <?php if ( ! empty($temp_filmmaker_photo)) : ?>
    <img
      alt="Photo of <?php echo $temp_filmmaker_name; ?>."
      class="c-filmmaker__photo"
      src="<?php echo $temp_filmmaker_photo['url']; ?>" />
  <?php endif; ?>
  <div class="c-filmmaker__content">
    <h3 class="c-filmmaker__name">
      <?php echo $temp_filmmaker_name; ?>
    </h3>
    <div class="c-filmmaker__bio">
      <?php echo $temp_filmmaker_bio; ?>
    </div>
  </div>


