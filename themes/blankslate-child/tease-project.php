<?php
  $video_id = get_field('video_id');
  $transcript = get_field('transcript');
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
        Creator Name Here
      </h3>
      <div class="c-creator__bio">
        <img
          alt="Photo of Creator Name."
          class="c-creator__photo"
          src="https://raw.githubusercontent.com/Disability-Justice-Project/disabilityjusticeproject.org/main/uploads/2021/05/britt-young-300x300.jpg" />
        <p class="c-creator__excerpt">
          Nam id iaculis justo. Duis dignissim est metus. Nam placerat turpis ut bibendum venenatis. In in egestas purus. <a class="c-creator__read-more" href="<?php the_permalink(); ?>">Read more</a>
        </p>
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
      <button type="button" class="c-share__email">
        <svg class="c-share__icon" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"></path></svg>
        <span class="screen-reader-text">Share via Email</span>
      </button>
    </div>
  </div>
  <div class="c-tease-project__accordion-wrapper">
    <section
      aria-hidden="true"
      aria-label="Transcript for <?php the_title(); ?>"
      class="c-tease-project__accordion-content u-flow"
      data-transcript="content"
      tabindex="-1">
      <?php echo $transcript; ?>
    </section>
  </div>
</div>
