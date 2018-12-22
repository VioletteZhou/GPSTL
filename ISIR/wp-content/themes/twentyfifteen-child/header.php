<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyfifteen' ); ?></a>

	<div id="sidebar" class="sidebar">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					twentyfifteen_the_custom_logo();

					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );

					if ( $description || is_customize_preview() ) : ?>

					<?php endif;
				?>

<<<<<<< HEAD
					<?php
=======
					<?php 
>>>>>>> master
					$page1 = get_page_by_title("Team Home");
					$page2 = get_page_by_title("Team Members");
					$page3 = get_page_by_title("Team Axes of research");
					$page4 = get_page_by_title("Team Experimental platforms");
					$page5 = get_page_by_title("Team Publications");
					$page6 = get_page_by_title("Team Links");
					$page7 = get_page_by_title("Team videos");
					$page8 = get_page_by_title("Team videos live");
<<<<<<< HEAD
					$page9 = get_category_by_slug("Team textes");
					$page10 = get_category_by_slug("Team photos");

					?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page1->ID ); ?>">Home</a><div>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_category_link($page9->term_id); ?>">Textes</a><div>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_category_link($page10->term_id); ?>">Photos</a><div>	
=======

				
					?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page1->ID ); ?>">Home</a><div>
>>>>>>> master
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page2->ID ); ?>">Members</a><div>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page3->ID ); ?>">Axes of research</a><div>
        		<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page4->ID ); ?>">Experimental platforms</a><div>
        		<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page5->ID ); ?>">Publications</a><div>
				<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page6->ID ); ?>">Links</a><div>
			<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page7->ID ); ?>">Videos</a><div>
			<div class="row" style="margin:25px auto"><a href="<?php echo get_permalink( $page8->ID ); ?>">Videos live</a><div>
			</div><!-- .site-branding -->
		</header><!-- .site-header -->

	</div><!-- .sidebar -->

	<div id="content" class="site-content">
