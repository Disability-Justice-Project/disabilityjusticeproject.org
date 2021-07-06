<?php
  $audio_version = get_field('audio_version');
?>

<audio
  class="c-audio-player"
  controls
  src="<?php echo $audio_version['url']; ?>"
  style="height: var(--size-600); margin-top: var(--size-150); padding: 0; border: none;">
    Your browser does not support the <code>audio</code> element. <a download href="<?php echo $audio_version['url']; ?>">Download the audio</a> instead.
</audio>

<!--
<div class="c-audio-player">
  <p class="c-audio-player__label">
    Play audio version
  </p>
  <button
    data-audio-player="toggle"
    class="c-audio-player__button"
    type="button">
    <svg aria-hidden="true" focusable="false" class="c-audio-player__icon" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M34.77 16.978L8.479.545C6.076-.93 3 .755 3 3.58v32.824c0 2.823 3.118 4.55 5.478 3.034L34.77 23.004c2.233-1.349 2.233-4.635 0-6.026z" fill="#FFF" fill-rule="nonzero"/></svg>
    <span class="screen-reader-text">Play</span>
  </button>
  <div
    data-audio-player="track"
    class="c-audio-player__track"></div>
  <p
    data-audio-player="timestamp"
    class="c-audio-player__timestamp">
    4:37
  </p>
</div>
-->
