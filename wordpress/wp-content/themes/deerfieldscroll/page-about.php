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

<main id="site-content">

  <div id="about">
    <div class="triv-block">
      <div class="triv-head">
        <div class="triv-img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/da-msb-960px.jpg" /></div>
      </div>
    </div>
    <div class="triv-block">
      <div class="triv-head">
        <div class="triv-title">About</div>
      </div>
      <div class="triv-body">
        <div class="triv-desc">
        <?php
        // page content
        while (have_posts()):
          // the_content() works only inside a WP loop
          the_post();
          the_content();
        endwhile;
        ?>
        </div>
      </div>
    </div>
    <div class="triv-block">
      <div class="triv-head">
        <div class="triv-title">Staff</div>
      </div>
      <div class="triv-body">
        <div class="triv-desc">
        <?php
        // query for the staff page
        $WPQuery = new WP_Query( 'pagename=staff' );
        while ($WPQuery->have_posts()):
          $WPQuery->the_post();
          the_content();
        endwhile;
        wp_reset_postdata();
        ?>
        </div>
      </div>
    </div>
  </div>

</main>

<?php
get_footer();
