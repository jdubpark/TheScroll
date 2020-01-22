<div id="site-nav" class="site-nav-main">
  <div id="site-nav-top" class="site-nav-top">
    <div class="container">
      <div class="site-nav-stock stnav__stock">
        <?php require_once 'livestock.php'; ?>
      </div>
    </div>
  </div>
  <div id="site-nav-content" class="site-nav-content">
    <div class="container">
      <a class="site-nav-icon" href="./" title="The Deerfield Scroll"></a>
      <div class="site-nav-info">
        <div class="site-nav-info-item"><?php echo date('l, M j, Y'); ?></div>
        <div class="site-nav-info-item"><i>Be Worthy of Your Heritage</i></div>
        <div class="site-nav-info-item">Print Edition</div>
        <div class="site-nav-info-item">About</div>
      </div>
    </div>
  </div>
  <div id="site-nav-bottom">
    <div class="site-nav-category">
      <ul class="container">
        <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
        <li><a href="<?php echo get_site_url().'/category/news'; ?>">News</a></li>
        <li><a href="<?php echo get_site_url().'/category/features'; ?>">Features</a></li>
        <li><a href="<?php echo get_site_url().'/category/opinion'; ?>">Opinion</a></li>
        <li><a href="<?php echo get_site_url().'/category/editorial'; ?>">Editorial</a></li>
        <li><a href="<?php echo get_site_url().'/category/arts-and-entertainment'; ?>">Arts</a></li>
        <li><a href="<?php echo get_site_url().'/category/sports'; ?>">Sports</a></li>
        <li><a href="<?php echo get_site_url().'/category/buzz'; ?>">Buzz</a></li>
        <li><a href="<?php echo get_site_url().'/archives'; ?>">Archives</a></li>
      </ul>
    </div>
  </div>
</div>
