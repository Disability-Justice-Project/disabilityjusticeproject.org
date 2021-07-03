<?php
  $video_id = get_field('video_id');
  $transcript = get_field('transcript');
  $temp_filmmaker_name = get_field('temp_filmmaker_name');
  $temp_filmmaker_photo = get_field('temp_filmmaker_photo');
  $temp_filmmaker_bio = get_field('temp_filmmaker_bio');
?>

<div class="c-tease-project">
  <div class="c-tease-project__video">
    <div class="u-embed-responsive">
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id; ?>" title="YouTube: <?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
  <div class="c-tease-project__content">
    <h2 class="c-tease-project__title">
      <a class="c-tease-project__link" href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>
    <p class="c-tease-project__excerpt">
      <?php the_excerpt(); ?>
    </p>
    <div class="c-creator">
      <h3 class="c-creator__name">
        <?php echo $temp_filmmaker_name; ?>
      </h3>
      <div class="c-creator__bio">
        <?php if ( ! empty($temp_filmmaker_photo)) : ?>
          <img
            alt="Photo of <?php echo $temp_filmmaker_name; ?>."
            class="c-creator__photo"
            src="<?php echo $temp_filmmaker_photo['url']; ?>">
        <?php endif; ?>
        <div class="c-creator__bio">
          <?php echo $temp_filmmaker_bio; ?>
        </div>
      </div>
    </div>
    <div class="c-tease-project__tools">
      <button
        data-transcript="button"
        aria-pressed="false"
        type="button"
        class="c-tease-project__transcript">
        Transcript<span class="screen-reader-text"> for <?php the_title(); ?></span>
      </button>
      <button type="button" class="c-share__facebook">
        <svg class="c-share__icon" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
        <span class="screen-reader-text">Share on Facebook</span>
      </button>
      <button type="button" class="c-share__twitter">
        <svg class="c-share__icon" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
        <span class="screen-reader-text">Share on Twitter</span>
      </button>
      <button type="button" class="c-share__whatsapp">
        <svg class="c-share__icon" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M259.71 0C121.88 0 10.15 111.73 10.15 249.56c0 68.41 36.21 129.55 36.21 129.55L2.73 512l136.75-43.7s50.76 30.82 120.23 30.82c137.83 0 249.56-111.73 249.56-249.56S397.54 0 259.71 0zm116.82 346.92c-14.82 16-46.34 23.41-61.26 19.23s-64.27-17.08-96.44-47.08-58.24-61.6-68.9-84.89-10.07-37.11-9.47-43.63 4-36.7 24.21-49.64c0 0 6.75-4.27 10.26-4.27h19.66a11.2 11.2 0 017.7 6.41c2.42 5.49 19 44.44 20.23 47.44s4.44 10.44-.72 17.1-16 19.09-16 19.09-4.28 3.85-.57 10S222 263 239 278.26s37.9 26.49 48.3 29.91S300 307 304 301.91s16.39-20.8 16.39-20.8 4.27-6.27 12.68-2.43 49.29 23.65 49.29 23.65a6.66 6.66 0 015.27 6.42c.29 5.55 3.72 22.18-11.1 38.17z"/></svg>
        <span class="screen-reader-text">Share via WhatsApp</span>
      </button>
    </div>
  </div>
  <div class="c-tease-project__accordion-wrapper">
    <section
      aria-hidden="true"
      aria-label="Transcript for <?php the_title(); ?>"
      class="c-tease-project__accordion-content u-flow"
      data-transcript="content"
      tabindex="0">
      <?php echo $transcript; ?>
    </section>
  </div>
</div>
