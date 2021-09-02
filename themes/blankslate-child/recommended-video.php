<?php
  $page_slug = $post->post_name;
  $transcript = get_field('transcript');
  $video_id = get_field('video_id');
?>

<div class="c-recommended-video">
  <div class="u-embed-responsive" onclick="location.href='<?php the_permalink(); ?>'">
    <img
      alt="Video thumbnail for <?php the_title(); ?>."
      class="c-recommended-video__thumbnail"
      src="https://img.youtube.com/vi/<?php echo $video_id; ?>/sddefault.jpg">
  </div>
  <h3 class="c-recommended-video__title">
    <a
      class="c-recommended-video__link"
      href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h3>
  <p class="c-recommended-video__excerpt">
    <span class="c-recommended-video__about-this-video">About this video:</span> <?php echo excerpt(55); ?>
  </p>
</div>
