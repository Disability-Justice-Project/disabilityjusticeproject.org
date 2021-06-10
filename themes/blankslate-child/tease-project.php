<div class="c-tease-project">
  <div class="c-tease-project__video">
    <div class="u-embed-responsive">
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/SDdsD5AmKYA" title="YouTube: <?php the_title(); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
  <div class="c-tease-project__content">
    <h2 class="c-tease-project__title">
      <a class="c-tease-project__link" href="<?php the_permalink(); ?>">
        <?php echo $video_id; ?><?php the_title(); ?>
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
      <button type="button" class="c-tease-project__transcript">
        Transcript
      </button>
      <button type="button" class="c-share__facebook">
        <svg class="c-share__icon" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M360.7 284.1l12.5-81.4h-78.1v-52.8c0-22.3 10.9-44 45.9-44h35.5V36.5S344.3 31 313.4 31C249.1 31 207 70 207 140.6v62.1h-71.5v81.4H207V481h88V284.1h65.7z"/></svg>
        <span class="screen-reader-text">Share on Facebook</span>
      </button>
      <button type="button" class="c-share__twitter">
        <svg class="c-share__icon" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 248 204"><path d="M221.95 51.29c.15 2.17.15 4.34.15 6.53 0 66.73-50.8 143.69-143.69 143.69v-.04c-27.44.04-54.31-7.82-77.41-22.64 3.99.48 8 .72 12.02.73 22.74.02 44.83-7.61 62.72-21.66-21.61-.41-40.56-14.5-47.18-35.07a50.338 50.338 0 0022.8-.87C27.8 117.2 10.85 96.5 10.85 72.46v-.64a50.18 50.18 0 0022.92 6.32C11.58 63.31 4.74 33.79 18.14 10.71a143.333 143.333 0 00104.08 52.76 50.532 50.532 0 0114.61-48.25c20.34-19.12 52.33-18.14 71.45 2.19 11.31-2.23 22.15-6.38 32.07-12.26a50.69 50.69 0 01-22.2 27.93c10.01-1.18 19.79-3.86 29-7.95a102.594 102.594 0 01-25.2 26.16z"/></svg>
        <span class="screen-reader-text">Share on Twitter</span>
      </button>
      <button type="button" class="c-share__email">
        <span class="screen-reader-text">Share via Email</span>
      </button>
    </div>
  </div>
</div>
