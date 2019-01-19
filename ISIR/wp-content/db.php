<?php


$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$dbname = "MEMBER";


global $db_member;
$db_member = new wpdb($dbusername,$dbpassword,$dbname,$servername);
global	$table_user;
$table_user = "User";
