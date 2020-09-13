<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Contact
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

<main id="site-content" class="site-content contactus">

  <section>
    <div class="container contactus-cover">
      <div class="columns is-multiline">
        <div class="column is-12 contactus-cover-title">Contact</div>

        <div class="column is-12">
          <?php
          $page_query = new WP_Query('pagename=contact');
          if ($page_query->have_posts()){
            $page_query->the_post();
            the_content();
          }
          wp_reset_postdata();
          ?>
        </div>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
