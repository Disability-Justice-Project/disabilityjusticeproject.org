<?php
  $filmmaker_photo = get_field('filmmaker_photo');
?>

<div class="c-mentor">
  <?php if ( ! empty($filmmaker_photo)) : ?>
    <img
      alt="Photo of <?php the_title(); ?>."
      class="c-mentor__photo"
      src="<?php echo $filmmaker_photo['url']; ?>" />
  <?php endif; ?>
  <div class="c-mentor__content">
    <h3 class="c-mentor__name">
      <?php the_title(); ?>
    </h3>
    <div class="c-mentor__bio">
      <?php the_content(); ?>
    </div>
  </div>
</div>
