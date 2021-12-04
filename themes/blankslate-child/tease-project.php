<?php
  $associated_filmmaker = get_field('associated_filmmaker');
  $page_slug = $post->post_name;
  $transcript = get_field('transcript');
  $video_id = get_field('video_id');
?>

<div class="c-tease-project js-transcript">
  <div class="c-tease-project__video">
    <div class="u-embed-responsive">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video_id; ?>/&cc_load_policy=1" title="YouTube: <?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
<!--
      <video
      id="<?php echo sanitize_title(get_the_title()) ?>"
      data-able-player
      data-youtube-id="<?php echo $video_id; ?>"
      data-root-path="/wp-content/themes/blankslate-child/vendor/ableplayer/"
      data-heading-level="3"
      preload="auto"
      playsinline
      poster="https://img.youtube.com/vi/<?php echo $video_id; ?>/sddefault.jpg">
      <track kind="captions">
    </video>
    -->
  </div>
  <div class="c-tease-project__content">

    <h2 class="c-tease-project__title">
      <span aria-hidden="true" class="c-creator__about-this-video">About this video</span>
      <a class="c-tease-project__link" href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>

    <p class="c-tease-project__excerpt">
      <?php echo excerpt(35); ?>
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
            Read&nbsp;more<span class="sr-only"> about <?php echo esc_html( $associated_filmmaker->post_title ); ?></span>
          </a>
        </p>
      </div>
    </div>

    <div class="c-tease-project__tools">
      <?php get_template_part('buttons-transcript');?>
      <?php get_template_part('buttons-share');?>
    </div>

  </div>

  <?php get_template_part('transcript');?>

</div>
