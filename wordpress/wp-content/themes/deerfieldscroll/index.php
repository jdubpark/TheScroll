<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Deerfield_Scroll
 * @since 1.0.0
 */

 // https://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query
 // A declaration that we are using the global WordPress variable $post in order
 // to make the Template Tags work (they will not be populated by setup_postdata() properly otherwise):
 // global $post;

 get_header();
 // if (is_front_page()):
 //   get_header('front');
 // else:
 //   get_header();
 // endif;
?>

<?php
  // the query
  // https://wordpress.stackexchange.com/questions/144343/wp-reset-postdata-or-wp-reset-query-after-a-custom-loop
  // $the_query = new WP_Query(array(
  //   // 'category_name' => 'news',
  //   'posts_per_page' => 3,
  // ));
  $postsLast = get_posts(array(
    'numberposts' => 4,
  ));

  $postsQuick = get_posts(array(
    'numberposts' => 10,
    'exclude' => $excludeLast,
  ));

  $excludeLast = [];
  if ($postsLast):
    foreach ($postsLast as $postLast):
      $excludeLast[] = $post->ID;
    endforeach;
  endif;

  $fetchCats = ['news', 'features', 'opinion', 'editorial', 'a&e', 'sports', 'buzz'];
  $homePosts = [];

  foreach ($fetchCats as $fetchCat){
    $homePosts[$fetchCat] = get_posts(array(
      'numberposts' => 4,
      'category' => get_cat_ID($fetchCat),
      'exclude' => $excludeLast,
    ));
  }
?>

<main id="site-content" class="nopad">

  <div id="home-top" class="stack hero">
    <div class="stack-section">
      <div class="stack-col left">
        <div class="stack-col-head">
          <div class="stack-col-head-name"><span>Quick</span> Browse</div>
        </div>
        <div class="stack-col-body quick">
          <?php
            foreach ($postsQuick as $post){
              setup_postdata($post);
              hm_get_template_part('template-parts/post/article-preview.php', [
                'type' => 'hero-quick',
                'opts' => ['excerpt_trim' => 20],
              ]);
            }
          ?>
        </div>
      </div>
      <div class="stack-col center">
        <div class="stack-col-head">
          <div class="stack-col-head-name"><span>Headlines</span></div>
        </div>
        <div class="stack-col-body headlines">
          <?php
            $post = $postsLast[0];
            setup_postdata($post);
            hm_get_template_part('template-parts/post/article-preview.php', ['type' => 'hero-top']);
          ?>
          <?php
            $post = $postsLast[1];
            setup_postdata($post);
            get_template_part('template-parts/post/article-preview');
          ?>
        </div>
      </div>
      <div class="stack-col right">
        <div class="stack-col-body">
          <a class="weatherwidget-io" href="https://forecast7.com/en/42d54n72d61/deerfield/?unit=us" data-label_1="DEERFIELD" data-days="5" data-theme="pure" >DEERFIELD</a>
          <script>
          !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
          </script>
        </div>
      </div>
    </div>
  </div>

  <div id="hfront-top" class="hfstack hfstack-alpha hfcontainer">
    <div class="hfstack-col left">
      <div class="hfstack-articles hfstack-articles-alpha">
        <?php
          $post = $postsLast[0];
          setup_postdata($post);
          // include(locate_template('template-parts/post/article-preview.php', false, false));
          get_template_part('template-parts/post/article-preview');
        ?>
        <?php
          $post = $postsLast[2];
          setup_postdata($post);
          get_template_part('template-parts/post/article-preview');
        ?>
      </div>
      <div class="hfstack-articles hfstack-articles-beta">
        <?php
          $post = $postsLast[1];
          setup_postdata($post);
          get_template_part('template-parts/post/article-preview');
        ?>
        <?php
          $post = $postsLast[3];
          setup_postdata($post);
          get_template_part('template-parts/post/article-preview');
          wp_reset_postdata();
        ?>
      </div>
    </div>
    <div class="hfstack-col right">
      <div class="hfstack-item hfweather">
        <a class="weatherwidget-io" href="https://forecast7.com/en/42d54n72d61/deerfield/?unit=us" data-label_1="DEERFIELD" data-days="5" data-theme="pure" >DEERFIELD</a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>
      </div>
      <div class="hfstack-item">
        <div class="hfsubscribe">
          <div class="hfsubscribe-desc">Receive the latest updates and issues (email only)</div>
          <div class="hfsubscribe-btn"><a href="subscribe">Subscribe to the Scroll</a></div>
        </div>
      </div>
    </div>
  </div>

  <div class="hfpadding sm"></div>

  <div id="posts-news" class="hfblock">
    <div class="hfprefmt">
      <div class="hfsection-header">
        <div class="hfsection-title">Latest News</div>
      </div>
      <div class="hfsection hfsection-alpha hfcontainer">
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['news']):
            foreach ($homePosts['news'] as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'switch');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-features" class="hfblock">
    <div class="hfprefmt">
      <div class="hfsection-header">
        <div class="hfsection-title">The Scroll Features</div>
      </div>
      <div class="hfsection hfsection-alpha hfcontainer">
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['features']):
            foreach ($homePosts['features'] as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'switch');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="hfcontainer">
    <div class="hfdivider"></div>
  </div>

  <div id="posts-opinion">
    <div class="hfprefmt">
      <div class="hfsection hfsection-beta hfcontainer">
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['opinion']):
            $post = $homePosts['opinion'][0];
            setup_postdata($post);
            get_template_part('template-parts/post/article-preview', 'big');
            wp_reset_postdata();
          endif;
          ?>
        </div>
        <div class="hfsection-articles hfsection-articles-beta">
          <?php
          if ($homePosts['opinion']):
            foreach (array_slice($homePosts['opinion'], 1) as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'textonly');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-editorial" class="hfblock">
    <div class="hfprefmt">
      <div class="hfsection-header">
        <div class="hfsection-title">Editorials</div>
      </div>
      <div class="hfsection hfsection-alpha hfcontainer">
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['editorial']):
            foreach ($homePosts['editorial'] as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'switch');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-ae">
    <div class="hfprefmt">
      <div class="hfsection hfsection-charlie hfcontainer">
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['a&e']):
            foreach (array_slice($homePosts['a&e'], 1) as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'ae');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-sports">
    <div class="hfprefmt">
      <div class="hfsection hfsection-beta hfcontainer">
        <div class="hfsection-articles hfsection-articles-beta switch">
          <?php
          if ($homePosts['sports']):
            foreach (array_slice($homePosts['sports'], 1) as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'textonly');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['sports']):
            $post = $homePosts['sports'][0];
            setup_postdata($post);
            get_template_part('template-parts/post/article-preview', 'big');
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="hfcontainer">
    <div class="hfdivider"></div>
  </div>

  <div id="posts-buzz" class="hfblock">
    <div class="hfprefmt">
      <div class="hfsection-header">
        <div class="hfsection-title">Deerfield Buzz</div>
      </div>
      <div class="hfsection hfsection-alpha hfcontainer">
        <div class="hfsection-articles hfsection-articles-alpha">
          <?php
          if ($homePosts['buzz']):
            foreach ($homePosts['buzz'] as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview', 'switch');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

</main>

<?php
get_footer();
