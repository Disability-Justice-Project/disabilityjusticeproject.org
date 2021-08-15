<?php
  $audio_version = get_field('audio_version');
?>

<div class="c-audio-player__wrapper">
  <audio
    id="audio-version"
    data-able-player
    data-able-player preload="auto">
    <source type="audio/mpeg" src="<?php echo $audio_version['url']; ?>"/>
  </audio>
</div>
