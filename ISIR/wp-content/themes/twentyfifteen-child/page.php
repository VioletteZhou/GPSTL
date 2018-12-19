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
								
								</div>	
									</div>
								</section>

							</main>
						</div>
			<?php break;
				case 'Team videos': 
			
				echo '
				<div style="margin: 0px auto; width:500px;">
					<form action="/action_page.php" style="margin-bottom:20px; ">
					  <input type="text" placeholder="Search for a video . . . " name="search">
					  <button type="submit" style="width:50px; height="100px; "><i class="fa fa-search"></i></button>
					</form>
					
					<div id="styled-select" style="width:700px;">   
						<select name="group" id="group">
							<option val="">Choose year</option>
							<option val="1">2018</option>
							<option val="2">2017</option>
							<option val="3">2016</option>
							<option val="4">Before 2016</option>
						</select>   
					</div>  
				</div>
				'; 
						global $wpdb;
						$table_name = 'isir_'.$blog_id.'_video';
						$blog_id = get_current_blog_id();
						$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video" );
						?>
					
						<?php		
								foreach ( $result as $print )   {
								echo '
								<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
									<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
									<div style="padding-left:20px;padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
								</div>
								'; 
								 }  
									
									?>
			<?php break;
					case 'Photos': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une photo</button>			
			<?php break; 

			case 'Team videos live':
				$blog_id = get_current_blog_id();
				$result = $wpdb->get_results( "SELECT * FROM isir_youtubelive WHERE blog_id=".$blog_id."");
				$row = json_decode(json_encode($result[0]), True);
				$embed = $row['sharelink'];
				echo "<h3>".$row['title']."</h3>";
				printf('<iframe width="560" height="315" src="https://www.youtube.com/embed/%s?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>',$embed);
				echo "<h4>By : ".$row['author_name']."<h4>";
			?>
								
			<?php break; 
					case 'Codes Sources': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter du code source</button>				
			<?php break;
					case 'Cours et présentations': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter un cours/une présentation</button>			
			<?php break; 
					case 'Réseaux sociaux': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter un post facebook/twetter</button>			
			<?php break; 
					case 'BD expérimentales': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une BD expérimentale</button>				
			<?php break;
						}

						
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
