<?php get_header();

get_template_part( 'content/archive-header' );

?>
<link rel="stylesheet" type="text/css" href="..\style.css">
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
			$table_name = 'isir_'.$blog_id.'_video';
			$blog_id = get_current_blog_id();
			$result = $wpdb->get_results( "SELECT * FROM isir_".$blog_id."_video WHERE isFavoris=1" );
			foreach ( $result as $print )   {
				echo '
					<div width="400px" style=" background-color:#FFFFFF; padding-bottom:20px; margin:15px; overflow:hidden; display: inline-block; " >
							<iframe width="600px" height="350px" src="'.$print->url.'" ></iframe>
							<div style="padding-left:20px;padding-right:20px; font-weight: bold;">'.$print->titre.'</div>
					</div>
					'; 
				}  
		}
 
 
		$page_title = $wp_query->post->post_title;
		switch($page_title)
		{
				case 'Textes': ?>
			
		<?php break;
				case 'Vidéos': 
			
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
