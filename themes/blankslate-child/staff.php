<?php if ( has_post_thumbnail() ) : ?>
  <?php the_post_thumbnail('full', array('class' => 'c-mentor__photo')); ?>
<?php endif; ?>
<div class="c-mentor__content">
  <h3 class="c-mentor__name">
    <?php the_title(); ?>
  </h3>
  <div class="c-mentor__bio">
    <?php the_content(); ?>
  </div>
</div>
