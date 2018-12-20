<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

function getPublicationHTML(){
	return "<div class=\"wrap\">
<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
<div class=\"container\">
<input class=\"form-control\" id=\"myInput\" type=\"text\" placeholder=\"Search..\">

<a href=\"#\" id=\"all\" >All</a>

<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

	<div id=\"docs\"></div></div>
</div>";


}


/*$catarr = array(
  'cat_ID' => 0,
  'cat_name' => "Textes",
  'category_description' =>'' ,
  'category_nicename' =>'Textes' ,
  'category_parent' => '',
  'taxonomy' => 'category' );

 wp_insert_category( $catarr);*/




// add Textes page
$new_page_title = "Textes";
if (get_page_by_title("Textes") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Textes",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}	
}

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
		'post_content' => getPublicationHTML(),
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


// Add Photos page
$new_page_title = "Photos";
if(get_page_by_title("Photos") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Photos",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

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
