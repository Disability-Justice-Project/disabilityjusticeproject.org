<?php
  $contact_prompt = get_field('contact_prompt');
?>

<aside class="c-contact-form">
  <details class="c-contact-form__disclosure">
    <summary role="button" class="c-contact-form__summary">
      <span class="u-color-text-gray-darkest c-contact-form__title">
        Have you experienced discrimination because because of your disability?
      </span>
      <span class="u-color-text-brick c-contact-form__subtitle">
        We want to hear your story.
      </span>
    </summary>
    <form>
      <legend class="sr-only">
        Contact
      </legend>
      <?php echo do_shortcode( '[contact-form-7 id="384" title="Your Story"]' ); ?>
    </form>
  </details>
</aside>
