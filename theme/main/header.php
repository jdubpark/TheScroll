<?php
/**
 * Header file for the Deerfield Scroll default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage DA_Scroll
 * @since 1.0
 */

 function get_file($rel_dir){
	 $abs_dir = get_template_directory_uri().$rel_dir;
	 return $abs_dir.'?v=1.0r1';
 }

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?> style="margin-top:0 !important;">

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="parkjongwon.com" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
		<title>The Deerfield Scroll - DA Student Newspaper</title>
		<?php if (is_front_page()): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/home.min.css')?>" />
		<?php elseif (is_single()): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/single.min.css')?>" />
		<?php elseif (is_category()): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/category.min.css')?>" />
		<?php elseif (is_page('about') or is_page('subscribe') or is_page('contact-us')): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/trivial.min.css')?>" />
		<?php endif; ?>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Noto+Serif:wght@400;700&family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
		<!-- Gentium+Basic:400 -->
		<noscript>
			You need to enable JavaScript to run this app.
		</noscript>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146912859-2"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'UA-146912859-2');
		</script>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<div id="header">
			<?php
        // $menus = wp_get_nav_menus();
        $menus = ['main' => [], 'scroll' => [], 'more' => []];
        $menus_slug = [
          'main' => 'main-menu',
          'scroll' => 'scroll-menu',
          'more' => 'more-menu',
        ];
        foreach ($menus_slug as $menu_key => $menu_slug){
          $menu_items = wp_get_nav_menu_items($menu_slug, ['update_post_term_cache' => false]);
          if ($menu_items){
            foreach ($menu_items as $menu_item){
              if ($menu_item->post_type !== 'nav_menu_item') continue;
              $title = trim($menu_item->title);
              if (strtolower($title) == 'home') continue;
              $menus[$menu_key][] = array(
                'title' => $title,
                'url' => $menu_item->url
              );
            }
          }
        }

        hm_get_template_part('template-parts/nav/nav-main', ['menus' => $menus])
			?>
		</div>
