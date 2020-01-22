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
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/css/normalize.min.css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/css/universal.min.css" />
		<?php if (is_front_page()): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/css/home.min.css" />
		<?php elseif (is_single()): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/css/single.min.css" />
		<?php elseif (is_category()): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/assets/css/category.min.css" />
		<?php endif; ?>
		<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:600|Spectral:400,400i,700,700i|Libre+Baskerville:400,400i|Open+Sans:800&display=swap" rel="stylesheet">
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
				if (is_single()):
					get_template_part('template-parts/nav/nav', 'mini');
				else:
					get_template_part('template-parts/nav/nav', 'home');
				endif;
			?>
		</div>
