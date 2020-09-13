<footer id="site-footer" class="site-footer">
  <div class="container">
    <section>
      <div class="columns is-multiline footer-top-menu">
        <div class="column is-3">
          <ul class="footer-menu">
            <li class="strong"><a href="<?php echo get_site_url(); ?>/subscribe">Subscribe</a></li>
            <li class="strong"><a href="<?php echo get_site_url(); ?>/contact">Contact</a></li>
          </ul>
        </div>
        <div class="column is-3">
          <ul class="footer-menu">
            <li class="strong">Stay updated</li>
            <li><a href="https://www.instagram.com/deerfieldscroll/?hl=en" target="_blank" rel="noopener nofollow">Instagram</a></li>
          </ul>
        </div>
        <div class="column is-6 footer-brief">
          The Deerfield Scroll, established in 1925, is the official student newspaper of Deerfield Academy. The Scroll encourages informed discussion of pertinent issues that concern the Academy and the world. Signed letters to the editor that express legitimate opinions are welcomed. We hold the right to edit for brevity.
        </div>
      </div>
    </section>

    <section>
      <div class="columns is-mobile is-multiline footer-all-menu">
        <?php
        $menu_items = wp_get_nav_menu_items('footer-menu');
        if (isset($menu_items)):
          // filter only nav menu items
          $menu_items = array_filter($menu_items, function($item){return $item->post_type == 'nav_menu_item';});
          $per_col = 3;
          $rows = ceil(count($menu_items) / $per_col);
          for ($i = 0; $i < $rows; $i++):
            $batched = array_slice($menu_items, $i*$per_col, $per_col);
        ?>
        <div class="column is-half-mobile is-2-desktop">
          <ul class="footer-menu">
            <?php
            // menu item head (only first one is filled)
            if ($i == 0) echo '<li class="strong">The Scroll</li>';
            else echo '<li class="strong space">&nbsp;</li>';
            // menu items
            foreach ($batched as $item){
              echo '<li><a href="'.$item->url.'">'.$item->title.'</a></li>';
            }
            ?>
          </ul>
        </div>
        <?php
          endfor;
        endif;
        ?>
      </div>
    </section>

    <section class="small">
      <div class="columns is-multiline">
        <div class="column is-2"><a href="<?php echo get_site_url(); ?>/policy#use">Terms of Use</a></div>
        <div class="column is-2"><a href="<?php echo get_site_url(); ?>/policy#privacy">Privacy</a></div>
        <!-- <div class="column is-2"><a href="<?php echo get_site_url(); ?>/policy#cookie">Cookie Policy</a></div> -->
        <div class="column is-6">Copyright © The Deerfield Scroll <?php echo date('Y'); ?>. All rights reserved. Made by <a class="madeby" href="https://parkjongwon.com/?ref=scroll" target="_blank" rel="noopener">Jong Won Park '21</a>.</div>
      </div>
    </section>
  </div>
</footer>

<?php if (is_category()): ?>
<script>const wpPageCategory = <?php echo $cat; ?>;</script>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
