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
  $lastposts = get_posts(array(
    'numberposts' => 4,
  ));
?>

<main id="site-content">

  <div class="hfront__stack hfront__stack-alpha hfront__container">
    <div class="hfront__stack-col left">
      <div class="hfront__stack-articles hfront__stack-articles-alpha">
        <?php
          $post = $lastposts[0];
          setup_postdata($post);
          // include(locate_template('template-parts/post/article-preview.php', false, false));
          get_template_part('template-parts/post/article-preview');
        ?>
        <?php
          $post = $lastposts[2];
          setup_postdata($post);
          get_template_part('template-parts/post/article-preview', 'textonly');
        ?>
      </div>
      <div class="hfront__stack-articles hfront__stack-articles-beta">
        <?php
          $post = $lastposts[1];
          setup_postdata($post);
          get_template_part('template-parts/post/article-preview');
        ?>
        <?php
          $post = $lastposts[3];
          setup_postdata($post);
          get_template_part('template-parts/post/article-preview', 'textonly');
          wp_reset_postdata();
        ?>
      </div>
    </div>
    <div class="hfront__stack-col right">
      <a class="weatherwidget-io" href="https://forecast7.com/en/42d54n72d61/deerfield/?unit=us" data-label_1="DEERFIELD" data-days="5" data-theme="pure" >DEERFIELD</a>
      <script>
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
      </script>
    </div>
  </div>

  <div class="hfront__section hfront__section-layout-alpha hfront__container">
    <?php // if ($the_query->have_posts()): ?>
  <?php // while ($the_query->have_posts()) : $the_query->the_post(); ?>

    <?php // the_title(); ?>
    <?php // the_excerpt(); ?>

  <?php // endwhile; ?>
  <?php // wp_reset_postdata(); ?>
<?php // endif; ?>
    <div class="hfront__article">

    </div>
  </div>

</main>

<?php
get_footer();
