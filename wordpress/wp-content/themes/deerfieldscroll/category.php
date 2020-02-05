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
 global $post;

 get_header();

 $get_posts = get_posts(array(
   'numberposts' => 11, // 3 main + 8 long
   'category' => $cat,
   'offset' => 0,
 ));

 // for dev
 $get_posts = array_merge($get_posts, $get_posts, $get_posts, $get_posts);
 // end dev

 $posts_main = array_slice($get_posts, 0, 3);
 $posts_long = array_slice($get_posts, 3, 8);

?>

<main id="site-content" class="nopad">

  <div class="container">
    <div class="category__wrapper">
      <div class="category__container">
        <div class="category__head">
          <div class="category__title"><?php echo single_cat_title(); ?></div>
        </div>
        <div class="category__body category__body-alpha">
          <div class="category__articles-main category__articles-main-alpha">
            <?php
              $post = $posts_main[0];
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview');
            ?>
          </div>
          <div class="category__articles-main category__articles-main-beta">
            <?php
              $post = $posts_main[1];
              setup_postdata($post);
              get_template_part('template-parts/post/article-preview');
            ?>
          </div>
          <div class="category__articles-main category__articles-main-beta">
              <?php
                $post = $posts_main[2];
                setup_postdata($post);
                get_template_part('template-parts/post/article-preview');
              ?>
          </div>
        </div>
      </div>
      <div class="category__container">
        <div class="category__head category__head-beta">
          <div class="category__title category__title-beta">Latest <?php echo single_cat_title(); ?> Headlines</div>
        </div>
        <div class="category__body">
          <div class="category__block category__block-left">
            <div class="category__articles-long">
              <?php
              foreach ($posts_long as $_post):
                $post = $_post;
                setup_postdata($post);
                get_template_part('template-parts/post/article-preview', 'section-long');
              endforeach;
              wp_reset_postdata();
              ?>
            </div>
          </div>
          <div class="category__block category__block-right">
            <div class="category__articles-side">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
<?php
get_footer();
