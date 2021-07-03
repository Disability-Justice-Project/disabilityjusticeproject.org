<?php
  $mentor_photo = get_field('filmmaker_photo');
?>

<?php if ( ! empty($mentor_photo)) : ?>
  <img
    alt="Photo of <?php the_title(); ?>."
    class="c-filmmaker__photo"
    src="<?php echo $mentor_photo['url']; ?>" />
<?php endif; ?>
<div class="c-filmmaker__content">
  <h3 class="c-heading__medium c-filmmaker__name">
    <?php the_title(); ?>
  </h3>
  <div class="c-filmmaker__bio">
    <?php the_content(); ?>
  </div>
</div>
