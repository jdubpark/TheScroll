<div id="site-nav" class="site-nav-main">
  <?php if (is_home() || is_front_page()): ?>
  <!-- <div id="site-nav-top" class="site-nav-top">
    <div class="container">
      <div class="site-nav-stock stnav__stock">
        <?php //require_once 'livestock.php'; ?>
      </div>
    </div>
  </div> -->
  <?php endif; ?>
  <div id="site-nav-content" class="site-nav-content <?php echo is_home() ? 'home' : 'mini'; ?>">
    <div class="columns">
      <div class="column is-4">
        <a class="site-nav-icon" href="<?php echo get_site_url(); ?>" title="The Deerfield Scroll"></a>
      </div>
      <div class="column is-8">

      </div>
    </div>
  </div>
  <div id="site-nav-menu" class="site-nav-menu">
    <div class="container">
      <ul>
        <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
        <li><a href="<?php echo get_site_url().'/category/news'; ?>">News</a></li>
        <li><a href="<?php echo get_site_url().'/category/features'; ?>">Features</a></li>
        <li><a href="<?php echo get_site_url().'/category/opinion'; ?>">Opinion</a></li>
        <li><a href="<?php echo get_site_url().'/category/editorial'; ?>">Editorial</a></li>
        <li><a href="<?php echo get_site_url().'/category/arts-and-entertainment'; ?>">Arts</a></li>
        <li><a href="<?php echo get_site_url().'/category/sports'; ?>">Sports</a></li>
        <li><a href="<?php echo get_site_url().'/category/buzz'; ?>">Buzz</a></li>
        <!-- <li><a href="<?php echo get_site_url().'/archive'; ?>">Archive</a></li> -->
      </ul>
    </div>
  </div>
</div>
