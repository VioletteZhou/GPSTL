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

get_header(); ?>

	<div id="primary" class="content-area">
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

				if(!empty($_POST["video_search_value"])) {
						$video_search_value = $_POST["video_search_value"];
				 }
				 ?>

							<div style="margin: 0px auto; width:500px;">
							<div>
							<form method="POST" action=" " style="margin-bottom:20px;align:center; text-align: center; ">
								<input type="text" id="myInputSearch" name ="video_search_value" value="<?php echo $video_search_value;?>" placeholder="Search for a video ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
								<input type="submit" style="display:inline-block; " ><i class="fa fa-search"></i></input>
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
									<div width="90%" align ="center" style=" background-color:#FFFFFF; padding-bottom:20px; margin:25px; overflow:hidden; display: inline-block; " >
											<iframe width="600px" height="350px" src="'.$print->url.'"  style="margin-top: 20px; "></iframe>
											<p style="padding-right:20px; font-weight: bold;">'.$print->titre.'</p>
											<p> '.$print->channelTitle.' at '.$print->addedAt.'<p>
									</div>
									';
								 }

			?>

		<?php break;
			case 'Team videos live':
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
					case 'Publications': ?>

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
									<form method="POST" action=" " style="margin-bottom:20px;align:center; text-align: center; ">
										<input type="text" id="myInputSearch" name = "code_source_search_value" value="<?php echo $code_source_search_value; ?>" placeholder="Search for a project ..." style="display:inline-block; width:70%; margin-top:20px; align:center;">
										<input type="submit" style="display:inline-block; " ><i class="fa fa-search"></i></input>
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
