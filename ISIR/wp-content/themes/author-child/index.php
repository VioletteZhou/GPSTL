<?php get_header();

get_template_part( 'content/archive-header' );

?>
	<div id="loop-container" class="loop-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				ct_author_get_content_template();
			endwhile;
		endif;

		
		?>
		<?php 

		$page_title = $wp_query->post->post_title;
											
		switch($page_title)
		{
				case 'Textes': ?>
				
		<?php break; 
				case 'Vidéos': ?>
						
		<?php break;
				case 'Publications': ?>
					
		<?php break;
				case 'Photos': ?>
							
		<?php break; 
				case 'Codes Sources': ?>
					
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
