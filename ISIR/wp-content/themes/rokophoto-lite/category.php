<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RokoPhoto
 */
get_header(); ?>
<div class="row"></div>
<div class="container">
    <?php
    $thiscat = single_cat_title('',false);
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
    ?>
</div>

<?php get_footer(); ?>
