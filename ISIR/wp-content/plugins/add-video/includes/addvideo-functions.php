<?php
/*
 * Add my new menu to the Admin Control Panel
 */


// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'addtext_Print_Video' );


// Add a new top level menu link to the ACP
function addtext_Print_Video()
{
  add_menu_page(
        'Add video page', // Title of the page
        'Add video', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
	    'add-video',
        'test_init_video' // The 'slug' - file to display when clicking the link
    );
}


function test_init_video(){

 echo '
 <h2>Search for the video that you want to add by keyWords or by URL : </h2>
<form method="POST">
  <div>
    Search keyWords/URL : <input type="search" id="q" name="q" placeholder="Enter Search Term" style="width:70%; ">
  </div>
  <div>
    Max Results: <input type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="10" style="margin-left:63px; width:70%;">
  </div>
  <input type="submit" value="Search" style="margin-left:35%; width:20%;">
</form>

 ';

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
require_once __DIR__ . '/vendor/autoload.php';

if (isset($_POST['q']) && isset($_POST['maxResults']) ) {

  $DEVELOPER_KEY = 'AIzaSyCOIvn7AigbvRyjSi1YFwq70i0GsJcW5yI';
  $client = new Google_Client();

  $client->setDeveloperKey($DEVELOPER_KEY);
  $youtube = new Google_Service_YouTube($client);

  $searchResponse = $youtube->search->listSearch('id,snippet', ['type' => 'video', 'q' => $_POST['q'], 'maxResults' => $_POST['maxResults']]);

  echo '<h4> Select the video to add from the results of the research " '.$_POST['q'].' " : </h5>';

  foreach ($searchResponse['items'] as $searchResult) {
      switch ($searchResult['id']['kind']) {
        case 'youtube#video':
          $videos .= sprintf('<li>%s (%s)</li>',
              $searchResult['snippet']['title'], $searchResult['id']['videoId']);
			  $id =   $searchResult['id']['videoId'];
			  $title = $searchResult['snippet']['title'];

			  echo '
				<div width=100% >
					<iframe width="400" height="200" style="display: inline-block; border: 1px; margin:10px;  vertical-align:top;"
						src="https://www.youtube.com/embed/'.$id.'">
					</iframe>
					<div style="display: inline-block; border: 1px;  vertical-align:top;">
						<p>'.$title.'</p>

						<form method="POST" >
							<input name="title" value="'.$title.'"  type="hidden"></input>
							<input name="url" value="https://www.youtube.com/embed/'.$id.'"  type="hidden"></input>
							<input type="submit" value ="Add the video"></input>
						</form>
					</div>
				</div>
					';
          break;
        case 'youtube#channel':
          $channels .= sprintf('<li>%s (%s)</li>',
              $searchResult['snippet']['title'], $searchResult['id']['channelId']);
			  echo  $channels;
          break;
        case 'youtube#playlist':
          $playlists .= sprintf('<li>%s (%s)</li>',
              $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
			   echo  $playlists;
          break;


      }
    }
}

if (isset($_POST['title']) && isset($_POST['url']))
{

  global $wpdb;

	$title = $_POST['title'];
	$url = $_POST['url'];
  $blog_id = get_current_blog_id();

	$table_name = 'isir_'.$blog_id.'_video';;

	$wpdb->insert(
		$table_name,
		array(
			'titre' => $title,
			'url' => $url,
      'isFavoris' => 0
		)
	);

}else{
	echo "je suis dans le else ";
}
}
