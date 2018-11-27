<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


// add Textes page
if (get_page_by_title("Textes") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Textes",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}	
}
// Add videos page 
if(get_page_by_title("Videos") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Vidéos",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}
// Add Publications page 
if(get_page_by_title("Publications") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Publications",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


// Add Photos page
if(get_page_by_title("Photos") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Photos",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add code sources page 
if(get_page_by_title("Codes Sources") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Codes Sources",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


// add cours et présentations 
if(get_page_by_title("Cours et présentations") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Cours et présentations",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add Réseax Sociaux
if(get_page_by_title("Réseax Sociaux") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Réseax Sociaux",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add BD Expérimentale
if(get_page_by_title("BD Expérimentale") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "BD Expérimentale",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}
