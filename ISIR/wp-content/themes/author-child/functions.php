<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


// add Textes page
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
$new_page_title = "Videos";
if(get_page_by_title("Videos") == null){
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
}
// Add Publications page
$new_page_title = "Publications";
if(get_page_by_title("Publications") == null){
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

// add code sources page
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
$new_page_title = "Cours et présentations";
if(get_page_by_title("Cours et présentations") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Cours et présentations",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add Réseax Sociaux
$new_page_title = "Réseax Sociaux";
if(get_page_by_title("Réseax Sociaux") == null){
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
}

// add BD Expérimentale
$new_page_title = "BD Expérimentale";
if(get_page_by_title("BD Expérimentale") == null){
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
}
