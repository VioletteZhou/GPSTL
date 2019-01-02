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
/**
*
*/
function createGoogleOAUTH_Table()
{
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = 'googleoauth';

  $sql = "CREATE TABLE $table_name (
    id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    blog_id INT(9) NOT NULL,
    auth2_client_id VARCHAR(100) NOT NULL,
    auth2_client_secret VARCHAR(100) NOT NULL
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  echo '<p>Create google table</p>';
}
/**
*
*/
function createyoutubelive_Table()
{
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = 'youtubelive';

  $sql = "CREATE TABLE $table_name (
    id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    blog_id INT(9) NOT NULL,
    title VARCHAR(100) NOT NULL,
    video_id VARCHAR(100) NOT NULL,
    description VARCHAR(250)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  echo '<p>Create youtubelive table</p>';
}
/**
*
*/
function addNewGoogleClientForm()
{
  $pagecontents = file_get_contents(__DIR__.'/view/form.html');
  $current_user = wp_get_current_user();
  $currentUserLink = 'http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
  $pagecontents =  str_replace("currentUserLink",$currentUserLink,$pagecontents);
  $pagecontents =  str_replace("Message", "Add oauth2",$pagecontents);
  $pagecontents =  str_replace("OAUTH2_ID","",$pagecontents);
  $pagecontents =  str_replace("usrnm","insertClientID",$pagecontents);
  $pagecontents =  str_replace("OAUTH2_SECRET","",$pagecontents);
  $pagecontents =  str_replace("psw","insertClientSecret",$pagecontents);
  $pagecontents =  str_replace("SubButton", "Add",$pagecontents);
  echo $pagecontents;
}
/**
*
*/
function insertGoogleClient()
{

  global $wpdb;
  $blog_id = get_current_blog_id();
  $table_name = 'googleoauth';
  $res = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");
  if(count($res)==0)
  {

    $res = $wpdb->insert(
                    $table_name,
                    array('blog_id' => $blog_id ,
                          'auth2_client_id' => $_POST["insertClientID"],
                          'auth2_client_secret' => $_POST["insertClientSecret"]
      )
    );

    if($res == false){
        echo "<h2>Please, complete necessary fields</h2>";
    }else{
      echo "<h2>Added successfully</h2>";
      dispAccountExistMess();
    }
  }
  else
  {
    echo "Please remove or update before !";
  }
}
/**
*
*/
function insertVideoData()
{
  global $wpdb;
  $blog_id = get_current_blog_id();
  $table_name = 'youtubelive';
  $res = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");
  $broadcastItem = json_decode($_SESSION['videosArray'],true)['live'];

  if(count($res) == 0)
  {
    $res = $wpdb->insert(
                    $table_name,
                    array('blog_id' => $blog_id,
                          'title' => $broadcastItem['snippet']['title'],
                          'video_id' =>$broadcastItem['id'],
                          'description' => $broadcastItem['snippet']['description']
                        )
    );
    if($res != false)
      echo "<p>Insert youtubelive </p>";
  }
  else
  {

    if($broadcastItem['snippet']['title'] != '')
    {
      $res = $wpdb->update(
        $table_name,
        array(
          'title' => $broadcastItem['snippet']['title'],
          'video_id' =>$broadcastItem['id'],
          'description' => $broadcastItem['snippet']['description']
        ),
        array( 'blog_id' =>$blog_id),
        array(
          '%s',
          '%s',
          '%s'
        ),
        array( '%d' )
      );
    }else{
      deleteCurrentView();
    }
  }
}
/**
*
*/
function updateGoogleClientForm()
{
  global $wpdb;
  $blog_id = get_current_blog_id();
  $table_name = 'googleoauth';
  $res = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");

  if(count($res) == 1)
  {
    $oauth_client_id = $res[0]->auth2_client_id;
    $oauth_client_secret = $res[0]->auth2_client_secret;
    $hist_max = $res[0]->hist_max;
    $pagecontents = file_get_contents(__DIR__.'/view/form.html');
    $current_user = wp_get_current_user();
    $currentUserLink = 'http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
    $pagecontents =  str_replace("currentUserLink",$currentUserLink,$pagecontents);
    $pagecontents =  str_replace("Message", "Update Data",$pagecontents);
    $pagecontents =  str_replace("OAUTH2_ID",$oauth_client_id ,$pagecontents);
    $pagecontents =  str_replace("usrnm","IDUpdate",$pagecontents);
    $pagecontents =  str_replace("OAUTH2_SECRET",$oauth_client_secret,$pagecontents);
    $pagecontents =  str_replace("psw","PASSUpdate",$pagecontents);
    $pagecontents =  str_replace("SubButton", "Update",$pagecontents);
    echo $pagecontents;
  }
  else
  {
    echo "<h2>Please add account before update !</h2>";
  }
}
/**
*
*/
function updateGoogleClient()
{
  global $wpdb;
  $blog_id = get_current_blog_id();
  $table_name = 'googleoauth';

  $res = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");

  if(count($res) == 1)
  {
    $oauth_client_id = $_POST["IDUpdate"] == ''? $res[0]->auth2_client_id:$_POST["IDUpdate"];
    $oauth_client_secret = $_POST["PASSUpdate"] == ''?$res[0]->auth2_client_secret: $_POST["PASSUpdate"];
    $res = $wpdb->update(
                   $table_name,
                    array(
                      'auth2_client_id' => $oauth_client_id,
                      'auth2_client_secret' =>  $oauth_client_secret
                    ),
                      array( 'blog_id' =>$blog_id),
                      array(
                          '%s',
                          '%s'
                      ),
                      array( '%d' )
                    );
    if($res != false)
      echo "<h2>Updated successfully</h2>";
    else
      echo "<h2>Nothing to update</h2>";
  }
  else{
    echo "<h2>Error update</h2>";
  }
}

