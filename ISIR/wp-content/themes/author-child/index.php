<?php get_header();

get_template_part( 'content/archive-header' );

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

global $wpdb;

$result = $wpdb->get_results( "SELECT * FROM isir_options  where option_name = 'home'"  );



if(count($result)>0){



	foreach ( $result as $print )   {

		echo '<a href="'.$print->option_value.'" style="float: right; "> <i class="fa fa-home"></i>Laboratory</a> '; 

		

	}

}	


?>
	<div id="loop-container" class="loop-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
					the_post();
					//ct_author_get_content_template();
			endwhile;
		endif;

		?>
		<?php

		$slug = basename(get_permalink());
		if ($slug == "hello-world"){
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


		// check for plugin using plugin name
		if ( is_plugin_active( 'add-video/add-video.php' ) ) {


			$table_name = 'isir_'.$blog_id.'_video';
			$blog_id = get_current_blog_id();
			$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video WHERE isFavoris=1" );


			if(count($result)>0)
				echo "<h1>Favorite videos</h1>";

			foreach ( $result as $print )   {
				echo '
					<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
							<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
							<div style="padding-left:20px;padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
					</div>
					';
				}
		}




		// check for plugin using plugin name
		if ( is_plugin_active( 'add-code-source/add-code-source.php' ) ) {


			$table_name = 'isir_'.$blog_id.'_code_source';
				$blog_id = get_current_blog_id();
				$result = $wpdb->get_results( "SELECT * FROM ".$table_name ." WHERE isFavoris=1 order by addedAt desc" );

				if(count($result)>0)
					echo "<h1>Favorite projects</h1>";

				foreach ($result as $print )
        		{

					echo '
					<table style=" border: none; background-color: white;  margin-top: 30px; width : 120%; padding: 30px; ">
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

		}

		$page_title = $wp_query->post->post_title;

		switch($page_title)
		{
				case 'Textes': ?>

		<?php break;
				case 'Vidéos':

// check for plugin using plugin name
		if ( is_plugin_active( 'add-video/add-video.php' ) ) {

		// echo '
		// 		<div style="margin: 0px auto; width:500px;">
		// 			<form action="/action_page.php" style="margin-bottom:20px; ">
		// 			  <input type="text" placeholder="Search for a video . . . " name="search">
		// 			  <button type="submit" style="width:50px; height="100px; "><i class="fa fa-search"></i></button>
		// 			</form>
		//
		// 			<div id="styled-select" style="width:700px;">
		// 				<select name="group" id="group">
		// 					<option val="">Choose year</option>
		// 					<option val="1">2018</option>
		// 					<option val="2">2017</option>
		// 					<option val="3">2016</option>
		// 					<option val="4">Before 2016</option>
		// 				</select>
		// 			</div>
		// 		</div>
		// 		';
		//
		if(!empty($_POST["video_search_value"])) {
				$video_search_value = $_POST["video_search_value"];
		 }
		 ?>
		 <div style="margin: 0px auto; width:500px;">
		 <div>
		 <form method="POST" action=" " style="margin-bottom:20px;align:center; text-align: center; ">
			 <input type="text" id="myInputSearch" name ="video_search_value" value="<?php echo $video_search_value;?>" placeholder="Search for a video ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
			 <button type="submit" style="display:inline-block; height:36px ;" ><i class="fa fa-search" style="font-size:18px"></i></button>
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
								<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
									<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
									<div style="padding-left:20px;padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
								</div>
								';
								 }
}


		 ?>

<?php break;
		case 'Videos live':

			// check for plugin using plugin name
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
				case 'Publications':





	// check for plugin using plugin name
	if ( is_plugin_active( 'hal/hal.php' ) ) {
	  //plugin is activated
 


		$table_name_hide = 'isir_'.$blog_id.'_hal_hide';
		$blog_id = get_current_blog_id();
		$result_hide = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_hal_hide" );	
		echo "<script type=\"text/javascript\">";
		foreach($result_hide as $tohide){
			echo "getSelectedHide(\"$tohide->id\");" ;

		}

		echo "</script>";	

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

			
		echo "<div class=\"wrap\">
			  <h1>Publications</h1><br>";


		$tablename = "isir_".get_current_blog_id()."_hal_id";
		$myrows = $wpdb->get_results( "SELECT idHal FROM $tablename" );

		$hasHal = true;

		if(count($myrows)!=0 && strlen($myrows[0]->idHal)!=0){
			$idHal = $myrows[0]->idHal;
		}
		else
			$hasHal = false;
		
		if($hasHal){


			echo "<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
			<div class=\"container\">";

			echo "<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search..\">
			<br>
			<a href=\"#\" id=\"all\" >Sort by date</a>

			<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

			<script>
				document.getElementById(\"all\").addEventListener(\"click\",function(){
				i_search = 0;
				getDocuments(\"$idHal\"); return false;
			    },false);
			</script>


			<script>
				document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
				i_search = 1;
				getDocumentsSortedByGroup(\"$idHal\"); return false;
			    },false);
			</script>

			<div id=\"docs\"></div></div>

			  <script type=\"text/javascript\">getDocuments(\"$idHal\");</script>

				
			</div>";
		}

	}

 ?>

		<?php break;
				case 'Photos': ?>

		<?php break;
				case 'Codes Sources':


// check for plugin using plugin name
if ( is_plugin_active( 'add-code-source/add-code-source.php' ) ) {
  //plugin is activated

					 if(!empty($_POST["code_source_search_value"])) {
							 $code_source_search_value = $_POST["code_source_search_value"];
						}

?>
				<div style="margin: 0px auto; width:500px;">
				<div>
				<form method="POST"  style="margin-bottom:20px;align:center; text-align: center; ">
					<input type="text" id="myInputSearch" name = "code_source_search_value" value="<?php echo $code_source_search_value; ?>" placeholder="Search for a project ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
					<button type="submit" style="display:inline-block;height:36px ;" ><i class="fa fa-search" style="font-size:18px"></i></button>
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
					<table style=" border: none; background-color: white; margin-left: -80px; margin-top: 30px; width : 170%; padding: 30px; ">
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

				?>
		<?php break;
				case 'Cours et présentations': ?>

		<?php break;
				case 'Réseaux Sociaux': ?>

		<?php break;
				case 'BD Expérimentale': ?>

		<?php break;
					}?>
	</div>
<?php


get_footer();
