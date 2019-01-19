<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header();
/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

 ?>

	<div id="primary" class="content-area" >
		<main id="main" class="site-main" role="main">

		<?php

		$page_title = $wp_query->post->post_title;

			switch($page_title)
			{
				   case 'Team Home': ?>
					<div id="primary" class="content-area">
							<main id="main" class="site-main" role="main">

									<div class="page-content">
										<h3>Description de l'équipe <h3>
										<p>ceci est une petite description de l'équipe de projet</p>
									</div>

							</main>
						</div>
			<?php break;
					case 'Team Members': ?>
						<div id="primary" class="content-area">
							<main id="main" class="site-main" role="main">
								<section class="error-404 not-found">
									<div class="page-content">
								<div class="row padding-top-30 padding-bottom-60">
								<?php
									$blogusers = get_users( 'orderby=post_count' );
										foreach ( $blogusers as $user ) {

											 $url = '/ISIR/'.$user->user_nicename; ?>

										 <li onclick="location.href='<?php echo $url; ?>'"> <?php echo esc_html( $user->display_name ) ?> </a></li>
										 <?php
									}
								?>

								</div>
									</div>
								</section>

							</main>
						</div>

		<?php break;
				case 'Team videos':

// check for plugin using plugin name
		if ( is_plugin_active( 'add-video/add-video.php' ) ) {
				if(!empty($_POST["video_search_value"])) {
						$video_search_value = $_POST["video_search_value"];
				 }
				 ?>
							<div style="margin: 0px auto;  margin-top:20px; ">
							<div>
							<form method="POST" action=" " style="margin-bottom:20px; align:center; text-align: center; ">
								<input type="text" id="myInputSearch" name ="video_search_value" value="<?php echo $video_search_value;?>" placeholder="Search for a video ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
								<input type="submit" style="display:inline-block; " value="Search" ></input>
							</form>
							</div>
			<?php

					global $wpdb;
					$table_name = 'isir_'.$blog_id.'_video';
					$blog_id = get_current_blog_id();
					// $result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video ORDER BY addedAt DESC" );
					if(!empty($_POST["video_search_value"])){
								$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video WHERE titre LIKE "."'%".$video_search_value."%'"." order by addedAt desc" );
					}else{
								$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video order by addedAt desc" );
					}
								foreach ( $result as $print )   {
									echo '
									<div width="90%" align ="center" style=" background-color:#FFFFFF; padding-bottom:20px; margin:25px; margin-left:110px; overflow:hidden; display: inline-block; " >
											<iframe width="600px" height="350px" src="'.$print->url.'"  style="margin-top: 20px; "></iframe>
											<p style="padding-right:20px; font-weight: bold;">'.$print->titre.'</p>
											<p> '.$print->channelTitle.' at '.$print->addedAt.'<p>
									</div>
									';
								 }
}

			?>

		<?php break;
			case 'Team videos live':

			if(is_plugin_active( 'youtube-live/youtube-live.php' ))
			{
				global $wpdb;
				$blog_id = get_current_blog_id();
				$table_name = 'youtubelive';
				$width=700;
				$height=430;
				$pagecontents = file_get_contents(__DIR__.'/view/youtubelive.html');
				$data = $wpdb->get_results( "SELECT * FROM $table_name  WHERE blog_id=".$blog_id."");

				if(count($data) == 1)
				{
					$data = $data[0];
					$iframe = '<iframe class="ifram" width='.$width.' height='.$height.'
								src="https://www.youtube.com/embed/'.$data->video_id.'?autoplay=1"
								frameborder="0" allow="autoplay; encrypted-media" allowfullscreen="">
								</iframe>';

					$pagecontents =  str_replace("ifrm",$iframe,$pagecontents);
					$pagecontents =  str_replace("title",$data->title,$pagecontents);
					$pagecontents =  str_replace("dscpt",'<p>'.$data->description.'</p>',$pagecontents);
				}
				else
				{
					$defaultImg ='<img class="ifram" src="/ISIR/wp-content/uploads/youtube-live/youtubelive.jpg" alt="Youtube-live" width="'.$width.'" height="'.$height.'"/>';
					$pagecontents =  str_replace("ifrm",$defaultImg,$pagecontents);
					$pagecontents =  str_replace("title","Youtube live currently unavailable.",$pagecontents);
					$pagecontents =  str_replace("dscpt","",$pagecontents);
				}
				echo $pagecontents;
			}
		?>

			<?php break;
					case 'Team Publications':



				// check for plugin using plugin name
				if ( is_plugin_active( 'hal/hal.php' ) ) {

					$tablename = "isir_".get_current_blog_id()."_hal_team";
	$myrows = $wpdb->get_results( "SELECT nameTeam FROM $tablename" );

	$nameTeam = $myrows[0]->nameTeam;

	global $db_member ;
	global $table_user;
	$rows = $db_member->get_results("select * from $table_user");

	$table_blogid = "isir_blogid";

	echo "<div id=\"liste_users\">";
	echo "<h4>List of the researchers of the team</h4>";
	echo "<ul >";

	foreach ($rows as $obj) :

		$equipes = explode("|", $obj->isirequipe);
		$belongs = false;
		foreach($equipes as $nom_equipe){
			if($nom_equipe == $nameTeam){
				$belongs = true;
				break;
			}

		}
		if($belongs){

			if(($blogid = $wpdb->get_results("select blog_id from $table_blogid where username = '$obj->username' "))){
		   		$tablename_user = "isir_".$blogid[0]->blog_id."_hal_id";
				$user_rows = $wpdb->get_results( "SELECT * FROM $tablename_user" );
				if(count($user_rows)!=0 && strlen($user_rows[0]->idHal)!=0){
					$idHal = $user_rows[0]->idHal;
					echo "<li><a href=\"#\" onclick=\"getDocuments('$idHal','$obj->username')\">".$obj->username."</a></li>";
					$username_idHal = $obj->username;

				}
				else{
					//echo "<li>".$obj->username." didn't active its HAL plugin</li>";
				}

			}
		}
	endforeach;

	echo "</ul></div>";

	echo "<div id=\"hal_component\">";
	echo "<strong id=\"publicationHead\">Publications</strong><br><br>";

	echo "<script type=\"text/javascript\">
		var i_search = 0;
		function myFunction() {

		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById(\"myInput\");
		  filter = input.value.toUpperCase();
		  table = document.getElementById(\"myTable\");
		  tr = table.getElementsByTagName(\"tr\");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName(\"td\")[i_search];
		    if (td) {
		      txtValue = td.textContent || td.innerText;
		      if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = \"\";
		      } else {
			tr[i].style.display = \"none\";
		      }
		    }
		  }
		}

		</script>";



	$tablename = "isir_".get_current_blog_id()."_hal_hide";
	$result_hide = $wpdb->get_results( "SELECT id FROM $tablename" );


	echo "<script type=\"text/javascript\">";
	foreach($result_hide as $tohide){
		echo "getSelectedHide(\"$tohide->id\");" ;

	}



	echo "</script>";


		echo "<div class=\"wrap\">";

		echo "<div id=\"wait\"><p>Loading. Please wait...</p></div>
		<div class=\"container\">
		<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search documents...\">
		<br>
		<a href=\"#\" id=\"all\" >Sort by date</a>

		<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

		<script>
			document.getElementById(\"all\").addEventListener(\"click\",function(){
			i_search = 0;
			getDocuments(curr_idHal); return false;
		    },false);
		</script>


		<script>
			document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
			i_search = 1;
			getDocumentsSortedByGroup(curr_idHal); return false;
		    },false);
		</script>

		<div id=\"docs\"></div></div>

		  <script type=\"text/javascript\">getDocuments(\"$idHal\", \"$username_idHal\");</script>


		</div>";


	echo "</div>";


				}

			?>

			<?php break;
					case 'Photos': ?>
			<?php break;
					case 'Codes Sources':

