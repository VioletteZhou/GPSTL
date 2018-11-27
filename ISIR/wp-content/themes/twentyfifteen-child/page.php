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
										echo '<li><a>' . esc_html( $user->display_name ) . '</a></li>';
									}
								?>
								
								</div>	
									</div>
								</section>

							</main>
						</div>
			<?php break;
					case 'Publications': ?>
					
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une publication</button>
			<?php break;
					case 'Photos': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une photo</button>			
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
