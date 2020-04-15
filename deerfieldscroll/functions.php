<?php

global $post;

function posts_load_more_scripts(){
	global $wp_query;

	// In most cases it is already included on the page and this line can be removed
	// wp_enqueue_script('jquery');

	// register our main script but do not enqueue it yet
	wp_register_script('posts_load_more', get_template_directory_uri().'/assets/js/posts-loadmore.js', array('jquery'));

	// now the most interesting part
	// we have to pass parameters to js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	wp_localize_script('posts_load_more', 'postLoadmoreParams', array(
		'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX
		// 'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
		'offset' => 0,
	) );

 	wp_enqueue_script('posts_load_more');
}

add_action('wp_enqueue_scripts', 'posts_load_more_scripts');

function post_load_more_ajax_handler(){
	// if (!isset($_POST['numberposts'], $_POST['category'], $_POST['offset'])) die();
  $args = array(
		'numberposts' => $_POST['numberposts'] ?: 8,
		'category' => $_POST['category'],
		'offset' => $_POST['offset'],
  );
  $posts = get_posts($args);
  $ar_posts = ['posts' => []];

	if ($posts):
		foreach ($posts as $_post):
			$thumbnail_url = get_the_post_thumbnail_url($_post) ?: get_template_directory_uri().'/assets/images/dummy.jpg';
			$post_wrapped =
			'<article class="article has-image">'.
			  '<div class="article__head">'.
			    '<div class="article__date">'.get_the_date('', $_post).'</div>'.
			  '</div>'.
			  '<div class="article__body">'.
			    '<div class="article__wrapper">'.
			      '<div class="article__content">'.
			        '<div class="article__title"><a href="'.get_the_permalink($_post).'">'.get_the_title($_post).'</a></div>'.
			        '<div class="article__excerpt">'.wp_trim_words(get_the_excerpt($_post), 30).'</div>'.
			      '</div>'.
			      '<a class="article__image" href="'.get_the_permalink($_post).'" style="background-image:url('.$thumbnail_url.')"></a>'.
			    '</div>'.
			  '</div>'.
			'</article>';
			$ar_posts['posts'][] = $post_wrapped;
		endforeach;
	endif;

  wp_send_json($ar_posts);
  die();
}

// $.ajax action: post_loadmore
add_action('wp_ajax_post_loadmore', 'post_load_more_ajax_handler');
add_action('wp_ajax_nopriv_post_loadmore', 'post_load_more_ajax_handler');

/* ********************* */
/* Jetpack Related Posts */
/* ********************* */

/* This is required to remove the CSS and JS enqueued in the header */
function jetpackme_no_related_posts( $options ) {
    if ( is_single() ) {
        $options['enabled'] = false;
    }
    return $options;
}

add_filter( 'jetpack_relatedposts_filter_options', 'jetpackme_no_related_posts' );

/* Create shortcode for displaying related posts anywhere in the post */
function labnol_related_shortcode( $atts ) {

    $related_posts = "";

    if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {

        $related = Jetpack_RelatedPosts::init_raw()
            ->set_query_name( 'jetpackme-shortcode' )
            ->get_for_post_id(
                get_the_ID(),
                array( 'size' => 5 ) // How many related posts?
            );

        if ( $related ) {

            foreach ( $related as $result ) {
                $related_post = get_post( $result[ 'id' ] );
                $url = get_permalink($related_post->ID);
                $title = $related_post->post_title;
                $related_posts .= "<li><a href='" . $url . "'>$title</a></li>";
            }
            $related_posts = '<ol>' . $related_posts . '</ol>';
        }

    }

    return $related_posts;
}

/* Create a new shortcode for Jetpack related posts */
add_shortcode( 'labnol_related', 'labnol_related_shortcode' );

/* Do not load the one-big Jetpack concatenated CSS file */
add_filter('jetpack_implode_frontend_css', '__return_false');

/* Dequeue the default styles and jQuery for Jetpack module */
function add_labnol_scripts() {
    if (!is_admin()) {
        wp_dequeue_script('jetpack-related_posts');
        wp_dequeue_style('jetpack-related_posts');
    }
}

add_action("wp_enqueue_scripts", "add_labnol_scripts", 20);

?>
