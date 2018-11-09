<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="main-body" class="container">
		<header id="header" class="row">
			<?php
			if(get_header_image()) {
				?>
				<a href="<?php echo esc_url(home_url('/')); ?>"><img id="logo" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php echo bloginfo('name'); ?>" title="<?php _e( 'back to home', 'blogkori' );?>"/></a>
                <p id="tagline"><?php echo bloginfo('description'); ?></p>
				<?php
			} else {
				?>
				<div class="col-sm-12">
				<h1 id="title"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php _e( 'back to home', 'blogkori' );?>"><?php echo bloginfo('name'); ?></a></h1>
				<p id="tagline"><?php echo bloginfo('description'); ?></p>
				</div>
				<?php
			}
				
			?>
		</header>
		<nav id="nav" class="navbar navbar-default row" role="navigation">
  <div class="">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
	<div class="col-xs-10 no-pad">
	<h1 class="navbar-brand"><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo bloginfo('name'); ?></a></h1>
	</div>
	<div class="col-xs-2 no-pad">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only"><?php _e( 'Toggle navigation', 'blogkori' );?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
    </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
       <?php
            wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker())
            );
        ?>
    <!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
