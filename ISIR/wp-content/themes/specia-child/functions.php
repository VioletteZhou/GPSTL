<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


if ( ! function_exists( 'specia_setup' ) ) :
function specia_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_theme_textdomain( 'specia', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary_menu' => esc_html__( 'Primary Menu', 'specia' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );


	add_theme_support('custom-logo');

	/*
	 * WooCommerce Plugin Support
	 */
	add_theme_support( 'woocommerce' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', specia_google_font() ) );

	// add Textes category
  //create the main category
  wp_insert_term(

  // the name of the category
  'Textes',

  // the taxonomy, which in this case if category (don't change)
  'category',

  array(

  // what to use in the url for term archive
  'slug' => 'Textes',
  ));

	// Add videos page
$new_page_title = "Vidéos";
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Vidéos",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
	// Add Publications page
$new_page_title = "Publications";
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Publications",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}

	// Add Photos page
  wp_insert_term(

  // the name of the category
  'Photos',

  // the taxonomy, which in this case if category (don't change)
  'category',

  array(

  // what to use in the url for term archive
  'slug' => 'Photos',
  ));


// add code source page 
$new_page_title = "Codes Sources";
if(get_page_by_title("Codes Sources") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Codes Sources",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

	// add cours et présentations
$new_page_title = "Cours & Présentation";
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Cours & Présentation",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}

	// add Réseax Sociaux
$new_page_title = "Réseax Sociaux";
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Réseax Sociaux",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}

	// add BD Expérimentale
$new_page_title = "BD Expérimentale";
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "BD Expérimentale",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);



$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}


// add videos live 
$new_page_title = "Videos live";
if(get_page_by_title("Videos live") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Videos live",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

}
endif;
add_action( 'after_setup_theme', 'specia_setup' );
