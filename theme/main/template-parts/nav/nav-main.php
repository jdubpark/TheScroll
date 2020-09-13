<?php
$menu_ok = (isset($template_args) and isset($template_args['menus']));
$menus = [];
if ($menu_ok) $menus = $template_args['menus'];
?>
<div id="site-nav-main" class="site-nav-main">
  <div id="site-nav-content" class="site-nav-content <?php echo is_home() ? 'home' : 'mini'; ?>">
    <div class="container">
      <div class="columns is-mobile">
        <div class="column content-left">
          <div class="site-nav-icon">
            <a href="<?php echo get_site_url(); ?>" title="The Deerfield Scroll"></a>
          </div>
        </div>

        <div class="column content-right">
          <div id="site-nav-menu" class="columns site-nav-menu">
            <div class="column top">
              <div class="columns is-mobile is-multiline">
                <ul class="column is-narrow hide-mobile">
                  <li><a href="<?php echo get_site_url(); ?>">Home</a></li>
                  <li><a href="<?php echo get_site_url(); ?>/edition">Latest edition</a></li>
                </ul>
                <ul class="column">
                  <li class="with-icon site-nav-item-menu site-nav-menu-trigger">
                    <span>Menu</span>
                    <span>Close</span>
                  </li>
                </ul>
                <ul class="column is-narrow-desktop">
                  <li class="with-icon site-nav-item-search site-nav-search-trigger"><span>Search</span></li>
                </ul>
              </div>
            </div>
            <ul class="column top is-narrow hide-mobile">
              <li class="with-icon site-nav-item-subscribe"><a href="<?php echo get_site_url(); ?>/subscribe">Subscribe</a></li>
            </ul>
          </div>

          <div id="site-nav-search" class="site-nav-search">
            <div class="columns is-mobile">
              <div class="column">
                <?php get_search_form(); ?>
              </div>
              <div class="column is-narrow">
                <div class="site-nav-search-close site-nav-search-trigger">Close</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="site-nav-dropdown" class="site-nav-dropdown">
    <div class="container">
      <div class="columns is-multiline">
        <section class="column is-6">
          <div class="columns is-mobile is-multiline">
            <ul class="column is-12">
              <li class="strong">Sections</li>
            </ul>
            <?php
            if ($menu_ok and isset($menus['main'])):
              if (wp_is_mobile()){
                // add home & latest edition for mobile-only
                array_unshift($menus['main'], ['url' => get_site_url().'/edition', 'title' => 'Latest Edition']);
                array_unshift($menus['main'], ['url' => get_site_url(), 'title' => 'Home']);
              }

              $rows = 3;
              $per_col = ceil(count($menus['main']) / $rows);
              for ($i = 0; $i < $rows; $i++):
                $menu_items = array_slice($menus['main'], $i*$per_col, $per_col);
            ?>
              <ul class="column is-half-mobile is-4-desktop">
                <?php foreach ($menu_items as $item): ?>
                <li><a href="<?php echo $item['url'] ?>"><?php echo $item['title'] ?></a></li>
                <?php endforeach; ?>
              </ul>
            <?
              endfor;
            endif;
            ?>
          </div>
        </section>
        <section class="column is-3">
          <div class="columns is-multiline">
            <ul class="column is-12">
              <li class="strong">The Scroll</li>
              <?php
              if ($menu_ok and isset($menus['scroll'])):
                foreach ($menus['scroll'] as $item):
              ?>
              <li><a href="<?php echo $item['url'] ?>"><?php echo $item['title'] ?></a></li>
              <?php
                endforeach;
              endif;
              ?>
            </ul>
          </div>
        </section>
        <section class="column is-3">
          <div class="columns is-multiline">
            <ul class="column is-12">
              <li class="strong">More</li>
              <?php
              if ($menu_ok and isset($menus['more'])):
                foreach ($menus['more'] as $item):
              ?>
              <li><a href="<?php echo $item['url'] ?>"><?php echo $item['title'] ?></a></li>
              <?php
                endforeach;
              endif;
              ?>
            </ul>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- <div id="site-nav-search" class="site-nav-search">

  </div> -->

  <!-- <div id="site-nav-menu" class="site-nav-menu">
    <div class="container is-vcentered is-gapless">
      <ul>
        <?php
          if (isset($template_args) and isset($template_args['list'])):
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
