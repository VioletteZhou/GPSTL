<?php

/**
 * The category template file
 * @package Busiprof
 */
get_header();
$info_list = array();
$template_uri = BUSI_TEMPLATE_DIR_URI. '/images/default/';
$current_options = wp_parse_args(  get_option( 'busiprof_theme_options', array() ), theme_setup_data() );
?>
<!-- Page Title -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<!-- <div class="page-title">
					<h2><?php  _e("Category Archive ", 'busiprof'); echo single_cat_title( '', false ); ?></h2>
					<p><?php bloginfo('description');?></p>
				</div> -->
			</div>
			<div class="col-md-6">
				<ul class="page-breadcrumb">
					 <?php if (function_exists('busiprof_custom_breadcrumbs')) busiprof_custom_breadcrumbs();?>
				</ul>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="row"></div>
	<div class="container">
	    <?php
	    $thiscat = single_cat_title('',false);
			  if($thiscat=='Login'){  ?>
						<form style= "margin-top:30px; margin-bottom: 30px;" action= <?php echo site_url()."/isir-login"; ?> method="post">
								<div class="md-form"><i class="fa fa-envelope prefix"></i>
								<input id="exampleInputEmail1" class="form-control" type="email" placeholder="Enter email" aria-describedby="emailHelp" />
								<label for="exampleInputEmail1" data-error="wrong" data-success="right">Type your email</label></div>
								<!-- password -->
								<div class="md-form"><i class="fa fa-lock prefix"></i>
								<input id="inputValidationEx2" class="form-control validate" type="password" />
								<label for="inputValidationEx2" data-error="wrong" data-success="right">Type your password</label></div>
								<!-- Validation button -->
								<input name="test_button" type="submit" value="Submit me" />
								</form>

    <?php
				}else {

	      if($thiscat=='Chercheur'){
	        $blogusers = get_users('blog_id=0');
	        $homeurl = home_url();
	        foreach ($blogusers as $user)
	        {   if($user->user_nicename!='root'){
	            $url = $homeurl.'/'.$user->user_nicename;
							array_push($info_list,['name' => $user->user_nicename , 'url' => $url , 'email' => $user->user_email]);
	        }
	        }
	      }else {
	         if($thiscat=='Equipe'){
	           $need = '/equipe';
	         }else if($thiscat=='Project'){
	           $need = '/projet';
	         }else if($thiscat=='Laboratoire'){
	           $need = '/lab';
	         }
	         $blog_list = get_blog_list( 0, 'all' );
	         $homeurl = home_url();
	         foreach ($blog_list AS $blog)
	         {
	             $blog_details = get_blog_details($blog['blog_id']);
	             if(strpos($blog_details->path, $need)){
										array_push($info_list,['name' => $blog_details->blogname , 'url' => $blog_details->siteurl]);
	             }
	          }
	      }
	}
	    ?>
	</div>
</section>

<!-- Portfolio Section -->
<?php if($thiscat == 'Chercheur'){  array_multisort(array_column($info_list, 'name'), SORT_ASC, $info_list); ?>
	<section id="section" class="portfolio bg-color">
		<div class="container">
			<!-- Section Title -->
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h1 class="section-heading"><?php echo $thiscat; ?>
						</h1>
						<p><?php echo esc_html($current_options['protfolio_description_tag']); ?></p>
						<form style="margin-top:30px;margin-bottom:30px;" method="post" id="searchform" action="http://localhost/ISIR/wp-content/themes/busiprof/category-Chercheur.php ">
							<input type="text" class="search_btn"  name="s" id="s" placeholder="<?php esc_attr_e( "Search", 'busiprof' ); ?>" />
							<input type="submit" class="submit_search" style="" name="submit" value="<?php esc_attr_e( "Search", 'busiprof' ); ?>" />
						</form>
					</div>
				</div>
			</div>
			<!-- /Section Title -->
			<!-- Portfolio Item -->
		<div class="tab-content main-portfolio-section" id="myTabContent">
			<!-- Portfolio Item -->
				<div class="row">
					<?php
	 			 for ($x=0; $x<count($info_list); $x++) {?>
					 <div class="col-md-3 col-sm-6 col-xs-12" onclick="location.href='<?php echo $info_list[$x]['url']; ?>';">
	 					<aside class="post">
	 						<figure class="post-thumbnail">
								<img alt="" src="<?php  $i = $x%4; echo esc_url($template_uri .'/rec_project'.$i.'.jpg'); ?>" class="project_feature_img" />
	 						</figure>
	 						<div class="portfolio-info">
	 							<div class="entry-header">
	 								<h4 class="entry-title">
	 								<?php echo esc_html($info_list[$x]['name']); ?>
	 								</h4>
	 							</div>
	 							<div class="entry-content">
	 								<p><?php
									if($info_list[$x]['email']){
										  echo esc_html($info_list[$x]['email']);
									}else{
								  		echo esc_html("Description ".$x);
									}
									?></p>
	 							</div>
	 						</div>
	 					</aside>
	 				</div>
	       <?php  } ?>
				</div>
		</div>
	</section>
	<?php }?>


	<?php if($thiscat == 'Project'|| $thiscat == 'Equipe'){  array_multisort(array_column($info_list, 'name'), SORT_ASC, $info_list); ?>
	<section id="section" class="service">
		<div class="container">

			<!-- Section Title -->
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h1 class="section-heading"><?php echo $thiscat; ?></h1>
						<p><?php echo $current_options['service_tagline']; ?></p>
						<form style="margin-top:30px;margin-bottom:30px;" method="post" id="searchform" action="<?php echo esc_url( "http://localhost/ISIR/wp-content/themes/busiprof/category-Chercheur.php" ); ?> ">
							<input type="text" class="search_btn"  name="s" id="s" placeholder="<?php esc_attr_e( "Search", 'busiprof' ); ?>" />
							<input type="submit" class="submit_search" style="" name="submit" value="<?php esc_attr_e( "Search", 'busiprof' ); ?>" />
						</form>
					</div>
				</div>
			</div>
				<!-- /Section Title -->
				<!-- Portfolio Item -->
				<div id="service_content" class="row">
				<!-- Portfolio Item -->
						<?php
						  $icon = "fa-life-ring";
						  $type = "Assistance aux Gestes et Applications THErapeutiques (ERL INSERM U1150)";
						  if($thiscat=='Project'){
							$icon = "fa-tasks";
							$type = "Projet ANR PROSBOT - Robot Prostatique Contrôlé par Modèle et Image - novembre 2011 / novembre 2014";
						}
		 			 for ($x=0; $x<count($info_list); $x++) {?>
						 <div class="col-md-3 col-sm-6 col-xs-12" onclick="location.href='<?php echo $info_list[$x]['url']; ?>';">
						 <div class="post">
						 	<div class="service-icon"><i class="fa <?php echo $icon; ?>"></i>
						 	</div>
						 	<div class="entry-header">
						 		<h4 class="entry-title"><?php echo esc_html($info_list[$x]['name']); ?></h4>
						 	</div>
						 	<div class="entry-content">
						 		<p><?php echo esc_html($type); ?></p>
						 	</div>
						 </div>
						 </div>
		       <?php  } ?>
					</div>
			</div>
	</section>

	<!-- End of Portfolio Section -->
<?php }?>

<!-- End of Page Title -->
<!-- <div class="clearfix"></div> -->
<!-- <div class="clearfix"></div> -->
<?php
if($_POST[s] !=''){
	  // $valueToSearch = $_POST[s];
		// $_POST[s] = "you"

}else{
		// $_POST[s] = "rien";
}
?>
<?php get_footer(); ?>
