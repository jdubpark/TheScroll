<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Search
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Deerfield_Scroll
 * @since 1.0.0
 */

 get_header();

 global $query_string;
 wp_parse_str($query_string, $search_query);

 $posts_per_page = 10;
 // $search_query['posts_per_page'] = $posts_per_page;

 $results = new WP_Query($search_query);
 $total_results = $results->found_posts;

 # search based on content
 // $results = $wpdb->get_results( "SELECT * FROM wp_posts WHERE post_content LIKE '%phrase%'" )

?>

<main id="site-content" class="site-content search">
  <section>
    <div class="container search-cover">
      <div class="columns is-multiline">
        <div class="column is-12 is-non-post">
          <div class="search-cover-head">
            <div class="columns is-multiline">
              <div class="column is-12 is-non-post">
                <div class="search-cover-title">
                  <i>Found <?php echo $total_results; ?> results for:</i> <span><?php echo the_search_query(); ?></span>
                </div>
              </div>
              <div class="column is-12 is-non-post">
                <div class="search-cover-amnt">
                  <i>displaying <?php echo $posts_per_page; ?> per page by date</i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="columns is-multiline">
        <div class="search-cover-content">
          <?php
          if (have_posts()):
          ?>
          <div class="column is-12 is-non-post">
            <div class="search-cover-pagination at-top">
              <?php echo paginate_links(); ?>
            </div>
          </div>
          <?php
            while (have_posts()):
          ?>
          <div class="column is-12">
          <?php
              the_post(); // setup_postdata($post);
              hm_get_template_part('template-parts/post/article-preview', [
                'type' => 'search',
                'opts' => ['excerpt_trim' => 40]
              ]);
          ?>
          </div>
          <?php
            endwhile;
          ?>
          <div class="column is-12 is-non-post">
            <div class="search-cover-pagination at-bottom">
              <?php echo paginate_links(); ?>
            </div>
          </div>
          <?php
          endif;
          ?>
        </div>
      </div>
    </div>
  </section>
</main>
