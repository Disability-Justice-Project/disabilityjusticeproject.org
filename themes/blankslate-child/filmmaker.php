<?php echo the_post_thumbnail('large', ['class' => 'c-filmmaker__photo']); ?>
<div class="c-filmmaker__content">
  <h3 id="<?php echo sanitize_title(get_the_title()) ?>" class="c-filmmaker__name">
    <?php the_title(); ?>
  </h3>
  <div class="c-filmmaker__bio">
    <?php the_content(); ?>
  </div>
</div>
