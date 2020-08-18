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
  $numLast = 11;
  $numQuick = 11;
  $postsLast = get_posts(array(
    'numberposts' => $numLast,
  ));

  $postsQuick = get_posts(array(
    'numberposts' => $numQuick,
    'offset' => $numLast,
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
    <div class="stack-wrapper">
      <div class="stack-section side">
        <div class="stack-row">
          <div class="stack-col fluid">
            <div class="stack-col-head">
              <div class="stack-col-head-name"><span>Quick</span> Browse</div>
            </div>
            <div class="stack-col-body quick">
              <?php
                foreach ($postsQuick as $post){
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview', [
                    'type' => 'hero-quick',
                    'opts' => ['excerpt_trim' => 20],
                  ]);
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="stack-section main">
        <div class="stack-row mod">
          <div class="stack-col fluid">
            <div class="stack-col-head">
              <div class="stack-col-head-name"><span>Latest</span> Headlines</div>
            </div>
          </div>
        </div>
        <div class="stack-row">
          <div class="stack-col left">
            <div class="stack-col-body headlines-1">
              <div class="stack-item">
                <?php
                  $post = $postsLast[0];
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview', ['type' => 'hero-top']);
                ?>
              </div>
              <div class="stack-item">
                <?php
                  $post = $postsLast[1];
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview');
                ?>
                <?php
                  $posts = array_slice($postsLast, 5, 2); // 6, 7
                  foreach ($posts as $post){
                    setup_postdata($post);
                    hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-image-no-excerpt']);
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="stack-col right">
            <div class="stack-col-body headlines-2">
              <?php
                $posts = array_slice($postsLast, 2, 3); // 3, 4, 5
                foreach ($posts as $post){
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview');
                }
              ?>
            </div>
          </div>
        </div>

        <div class="stack-row">
          <div class="stack-col left">
            <div class="stack-col-head">
              <div class="stack-col-head-name"><span>More</span> Headlines</div>
            </div>
            <div class="stack-col-body headlines-3">
              <div class="stack-item">
                <?php
                  $posts = array_slice($postsLast, 7, 2); // 8, 9
                  foreach ($posts as $post){
                    setup_postdata($post);
                    hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-excerpt']);
                  }
                ?>
              </div>
              <div class="stack-item">
                <?php
                  $posts = array_slice($postsLast, 9, 2); // 10, 111
                  foreach ($posts as $post){
                    setup_postdata($post);
                    hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-image-no-excerpt']);
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="stack-col right">
            <div class="stack-col-head">
              <div class="stack-col-head-name"><span>Deerfield, MA</span></div>
            </div>
            <div class="stack-col-body">
              <div class="stack-block">
                <a class="weatherwidget-io" href="https://forecast7.com/en/42d54n72d61/deerfield/?unit=us" data-label_1="DEERFIELD" data-days="5" data-theme="pure" >DEERFIELD</a>
                <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                </script>
              </div>
              <!-- <div class="stack-block">

              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-news" class="hfblock">
    <div class="hfprefmt container">
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
    <div class="hfprefmt container">
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
    <div class="hfprefmt container">
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
              hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-image']);
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-editorial" class="hfblock">
    <div class="hfprefmt container">
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
    <div class="hfprefmt container">
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
    <div class="hfprefmt container">
      <div class="hfsection hfsection-beta hfcontainer">
        <div class="hfsection-articles hfsection-articles-beta switch">
          <?php
          if ($homePosts['sports']):
            foreach (array_slice($homePosts['sports'], 1) as $post):
              setup_postdata($post);
              hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-image']);
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
        <div class="hfsection-articles hfsection-articles-alpha right">
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
    <div class="hfprefmt container">
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
