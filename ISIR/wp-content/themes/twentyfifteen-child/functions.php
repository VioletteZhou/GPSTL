<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}


// Add Team home page 
$new_page_title = "Team Home";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Home",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);

 $page_check = get_page_by_title($new_page_title);


if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}


// Add Team Members page 
$new_page_title = "Team Members";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Members",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);

$page_check = get_page_by_title($new_page_title);

if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}


// Add Axes of research page 

$new_page_title = "Team Axes of research";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Axes of research",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);

$page_check = get_page_by_title($new_page_title);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}



// Add Experimental platforms page 
$new_page_title = "Team Experimental platforms";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Experimental platforms",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
$page_check = get_page_by_title($new_page_title);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Team Publications page 
$new_page_title = "Team Publications";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Publications",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
$page_check = get_page_by_title($new_page_title);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// Add Team Links page 
$new_page_title = "Team Links";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team Links",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
$page_check = get_page_by_title($new_page_title);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}

// add video live 
$new_page_title = "Team videos live";
if(get_page_by_title("Team videos live") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Team videos live",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}
// Add Team Links page 
$new_page_title = "Team videos";
$new_page = array(
	'post_type' => 'page',
	'post_title' => "Team videos",
	'post_content' => '',
	'post_status' => 'publish',
	'post_author' => 1,
);
$page_check = get_page_by_title($new_page_title);
if(!isset($page_check->ID)){
	$new_page_id = wp_insert_post($new_page);
}
