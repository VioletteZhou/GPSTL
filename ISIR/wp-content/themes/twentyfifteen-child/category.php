<?php
/**
* A Simple Category Template
*/

get_header(); ?>
<div id="content" role="main">
<?php
while ( have_posts() ) : the_post();

  // Include the page content template.
  get_template_part( 'content', 'page' );

// End the loop.
endwhile; ?>
