<?php

global $post;

add_theme_support( 'html5', array( 'search-form' ) );
add_theme_support( 'post-thumbnails' );

// add_theme_support( 'title-tag' );
// add_theme_support( 'custom-logo', array(
//     'height' => 480,
//     'width'  => 720,
// ) );

add_post_type_support( 'page', 'excerpt' );

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
		'offset' => 11, // start at first offset (initial 11 posts are fetched)
	));

 	wp_enqueue_script('posts_load_more');
}

add_action('wp_enqueue_scripts', 'posts_load_more_scripts');

function load_universal_scripts(){
	global $wp_query;
	wp_register_script('universal_scripts', get_template_directory_uri().'/assets/js/universal.js', array('jquery'));
	// wp_localize_script('universal_scripts', 'postLoadmoreParams', array(
	// 	'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX
	// 	// 'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
	// 	'offset' => 11, // start at first offset (initial 11 posts are fetched)
	// ) );
	wp_enqueue_script('universal_scripts');
}

add_action('wp_enqueue_scripts', 'load_universal_scripts');

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
			$thumbnail_url = get_the_post_thumbnail_url($_post);
			$has_image = $thumbnail_url ? ' has-image' : '';
			$no_image = $thumbnail_url ? '' : ' no-image';
			$thumbnail_url_style = $thumbnail_url ? ' style="background-image:url('.$thumbnail_url.')"' : '';
			$post_wrapped =
			'<article class="article'.$has_image.'">'.
			  '<div class="article__head">'.
			    '<div class="article__date">'.get_the_date('', $_post).'</div>'.
			  '</div>'.
			  '<div class="article__body">'.
			    '<div class="article__wrapper">'.
			      '<div class="article__content">'.
			        '<div class="article__title"><a href="'.get_the_permalink($_post).'">'.get_the_title($_post).'</a></div>'.
							'<div class="article__excerpt">'.wp_trim_words(get_the_excerpt($_post), $has_image ? 30 : 40).'</div>'.
			      '</div>'.
						'<a class="article__image cover'.$no_image.'" href="'.get_the_permalink($_post).'"'.$thumbnail_url_style.'></a>'.
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

/**
 * Like get_template_part() put lets you pass args to the template file
 * Args are available in the tempalte as $template_args array
 * @param string filepart
 * @param mixed wp_args style argument list
 */
function hm_get_template_part( $file, $template_args = array(), $cache_args = array() ) {
    $template_args = wp_parse_args( $template_args );
    $cache_args = wp_parse_args( $cache_args );
    if ( $cache_args ) {
        foreach ( $template_args as $key => $value ) {
            if ( is_scalar( $value ) || is_array( $value ) ) {
                $cache_args[$key] = $value;
            } else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
                $cache_args[$key] = call_user_method( 'get_id', $value );
            }
        }
        if ( ( $cache = wp_cache_get( $file, serialize( $cache_args ) ) ) !== false ) {
            if ( ! empty( $template_args['return'] ) )
                return $cache;
            echo $cache;
            return;
        }
    }
    $file_handle = $file;
    do_action( 'start_operation', 'hm_template_part::' . $file_handle );
    if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) )
        $file = get_stylesheet_directory() . '/' . $file . '.php';
    elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
        $file = get_template_directory() . '/' . $file . '.php';
    ob_start();
    $return = require( $file );
    $data = ob_get_clean();
    do_action( 'end_operation', 'hm_template_part::' . $file_handle );
    if ( $cache_args ) {
        wp_cache_set( $file, $data, serialize( $cache_args ), 3600 );
    }
    if ( ! empty( $template_args['return'] ) )
        if ( $return === false )
            return false;
        else
            return $data;
    echo $data;
}

?>
