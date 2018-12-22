<?php

add_action('wp_ajax_nopriv_ajax_request_hal_add', 'add_publication');
add_action('wp_ajax_ajax_request_hal_add', 'add_publication');

add_action('wp_ajax_nopriv_ajax_request_hal_remove', 'remove_publication');
add_action('wp_ajax_ajax_request_hal_remove', 'remove_publication');

add_action('wp_ajax_nopriv_ajax_request_hal_add_hide', 'add_publication_hide');
add_action('wp_ajax_ajax_request_hal_add_hide', 'add_publication_hide');

add_action('wp_ajax_nopriv_ajax_request_hal_remove_hide', 'remove_publication_hide');
add_action('wp_ajax_ajax_request_hal_remove_hide', 'remove_publication_hide');





function add_publication(){

global $wpdb;

    $ret = 'ok'; //our return variable

		$id = $_REQUEST['id'];
		$label =  $_REQUEST['label'];
		$uri =  $_REQUEST['uri'];
		$tablename = "isir_".get_current_blog_id()."_hal";

		$wpdb->insert( 
			$tablename, 
			array( 
				'id' => $id,
				'label'=>$label,
				'url' => $uri 
			)
		);

    echo $ret;
    die(); //this makes sure you don't get a "1" or "0" appended to the end of your request.
}


function remove_publication(){

global $wpdb;

    $ret = 'ok'; //our return variable

		$id = $_REQUEST['id'];
		$tablename = "isir_".get_current_blog_id()."_hal";

		$wpdb->delete( 
			$tablename, 
			array( 
				'id' => $id 
			), 
			array(  
				'%d' 
			) 
		);

        

    echo $ret;
    die(); //this makes sure you don't get a "1" or "0" appended to the end of your request.
}


function add_publication_hide(){

global $wpdb;

    $ret = 'ok'; //our return variable

		$id = $_REQUEST['id'];
		$tablename = "isir_".get_current_blog_id()."_hal_hide";

		$wpdb->insert( 
			$tablename, 
			array( 
				'id' => $id
			)
		);

    echo $ret;
    die(); //this makes sure you don't get a "1" or "0" appended to the end of your request.
}


function remove_publication_hide(){

global $wpdb;

    $ret = 'ok'; //our return variable

		$id = $_REQUEST['id'];
		$tablename = "isir_".get_current_blog_id()."_hal_hide";

		$wpdb->delete( 
			$tablename, 
			array( 
				'id' => $id 
			), 
			array(  
				'%d' 
			) 
		);

        

    echo $ret;
    die(); //this makes sure you don't get a "1" or "0" appended to the end of your request.
}

