<?php

/**
 * The category template file
 * @package WordPress
 */
get_header();
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
			  if($thiscat=='Login'){

					echo '<form style= "margin-top:30px; margin-bottom: 30px;" action="login.php" method="post">
<div class="md-form"><i class="fa fa-envelope prefix"></i>
<input id="exampleInputEmail1" class="form-control" type="email" placeholder="Enter email" aria-describedby="emailHelp" />
<label for="exampleInputEmail1" data-error="wrong" data-success="right">Type your email</label></div>
<!-- password -->
<div class="md-form"><i class="fa fa-lock prefix"></i>
<input id="inputValidationEx2" class="form-control validate" type="password" />
<label for="inputValidationEx2" data-error="wrong" data-success="right">Type your password</label></div>
<!-- Validation button -->
<input name="test_button" type="submit" value="Submit me" />
</form>';

				}else {

	      if($thiscat=='Chercheur'){
	        $blogusers = get_users('blog_id=0');
	        $homeurl = home_url();
	        echo '<div class="list"><ul>';
	        foreach ($blogusers as $user)
	        {   if($user->user_nicename!='root'){
	            $url = $homeurl.'/'.$user->user_nicename;
	            echo '<li><a href='.$url.'>'.$user->user_nicename.'</a></li>';
	        }
	        }
	        echo '</ul></div>';
	      }else {
	         if($thiscat=='Equipe'){
	           $need = '/equipe';
	         }else if($thiscat=='Project'){
	           $need = '/projet';
	         }else if($thiscat=='Laboratoire'){
	           $need = '/lab';
	         }
	         $names=array();
	         $urls=array();
	         $blog_list = get_blog_list( 0, 'all' ); //显示全部站点列表
	         $homeurl = home_url();
	         foreach ($blog_list AS $blog)
	         {
	             $blog_details = get_blog_details($blog['blog_id']);
	             if(strpos($blog_details->path, $need)){
	                  array_push($names,$blog_details->blogname);
	                  array_push($urls,$blog_details->siteurl);
	             }
	          }
	          sort($names);
	          sort($urls);
	          echo '<div class="list"><ul>';
	          for($i=0;$i<count($names);++$i){
	            echo '<li><a href='.$urls[$i].'>'.$names[$i].'</a></li>';
	          }
	          echo '</ul></div>';
	      }
	      echo '<style>
	            .list{margin:40px auto;}
	            li {list-style-type:none; line-height:40px; font-size:20px; text-align: center;  }
	            </style>';
	}

	    ?>
	</div>
</section>
<!-- End of Page Title -->
<!-- <div class="clearfix"></div> -->
<!-- <div class="clearfix"></div> -->

<?php get_footer(); ?>
