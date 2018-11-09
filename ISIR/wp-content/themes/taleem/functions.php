<?php
		
	
	include_once 'inc/customizer.php';

	function taleem_enqueue_styles() {
		
		wp_enqueue_style( 'taleem-parent-style', get_template_directory_uri() . '/style.css' );
		
		wp_enqueue_style( 'taleem-common-style', get_stylesheet_directory_uri() . '/css/general.css?t='.time() );
		wp_enqueue_style( 'taleem-media-style', get_stylesheet_directory_uri() . '/css/devices.css' );
		
		wp_enqueue_script( 'taleem-scripts', get_stylesheet_directory_uri() . '/js/clientside.js', array( 'jquery' ), '', true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}		
	}
	add_action('wp_enqueue_scripts', 'taleem_enqueue_styles');
		
		
	function taleem_content_width() {
	
		$content_width = $GLOBALS['content_width'];
	
		// Get layout.
		$page_layout = get_theme_mod( 'page_layout' );
	
		// Check if layout is one column.
		if ( 'one-column' === $page_layout ) {
			if ( is_front_page() ) {
				$content_width = 644;
			} elseif ( is_page() ) {
				$content_width = 740;
			}
		}
	
		// Check if is single post and there is no sidebar.
		if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
			$content_width = 740;
		}
		$GLOBALS['content_width'] = apply_filters( 'taleem_content_width', $content_width );
	}
	add_action( 'template_redirect', 'taleem_content_width', 0 );	
	
	add_filter( 'document_title_parts', 'wp_remove_title_sitename' );
	  function wp_remove_title_sitename( $title ) {
		if ( is_search() || is_404() || is_author() || is_tag() ) {
		unset( $title['site'] );
		}
		return $title;
	  }
	
	// breadcrumb list
	if (!function_exists('taleem_breadcrumb')) {
	  function taleem_breadcrumb($divOption = array("id" => "wp_breadcrumb", "class" => "wp_breadcrumb inner wrap cf")){
		  global $post;
		  $str ='';
		  if(!get_option('side_options_pannavi')){
			if(!is_home()&&!is_front_page()&&!is_admin() ){
				$tagAttribute = '';
				foreach($divOption as $attrName => $attrValue){
					$tagAttribute .= sprintf(' %s="%s"', $attrName, esc_attr($attrValue));
				}
				$str.= '<div'. $tagAttribute .'>';
				$str.= '<ul itemscope itemtype="http://schema.org/BreadcrumbList">';
				$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( home_url() ) .'/" itemprop="item"><span itemprop="name">'.__('HOME', 'taleem').'</span></a></li>';
	 
				if(is_category()) {
					$cat = get_queried_object();
					if($cat -> parent != 0){
						$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
						foreach($ancestors as $ancestor){
							$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( get_category_link($ancestor) ) .'" itemprop="item"><span itemprop="name">'. esc_html( get_cat_name($ancestor) ) .'</span></a></li>';
						}
					}
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'. esc_attr($cat->name) . '</span></li>';
				} elseif(is_single()){
					$categories = get_the_category($post->ID);
					$cat = $categories[0];
					if($cat -> parent != 0){
						$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
						foreach($ancestors as $ancestor){
							$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( get_category_link($ancestor) ).'" itemprop="item"><span itemprop="name">'. esc_html( get_cat_name($ancestor) ). '</span></a></li>';
						}
					}
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( get_category_link($cat -> term_id) ). '" itemprop="item"><span itemprop="name">'. $cat-> cat_name . '</span></a></li>';
					$str.= '<li>'. $post -> post_title .'</li>';
				} elseif(is_page()){
					if($post -> post_parent != 0 ){
						$ancestors = array_reverse(get_post_ancestors( $post->ID ));
						foreach($ancestors as $ancestor){
							$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. get_permalink($ancestor).'" itemprop="item"><span itemprop="name">'. esc_html( get_the_title($ancestor) ) .'</span></a></li>';
						}
					}
					$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'. esc_attr($post->post_title) .'</span></li>';
				 } else{
					$str.='<li>'. wp_get_document_title('', false) .'</li>';
				}
				$str.='</ul>';
				$str.='</div>';
			}
		}
		  echo $str;
	  }
	}
	
	// Year of issue
	function taleem_get_first_post_year(){
	  $year = null;
	  query_posts('posts_per_page=1&order=ASC');
	  if ( have_posts() ) : while ( have_posts() ) : the_post();
		$year = intval(get_the_time('Y'));
	  endwhile; endif;
	  wp_reset_query();
	  return $year;
	}
	 
	//Copyright
	function taleem_get_copylight_credit(){
	  $site_tag = get_bloginfo('name');
	  return '&copy; '.taleem_get_first_post_year().' '.$site_tag;
	}
	
	function taleem_footer_scripts(){
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$custom_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		
		$all_theme_options = get_option('taleem_theme_options', array());
		
		
?>
	<style type="text/css">
		<?php if(!empty($custom_logo)): ?>	
		body.home footer.site-footer:after{
			background: url("<?php echo $custom_logo[0]; ?>") no-repeat 0 0;
			background-size: auto 72px;
			background-position: bottom center;			
		}
		<?php endif; ?>
		
		<?php 
			if(!empty($all_theme_options)){
				foreach($all_theme_options as $option_key=>$option_value){
					switch($option_key){
						case 'bars_bgcolor':
		?>
							.site-content .page-header,
							.home.blog #primary .pagination,
							.wp_breadcrumb,
							.comments-pagination, .post-navigation{
								background-color: <?php echo taleem_hex2rgba($option_value, 0.9); ?>;
							}
		<?php							
						break;
						
						case 'pagination_color':
		?>
							.nav-links a, .nav-links a:visited,
							.page-numbers.current, .page-links span.page-number{
								color: <?php echo $option_value; ?>;
							}
		<?php							
						break;
						
						case 'pagination_bgcolor':
		?>
							.pagination .prev.page-numbers:hover, .pagination .next.page-numbers:hover,
							.pagination a:not(.prev):not(.next):focus, .pagination a:not(.prev):not(.next):hover,
							.pagination .nav-links span:hover{
								background-color: <?php echo $option_value; ?>;
							}
		<?php							
						break;					
						
						case 'buttons_bgcolor':
		?>																	
							button, input[type="button"], input[type="submit"]{
								background: <?php echo $option_value; ?>;
							}
							button:hover, input[type="button"]:hover, input[type="submit"]:hover{
								background-color: <?php echo taleem_hex2rgba($option_value, 0.9); ?>;
							}
						
		<?php							
						break;	
						
						case 'buttons_color':
		?>																	
							button, input[type="button"], input[type="submit"]{
								color: <?php echo taleem_hex2rgba($option_value, 0.9); ?>;
							}
							button:hover, input[type="button"]:hover, input[type="submit"]:hover{
								color: <?php echo $option_value; ?>;
							}							
						
		<?php							
						break;		
						
						case 'link_color':
		?>																	
							a, a:visited{
								color: <?php echo $option_value; ?>;
							}						
						
		<?php							
						break;				
						
						case 'link_hover_color':
		?>																	
							a:hover, a:focus, .entry-content a:focus, .entry-content a:hover, .entry-summary a:focus, .entry-summary a:hover, .widget a:focus, .widget a:hover, .site-footer .widget-area a:focus, .site-footer .widget-area a:hover, .posts-navigation a:focus, .posts-navigation a:hover, .comment-metadata a:focus, .comment-metadata a:hover, .comment-metadata a.comment-edit-link:focus, .comment-metadata a.comment-edit-link:hover, .comment-reply-link:focus, .comment-reply-link:hover, .widget_authors a:focus strong, .widget_authors a:hover strong, .entry-title a:focus, .entry-title a:hover, .entry-meta a:focus, .entry-meta a:hover, .page-links a:focus .page-number, .page-links a:hover .page-number, .entry-footer a:focus, .entry-footer a:hover, .entry-footer .cat-links a:focus, .entry-footer .cat-links a:hover, .entry-footer .tags-links a:focus, .entry-footer .tags-links a:hover, .post-navigation a:focus, .post-navigation a:hover, .comments-pagination a:not(.prev):not(.next):focus, .comments-pagination a:not(.prev):not(.next):hover, .logged-in-as a:focus, .logged-in-as a:hover, a:focus .nav-title, a:hover .nav-title, .edit-link a:focus, .edit-link a:hover, .site-info a:focus, .site-info a:hover, .widget .widget-title a:focus, .widget .widget-title a:hover, .widget ul li a:focus, .widget ul li a:hover{
								color: <?php echo $option_value; ?>;
							}						
						
		<?php							
						break;	
						
						case 'header_bgcolor':
		?>																	
							.site-header{
								background-color: <?php echo taleem_hex2rgba($option_value, 0.9); ?>;
							}
												
						
		<?php							
						break;		
						
						
						case 'menu_bgcolor':
		?>																	
							.js .main-navigation ul,
							.js .main-navigation ul.menu{
								background-color: <?php echo $option_value; ?>;
							}
							.js .home .menu-toggle, .js .menu-toggle{
								background-color: <?php echo taleem_hex2rgba($option_value, 0.3); ?>;
								
							}

		<?php							
						break;		
						
						
						case 'menu_text_color':
		?>																	
							.main-navigation li a,
							.js .home .menu-toggle, .js .menu-toggle{
								color: <?php echo $option_value; ?>;
							}
							.js .home .menu-toggle, .js .menu-toggle{
								border:1px solid <?php echo taleem_hex2rgba($option_value, 0.5); ?>;
							}
							.js .home .menu-toggle svg, .js .menu-toggle svg{
								color: <?php echo $option_value; ?>;
							}												
						
		<?php							
						break;																							
								
						
					}
				}
			}
		?>
		
	</style>			
<?php			
	}
	
	add_action('wp_footer', 'taleem_footer_scripts');
	
		
	function taleem_hex2rgba($color, $opacity = false) {
	 
		$default = 'rgb(0,0,0)';
	 
		//Return default if no color provided
		if(empty($color))
			  return $default; 
	 
		//Sanitize $color if "#" is provided 
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}
	 
			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}
	 
			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
	 
			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
	 
			//Return rgb(a) color string
			return $output;
	}	
	
	function taleem_setup() {
		

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
	
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
	
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
	
		add_image_size( 'taleem-featured-image', 2000, 1200, true );
	
		add_image_size( 'taleem-thumbnail-avatar', 100, 100, true );
	
		// Set the default content width.
		$GLOBALS['content_width'] = 525;
	
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'top'    => __( 'Top Menu', 'taleem' ),
				'social' => __( 'Social Links Menu', 'taleem' ),
			)
		);
	
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
	
		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);
	
		// Add theme support for Custom Logo.
		add_theme_support(
			'custom-logo', array(
				'width'      => 250,
				'height'     => 250,
				'flex-width' => true,
			)
		);
	
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
				
		$defaults = array(
			'default-color'          => '',
			'default-image'          => get_stylesheet_directory_uri().'/images/book-1822474_1920.jpg',
			'default-repeat'         => 'no-repeat',
			'default-position-x'     => 'center',
			'default-position-y'     => 'center',
			'default-size'           => 'cover',
			'default-attachment'     => 'fixed',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);
				
		add_theme_support( 'custom-background', $defaults );
		
		
	
		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
		  */
		  
		if(function_exists('taleem_fonts_url'))
		add_editor_style( array( 'assets/css/editor-style.css', taleem_fonts_url() ) );
		
		
	
		// Define and register starter content to showcase the theme on new sites.
		$starter_content = array(
			'widgets'     => array(
				// Place three core-defined widgets in the sidebar area.
				'sidebar-1' => array(
					'text_business_info',
					'search',
					'text_about',
				),
	
				// Add the core-defined business info widget to the footer 1 area.
				'sidebar-2' => array(
					'text_business_info',
				),
	
				// Put two core-defined widgets in the footer 2 area.
				'sidebar-3' => array(
					'text_about',
					'search',
				),
			),
	
			// Specify the core-defined pages to create and add custom thumbnails to some of them.
			'posts'       => array(
				'home',
				'about'            => array(
					'thumbnail' => '{{image-sandwich}}',
				),
				'contact'          => array(
					'thumbnail' => '{{image-espresso}}',
				),
				'blog'             => array(
					'thumbnail' => '{{image-coffee}}',
				),
				'homepage-section' => array(
					'thumbnail' => '{{image-espresso}}',
				),
			),
	
			// Create the custom image attachments used as post thumbnails for pages.
			'attachments' => array(
				'image-espresso' => array(
					'post_title' => _x( 'Media #1', 'Taleem starter content #1', 'taleem' ),
					'file'       => 'images/classroom-2787754_640.jpg', // URL relative to the template directory.
				),
				'image-sandwich' => array(
					'post_title' => _x( 'Media #2', 'Taleem starter content #2', 'taleem' ),
					'file'       => 'images/school-3518726_640.jpg',
				),
				'image-coffee'   => array(
					'post_title' => _x( 'Media #3', 'Taleem starter content #3', 'taleem' ),
					'file'       => 'images/pencils-1280558_640.jpg',
				),
			),
	
			// Default to a static front page and assign the front and posts pages.
			'options'     => array(
				'show_on_front'  => 'page',
				'page_on_front'  => '{{home}}',
				'page_for_posts' => '{{blog}}',
			),
	
			// Set the front page section theme mods to the IDs of the core-registered pages.
			'theme_mods'  => array(
				'panel_1' => '{{homepage-section}}',
				'panel_2' => '{{about}}',
				'panel_3' => '{{blog}}',
				'panel_4' => '{{contact}}',
			),
	
			// Set up nav menus for each of the two areas registered in the theme.
			'nav_menus'   => array(
				// Assign a menu to the "top" location.
				'top'    => array(
					'name'  => __( 'Top Menu', 'taleem' ),
					'items' => array(
						'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
						'page_about',
						'page_blog',
						'page_contact',
					),
				),
	
				// Assign a menu to the "social" location.
				'social' => array(
					'name'  => __( 'Social Links Menu', 'taleem' ),
					'items' => array(
						'link_yelp',
						'link_facebook',
						'link_twitter',
						'link_instagram',
						'link_email',
					),
				),
			),
		);
	
	
		$starter_content = apply_filters( 'taleem_starter_content', $starter_content );
	
		add_theme_support( 'starter-content', $starter_content );
		
		
	}
	add_action( 'after_setup_theme', 'taleem_setup' );
		
	function taleem_get_svg( $args = array() ) {
		// Make sure $args are an array.
		if ( empty( $args ) ) {
			return __( 'Please define default parameters in the form of an array.', 'taleem' );
		}
	
		// Define an icon.
		if ( false === array_key_exists( 'icon', $args ) ) {
			return __( 'Please define an SVG icon filename.', 'taleem' );
		}
	
		// Set defaults.
		$defaults = array(
			'icon'     => '',
			'title'    => '',
			'desc'     => '',
			'fallback' => false,
		);
	
		// Parse args.
		$args = wp_parse_args( $args, $defaults );
	
		// Set aria hidden.
		$aria_hidden = ' aria-hidden="true"';
	
		// Set ARIA.
		$aria_labelledby = '';
	
		if ( $args['title'] ) {
			$aria_hidden     = '';
			$unique_id       = uniqid();
			$aria_labelledby = ' aria-labelledby="title-' . esc_attr($unique_id) . '"';
	
			if ( $args['desc'] ) {
				$aria_labelledby = ' aria-labelledby="title-' . esc_attr($unique_id) . ' desc-' . esc_attr($unique_id) . '"';
			}
		}
	
		// Begin SVG markup.
		$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . esc_attr($aria_labelledby) . ' role="img">';
	
		// Display the title.
		if ( $args['title'] ) {
			$svg .= '<title id="title-' . esc_attr($unique_id) . '">' . esc_html( $args['title'] ) . '</title>';
	
			// Display the desc only if the title is already set.
			if ( $args['desc'] ) {
				$svg .= '<desc id="desc-' . esc_attr($unique_id) . '">' . esc_html( $args['desc'] ) . '</desc>';
			}
		}
	
		/*
		 * Display the icon.
		 *
		 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		 *
		 * See https://core.trac.wordpress.org/ticket/38387.
		 */
		$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';
	
		// Add some markup to use as a fallback for browsers that do not support SVGs.
		if ( $args['fallback'] ) {
			$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
		}
	
		$svg .= '</svg>';
	
		return $svg;
	}	
		
	function taleem_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'taleem' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'taleem' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	
		register_sidebar( array(
			'name'          => __( 'Footer 1', 'taleem' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Add widgets here to appear in your footer.', 'taleem' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	
		register_sidebar( array(
			'name'          => __( 'Footer 2', 'taleem' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Add widgets here to appear in your footer.', 'taleem' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
	add_action( 'widgets_init', 'taleem_widgets_init' );	
	
	function taleem_body_classes( $classes ) {	
	
	
		$image = get_background_image();
		if(empty($image)){
			$classes[] = 'bright';
		}
		
		
		return $classes;
	}	
	
	add_filter( 'body_class', 'taleem_body_classes', 11 );
	
