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
<<<<<<< HEAD

		<?php

		$page_title = $wp_query->post->post_title;

=======
		<?php

		$page_title = $wp_query->post->post_title;
												
>>>>>>> master
			switch($page_title)
			{
				    case 'Team Home': ?>
					<div id="primary" class="content-area">
							<main id="main" class="site-main" role="main">
<<<<<<< HEAD

=======
							
>>>>>>> master
									<div class="page-content">
										<h3>Description de l'équipe <h3>
										<p>ceci est une petite description de l'équipe de projet</p>
									</div>

							</main>
						</div>
<<<<<<< HEAD
			<?php break;
=======
			<?php break; 
>>>>>>> master
					case 'Team Members': ?>
						<div id="primary" class="content-area">
							<main id="main" class="site-main" role="main">
								<section class="error-404 not-found">
									<div class="page-content">
								<div class="row padding-top-30 padding-bottom-60">
								<?php
									$blogusers = get_users( 'orderby=post_count' );
										foreach ( $blogusers as $user ) {
										echo '<li><a>' . esc_html( $user->display_name ) . '</a></li>';
									}
								?>
<<<<<<< HEAD

								</div>
=======
								
								</div>	
>>>>>>> master
									</div>
								</section>

							</main>
						</div>

		<?php break;
<<<<<<< HEAD
				case 'Team videos':

=======
				case 'Team videos': 
			
>>>>>>> master
				echo '
				<div style="margin: 0px auto; width:500px;">
					<form action="/action_page.php" style="margin-bottom:20px; ">
					  <input type="text" placeholder="Search for a video . . . " name="search">
					  <button type="submit" style="width:50px; height="100px; "><i class="fa fa-search"></i></button>
					</form>
<<<<<<< HEAD

					<div id="styled-select" style="width:700px;">
=======
					
					<div id="styled-select" style="width:700px;">   
>>>>>>> master
						<select name="group" id="group">
							<option val="">Choose year</option>
							<option val="1">2018</option>
							<option val="2">2017</option>
							<option val="3">2016</option>
							<option val="4">Before 2016</option>
<<<<<<< HEAD
						</select>
					</div>
				</div>
				';
=======
						</select>   
					</div>  
				</div>
				'; 
>>>>>>> master
						global $wpdb;
						$table_name = 'isir_'.$blog_id.'_video';
						$blog_id = get_current_blog_id();
						$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video" );
						?>
<<<<<<< HEAD

						<?php
=======
					
						<?php		
>>>>>>> master
								foreach ( $result as $print )   {
								echo '
								<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
									<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
									<div style="padding-left:20px;padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
								</div>
<<<<<<< HEAD
								';
								 }

			?>

		<?php break;
=======
								'; 
								 }  
									
			?>

		<?php break; 
>>>>>>> master
			case 'Team videos live':
				$blog_id = get_current_blog_id();
					$result = $wpdb->get_results( "SELECT * FROM isir_youtubelive WHERE blog_id=".$blog_id."");
					$row = json_decode(json_encode($result[0]), True);
					$embed = $row['sharelink'];
<<<<<<< HEAD

=======
		
>>>>>>> master
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
<<<<<<< HEAD

			<?php break;
					case 'Photos': ?>
			<?php break;
					case 'Codes Sources': ?>
			<?php break;
					case 'Cours et présentations': ?>
			<?php break;
					case 'Réseaux sociaux': ?>
			<?php break;
=======
					
			<?php break;
					case 'Photos': ?>
			<?php break; 
					case 'Codes Sources': ?>
			<?php break;
					case 'Cours et présentations': ?>
			<?php break; 
					case 'Réseaux sociaux': ?>
			<?php break; 
>>>>>>> master
					case 'BD expérimentales': ?>
			<?php break;
						}

<<<<<<< HEAD

=======
						
>>>>>>> master
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'content', 'page' );

<<<<<<< HEAD
=======
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

>>>>>>> master
		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