/**
*
*/
function dispMainMenu()
{
  $current_user = wp_get_current_user();
  $pagecontents = file_get_contents(__DIR__.'/view/menu.html');
  $currentUserLink = 'http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
  $pagecontents =  str_replace("currentUserLink",$currentUserLink,$pagecontents);
  $pagecontents =  str_replace(" active","",$pagecontents);

  if(isset($_POST['youtubelive']))
    $pagecontents =  str_replace("_1","_1 active",$pagecontents);
  else if(isset($_POST['addNewGoogleClient']) || isset($_POST['insertClientID']))
    $pagecontents =  str_replace("_2","_2 active",$pagecontents);
  else if(isset($_POST['updateGoogleClient']) || isset($_POST['IDUpdate']))
    $pagecontents =  str_replace("_3","_3 active",$pagecontents);
  else if(isset($_POST['help']))
      $pagecontents =  str_replace("_4","_4 active",$pagecontents);
  else
    $pagecontents =  str_replace("_1","_1 active",$pagecontents);

  echo $pagecontents;
}

/***
*
*/
function help()
{
  $pagecontents = file_get_contents(__DIR__.'/view/help.html');
  $current_user = wp_get_current_user();
  $currentUserLink = 'http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
  $pagecontents =  str_replace("redirectLink",$currentUserLink,$pagecontents);

  echo $pagecontents;
}
/**
*
*/
function dispAccountExistMess()
{
  $pagecontents = file_get_contents(__DIR__.'/view/existmessage.html');
  $current_user = wp_get_current_user();
  $currentUserLink = 'http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
  $pagecontents =  str_replace("redirectLink",$currentUserLink,$pagecontents);
  echo $pagecontents;
}

/**
*
*/
function getYoutubeLiveView($broadcastItem,$width,$height)
{
  $pagecontents = file_get_contents(__DIR__.'/view/youtubelive.html');
  $pagecontents =  str_replace("Current website view","Live",$pagecontents);
  $pagecontents =  str_replace("wth",$width,$pagecontents);
  $pagecontents =  str_replace("hght",$height,$pagecontents);
  $pagecontents =  str_replace("vidoID",$broadcastItem['id'],$pagecontents);
  $pagecontents =  str_replace("video title",$broadcastItem['snippet']['title'],$pagecontents);
  $pagecontents =  str_replace("description",$broadcastItem['snippet']['description'],$pagecontents);
  $pagecontents =  str_replace("frm","",$pagecontents);
  return $pagecontents;
}

