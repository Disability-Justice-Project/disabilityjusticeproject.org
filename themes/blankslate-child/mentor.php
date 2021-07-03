<?php
  $mentor_photo = get_field('mentor_photo');
?>


<?php if ( ! empty($mentor_photo)) : ?>
  <img
    alt="Photo of <?php the_title(); ?>."
    class="c-mentor__photo"
    src="<?php echo $mentor_photo['url']; ?>" />
<?php endif; ?>
<div class="c-mentor__content">
  <h3 class="c-mentor__name">
    <?php the_title(); ?>
  </h3>
  <div class="c-mentor__bio">
    <?php the_content(); ?>
  </div>
</div>
