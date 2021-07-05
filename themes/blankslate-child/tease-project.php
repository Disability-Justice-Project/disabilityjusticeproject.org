<?php
  $video_id = get_field('video_id');
  $transcript = get_field('transcript');
  $temp_filmmaker_name = get_field('temp_filmmaker_name');
  $temp_filmmaker_photo = get_field('temp_filmmaker_photo');
  $temp_filmmaker_bio = get_field('temp_filmmaker_bio');
?>

<div class="c-tease-project">
  <div class="c-tease-project__video">
    <div class="u-embed-responsive">
      <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id; ?>" title="YouTube: <?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
  <div class="c-tease-project__content">

  <h2 class="c-tease-project__title">
    <a class="c-tease-project__link" href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h2>

    <p class="c-tease-project__excerpt">
      <?php the_excerpt(); ?>
    </p>

    <div class="c-creator">
      <h3 class="c-creator__name">
        <?php echo $temp_filmmaker_name; ?>
      </h3>
      <div class="c-creator__bio">
        <?php if ( ! empty($temp_filmmaker_photo)) : ?>
          <img
            alt="Photo of <?php echo $temp_filmmaker_name; ?>."
            class="c-creator__photo"
            src="<?php echo $temp_filmmaker_photo['url']; ?>">
        <?php endif; ?>
        <div class="c-creator__bio">
          <?php echo $temp_filmmaker_bio; ?>
        </div>
      </div>
    </div>

    <div class="c-tease-project__tools">
      <?php get_template_part('buttons-transcript');?>
      <?php get_template_part('buttons-share');?>
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