/**
*
*/
function getYoutubeLiveDefaultDisp($type)
{
  $pagecontents = file_get_contents(__DIR__.'/view/liveunavailable.html');
  if($type=='live')
  {
    $pagecontents =  str_replace("Current website view",'Live',$pagecontents);
  }
  $pagecontents =  str_replace("radio","",$pagecontents);

  return $pagecontents;
}

/**
*
*/
function dispCurrentView($width,$height)
{
  $res = '';
  global $wpdb;
  $blog_id = get_current_blog_id();
  $table_name = 'youtubelive';
  $data = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");

  if(count($data) == 1)
  {
    $data = $data[0];
    $current_user = wp_get_current_user();
    $currentUserLink = 'http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
    $form = '<form method="POST" action='.$currentUserLink.'>
      <input class="btn valideInput" type="submit" value="Delete current view" style="margin-bottom:2%; width:20%;" id="Delete current view" name="Delete current view">
    </form>';
    $pagecontents = file_get_contents(__DIR__.'/view/youtubelive.html');
    $pagecontents =  str_replace("wth",$width,$pagecontents);
    $pagecontents =  str_replace("hght",$height,$pagecontents);
    $pagecontents =  str_replace("vidoID",$data->video_id,$pagecontents);
    $pagecontents =  str_replace("video title",$data->title,$pagecontents);
    $pagecontents =  str_replace("description",$data->description,$pagecontents);
    $pagecontents =  str_replace("frm",$form,$pagecontents);
    $res .= $pagecontents;
  }

  if($res == '')
      echo getYoutubeLiveDefaultDisp('websiteView');
  else
      echo $res;
}

/**
*
*/
function delete($table_name)
{
  global $wpdb;
  $blog_id = get_current_blog_id();
  $wpdb->delete($table_name,array('blog_id' =>$blog_id), array( '%d' ));
}

/**
*
*/
function deleteCurrentView()
{
  delete('youtubelive');
}

