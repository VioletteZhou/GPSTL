<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


// Add Team home page 
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Home",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Team Members page 
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Members",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Axes of research page 
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Axes of research",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Experimental platforms page 
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Experimental platforms",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Team Publications page 
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Publications",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Team Links page 
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Links",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}
