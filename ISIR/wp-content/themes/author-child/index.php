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
				<div style="vertical-align:middle; ">
					<button type="button" style= " margin-bottom: 30px; float: right;">+ Ajouter un texte</button>
				</div>
		<?php break; 
				case 'Vidéos': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une vidéo</button>
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
				case 'Réseax Sociaux': ?>
					<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter un post facebook/twetter</button>			
		<?php break; 
				case 'BD Expérimentale': ?>
					<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une BD expérimentale</button>				
		<?php break;
					}?>
	</div>
<?php


get_footer();