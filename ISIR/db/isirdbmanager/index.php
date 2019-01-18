<?php
require_once('MysqliDb.php');
include('./db_backup/db_backup_library.php');
include('./export.php');
include('./import.php');

$pages = array(
        'home' => 'home',
        'importwp' => 'importwp',
        'importIsir' => 'importIsir',
        'exportWp' => 'exportWp',
        'exportIsir' => 'exportIsir',
        );
//require_once('./db_backup/db_backup_library.php');
//error_reporting(E_ALL);
/*$action = 'adddb';
$data = array();
*/

/*function action_adddb () {
    global $db;

    $data = Array(
        'login' => $_POST['login'],
        'customerId' => 1,
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'password' => $db->func('SHA1(?)',Array ($_POST['password'] . 'salt123')),
        'createdAt' => $db->now(),
        'expires' => $db->now('+1Y')
    );
    $id = $db->insert ('users', $data);
    header ("Location: index.php");
    exit;
}

function action_moddb () {
    global $db;

    $data = Array(
        'login' => $_POST['login'],
        'customerId' => 1,
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
    );
    $id = (int)$_POST['id'];
    $db->where ("customerId",1);
    $db->where ("id", $id);
    $db->update ('users', $data);
    header ("Location: index.php");
    exit;

}
function action_rm () {
    global $db;
    $id = (int)$_GET['id'];
    $db->where ("customerId",1);
    $db->where ("id", $id);
    $db->delete ('users');
    header ("Location: index.php");
    exit;

}
function action_mod () {
    global $db;
    global $data;
    global $action;

    $action = 'moddb';
    $id = (int)$_GET['id'];
    $db->where ("id", $id);
    $data = $db->getOne ("users");
}*/

//$db = new Mysqlidb ('localhost', 'root', 'root', 'testdb');
/*$db = new MysqliDb (Array (
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'root',
                'db'=> 'member',
                'port' => 8889,
                'charset' => 'utf8'));

$member = $db->get('user');

//print_r($member);

if ($_GET) {
    $f = "action_".$_GET['action'];
    if (function_exists ($f)) {
        $f();
    }
}
*/

/*$memberdb = new MysqliDb (Array (
                'host' => DB_HOST,
                'username' => DB_USER,
                'password' => DB_PASSWORD,
                'db'=> MEMBER_DB_NAME,
                'port' => PORT,
                'charset' =>DB_CHARSET));*/
 //echo $member->getStatus();
 //print_r($memberdb );

 /*function exportdb($dbname,$filepath,$filename)
 {
   $dbbackup = new db_backup(DB_HOST,DB_USER,DB_PASSWORD,$dbname);
   $dbbackup->backup();

   if($dbbackup->save($filepath,$filename))
   {
     return "<p>Exported database ($dbname) successfully !<p>";
   }
   else
   {
     return "<p>Error to export database ($dbname) .<p>";
   }
   $dbbackup->closeMysqli();
 }*/

 /*function importdb($dbname,$filepath,$filename)
 {
   $dbbackup = new db_backup(DB_HOST,DB_USER,DB_PASSWORD,$dbname);
   $dbbackup->backup();

   if($dbbackup->db_import($filepath.$filename))
   {
     //echo "Database Successfully Imported";
     return "<p>Imported database ($dbname) successfully !<p>";
   }
   else
   {
     return "<p>Error to import database ($dbname) .<p>";
   }
   $dbbackup->closeMysqli();
 }*/


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body {margin: 0;}

ul.topnav {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

ul.topnav li {float: left;}

ul.topnav li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

ul.topnav li a:hover:not(.active) {background-color: #111;}

ul.topnav li a.active {background-color: #4CAF50;}

ul.topnav li.right {float: right;}

@media screen and (max-width: 600px) {
  ul.topnav li.right,
  ul.topnav li {float: none;}
}
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

.input-container {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  width: 100%;
  margin-bottom: 15px;
}

.icon {
  padding: 10px;
  background:  #23282D;
  color: white;
  min-width: 50px;
  text-align: center;
}

.input-field {
  width: 100%;
  padding: 10px;
  outline: none;
}

.input-field:focus {
  border: 2px solid dodgerblue;
}

/* Set a style for the submit button */
.btn {
  background-color: #FF0000;
  color: white;
  padding: 15px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.btn:hover {
  opacity: 1;
}

.image-upload > input
{
    display: none;
}
</style>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js">
</script>
</head>
<body>
<h1>Isir Database manager</h1>
<ul class="topnav">
  <?php foreach ($pages as $pageId => $pageTitle): ?>
 <li><a <?=(($_GET['page'] == $pageId ||(empty($_GET) && $pageId == 'home')) ? 'class="active"' : '')?> href="?page=<?=$pageId?>"><?=$pageTitle?></a></li>
  <?php endforeach; ?>
</ul>

<div style="padding:0 16px;">
  <?php
    if($_GET['page'] == 'importIsir')
    {
      echo MysqliDb::createdb( DB_HOST,DB_USER,DB_PASSWORD,MEMBER_DB_NAME);
      echo importdb(MEMBER_DB_NAME,"./../data/","member.sql");
    }
    else if($_GET['page'] == 'importwp')
    {
      echo MysqliDb::createdb( DB_HOST,DB_USER,DB_PASSWORD,WP_DB_NAME);
      //echo importdb(WP_DB_NAME,"./../data/","db.sql");
    }
    else if($_GET['page'] == 'exportIsir')
    {
      echo exportdb(MEMBER_DB_NAME,"./../data/","member");
    }
    else if($_GET['page'] == 'exportWp')
    {
      echo exportdb(WP_DB_NAME,"./../data/","db");
    }
    if(isset($_POST['submit']) && ($_POST['submit'] == 'Search'))
    {
	     $dir_to_search = $_POST['dir_to_search'];
	     echo $dir_to_search.'<br />';
    }
    else
    {
        //$dir_to_search = $_POST['dir_to_search'];
	      //echo $dir_to_search.'<br />';
        //print_r($_FILES);
        echo '
        <p>This example use media queries to stack the topnav
        vertically when the screen size is 600px or less.
        </p>

        ';
    }

    //database_url : http://localhost/ISIR/db/PHP-MySQLi-Database-Class/
    //?page=exportWp
  ?>
  <form method="POST" action="" style="max-width:500px;margin:auto" enctype="multipart/form-data">
    <div class="input-container">
      <i class="fa fa-key icon"></i>
      <input class="input-field" type="password" placeholder="password" name="psw">
    </div>
    <div class="input-container">

      <div class="image-upload">
        <label for="file-input">
          <i class="fa fa-upload icon"></i>
        </label>
        <input id="file-input" type="file" onchange="getfile(event)" name="dir_to_search"/>
      </div>
      <input class="input-field" id="file-name"
      type="text" placeholder="choose file" name="psw" readonly="readonly">

    </div>
    <?php if($_GET['page'] == 'home'||$_GET['page']==''){ ?>
      <input type="submit"  value="Encrypt file" class="btn">
    <?php } else { ?>
      <input type="submit"  value="Decrypt file" class="btn">
    <?php } ?>
  </form>

</div>

<script>
  document.getElementById('file-input').onchange = function(){
    var filepath = this.value.split("\\");
    document.getElementById('file-name').value =filepath[filepath.length-1];
  };
</script>

</body>
</html>
