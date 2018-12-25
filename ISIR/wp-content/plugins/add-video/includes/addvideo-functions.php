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
	
  global $wpdb;
	$table_name = 'isir_'.$blog_id.'_video';
	$blog_id = get_current_blog_id();
	$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video" );
		
	if($result != null){

		echo '
	 <h2>My videos : </h2>
	 <div>
		Check the "is Favoris" box to add the video to your favorites
	</div>
	<table id="tableVideo" cellpadding="10" cellspacing="10" class="tableau">
			<thead>
				<tr><th scope="col">Is favoris</th><th scope="col">Title</th><th scope="col">URL</th><th scope="col"></th>
				</tr>
			</thead>
			<tbody>'; 
			foreach ( $result as $print )   {
				
				if($print->isFavoris == 0)
				{
					echo '<tr value="is Favoris"><th scope="row">
							<form id="myform" method="post">
								<input class= "favoris" type="checkbox" id="'.$print->id.'" name="'.$print->id.'" onClick="this.form.submit();"> 
								<input name="videoId" value="'.$print->id.'"  type="hidden"></input>
							</form>
						</th>'; 
				}else{
					echo '<tr value="is Favoris"><th scope="row"> 
								<form id="myform" method="post">
									<input type="checkbox" id="'.$print->id.'" name="'.$print->id.'" checked="true" onClick="this.form.submit();">
									<input name="videoId" value="'.$print->id.'"  type="hidden"></input>
								</form>
						  </th>'; 
				}
				
			echo '
			<form method="POST" >
				<td>'.$print->titre.'</td><td ><a href="'.$print->url.'">'.$print->url.'</a></td><td><button style = "background-color: #008CBA;;  border: none; color: white; padding: 5px 5px; text-align: center; text-decoration: none; font-size: 16px; width : 100px; ">delete</button></td></tr>
				<input name="deleteVideoId" value="'.$print->id.'"  type="hidden"></input>
			</form>

				'; 
			 }  
				
				echo '
			</tbody>
	  </table>
	'; 	 
	
	
	}
	

 echo '
 <h2>Search for the video that you want to add by keyWords or by URL : </h2>
<form method="POST">
  <div>
    Search keyWords/URL : <input type="search" id="q" name="q" placeholder="Enter Search Term" style="width:70%; ">
  </div>
  <div>
    Max Results: <input type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="10" style="margin-left:63px; width:70%;">
  </div>
  <input type="submit" value="Search" style="margin-left:35%; margin-top : 20px; width:20%; background-color: #008CBA;;  border: none; color: white; padding: 5px 5px; text-align: center; text-decoration: none; font-size: 16px;">
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
				$channelTitle = $searchResult['snippet']['channelTitle'];
				$publishedAt = $searchResult['snippet']['publishedAt'];

				echo '
				<table style="background-color: white; margin: 30px; width : 90%; padding: 30px; ">
				<tr>
						<td  align="center" style="width : 25%; ">
						<iframe width="400" height="200" style="display: inline-block; border: 1px; margin:10px;  vertical-align:top;"
							src="https://www.youtube.com/embed/'.$id.'">
						</iframe>
						</td>
						<td style="position: relative; padding-left: 50px; width: 50%; ">
							<h3>'.$title.'</h3>
							<h4>'.$channelTitle.'</h4>
							<p>'.$publishedAt.'</p>
						</td>
						<td  align="center"  style="width : 25%; ">
							<form method="POST" >
								<input name="title" value="'.$title.'"  type="hidden"></input>
								<input name="channelTitle" value="'.$channelTitle.'"  type="hidden"></input>
								<input name="publishedAt" value="'.$publishedAt.'"  type="hidden"></input>
								<input name="url" value="https://www.youtube.com/embed/'.$id.'"  type="hidden"></input>
								<input type="submit" value ="Add the video" style = "background-color: #008CBA;;  border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; font-size: 16px;"></input>
							</form>
						</td>
				</tr>
		</table>

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
	$channelTitle = $_POST['channelTitle']; 
	$publishedAt = $_POST['publishedAt']; 
	$today = date("Y-m-d H:i:s");

	$blog_id = get_current_blog_id();
	$table_name = 'isir_'.$blog_id.'_video';

	$wpdb->insert(
		$table_name,
		array(
			'titre' => $title,
			'url' => $url,
			'channelTitle' => $channelTitle, 
			'addedAt' => $today, 
			'publishedAt' => $publishedAt, 
			'isFavoris' => 0
		)
	);
	
	echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";

}

if (isset($_POST['videoId']) )
{
	
	global $wpdb;
	$blog_id = get_current_blog_id();
	$table_name = 'isir_'.$blog_id.'_video';
	
	if(isset($_POST[$_POST['videoId']])){
		
		$result = $wpdb->get_results( "UPDATE ".$table_name." SET isFavoris = 1 WHERE id=".$_POST['videoId']."");
		echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";
		
	}else{
		
		$result = $wpdb->get_results( "UPDATE ".$table_name." SET isFavoris = 0 WHERE id=".$_POST['videoId']."");
		echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";
	}
}

if (isset($_POST['deleteVideoId']) )
{
	
	global $wpdb;
	$blog_id = get_current_blog_id();
	$table_name = 'isir_'.$blog_id.'_video';
	

	$result = $wpdb->get_results( "DELETE FROM ".$table_name."  WHERE id=".$_POST['deleteVideoId']."");
	echo "<script type='text/javascript'>
    window.location=document.location.href;
    </script>";
		
}
}
