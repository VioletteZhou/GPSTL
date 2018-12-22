<?php
/**
* A Simple Category Template
*/
 
get_header(); ?> 
 
<section id="primary" class="site-content">
<div id="content" role="main">

 
 
<section>
	<div class="row"></div>
	<div class="container">
	    <?php
			$thiscat = single_cat_title('',false);?>
			<div class="md-form" style= "margin-top:30px; margin-bottom: 30px;">
			<?php
			switch($thiscat){
				case 'Textes': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter un texte</button>
		  <?php break; 
		  		case 'Vidéos': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une vidéos</button>
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
		  <?php break; ?>
			</div>
		  <?php }
	    ?>
	</div>
</section>
 
<?php get_footer(); ?>