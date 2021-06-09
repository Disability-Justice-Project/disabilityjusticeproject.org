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
        <span class="screen-reader-text">Share on Facebook</span>
      </button>
      <button type="button" class="c-share__twitter">
        <span class="screen-reader-text">Share on Twitter</span>
      </button>
      <button type="button" class="c-share__email">
        <span class="screen-reader-text">Share via Email</span>
      </button>
    </div>
  </div>
</div>