// check for plugin using plugin name
if ( is_plugin_active( 'add-code-source/add-code-source.php' ) ) {

										 if(!empty($_POST["code_source_search_value"])) {
												 $code_source_search_value = $_POST["code_source_search_value"];
											}

					?>
									<div style="margin: 0px auto;">
									<div>
									<form method="POST" action=" " style="margin-bottom:20px;align:center; text-align: center; ">
										<input type="text" id="myInputSearch" name = "code_source_search_value" value="<?php echo $code_source_search_value; ?>" placeholder="Search for a project ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
										<input type="submit" style="display:inline-block; " value="Search"></input>
									</form>
									</div>
					  <?php

									global $wpdb;
									$table_name = 'isir_'.$blog_id.'_code_source';
									$blog_id = get_current_blog_id();
									if(!empty($_POST["code_source_search_value"])){
												$result = $wpdb->get_results( "SELECT * FROM ".$table_name ." WHERE name LIKE "."'%".$code_source_search_value."%'"." order by addedAt desc" );
									}else{
												$result = $wpdb->get_results( "SELECT * FROM ".$table_name ." order by addedAt desc" );
									}

					foreach ($result as $print )
					{

						echo '
						<table style=" border: none; background-color: white;  margin-top: 30px; width : 90%; padding: 30px; margin-left: 5%; ">
							<tr>
								<td  align="center" style="width : 30%; ">
								<img  src="'.$print->avatar_url.'" alt="Avatar" style="border-radius: 50%; width:100px;  height: 100px; display:inline-block; ">
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

					?>
			<?php break;
					case 'Cours et présentations': ?>
			<?php break;
					case 'Réseaux sociaux': ?>
			<?php break;
					case 'BD expérimentales': ?>
			<?php break;
						}


		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'content', 'page' );

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
