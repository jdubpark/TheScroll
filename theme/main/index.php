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
  $numLast = 8;
  $numQuick = 12;
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

  $fetchCats = [
    'news' => 5,
    'features' => 5,
    'opinion' => 6, 'editorial' => 5, 'a&e' => 5, 'sports' => 5, 'buzz' => 5];
  $homePosts = [];

  foreach ($fetchCats as $fetchCat => $numpost){
    $homePosts[$fetchCat] = get_posts(array(
      'numberposts' => $numpost,
      'category' => get_cat_ID($fetchCat),
      'exclude' => $excludeLast,
    ));
  }
?>

<main id="site-content" class="site-content home">
  <section>
    <div class="container hero front-cover">
      <div class="columns is-multiline">
        <section class="column is-3 is-topmost front-cover-quick front-cover-level">
          <div class="front-cover-head">
            <div class="front-cover-title"><strong>Quick</strong> browse</div>
          </div>

          <div class="front-cover-body">
            <?php
            foreach ($postsQuick as $post){
              setup_postdata($post);
              hm_get_template_part('template-parts/post/article-preview', [
                'type' => 'hero-quick',
                'opts' => ['excerpt_trim' => 22],
              ]);
            }
            ?>
          </div>
        </section>

        <section class="column is-9 is-topmost front-cover-main front-cover-level">
          <section class="columns is-multiline front-cover-wrap">
            <div class="column is-12 front-cover-head">
              <div class="front-cover-title"><strong>Latest</strong> headlines</div>
            </div>

            <div class="column is-7 front-cover-focus front-cover-level">
              <div class="front-cover-body">
                <div class="front-cover-ftop">
                  <?php
                  $post = $postsLast[0];
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview', ['type' => 'hero-top']);
                  ?>
                </div>

                <div class="front-cover-fsup">
                  <?php
                  $posts = [$postsLast[2], $postsLast[4]];
                  foreach ($posts as $idx => $post){
                    setup_postdata($post);
                    if ($idx % 2 == 1) hm_get_template_part('template-parts/post/article-preview', ['type' => 'flip-image']);
                    else hm_get_template_part('template-parts/post/article-preview');
                  }
                  ?>
                </div>
              </div>
            </div>

            <div class="column is-5 front-cover-side front-cover-level">
              <div class="front-cover-body">
                <?php
                $posts = [$postsLast[1], $postsLast[3], $postsLast[5]];
                foreach ($posts as $post){
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview');
                }
                ?>
              </div>
            </div>
          </section>

          <section class="columns is-multiline front-cover-wrap">
            <div class="column is-7 front-cover-more front-cover-level">
              <div class="front-cover-head">
                <div class="front-cover-title"><strong>Look</strong> through</div>
              </div>

              <section class="columns is-multiline front-cover-body">
                <div class="column is-6 is-last">
                  <?php
                  $post = $postsLast[6];
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-excerpt']);
                  ?>
                </div>

                <div class="column is-6 is-last">
                  <?php
                  $post = $postsLast[7];
                  setup_postdata($post);
                  hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-excerpt']);
                  ?>
                </div>
              </section>
            </div>

            <div class="column is-5 front-cover-deerfield front-cover-level">
              <div class="front-cover-head">
                <div class="front-cover-title"><strong>Deerfield, MA</strong></div>
              </div>

              <div class="front-cover-body">
                <a class="weatherwidget-io" href="https://forecast7.com/en/42d54n72d61/deerfield/?unit=us" data-label_1="DEERFIELD" data-days="5" data-theme="pure" >DEERFIELD</a>
                <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
                </script>
              </div>
            </div>
          </section>
        </section>
      </div>
    </div>
  </section>

  <section>
    <div class="container cover-news cover-divi news">
      <div class="columns is-multiline">
        <div class="column is-12">
          <div class="cover-full-title">
            <a href="//category/news"><strong>Latest</strong> news <span></span></a>
          </div>
        </div>
        <?php
        if ($homePosts['news']):
          foreach ($homePosts['news'] as $post):
            setup_postdata($post);
            echo '<div class="column is-one-fifth">';
            hm_get_template_part('template-parts/post/article-preview', [
              'type' => 'no-category',
              'opts' => ['excerpt_trim' => 20],
            ]);
            echo '</div>';
          endforeach;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <section>
    <div class="container cover-opinion cover-divi opinion">
      <div class="columns is-multiline">
        <div class="column is-12">
          <div class="cover-full-title">
            <a href="//category/opinion"><strong>Opinion</strong> columns <span></span></a>
          </div>
        </div>
        <?php
        if ($homePosts['opinion']):
          foreach ($homePosts['opinion'] as $post):
            setup_postdata($post);
            echo '<div class="column is-4">';
            hm_get_template_part('template-parts/post/article-preview', [
              'type' => 'plain-text',
              'opts' => ['excerpt_trim' => 30],
            ]);
            echo '</div>';
          endforeach;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <section>
    <div class="container cover-features cover-divi features">
      <div class="columns is-multiline">
        <div class="column is-12">
          <div class="cover-full-title">
            <a href="//category/features"><strong>The Scroll</strong> features <span></span></a>
          </div>
        </div>
        <?php
        if ($homePosts['features']):
          foreach ($homePosts['features'] as $post):
            setup_postdata($post);
            echo '<div class="column is-one-fifth">';
            hm_get_template_part('template-parts/post/article-preview', [
              'type' => 'no-category',
              'opts' => ['excerpt_trim' => 20],
            ]);
            echo '</div>';
          endforeach;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- <section>
    <div class="container cover-opinion opinion">
      <div class="columns is-multiline">
        <div class="column is-12">
          <div class="cover-full-title">
            <a href="//category/opinion"><strong>Deerfield</strong> Buzz <span></span></a>
          </div>
        </div>
      </div>
    </div>
    <div class="column is-5">
      <?php
      if ($homePosts['opinion']):
        $post = $homePosts['opinion'][0];
        setup_postdata($post);
        hm_get_template_part('template-parts/post/article-preview');
        wp_reset_postdata();
      endif;
      ?>
    </div>

    <div class="column is-7">
      <div class="columns is-multiline">
        <?php
        if ($homePosts['opinion']):
          foreach (array_slice($homePosts['opinion'], 1) as $post):
            setup_postdata($post);
            echo '<div class="column is-12">';
            hm_get_template_part('template-parts/post/article-preview', ['type' => 'no-image']);
            echo '</div>';
          endforeach;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section> -->
</main>

<!-- <main id="site-content" class="nopad">

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

</main> -->

<?php
get_footer();
