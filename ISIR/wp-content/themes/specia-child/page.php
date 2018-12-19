<?php
get_header();
get_template_part('sections/specia','breadcrumb'); ?>

<section class="page-wrapper">
	<div class="container">
					
		
		<div class="row padding-top-60 padding-bottom-60">		
			<?php 

			
			$page_title = $wp_query->post->post_title; 	
			echo $page_title ; 
		 						
			switch($page_title)
			{
				  case 'Textes': ?>
					<div style="vertical-align:middle; ">
						<button type="button" style= " margin-bottom: 30px; float: right;">+ Ajouter un texte</button>
					</div>
			<?php break; 
				
					case 'Vidéos': 
			
				echo '
				<div>
					<form action="/action_page.php" style="margin-bottom:20px;align:center;  ">
					  <input type="text" placeholder="Search for a video . . . " name="search" style="display:inline-block; width:60%; ">
					  <button type="submit" style="display:inline-block; " ><i class="fa fa-search"></i></button>
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
				case 'Videos live': 
					$blog_id = get_current_blog_id();
					$result = $wpdb->get_results( "SELECT * FROM isir_youtubelive WHERE blog_id=".$blog_id."");
					$row = json_decode(json_encode($result[0]), True);
					$embed = $row['sharelink'];
					echo "<h3>".$row['title']."</h3>";
					printf('<iframe width="560" height="315" src="https://www.youtube.com/embed/%s?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>',$embed);
					echo "<h4>By : ".$row['author_name']."<h4>";
			?>
			<?php break;
				case 'Publications': ?>
					<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une publication</button>
			<?php break;
					case 'Photos': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une photo</button>			
			<?php break; 
					case 'Code source': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter du code source</button>				
			<?php break;
					case 'Cours & Présentation': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter un cours/une présentation</button>			
			<?php break; 
					case 'Réseax Sociaux': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter un post facebook/twetter</button>			
			<?php break; 
					case 'BD Expérimentale': ?>
						<button type="button" style= "margin-top:30px; margin-bottom: 30px; float: right;">+ Ajouter une BD expérimentale</button>				
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
		
				

			</div><!-- /.posts -->
							
			</div><!-- /.col -->
			
						
		</div><!-- /.row -->
	</div><!-- /.container -->
</section>

<?php get_footer(); ?>

