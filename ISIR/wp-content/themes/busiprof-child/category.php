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
						if(!empty($_POST["namechercheur"])) {
							 $namechercheur = $_POST["namechercheur"];
						}else if(!empty($_POST["equipename"])) {
							 $equipename = $_POST["equipename"];
						}


            $thiscat = single_cat_title('',false);
            if($thiscat=='Login'){ ?>
        <?php
            }else {

               if($thiscat=='Chercheur'){
                 $blogusers = get_users('blog_id=0');
                 $homeurl = home_url();
                 foreach ($blogusers as $user)
                 {
									// echo "<script>alert(".$user.")</script>";
									if (strpos($a, 'are') !== false) {
									    echo 'true';
									}
									 		if($user->user_nicename!='root' && (empty($namechercheur) || strpos(strtolower($user->user_nicename), strtolower($namechercheur)) !== false) ){
		                     $url = $homeurl.'/'.$user->user_nicename;
			            			 array_push($info_list,['name' => $user->user_nicename , 'url' => $url , 'email' => $user->user_email]);
			                }
                 }
               }else {
                  if($thiscat=='Equipe'){
                    $need = 2;
                  }else if($thiscat=='Project'){
                    $need = 1;
                  }
                  $blog_list = get_blog_list( 0, 'all' );
                  $homeurl = home_url();
                  foreach ($blog_list AS $blog)
                  {
                      $blog_details = get_blog_details($blog['blog_id']);
                      if($blog_details->blog_type == $need && (empty($equipename) || strpos(strtolower($blog_details->blogname), strtolower($equipename)) !== false)){
            						array_push($info_list,['name' => $blog_details->blogname , 'url' => $blog_details->siteurl, 'blog_desc' => $blog_details->blog_desc]);
                      }
                   }
               }
            }
             ?>
    </div>
</section>
<!-- Portfolio Section -->
<?php if($thiscat == 'Chercheur'){  array_multisort(array_column($info_list, 'name'), SORT_ASC, $info_list); ?>
<section id="section" class="portfolio bg-color" >
    <div class="container">
    <!-- Section Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="section-title">
                <h1 class="section-heading"><?php echo $thiscat; ?>
                </h1>
                <p><?php echo esc_html($current_options['protfolio_description_tag']); ?></p>

							<form id="searchform" name="frmSearch" method="post" action="/ISIR/blog/category/chercheur/" style="margin-top:30px;margin-bottom:30px;">
									<input type="text" name="namechercheur" class="search_btn" value="<?php echo $namechercheur; ?>" placeholder="<?php esc_attr_e( "Search", 'busiprof' ); ?>"	/>
									<input type="submit" name="go" class="submit_search" value="Search">
							</form>



            </div>
        </div>
    </div>
    <!-- /Section Title -->
    <!-- Portfolio Item -->
    <div class="tab-content main-portfolio-section" id="myTabContent">
        <!-- Portfolio Item -->
        <div class="row" >
            <?php for ($x=0; $x<count($info_list); $x++) {?>
		            <div class="col-md-3 col-sm-6 col-xs-12" onclick="location.href='<?php echo $info_list[$x]['url']; ?>';">
		                <aside class="post">
		                    <figure class="post-thumbnail">
		                        <img alt="" src="<?php  $i = $x%4; echo esc_url($template_uri .'/rec_project'.$i.'.jpg'); ?>" class="project_feature_img" />
		                    </figure>
		                    <div class="portfolio-info">
		                        <div class="entry-header">
		                            <h4 class="entry-title" class="entry-content">
		                                <?php echo esc_html($info_list[$x]['name']); ?>
		                            </h4>
		                        </div>
		                        <div class="entry-content" >
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
										<?php if($thiscat == 'Equipe'){  ?>
										<form id="equipeform" name="equipeSearch" method="post" action="/ISIR/blog/category/equipe/" style="margin-top:30px;margin-bottom:30px;">
										<?php }?>
										<?php if($thiscat == 'Project'){  ?>
									  <form id="equipeform" name="equipeSearch" method="post" action="/ISIR/blog/category/project/" style="margin-top:30px;margin-bottom:30px;">
										<?php }?>
												<input type="text" name="equipename" class="search_btn" value="<?php echo $equipename; ?>" placeholder="<?php esc_attr_e( "Search", 'busiprof' ); ?>"	/>
												<input type="submit" name="go" class="submit_search" value="Search">
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
                        <p><?php echo esc_html($info_list[$x]['blog_desc']); ?></p>
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
    /*if($_POST[s] !=''){
    	  // $valueToSearch = $_POST[s];
    		// $_POST[s] = "you"

    }else{
    		// $_POST[s] = "rien";
    }*/
    ?>
<?php get_footer(); ?>
