<?php
  $associated_filmmaker = get_field('associated_filmmaker');
  $behind_the_scenes = get_field('behind_the_scenes');
?>

  <div class="l-landing__byline">
    <aside class="l-landing__share">
      <?php get_template_part('buttons-share');?>
    </aside>
  </div>
  <div class="l-landing__content js-transcript">
    <div class="c-content c-content--project">
      <?php the_content(); ?>

      <div class="c-tease-project__tools">
        <?php get_template_part('buttons-transcript');?>
      </div>
    </div>

    <?php get_template_part('transcript');?>
  </div>

  <img
    alt="Photo of <?php echo esc_html( $associated_filmmaker->post_title ); ?>."
    class="c-filmmaker__photo"
    src="<?php echo get_the_post_thumbnail($associated_filmmaker, 'large'); ?>
  <div id="filmmaker" class="c-filmmaker__content">
    <h3 class="c-filmmaker__name">
      <span class="u-color-text-brick">Filmmaker:</span>
      <?php echo esc_html( $associated_filmmaker->post_title ); ?>
    </h3>
    <div class="c-filmmaker__bio">
      <?php echo( $associated_filmmaker->post_content ); ?>
    </div>
  </div>

  <?php if ( ! empty($behind_the_scenes)) : ?>
    <p class="l-landing__section l-landing__topic c-content__topic">
      Behind the scenes
    </p>
    <div id="behind-the-scenes" class="u-flow c-filmmaker__behind-the-scenes">
      <?php echo $behind_the_scenes; ?>
    </div>
  <?php endif; ?>

</div>


