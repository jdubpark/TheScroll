<article class="article full">
  <div class="article__wrapper">
    <a
      class="article__image"
      href="<?php echo get_the_permalink(); ?>"
      <?php if (get_the_post_thumbnail_url()): ?>
      style="background-image:url('<?php echo get_the_post_thumbnail_url() ?>')"
      <?php endif; ?>
    ></a>
    <div class="article__content">
      <div class="article__category"><?php echo get_the_category()[0]->name; ?></div>
      <div class="article__title">
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
      </div>
      <div class="article__excerpt">
        <?php echo get_the_post_thumbnail_url() ? '' : wp_trim_words(get_the_excerpt(), 30); ?>
      </div>
    </div>
  </div>
</article>
