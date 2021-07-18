<?php
  $video_id = get_field('video_id');
  $transcript = get_field('transcript');
?>

<div id="post-<?php the_ID(); ?>" class="l-landing">

  <div class="l-landing__hero">
    <div class="u-embed-responsive">
      <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id; ?>" title="YouTube: <?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>

  <p class="l-landing__topic c-content__topic">
    Film
  </p>
  <h1 id="title" class="l-landing__heading c-heading__large">
    <?php the_title(); ?>
  </h1>

  <?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
</div>

<?php get_template_part('tease-videos');?>
