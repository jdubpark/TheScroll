<article class="article has-image">
  <div class="article__head">
    <div class="article__date"><?php echo get_the_date(); ?></div>
    <!-- <div class="article__author"><?php //echo get_post_meta(get_the_id()); ?></div> -->
  </div>
  <div class="article__body">
    <div class="article__wrapper">
      <div class="article__content">
        <div class="article__title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
        <div class="article__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></div>
      </div>
      <a class="article__image" href="<?php echo get_the_permalink(); ?>" style="background-image:url('<?php echo get_template_directory_uri() ?>/assets/images/dummy.jpg')"></a>
    </div>
  </div>
</article>
