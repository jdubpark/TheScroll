<form id="search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="columns is-mobile">
    <div class="column is-narrow">
      <span class="search-label">Search</span>
    </div>
    <div class="column">
      <input type="text" class="search-field" name="s" value="<?php echo get_search_query(); ?>">
    </div>
    <div class="column is-narrow">
      <button class="search-btn" type="submit"><span></span></button>
    </div>
  </div>
</form>
