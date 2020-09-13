<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Category
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

 $num_main_posts = 3;
 $posts_per_page = 10;
 $posts_main = get_posts(array(
   'numberposts' => $num_main_posts, // 3 main
   'category' => $cat, // passed from url querystring (e.g. /category/CAT_NAME => cat_id)
 ));
 $posts_main_ids = [];
 foreach ($posts_main as $post) $posts_main_ids[] = $post->ID;

 $paged = (get_query_var('page')) ? absint(get_query_var('page')) : 1;

 $args = [
   'post_type' => 'post',
   'posts_per_page' => $posts_per_page,
   'cat' => $cat,
   'paged' => $paged,
   'post__not_in' => $posts_main_ids,
   // 'comment_count' => array(
   //      'value' => 25,
   //      'compare' => '>=',
   //  )
 ];

 // echo 'PAGE';
 // echo $paged;

 $the_query = new WP_Query($args);

 $big = 999999999; // need an unlikely integer
 $pagination = paginate_links([
   // don't change (default setting):
   // 'base' => $pagenum_link (http://example.com/all_posts.php%_% : %_% is replaced by format (below).)
   'format' => '?page=%#%', // %#% is replaced by the page number.
   'current' => max(1, $paged),
   'total' => $the_query->max_num_pages,
 ]);

?>

<main id="site-content" class="site-content category">

  <section>
    <div class="container category-cover">
      <div class="columns category-cover-level">
        <div class="column is-12 category-cover-head">
          <div class="category-cover-title"><?php echo single_cat_title(); ?></div>
        </div>
      </div>

      <div class="columns category-cover-level">
        <div class="column is-5 category-cover-ftop">
          <div class="columns">
            <div class="column is-12">
              <?php
                $post = $posts_main[0];
                setup_postdata($post);
                hm_get_template_part('template-parts/post/article-preview');
              ?>
            </div>
          </div>
        </div>
        <div class="column is-7 category-cover-fsup">
          <div class="columns is-multiline">
            <?php
            $posts = [$posts_main[1], $posts_main[2]];
            foreach ($posts as $post):
              setup_postdata($post);
              echo '<div class="column is-6">';
              hm_get_template_part('template-parts/post/article-preview', [
                'opts' => ['excerpt_trim' => 20],
              ]);
              echo '</div>';
            endforeach;
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container category-headlines">
      <div class="columns category-headlines-level">
        <div class="column is-12 category-headlines-head">
          <div class="category-headlines-title">Latest <?php echo single_cat_title(); ?> headlines</div>
        </div>
      </div>

      <div class="columns category-headlines-level">
        <div class="column is-9 category-headlines-all">
          <div class="columns is-multiline">
            <div class="column is-12 is-non-post">
              <div class="category-headlines-pagination at-top">
                <?php echo $pagination; ?>
              </div>
            </div>
            <?php
            if ($the_query->have_posts()):
              while ($the_query->have_posts()):
                $the_query->the_post();
                echo '<div class="column is-12">';
                // get_template_part('template-parts/post/article-preview', 'section-long');
                hm_get_template_part('template-parts/post/article-preview', ['type' => 'category-all']);
                echo '</div>';
              endwhile;
            ?>
            <div class="column is-12 is-non-post">
              <div class="category-headlines-pagination at-bottom">
                <?php echo $pagination; ?>
              </div>
            </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
