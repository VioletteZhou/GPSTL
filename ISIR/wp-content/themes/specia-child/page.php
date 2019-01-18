<?php
get_header();
get_template_part('sections/specia','breadcrumb'); ?>

<section class="page-wrapper" style="text-align: center;">
	<div class="container" >

		<div class="row padding-top-60 padding-bottom-60">
			<?php

			$page_title = $wp_query->post->post_title;

			switch($page_title)
			{
				    case 'Textes': ?>
					<div style="vertical-align:middle; ">
						<button type="button" style= " margin-bottom: 30px; float: right;">+ Ajouter un texte</button>
					</div>
			<?php break;
					case 'Videos':
				if ( is_plugin_active( 'add-video/add-video.php' ) ) {
					if(!empty($_POST["video_search_value"])) {
							$video_search_value = $_POST["video_search_value"];
					 }
					 ?>

								<div style="margin: 0px auto;">
								<div>
								<form method="POST" action=" " style="margin-bottom:20px;align:center; text-align: center; ">
									<input type="text" id="myInputSearch" name ="video_search_value" value="<?php echo $video_search_value;?>" placeholder="Search for a video ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
									<button type="submit" style="display:inline-block; " ><i class="fa fa-search"></i></button>
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
								<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin-right:70px; margin-top:15px; overflow:hidden; display: inline-block; " >
									<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
									<div style="padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
									<p> '.$print->channelTitle.' at '.$print->addedAt.'<p>
								</div>
								';
								 }

			}
			 ?>

			<?php break;
				case 'Videos live':

				if ( is_plugin_active( 'youtube-live/youtube-live.php' ) ) {
					$blog_id = get_current_blog_id();
					$result = $wpdb->get_results( "SELECT * FROM isir_youtubelive WHERE blog_id=".$blog_id."");
					$row = json_decode(json_encode($result[0]), True);
					$embed = $row['sharelink'];

					$url = "https://www.youtube.com/oembed?format=json&url=https://youtu.be/".$embed;
      				$data = file_get_contents($url);
      				$json = json_decode($data);
					if(count($result) == 0 || $json->title == "")
					{
						echo "<h3>Youtube live currently unavailable</h3>";
						echo '<img src="/ISIR/wp-content/uploads/youtube-live/youtubelive.jpg" alt="Youtube-live" width="560" height="315"/>';
					}
					else
					{
						echo "<h3>".$row['title']."</h3>";
						printf('<iframe width="560" height="315" src="https://www.youtube.com/embed/%s?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>',$embed);
						echo "<h4>By : ".$row['author_name']."<h4>";
					}
			}
			?>

			<?php break;
					case 'Publications':

	// check for plugin using plugin name
	if ( is_plugin_active( 'hal/hal.php' ) ) {
	  //plugin is activated



		$table_name_show = 'isir_'.$blog_id.'_hal_show';
		$blog_id = get_current_blog_id();
		$result_show = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_hal_show" );
		echo "<script type=\"text/javascript\">";
		foreach($result_show as $toshow){
			echo "getSelectedShow(\"$toshow->id\", \"$toshow->label\", \"$toshow->url\", \"$toshow->type\");" ;

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



			echo "<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
			<div class=\"container\">";

			echo "<input class=\"form-control\" id=\"myInput\" type=\"text\" onkeyup=\"myFunction()\" placeholder=\"Search..\">
			<br>
			<a href=\"#\" id=\"all\" >Sort by date</a>

			<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>

			<script>
				document.getElementById(\"all\").addEventListener(\"click\",function(){
				i_search = 0;
				getDocuments(); return false;
			    },false);
			</script>


			<script>
				document.getElementById(\"sortbygroup\").addEventListener(\"click\",function(){
				i_search = 1;
				getDocumentsSortedByGroup(); return false;
			    },false);
			</script>



				<div id=\"docs\"></div></div>
				<script type=\"text/javascript\">getDocuments();</script>
			</div>";


	}

 ?>


			<?php break;
					case 'Photos': ?>
			<?php break;
					case 'Codes Sources':
				if ( is_plugin_active( 'add-code-source/add-code-source.php' ) ) {

										 if(!empty($_POST["code_source_search_value"])) {
												 $code_source_search_value = $_POST["code_source_search_value"];
											}

					?>
									<div style="margin: 0px auto; margin-left:60px;">
									<div>
									<form method="POST"  style="margin-bottom:20px;align:center; text-align: center; ">
										<input type="text" id="myInputSearch" name = "code_source_search_value" value="<?php echo $code_source_search_value; ?>" placeholder="Search for a project ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
										<button type="submit" style="display:inline-block; " ><i class="fa fa-search"></i></button>
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
						<table style=" border: none; background-color: white;  margin-top: 30px; width : 90%; padding: 30px; ">
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

				if ( class_exists( 'WooCommerce' ) )
				{

					if( is_account_page() || is_cart() || is_checkout() ) {
							echo '<div class="col-md-'.( !is_active_sidebar( "woocommerce-1" ) ?"12" :"8" ).'">';
					}
					else{

					echo '<div class="col-md-'.( !is_active_sidebar( "sidebar-primary" ) ?"12" :"8" ).'">';

					}

				}
				else
				{

					echo '<div class="col-md-'.( !is_active_sidebar( "sidebar-primary" ) ?"12" :"8" ).'">';


				}
			?>
			<div class="site-content">

			<?php

				if( have_posts()) :  the_post();

				the_content();
				endif;

				//comments_template( '', true ); // show comments
			?>


			</div><!-- /.posts -->

			</div><!-- /.col -->


		</div><!-- /.row -->
	</div><!-- /.container -->
</section>

<?php get_footer(); ?>
