<?php get_header();

get_template_part( 'content/archive-header' );

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


			$table_name = 'isir_'.$blog_id.'_hal';
			$blog_id = get_current_blog_id();
			$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_hal" );
			if($result != null){
				echo "<h1>Favorite publications</h1>";
			}
			foreach ( $result as $print )   {
				echo "
						<li id=\"element_".$print->id."\" class=\"list-group-item\"> <a href=\"".$print->url."\">".$print->label."</a></li>

					";
				}


			$table_name = 'isir_'.$blog_id.'_video';
			$blog_id = get_current_blog_id();
			$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video WHERE isFavoris=1 order by addedAt desc" );
			if($result != null){
				echo "<h1>Favorite videos</h1>";
			}
			foreach ( $result as $print )   {
				echo '
					<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
							<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
							<div style="padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
							<p> '.$print->channelTitle.' at '.$print->addedAt.'<p>
					</div>
					';
				}


				global $wpdb;
				$table_name = 'isir_'.$blog_id.'_code_source';
				$blog_id = get_current_blog_id();
				$result = $wpdb->get_results( "SELECT * FROM ".$table_name ." WHERE isFavoris=1 order by addedAt desc" );
				if($result != null){
					echo "<h1>Favorite projects</h1>";
				}
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

		$page_title = $wp_query->post->post_title;

		switch($page_title)
		{
				case 'Textes': ?>

		<?php break;
				case 'Vidéos':
				if(!empty($_POST["video_search_value"])) {
						$video_search_value = $_POST["video_search_value"];
				 }
				 ?>

				<div style="margin: 0px auto; width:500px;">
				<div>
				<form method="POST" style="margin-bottom:20px;align:center; text-align: center; ">
					<input type="text" id="myInputSearch" name ="video_search_value" value="<?php echo $video_search_value;?>" placeholder="Search for a video ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
					<button type="submit" style="display:inline-block; " ><i class="fa fa-search"></i></button>
				</form>
				</div>

				<?php
						global $wpdb;
						$table_name = 'isir_'.$blog_id.'_video';
						$blog_id = get_current_blog_id();

						if(!empty($_POST["video_search_value"])){
							  	$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video WHERE titre LIKE "."'%".$video_search_value."%'"." order by addedAt desc" );
						}else{
									$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video order by addedAt desc" );
						}

								foreach ( $result as $print )   {
								echo '
								<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
									<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
									<div style="padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
									<p> '.$print->channelTitle.' at '.$print->addedAt.'<p>
								</div>
								';
								 }


		 ?>

<?php break;
		case 'Videos live':
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
			?>

		<?php break;
				case 'Publications': echo "<div class=\"wrap\">

					<div id=\"wait\"><p>Chargement en cours. Attendez svp...</p></div>
					<div class=\"container\">
					<input class=\"form-control\" id=\"myInput\" type=\"text\" placeholder=\"Search..\">
					<a href=\"#\" id=\"all\" >All</a>
					<a href=\"#\" id=\"sortbygroup\" >Sort by doctype</a>
					<div id=\"docs\"></div></div>
					</div>"; ?>

		<?php break;
				case 'Photos': ?>

		<?php break;
				case 'Codes Sources':

					 if(!empty($_POST["code_source_search_value"])) {
							 $code_source_search_value = $_POST["code_source_search_value"];
						}

?>
				<div style="margin: 0px auto; width:500px;">
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
