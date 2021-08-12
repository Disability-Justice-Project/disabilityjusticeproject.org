<?php
  $transcript = get_field('transcript');
?>

<div class="c-tease-project__accordion-wrapper">
  <section
    aria-hidden="true"
    aria-describedby="transcript-for-<?php echo sanitize_title(get_the_title()) ?>"
    class="c-tease-project__accordion-content u-flow"
    data-transcript="content">
    <h4
      id="transcript-for-<?php echo sanitize_title(get_the_title()) ?>"
      data-transcript="title"
      class="sr-only"
      tabindex="-1">
      Transcript for <?php the_title(); ?>
    </h4>
    <?php echo $transcript; ?>
  </section>
</div>
