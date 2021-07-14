<?php
  $associated_filmmaker = get_field('associated_filmmaker');
  $page_slug = $post->post_name;
  $transcript = get_field('transcript');
  $video_id = get_field('video_id');
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
      <span class="c-creator__about-this-video">About this video:</span> <?php echo excerpt(35); ?>
    </p>

    <div class="c-creator">
      <h3 class="c-creator__name">
        Filmmaker: <span class="c-creator__name-link" onclick="location.href='<?php the_permalink(); ?>'"><?php echo esc_html( $associated_filmmaker->post_title ); ?></span>
      </h3>
      <div class="c-creator__info">
        <img
          alt="Photo of <?php echo esc_html( $associated_filmmaker->post_title ); ?>."
          class="c-creator__photo"
          onclick="location.href='<?php the_permalink(); ?>'"
          src="<?php echo get_the_post_thumbnail($associated_filmmaker, 'large'); ?>
        <p class="c-creator__bio">
          <?php echo esc_html( $associated_filmmaker->post_excerpt ); ?>&nbsp;
          <a class="c-creator__read-more" href="<?php the_permalink(); ?>">
            Read&nbsp;more<span class="screen-reader-text"> about <?php echo esc_html( $associated_filmmaker->post_title ); ?></span>
          </a>
        </p>
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
      aria-describedby="transcript-for-<?php echo sanitize_title(get_the_title()) ?>"
      class="c-tease-project__accordion-content u-flow"
      data-transcript="content">
      <h4
        id="transcript-for-<?php echo sanitize_title(get_the_title()) ?>"
        data-transcript="title"
        class="screen-reader-text"
        tabindex="-1">
        Transcript for <?php the_title(); ?>
      </h4>
      <?php echo $transcript; ?>
    </section>
  </div>

</div>
