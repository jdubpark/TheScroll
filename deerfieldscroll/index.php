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

<main id="site-content">

  <div class="hfront__stack hfront__stack-alpha hfront__container">
    <div class="hfront__stack-col left">
      <div class="hfront__stack-articles hfront__stack-articles-alpha">
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
      <div class="hfront__stack-articles hfront__stack-articles-beta">
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
    <div class="hfront__stack-col right">
      <div class="hfront__stack-item hfront__weather">
        <a class="weatherwidget-io" href="https://forecast7.com/en/42d54n72d61/deerfield/?unit=us" data-label_1="DEERFIELD" data-days="5" data-theme="pure" >DEERFIELD</a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>
      </div>
      <div class="hfront__stack-item">
        <div class="hfront__subscribe">
          <div class="hfront__subscribe-desc">Receive the latest updates and issues (email only)</div>
          <div class="hfront__subscribe-btn"><a href="subscribe">Subscribe to the Scroll</a></div>
        </div>
      </div>
    </div>
  </div>

  <div class="hfront__padding sm"></div>

  <div id="posts-news" class="hfront__block">
    <div class="hfront__prefmt">
      <div class="hfront__section-header">
        <div class="hfront__section-title">Latest News</div>
      </div>
      <div class="hfront__section hfront__section-alpha hfront__container">
        <div class="hfront__section-articles hfront__section-articles-alpha">
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

  <div id="posts-features" class="hfront__block">
    <div class="hfront__prefmt">
      <div class="hfront__section-header">
        <div class="hfront__section-title">The Scroll Features</div>
      </div>
      <div class="hfront__section hfront__section-alpha hfront__container">
        <div class="hfront__section-articles hfront__section-articles-alpha">
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

  <div class="hfront__container">
    <div class="hfront__divider"></div>
  </div>

  <div id="posts-opinion">
    <div class="hfront__prefmt">
      <div class="hfront__section hfront__section-beta hfront__container">
        <div class="hfront__section-articles hfront__section-articles-alpha">
          <?php
          if ($homePosts['opinion']):
            $post = $homePosts['opinion'][0];
            setup_postdata($post);
            get_template_part('template-parts/post/article-preview');
            wp_reset_postdata();
          endif;
          ?>
        </div>
        <div class="hfront__section-articles hfront__section-articles-beta">
          <?php
          if ($homePosts['opinion']):
            foreach (array_slice($homePosts['opinion'], 1) as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-editorial" class="hfront__block">
    <div class="hfront__prefmt">
      <div class="hfront__section-header">
        <div class="hfront__section-title">Editorials</div>
      </div>
      <div class="hfront__section hfront__section-alpha hfront__container">
        <div class="hfront__section-articles hfront__section-articles-alpha">
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
    <div class="hfront__prefmt">
      <div class="hfront__section hfront__section-charlie hfront__container">
        <div class="hfront__section-articles hfront__section-articles-alpha">
          <?php
          if ($homePosts['a&e']):
            foreach (array_slice($homePosts['a&e'], 1) as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div id="posts-ae">
    <div class="hfront__prefmt">
      <div class="hfront__section hfront__section-beta hfront__container">
        <div class="hfront__section-articles hfront__section-articles-beta switch">
          <?php
          if ($homePosts['sports']):
            foreach (array_slice($homePosts['sports'], 1) as $post):
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview');
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
        <div class="hfront__section-articles hfront__section-articles-alpha">
          <?php
          if ($homePosts['sports']):
            $post = $homePosts['sports'][0];
            setup_postdata($post);
            get_template_part('template-parts/post/article-preview');
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="hfront__container">
    <div class="hfront__divider"></div>
  </div>

  <div id="posts-buzz" class="hfront__block">
    <div class="hfront__prefmt">
      <div class="hfront__section-header">
        <div class="hfront__section-title">Deerfield Buzz</div>
      </div>
      <div class="hfront__section hfront__section-alpha hfront__container">
        <div class="hfront__section-articles hfront__section-articles-alpha">
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
