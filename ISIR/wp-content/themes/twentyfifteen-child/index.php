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

get_header(); 



?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.

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

		global $wpdb;
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
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
