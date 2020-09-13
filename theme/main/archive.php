<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Archives
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

 $year = get_query_var('year') ? absint(get_query_var('year')) : null;
 $month = get_query_var('monthnum') ? absint(get_query_var('monthnum')) : null;

 $display_posts = false;
 if ($year > 2000 and $month){
   $display_posts = true;
   $args = [
     'post_type' => 'post',
     'posts_per_page' => -1,
     'date_query' => [
       [
         'year' => $year,
         'month' => $month,
       ],
     ],
   ];
   $posts_query = new WP_Query($args);
   // var_dump($posts_query);
 }
?>

<main id="site-content" class="site-content archive">

  <section>
    <div class="container archive-cover">
      <div class="columns archive-cover-level">
        <div class="column is-12 archive-cover-head">
          <div class="archive-cover-title">Archives</div>
        </div>
      </div>

      <div class="columns is-multiline archive-cover-level">
        <?php
        // default archive page
        echo '<div class="column is-12 archive-cover-monthly">';
        wp_custom_archive(['type' => 'monthly']);
        echo '</div>';

        // get archive by year and month
        if ($display_posts):
        ?>
        <div class="column is-12 archive-cover-time">
          <span><?php echo $year; ?></span>
          <span><?php echo $wp_locale->get_month($month); ?></span>
        </div>

        <div class="column is-12 archive-cover-posts">
          <div class="columns is-multiline">
            <?php
            if (have_posts()):
              while (have_posts()):
                the_post();
                echo '<div class="column is-12">';
                hm_get_template_part('template-parts/post/article-preview', ['type' => 'archive']);
                echo '</div>';
              endwhile;
            endif;
            ?>
          </div>
        </div>

        <?php
        endif;
        ?>
      </div>
    </div>
  </section>

</main>
<?php
get_footer();
