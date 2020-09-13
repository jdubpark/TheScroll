<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Latest Edition
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Deerfield_Scroll
 * @since 1.0.0
 */

 get_header();

?>

<main id="site-content" class="site-content edition">
  <section>
    <div class="container edition-cover">
      <div class="columns is-mobile is-multiline">
        <div class="column is-12 edition-cover-title">
          Getting ready...
        </div>

        <div class="column is-12 edition-cover-image-wrapper">
          <div class="edition-cover-image"></div>
        </div>

        <div class="column is-12 edition-cover-desc">
          <p>
            The Scroll is currently working on assembling the <strong>latest edition</strong> page. Please check this page again in a week or two.
          </p>
          <span><a href='https://pngtree.com/so/isometric'>image from pngtree.com</a></span>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
