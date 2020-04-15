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
      <div class="site-nav-item left">
        <button id="site-nav-menu-trigger" class="site-nav-menu-trigger">
          <span class="a"></span>
          <span class="b"></span>
          <span class="c"></span>
        </button>
      </div>
      <div class="site-nav-item center">
        <a class="site-nav-icon" href="<?php echo get_site_url(); ?>" title="The Deerfield Scroll"></a>
      </div>
      <div class="site-nav-item right">

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
