<?php

function contact_function($atts, $content = null) {
  return '
  <aside class="l-contact-form c-contact-form">
    <details class="c-contact-form__disclosure">
      <summary role="button" class="c-contact-form__summary">
        <span class="c-contact-form__title">
          ' . $content . '
        </span>
        <span class="c-contact-form__subtitle">
          We want to hear your story.
        </span>
      </summary>
      <form>
        <legend class="sr-only">
          Contact
        </legend>
        <div class="c-contact-form__lockup">
          <div class="c-contact-form__consent">
            <label class="c-contact-form__label" for="consent">I consent to have my story published by the Disability Justice Project</label>
            <input class="c-contact-form__checkbox" id="consent" name="consent" type="checkbox">
            <a class="c-contact-form__mail-button" href=" mailto:disabilityjusticesocialmedia@gmail.com?subject=Your%20story&body=Tell%20us%20your%20story%20here.%20Include%20images%20or%20video%20if%20it%20will%20help%20tell%20the%20story.">Tell us your story</a>
          </div>
        </div>
      </form>
    </details>
  </aside>
  ';
}
add_shortcode('contact', 'contact_function');

?>
