<?php
/**
 * Add Support for Theme Addons
 *
 * @package Donovan
 */

/**
 * Register support for Jetpack and theme addons
 */
function donovan_theme_addons_setup() {

	// Add theme support for Donovan Pro plugin.
	add_theme_support( 'donovan-pro' );

	// Add theme support for ThemeZee Plugins.
	add_theme_support( 'themezee-breadcrumbs' );

	// Add theme support for Widget Bundle.
	add_theme_support( 'themezee-widget-bundle', array(
		'thumbnail_size' => array( 100, 80 ),
		'svg_icons'      => true,
	) );

	// Add theme support for Related Posts.
	add_theme_support( 'themezee-related-posts', array(
		'thumbnail_size' => array( 640, 360 ),
	) );

	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrapper',
		'footer_widgets' => 'footer',
		'wrapper'        => false,
		'render'         => 'donovan_infinite_scroll_render',
		'posts_per_page' => 6,
	) );

	// Add Theme Support for wooCommerce.
	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'donovan_theme_addons_setup' );


/**
 * Custom render function for Infinite Scroll.
 */
function donovan_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', esc_attr( donovan_get_option( 'blog_content' ) ) );
	}
}


/**
 * Set wrapper start for wooCommerce
 */
function donovan_wrapper_start() {
	echo '<section id="primary" class="content-area">';
	echo '<main id="main" class="site-main" role="main">';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'donovan_wrapper_start', 10 );


/**
 * Set wrapper end for wooCommerce
 */
function donovan_wrapper_end() {
	echo '</main><!-- #main -->';
	echo '</section><!-- #primary -->';
}
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'donovan_wrapper_end', 10 );
