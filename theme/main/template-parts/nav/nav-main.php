<div id="site-nav" class="site-nav-main">

  <!-- <div id="site-nav-bar" class="site-nav-bar">
    <div class="container">
      <div class="columns">
      </div>
    </div>
  </div> -->

  <div id="site-nav-content" class="site-nav-content <?php echo is_home() ? 'home' : 'mini'; ?>">
    <div class="container">
      <div class="columns">
        <div class="column content-left">
          <div class="site-nav-icon">
            <a href="<?php echo get_site_url(); ?>" title="The Deerfield Scroll"></a>
          </div>
        </div>
        <div class="column content-right">
          <div id="site-nav-menu" class="site-nav-menu columns">
            <ul class="column">
              <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
              <li><a href="<?php echo get_site_url(); ?>/editions">Latest edition</a></li>
            </ul>
            <ul class="column stretch">
              <li class="with-icon site-nav-item-menu"><span>Menu</span></li>
            </ul>
            <ul class="column">
              <li class="with-icon site-nav-item-search"><span>Search</span></li>
            </ul>
            <ul class="column">
              <li class="with-icon site-nav-item-subscribe"><span>Subscribe</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div id="site-nav-menu-full" class="site-nav-menu-full">

  </div> -->
  <!-- <div id="site-nav-search" class="site-nav-search">

  </div> -->

  <!-- <div id="site-nav-menu" class="site-nav-menu">
    <div class="container is-vcentered is-gapless">
      <ul>
        <?php
          if (isset($template_args)):
            foreach ($template_args['list'] as $item):
        ?>
        <li><a href="<?php echo $item['url'] ?>"><?php echo $item['title'] ?></a></li>
        <?php
            endforeach;
          endif;
        ?>
      </ul>
    </div>
  </div> -->
</div>
