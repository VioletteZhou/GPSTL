<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */


?>

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<?php

get_header();

global $wpdb;

$result = $wpdb->get_results( "SELECT * FROM isir_options  where option_name = 'home'"  );

if(count($result)>0){

    foreach ( $result as $print )   {

        echo '<a href="'.$print->option_value.'" style="float: right;color:#5882FA;"> <i class="fa fa-home"></i>Laboratory</a> ';



    }

}


get_header();



?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		global $wpdb;
// check for plugin using plugin name
		if ( is_plugin_active( 'hal/hal.php' ) ) {

			$table_name = 'isir_'.$blog_id.'_hal';
			$blog_id = get_current_blog_id();
			$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_hal" );

			if(count($result)>0){
				echo "<h1>Favorite publications</h1>";
				echo "<table id=\"myTable\">";


  				 echo "<tr class=\"header\">   <th>Publication</th> </tr>";



				foreach ( $result as $print )   {
					echo "
					<td> <a href=\"".$print->url."\">".$print->label."</a></td></tr>

						";
					}

				echo "</table>";
			}
		}

		if ( is_plugin_active( 'add-video/add-video.php' ) ) {
			$table_name = 'isir_'.$blog_id.'_video';
			$blog_id = get_current_blog_id();
			$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video WHERE isFavoris=1" );
			if($result != null){
				echo "<h1 style='margin-left: 30px; '>Favorite videos</h1>";
			}
			foreach ( $result as $print )   {
				echo '
					<div width="90%" align ="center" style=" background-color:#FFFFFF; padding-bottom:20px; margin:25px; overflow:hidden; display: inline-block; " >
							<iframe width="600px" height="350px" src="'.$print->url.'"  style="margin-top: 20px; "></iframe>
							<p style="padding-right:20px; font-weight: bold;">'.$print->titre.'</p>
							<p> '.$print->channelTitle.' at '.$print->addedAt.'<p>
					</div>
					';
				}

				$table_name = 'isir_'.$blog_id.'_code_source';
				$blog_id = get_current_blog_id();
				$result = $wpdb->get_results( "SELECT * FROM ".$table_name ." WHERE isFavoris=1 order by addedAt desc" );
				if($result != null){
					echo "<h1 style='margin-left: 30px; '>Favorite projects</h1>";
				}
				foreach ($result as $print )
				{

					echo '
					<table style=" border: none; background-color: white;  margin: 30px; width : 100%; padding: 30px; ">
						<tr>
							<td  align="center" style="width : 30%; ">
							<img  src="'.$print->avatar_url.'" alt="Avatar" style="border-radius: 50%; width:70px;  height: 70px; display:inline-block; ">
							<h4>'.$print->owner.'</h4>
							</td>
							<td style="position: relative; padding-left: 50px; width: 70%; ">
							<h3 style=" margin-top: 0; ">'.$print->name.'</h3>
							';
							if($print->description != null){
								echo '</br>';
								echo '<p style=" margin-top: 0; " >Description : '.$print->description.'</p>';
							}
							echo '
							<p style=" margin-top: 0; " >Created at  : '.$print->created_at.' </p>
							';
							if($print->language != ""){
								echo '<p style=" margin-top: 0; " >Language  : '.$print->language.'</p>';
							}
							echo '
							<p>HTML Link : </p><a  style="  margin-top: 0; " href="'.$print->html_url.'">'.$print->html_url.'</a>
							<p>Clone Link : '.$print->clone_url.'</p>
							</td>

						</tr>
					</table>

							';
				}
			}


		// if(is_plugin_active( 'youtube-live/youtube-live.php' ))
		// {
		// 	global $wpdb;
		// 	$blog_id = get_current_blog_id();
		// 	$table_name = 'youtubelive';
		// 	$width=700;
		// 	$height=430;
		// 	$pagecontents = file_get_contents(__DIR__.'/view/youtubelive.html');
		// 	$data = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");
    //
		// 	if(count($data) == 1)
		// 	{
		// 		$data = $data[0];
		// 		$iframe = '<iframe class="ifram" width='.$width.' height='.$height.'
		// 					src="https://www.youtube.com/embed/'.$data->video_id.'?autoplay=1"
		// 					frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="">
		// 					</iframe>';
    //
		// 		$pagecontents =  str_replace("ifrm",$iframe,$pagecontents);
		// 		$pagecontents =  str_replace("title",$data->title,$pagecontents);
		// 		$pagecontents =  str_replace("dscpt",'<p>'.$data->description.'</p>',$pagecontents);
		// 	}
		// 	else
		// 	{
		// 		$defaultImg ='<img class="ifram" src="/ISIR/wp-content/uploads/youtube-live/youtubelive.jpg" alt="Youtube-live" width="'.$width.'" height="'.$height.'"/>';
		// 		$pagecontents =  str_replace("ifrm",$defaultImg,$pagecontents);
		// 		$pagecontents =  str_replace("title","Youtube live currently unavailable.",$pagecontents);
		// 		$pagecontents =  str_replace("dscpt","",$pagecontents);
		// 	}
		// 	echo $pagecontents;
		// }
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
