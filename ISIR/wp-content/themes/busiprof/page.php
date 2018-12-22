<?php
get_header();
get_template_part('index', 'bannerstrip');
?>
<div class="page-content">
		<?php the_post(); echo the_content(); ?>
</div>
<div class="clearfix"></div>
<?php get_footer(); ?>