/**
*
*/
function deleteGoogleUser()
{
  delete('googleoauth');
}
/**
*
*/
function setYoutubeLiveHomePage($broadcastsResponse)
{

  $videosArray = array();
  $videoLive = '';

  foreach ($broadcastsResponse['items'] as $broadcastItem)
  {
    if($broadcastItem['snippet']['actualStartTime'] != null &&
    $broadcastItem['snippet']['actualEndTime'] == null)
    {
      $videoLive = getYoutubeLiveView($broadcastItem,500,330);
      $videosArray['live'] = $broadcastItem;
      break;
    }
  }
  dispPage($videoLive,$videosArray);
}
/**
*
*/
function dispPage($videoLive,$videosArray)
{
  if($videoLive == '')
  {
    $videoLive = getYoutubeLiveDefaultDisp('live');
  }

  $form = '<form method="POST">';
  $form .= $videoLive;
  $form .= '<br><br><input class="live" type="submit" name="Add live" value="Add live" style="margin-bottom:2%; width:15%;"></form>';
  $_SESSION['videosArray'] = json_encode($videosArray);
  dispCurrentView(500,330);
  echo $form;
}
/**
*
*/
function newConnexion($client)
{
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;
  $authUrl = $client->createAuthUrl();
  echo '<h2>You need to <a href='.$authUrl.'>authorize access</a> before proceeding.</h2>';
}
/**
*
*/
function refreshSession($errorMess)
{
  $error = json_decode($errorMess, true)['error']['errors'][0]['reason'];
  $_SESSION = array();
  if($expired == 0)
    youtubeLiveStreams($oauth_client_id,$oauth_client_secret,1);
  else if($error == 'authError')
    echo '<h2>Account not recognized, please update your data.</h2>';
}
/**
*
*/
function youtubeLiveStreams($oauth_client_id,$oauth_client_secret,$hist_max,$expired)
{
  if(!file_exists(__DIR__ . '/vendor/autoload.php'))
  {
    throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
  }

  require_once __DIR__ . '/vendor/autoload.php';

  $OAUTH2_CLIENT_ID = $oauth_client_id;
  $OAUTH2_CLIENT_SECRET = $oauth_client_secret;


  $client = new Google_Client();
  $client->setClientId($OAUTH2_CLIENT_ID);
  $client->setClientSecret( $OAUTH2_CLIENT_SECRET);

  $current_user = wp_get_current_user();

  $client->setScopes('https://www.googleapis.com/auth/youtube');
  $redirect ='http://localhost/ISIR/'.$current_user->user_login.'/wp-admin/admin.php?page=add-youtubelive';
  $client->setRedirectUri($redirect);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);
  // Check if an auth token exists for the required scopes
  $tokenSessionKey = 'token-'.$client->prepareScopes();

  if(isset($_GET['code']))
  {
    if(strval($_SESSION['state']) !== strval($_GET['state']))
    {
      die('The session state did not match.');
    }

    $client->authenticate($_GET['code']);

    if(!isset($_SESSION[$tokenSessionKey]))
    {
        $_SESSION[$tokenSessionKey] = $client->getAccessToken();
    }

    header('Location: ' . $redirect);
  }

  if(isset($_SESSION[$tokenSessionKey]))
  {
    $client->setAccessToken($_SESSION[$tokenSessionKey]);
  }
  // Check to ensure that the access token was successfully acquired.
  if($client->getAccessToken())
  {
    try
    {
      $broadcastsResponse = $youtube->liveBroadcasts->listLiveBroadcasts(
          'id,snippet',
          array(
              'mine' => 'true',
              'maxResults'=>$hist_max
      ));
      setYoutubeLiveHomePage($broadcastsResponse);
    }
    catch (Google_Service_Exception $e)
    {
      refreshSession($e->getMessage());
    }
    catch (Google_Exception $e)
    {
      echo '2 : '.$e->getMessage();
    }
    $_SESSION[$tokenSessionKey] = $client->getAccessToken();
  }
  else
  {
    newConnexion($client);
  }
}
/**
*
*/
function test_init_youtubelive()
{
  global $wpdb;
  dispMainMenu();
  $google_table_name = 'googleoauth';
  $youtubelive_table_name = 'youtubelive';
  $blog_id = get_current_blog_id();

  if(isset($_POST["Delete_current_view"]))
  {
    deleteCurrentView();
  }
  else if(isset($_POST["delete_account"]))
  {
    deleteGoogleUser();
  }

  $res = $wpdb->get_results( "SELECT * FROM $google_table_name WHERE blog_id=".$blog_id."");

  if($wpdb->get_var("SHOW TABLES LIKE '$google_table_name'") != $google_table_name)
  {
    createGoogleOAUTH_Table();
  }
  if($wpdb->get_var("SHOW TABLES LIKE '$youtubelive_table_name'") != $youtubelive_table_name)
  {
    createyoutubelive_Table();
  }

  if(isset($_POST["Add_live"]))
  {
    insertVideoData();
  }

  if(count($res) == 1 &&
      !(isset($_POST["addNewGoogleClient"]) && !empty($_POST["addNewGoogleClient"])) &&
      !(isset($_POST["updateGoogleClient"]) && !empty($_POST["updateGoogleClient"])) &&
      !(($_POST["help"]) && !empty($_POST["help"])) &&
      !(isset($_POST["IDUpdate"]) && !empty($_POST["IDUpdate"]))
    )
  {
    youtubeLiveStreams($res[0]->auth2_client_id,$res[0]->auth2_client_secret,$res[0]->hist_max,0);
  }
  else if(isset($_POST["insertClientID"]) && !empty($_POST["insertClientID"]))
  {
    insertGoogleClient();
  }
  else if(isset($_POST["IDUpdate"]) && !empty($_POST["IDUpdate"]))
  {
    updateGoogleClient();
    updateGoogleClientForm();
  }
  else if(isset($_POST["addNewGoogleClient"]) && !empty($_POST["addNewGoogleClient"]))
  {
    if(count($res) == 0)
      addNewGoogleClientForm();
    else
      dispAccountExistMess();
  }
  else if(isset($_POST["updateGoogleClient"]) && !empty($_POST["updateGoogleClient"]))
  {
    updateGoogleClientForm();
  }
  else if(($_POST["help"]) && !empty($_POST["help"]))
  {
    help();
  }
  else
  {
    addNewGoogleClientForm();
  }
}
