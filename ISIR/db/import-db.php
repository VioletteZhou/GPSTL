<?php

	// Name of the file
	$isirdbFile = './data/db.sql';
	$memberdbFile = './data/member.sql';
	// MySQL host
	$mysql_host = 'localhost';
	// MySQL username
	$mysql_username = 'root';
	// MySQL password
	$mysql_password = 'root';
	// Database name
	$isirdb = 'ISIR';
	$memberdb = 'MEMBER';


	function createDb($servername, $username, $password,$dbname)
	{
		// Create connection
		$conn = new mysqli($servername, $username, $password);
		// Check connection
		if ($conn->connect_error){
    		die("Connection failed: " . $conn->connect_error)."\n";
		}	 


		$sql = "DROP DATABASE IF EXISTS $dbname";

		if (mysqli_query($conn, $sql)) {
    		echo "Record deleted successfully\n";
		}else {
  			echo "Error deleting record: " . mysqli_error($conn)."\n";
		}

		// Create database
		$sql = "CREATE DATABASE $dbname";

		if ($conn->query($sql) === TRUE) {
    		echo "Database created successfully\n";
		} else {
    		echo "Error creating database: " . $conn->error;
		}
		$conn->close();
	}

	function importDb($mysql_host, $mysql_username, $mysql_password,$dbname,$dbFile)
	{
		$conn = new mysqli($mysql_host,$mysql_username,$mysql_password, $dbname);
		$query = '';
		$sqlScript = file($dbFile);

		foreach ($sqlScript as $line){
			$startWith = substr(trim($line), 0 ,2);
			$endWith = substr(trim($line), -1 ,1);
			if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
				continue;
			}
			$query = $query . $line;
			if($endWith == ';'){
				mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
				$query= '';		
			}
		}
		echo '<div class="success-response sql-import-response">SQL file imported successfully</div>';		
	}

	createDb($mysql_host,$mysql_username,$mysql_password,$isirdb);
	importDb($mysql_host,$mysql_username, $mysql_password,$isirdb,$isirdbFile);
	createDb($mysql_host,$mysql_username,$mysql_password,$memberdb);
	importDb($mysql_host, $mysql_username, $mysql_password,$memberdb,$memberdbFile);
?>