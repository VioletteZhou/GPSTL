<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ISIR";

$query =  "CREATE TABLE Youtubelive(
		id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		blog_id INT(9) NOT NULL,
		sharelink VARCHAR(100) NOT NULL
	)";

function createTable($query,$servername, $username, $password, $dbname)
  {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if($conn->query($query) === TRUE) {
      echo "Table User created successfully\n";
    } else {
      echo "Error creating table: " . $conn->error."\n";
    }
    $conn->close();
  }

  createTable($query,$servername, $username, $password, $dbname);
?>