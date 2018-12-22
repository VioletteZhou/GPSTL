<?php
session_start(); 
/*
 * Add my new menu to the Admin Control Panel
 */


// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'add_Youtubelive' );

 
// Add a new top level menu link to the ACP
function add_Youtubelive()
{
  add_menu_page(
    'Add youtubelive page', // Title of the page
    'Add youtubelive', // Text to show on the menu link
    'manage_options', // Capability requirement to see the link
	  'add-youtubelive',
    'test_init_youtubelive' // The 'slug' - file to display when clicking the link
  );
}

function create_table()
{
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = 'isir_youtubelive';
  $sql = "CREATE TABLE $table_name (
    id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    blog_id INT(9) NOT NULL,
    title VARCHAR(100) NOT NULL,
    author_name VARCHAR(100) NOT NULL,
    sharelink VARCHAR(100) NOT NULL
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  echo "create";
}

function add_sharelink()
{
  global $wpdb;
  $table_name = 'isir_youtubelive'; 
  $blog_id = get_current_blog_id();

  
  $result = $wpdb->get_results( "SELECT * FROM isir_youtubelive WHERE blog_id=".$blog_id."");
  if( 0 < count($result)){
    $result = $wpdb->update( 
      $table_name, 
      array(
        'title' => $_SESSION["title"],
        'author_name' => $_SESSION["author_name"], 
        'sharelink' => $_SESSION["embed"] 
      ), 
      array( 'blog_id' =>$blog_id), 
      array( 
        '%s'
      ), 
      array( '%d' ) 
    );
  }else{
    $result = $wpdb->insert(
    $table_name,
    array(
        'blog_id' => $blog_id ,
        'title' => $_SESSION["title"],
        'author_name' => $_SESSION["author_name"],
        'sharelink' => $_SESSION["embed"]
      )
    );
  }
  echo "Youtube live added !";
}

function test_init_youtubelive()
{
  echo '
 
 <a href="https://www.youtube.com" target="_blank"><h2>Youtube live </h2></a>
  
  <form method="POST">
    Share link : 
    <div>
      <input type="search" id="sharelink" name="sharelink" placeholder="Enter share link" style="width:60%;">
    </div>
    <input type="submit" value="View" style="margin-bottom:2%; width:10%;">
  </form>
 ';
  if(isset($_POST["sharelink"]) && !empty($_POST["sharelink"]))
  {
    $embed  =explode("/",explode("//",$_POST["sharelink"])[1])[1];
    $_SESSION["embed"] = $embed;
    if($embed != "")
    {
      $url = "https://www.youtube.com/oembed?format=json&url=".$_POST["sharelink"];
      $data = file_get_contents($url);
      $json = json_decode($data);
      $_SESSION["title"] = $json->title;
      $_SESSION["author_name"] = $json->author_name;
      echo "<h3>".$json->title."</h3>";
      printf('<iframe width="560" height="315" src="https://www.youtube.com/embed/%s?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>',$embed);

      echo "<h4>By : ".$json->author_name."<h4>";
      echo '<form method="POST">
      <input type="submit" id="addlive" name="addlive" value="Add live" style="margin-bottom:4%; width:10%;"></form>';
    }
    else
    {
      echo "Invalid link !";
    }
  }
  if(array_key_exists('addlive',$_POST))
  {
    add_sharelink();
  }else if(empty($_POST["sharelink"]))
  {
    echo "Missing field share link";
  }

  echo $data = file_get_contents("https://www.youtube.com/oembed?format...");;
}
