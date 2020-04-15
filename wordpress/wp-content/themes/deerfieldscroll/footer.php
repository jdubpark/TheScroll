<footer id="site-footer" class="site-footer">
  <div class="site-footer__container container">
    <div class="site-footer__wrapper">
      <div class="site-footer__head">
        <div class="site-footer__logo">Deerfield Scroll</div>
      </div>
      <div class="site-footer__body">
        <div class="site-footer__block site-footer__block-alpha">
          <div class="site-footer__desc">
            The Deerfield Scroll, established in 1925, is the official student newspaper of Deerfield Academy. The Scroll encourages informed discussion of pertinent issues that concern the Academy and the world. Signed letters to the editor that express legitimate opinions are welcomed. We hold the right to edit for brevity.
          </div>
        </div>
        <div class="site-footer__block site-footer__block-beta">
          <div class="site-footer__list">
            <div class="site-footer__list-title">Discover content</div>
            <ul class="site-footer__list-content">
              <li><a href="<?php echo get_site_url().'/category/news'; ?>">News</a></li>
              <li><a href="<?php echo get_site_url().'/category/features'; ?>">Features</a></li>
              <li><a href="<?php echo get_site_url().'/category/opinion'; ?>">Opinion</a></li>
              <li><a href="<?php echo get_site_url().'/category/editorial'; ?>">Editorial</a></li>
            </ul>
          </div>
        </div>
        <div class="site-footer__block site-footer__block-beta">
          <div class="site-footer__list">
            <div class="site-footer__list-title">More readings</div>
            <ul class="site-footer__list-content">
              <li><a href="<?php echo get_site_url().'/category/arts-and-entertainment'; ?>">Arts</a></li>
              <li><a href="<?php echo get_site_url().'/category/sports'; ?>">Sports</a></li>
              <li><a href="<?php echo get_site_url().'/category/buzz'; ?>">Buzz</a></li>
              <li><a href="<?php echo get_site_url().'/archive/'; ?>">Archive</a></li>
            </ul>
          </div>
        </div>
        <div class="site-footer__block site-footer__block-beta">
          <div class="site-footer__list">
            <div class="site-footer__list-title">The Scroll</div>
            <ul class="site-footer__list-content">
              <li><a href="<?php echo get_site_url().'/about/'; ?>">About</a></li>
              <li><a href="<?php echo get_site_url().'/contact-us/'; ?>">Contact</a></li>
              <li><a href="<?php echo get_site_url().'/subscribe/'; ?>">Subscribe</a></li>
              <li><a href="https://deerfield.edu" target="_blank">DA website</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php if (is_category()): ?>
<script>const wpPageCategory = <?php echo $cat; ?>;</script>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
