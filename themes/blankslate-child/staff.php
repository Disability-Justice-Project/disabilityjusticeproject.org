<?php
  $staff_title = get_field('staff_title');
?>

<?php if ( has_post_thumbnail() ) : ?>
  <?php the_post_thumbnail('full', array('class' => 'c-mentor__photo')); ?>
<?php endif; ?>
<div class="c-mentor__content">
  <h3 class="c-mentor__name">
    <?php the_title(); ?>
    <?php if ( ! empty($staff_title)) : ?>
      <span class="c-mentor__title">
        <?php echo $staff_title; ?>
      </span>
    <?php endif; ?>
  </h3>
  <div class="c-mentor__bio">
    <?php the_content(); ?>
  </div>
</div>
