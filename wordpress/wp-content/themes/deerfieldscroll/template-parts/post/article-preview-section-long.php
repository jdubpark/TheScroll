<article class="article<?php echo get_the_post_thumbnail_url() ? ' has-image' : ''; ?>">
  <div class="article__head">
    <div class="article__date"><?php echo get_the_date(); ?></div>
    <!-- <div class="article__author"><?php //echo get_post_meta(get_the_id()); ?></div> -->
  </div>
  <div class="article__body">
    <div class="article__wrapper">
      <div class="article__content">
        <div class="article__title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
        <div class="article__excerpt">
          <?php echo wp_trim_words(get_the_excerpt(), get_the_post_thumbnail_url() ? 30 : 40); ?>
        </div>
      </div>
      <a
        class="article__image cover<?php echo get_the_post_thumbnail_url() ? '' : ' no-image'; ?>"
        href="<?php echo get_the_permalink(); ?>"
        <?php if (get_the_post_thumbnail_url()): ?>
        style="background-image:url('<?php echo get_the_post_thumbnail_url() ?>')"
        <?php endif; ?>
      ></a>
    </div>
  </div>
</article>
