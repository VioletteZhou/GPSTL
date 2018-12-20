<header role="banner">
	<nav class='navbar navbar-default <?php echo specia_sticky_menu(); ?>' role='navigation'>

		<div class="container">

			<!-- Mobile Display -->
			<div class="navbar-header">
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



				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only"><?php echo 'Toggle navigation'; ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- /Mobile Display -->

			<!-- Menu Toggle -->

			<?php

			$page1 = get_category_by_slug("Textes");
			$page2 = get_page_by_title("Videos");
			$page3 = get_page_by_title("Publications");
			$page4 = get_category_by_slug("Photos");
			$page5 = get_page_by_title("Codes Sources");
			$page6 = get_page_by_title("Cours & Présentation");
			$page7 = get_page_by_title("Réseax Sociaux");
			$page8 = get_page_by_title("BD Expérimentale");
			$page9 = get_page_by_title("Videos live");


			?>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			<ul class="nav navbar-nav navbar-right">
				<li id=" menu-item-0 " class="menu-item menu-item-2"><a href="<?php echo get_category_link($page1->term_id); ?>" title="Textes">Textes</a></li>
				<li id=" menu-item-1 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page2->ID ); ?>">Vidéos</a></li>
				<li id=" menu-item-2 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page3->ID ); ?>">Publications</a></li>
				<li id=" menu-item-3 " class="menu-item menu-item-2"><a href="<?php echo get_category_link($page4->term_id); ?>">Photos</a></li>
				<li id=" menu-item-4 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page5->ID ); ?>">Codes Sources</a></li>
				<li id=" menu-item-5 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page6->ID ); ?>">Cours et présentations</a></li>
				<li id=" menu-item-6 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page7->ID ); ?>">Réseaux sociaux</a></li>
				<li id=" menu-item-7 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page8->ID ); ?>">BD expérimentales</a></li>
				<li id=" menu-item-8 " class="menu-item menu-item-2"><a href="<?php echo get_permalink( $page9->ID ); ?>">Videos live</a></li>


			</ul>

			</div>
			<!-- Menu Toggle -->

		</div>
	</nav>
</header>
<div class="clearfix"></div>
