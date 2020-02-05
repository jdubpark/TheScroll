<article class="article full">
  <div class="article__wrapper">
    <a class="article__image" href="<?php echo get_the_permalink(); ?>" style="background-image:url('<?php echo get_template_directory_uri() ?>/assets/images/dummy.jpg')"></a>
    <div class="article__content">
      <div class="article__title">
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
      </div>
      <div class="article__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></div>
      <div class="article__category"><?php echo get_the_category()[0]->name; ?></div>
    </div>
  </div>
</article>
