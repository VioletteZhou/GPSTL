<?php
  include './query/user-query.php';

  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "MEMBER";
  $usertable="User";
  $csvFile ="./data/export.csv";


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

  function importFromcsv($filePath,$servername, $username, $password, $dbname)
  {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $fileResource = fopen($filePath, 'r');
    fgets($fileResource);
    while(!feof($fileResource))
    {
      $userData = explode(";",fgets($fileResource));
      $sql = "INSERT INTO User(username,email,password,isirequipe,role)
      VALUES ('$userData[0]','$userData[1]','$userData[2]','$userData[3]','$userData[4]');";
  
      if ($conn->query($sql) === TRUE){
        echo "New records created successfully";
      } else {
        echo "Error: " . $sql. "<br>" . $conn->error;
        break;
      }
    }
    fclose($fileResource);
    $conn->close();
  }
  createDb($servername, $username, $password,$dbname);
  createTable($createUserTable,$servername, $username, $password, $dbname);
  importFromcsv($csvFile,$servername, $username, $password, $dbname);
?>