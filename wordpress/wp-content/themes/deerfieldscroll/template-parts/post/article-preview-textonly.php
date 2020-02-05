<article class="article textonly">
  <div class="article__wrapper">
    <div class="article__content">
      <div class="article__category"><?php echo get_the_category()[0]->name; ?></div>
      <div class="article__title">
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
      </div>
      <div class="article__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></div>
    </div>
  </div>
</article>
