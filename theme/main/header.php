<?php
/**
 * Header file for the Deerfield Scroll default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Deerfield_Scroll
 * @since 1.0.0
 */

 function get_file($rel_dir){
	 $abs_dir = get_template_directory_uri().$rel_dir;
	 return $abs_dir.'?v=1.0.0r1';
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
		<title>The Scroll - DA Student Newspaper</title>
		<?php if (is_front_page()): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/home.min.css')?>" />
		<?php elseif (is_single()): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/single.min.css')?>" />
		<?php elseif (is_category()): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/category.min.css')?>" />
		<?php elseif (is_page('about') or is_page('subscribe') or is_page('contact-us')): ?>
		<link rel="stylesheet" href="<?php echo get_file('/assets/style/_old/trivial.min.css')?>" />
		<?php endif; ?>
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700|Open+Sans:400,600,700&display=swap" rel="stylesheet">
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
				get_template_part('template-parts/nav/nav-main');
			?>
		</div>
