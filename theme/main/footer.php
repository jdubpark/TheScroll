<footer id="site-footer" class="site-footer">
  <div class="container">
    <section>
      <div class="columns is-multiline">
        <div class="column is-3">
          <ul class="footer-menu">
            <li class="strong">Subscribe</li>
            <li class="strong">Contact</li>
          </ul>
        </div>
        <div class="column is-3">
          <ul class="footer-menu">
            <li class="strong">Keep updated</li>
            <li>Instagram</li>
          </ul>
        </div>
        <div class="column is-6 footer-brief">
          The Deerfield Scroll, established in 1925, is the official student newspaper of Deerfield Academy. The Scroll encourages informed discussion of pertinent issues that concern the Academy and the world. Signed letters to the editor that express legitimate opinions are welcomed. We hold the right to edit for brevity.
        </div>
      </div>
    </section>

    <section>
      <div class="columns is-multiline">
        <div class="column is-2">
          <ul class="footer-menu">
            <li class="strong">The Scroll</li>
            <li>About</li>
            <li>Deerfield</li>
            <li>Search</li>
          </ul>
        </div>

        <div class="column is-2">
          <ul class="footer-menu">
            <li class="strong space">&nbsp;</li>
            <li>Archives</li>
            <li>Latest edition</li>
            <li>News</li>
          </ul>
        </div>

        <div class="column is-2">
          <ul class="footer-menu">
            <li class="strong space">&nbsp;</li>
            <li>Opinion</li>
            <li>Features</li>
            <li>Editorials</li>
          </ul>
        </div>

        <div class="column is-2">
          <ul class="footer-menu">
            <li class="strong space">&nbsp;</li>
            <li>A&E</li>
            <li>Sports</li>
            <li>Buzz</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="small">
      <div class="columns is-multiline">
        <div class="column is-2"><a>Terms of Use</a></div>
        <div class="column is-2"><a>Privacy</a></div>
        <div class="column is-2"><a>Cookie Policy</a></div>
        <div class="column is-6">Copyright © The Deerfield Scroll <?php echo date('Y'); ?>. All rights reserved. Made by <a class="madeby" href="https://parkjongwon.com/?ref=scroll" target="_blank" rel="noopener">Jong Won Park '21</a>.</div>
      </div>
    </section>
  </div>

  <!-- <div class="site-footer__container container">
    <div class="site-footer__wrapper">
      <div class="site-footer__head">
        <div class="site-footer__logo">Deerfield Scroll</div>
      </div>
      <div class="site-footer__body">
        <div class="site-footer__block site-footer__block-t1">
          <div class="site-footer__desc">
            The Deerfield Scroll, established in 1925, is the official student newspaper of Deerfield Academy. The Scroll encourages informed discussion of pertinent issues that concern the Academy and the world. Signed letters to the editor that express legitimate opinions are welcomed. We hold the right to edit for brevity.
          </div>
        </div>
        <div class="site-footer__block site-footer__block-t2">
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
        <div class="site-footer__block site-footer__block-t2">
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
        <div class="site-footer__block site-footer__block-t2">
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
  </div> -->
</footer>

<?php if (is_category()): ?>
<script>const wpPageCategory = <?php echo $cat; ?>;</script>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
