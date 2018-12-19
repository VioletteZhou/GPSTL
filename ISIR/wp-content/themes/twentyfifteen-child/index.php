<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
	
		<?php 

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
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->


