<header role="banner">

	<div class="container">
		<div class="col-md-4 col-sm-4 col-xs-12 header-fabify padding-top-25">
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand">
				<?php
					if(has_custom_logo())
					{	
						the_custom_logo();
					}
					else { 
						echo bloginfo('name'); 
					}
				?>
				
				<?php
					$description = get_bloginfo( 'description');
					if ($description) : ?>
						<p class="site-description"><?php echo $description; ?></p>
				<?php endif; ?>
			</a>
		</div>
		
		<div class="col-md-8 col-sm-8 col-xs-12 header-fabify padding-top-25">
			<ul class="search-cart text-right">
				<?php
					$button_label= get_theme_mod('button_label','Book Now');
					$button_url= get_theme_mod('button_url');
					$button_icon= get_theme_mod('button_icon','fa-clock-o'); 			
					$header_cart= get_theme_mod('header_cart','on');
					$header_search= get_theme_mod('header_search','on');
				?>
				
				<li>
					<form class="searchbox"  action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
					<input type="search" name="s" id="s" placeholder="<?php esc_attr_e( 'Search anything...','fabify' ); ?>" name="search" class="searchbox-input" onkeyup="buttonUp();" required>
					<input type="submit" class="searchbox-submit" value="">
					<span class="searchbox-icon"><i class="fa fa-search"></i></span>
					</form>
				</li>
				
				<?php if($header_cart== 'on') :?>
				<li>
					<div class="fabify-cart">
						<a href="" class="cart-icon"><i class="fa fa-cart-plus"></i>
							<span class="count">0</span>
						</a>
					</div>
				</li>
				<?php endif; ?>
				
				<?php if($button_label) :?>
				<li>
					<div class="fabify-button">
						<a href="<?php echo esc_url($button_url); ?>"><i class="fa <?php echo esc_html($button_icon); ?>"></i> <?php echo esc_html($button_label); ?></a>
					</div>
				</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
	
</header>

<div class="container">
	<nav class='navbar navbar-default nav-fabify <?php echo specia_sticky_menu(); ?>' role='navigation'>
		
		<div class="container">

			<!-- Mobile Display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only"><?php _e('Toggle navigation','fabify');?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- /Mobile Display -->

			<!-- Menu Toggle -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			<?php 
				wp_nav_menu( 
					array(  
						'theme_location' => 'primary_menu',
						'container'  => '',
						'menu_class' => 'nav navbar-nav navbar-right',
						'fallback_cb' => 'specia_fallback_page_menu',
						'walker' => new specia_nav_walker()
						 ) 
					);
			?>
			</div>
			<!-- Menu Toggle -->
			
		</div>
	</nav>
</div>
<div class="clearfix"></div>