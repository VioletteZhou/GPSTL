<?php
	
	$createUserTable = "CREATE TABLE User(
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		username VARCHAR(30) NOT NULL,
		email VARCHAR(30) NOT NULL,
		password VARCHAR(50) NOT NULL,
		isirequipe VARCHAR(50) NOT NULL,
  		role VARCHAR(50)
	)";
?>