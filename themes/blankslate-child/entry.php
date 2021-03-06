<?php
  $video_id = get_field('video_id');
  $transcript = get_field('transcript');
?>

<div id="post-<?php the_ID(); ?>" class="l-landing">

  <div id="title" class="l-landing__hero">
    <div class="u-embed-responsive">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video_id; ?>/&cc_load_policy=1?color=white" title="YouTube: <?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
<!--
    <video
      id="<?php echo sanitize_title(get_the_title()) ?>"
      data-able-player
      data-youtube-id="<?php echo $video_id; ?>"
      data-root-path="/wp-content/themes/blankslate-child/vendor/ableplayer/"
      data-heading-level="2"
      preload="auto"
      playsinline
      poster="https://img.youtube.com/vi/<?php echo $video_id; ?>/sddefault.jpg">
    </video>
-->
  </div>

  <p class="l-landing__topic c-content__topic">
    Film
  </p>
  <h1 class="l-landing__heading c-heading__large">
    <?php the_title(); ?>
  </h1>

  <?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
</div>

<?php get_template_part('tease-videos');?>
<?php get_template_part('newsletter-signup');?>
