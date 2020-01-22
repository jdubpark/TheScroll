<article class="article textonly">
  <a class="article__wrapper" href="<?php echo get_the_permalink(); ?>">
    <div class="article__content">
      <div class="article__category"><?php echo get_the_category()[0]->name; ?></div>
      <div class="article__title"><?php echo get_the_title(); ?></div>
      <div class="article__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></div>
    </div>
  </a>
</article>
