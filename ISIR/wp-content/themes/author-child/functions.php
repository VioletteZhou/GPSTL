<?php
/**
** activation theme
**/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
add_action( 'customize_register', 'ct_author_add_customizer_content_child',11 );

function theme_enqueue_styles() {
 wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );


}




// add Textes page

// add Textes page
wp_insert_term(

// the name of the category
'Textes',

// the taxonomy, which in this case if category (don't change)
'category',

array(

// what to use in the url for term archive
'slug' => 'Textes',
));


// Add videos page
$new_page_title = "Videos";
if(get_page_by_title("Videos") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Videos",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}
// Add Publications page
$new_page_title = "Publications";
if(get_page_by_title("Publications") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Publications",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


// Add Photos page

// Add Photos page
wp_insert_term(

// the name of the category
'Photos',

// the taxonomy, which in this case if category (don't change)
'category',

array(

// what to use in the url for term archive
'slug' => 'Photos',
));

// add code sources page
$new_page_title = "Codes Sources";
if(get_page_by_title("Codes Sources") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Codes Sources",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}


// add cours et présentations
$new_page_title = "Cours et présentations";
if(get_page_by_title("Cours et présentations") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Cours et présentations",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add Réseax Sociaux
$new_page_title = "Réseax Sociaux";
if(get_page_by_title("Réseax Sociaux") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Réseax Sociaux",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add BD Expérimentale
$new_page_title = "BD Expérimentale";
if(get_page_by_title("BD Expérimentale") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "BD Expérimentale",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}

// add video live
$new_page_title = "Videos live";
if(get_page_by_title("Videos live") == null){
	$new_page = array(
		'post_type' => 'page',
		'post_title' => "Videos live",
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
	);
$page_check = get_page_by_title($new_page_title);
	if(!isset($page_check->ID)){
		$new_page_id = wp_insert_post($new_page);
	}
}



function ct_author_add_customizer_content_child( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'author' );
	}

	/***** Add PostMessage Support *****/

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Add Custom Controls *****/


	/***** Avatar *****/

	// section
	$wp_customize->add_section( 'ct_author_avatar', array(
		'title'    => __( 'Avatar', 'author' ),
		'priority' => 15
	) );
	// setting
	$wp_customize->add_setting( 'avatar_method', array(
		'default'           => 'none',
		'sanitize_callback' => 'ct_author_sanitize_avatar_method'
	) );
	// control
	$wp_customize->add_control( 'avatar_method', array(
		'label'       => __( 'Avatar image source', 'author' ),
		'section'     => 'ct_author_avatar',
		'settings'    => 'avatar_method',
		'type'        => 'radio',
		'description' => __( 'Gravatar uses the admin email address.', 'author' ),
		'choices'     => array(
			'gravatar' => __( 'Gravatar', 'author' ),
			'upload'   => __( 'Upload an image', 'author' ),
			'none'     => __( 'Do not display avatar', 'author' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'avatar', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'avatar', array(
			'label'    => __( 'Upload your avatar', 'author' ),
			'section'  => 'ct_author_avatar',
			'settings' => 'avatar'
		)
	) );

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_author_logo_upload', array(
		'title'       => __( 'Logo', 'author' ),
		'priority'    => 25,
		'description' => __( 'Use this instead of the avatar if you want a non-rounded logo image.', 'author' )
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'logo_image', array(
			'label'    => __( 'Upload custom logo.', 'author' ),
			'section'  => 'ct_author_logo_upload',
			'settings' => 'logo_upload'
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_author_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_author_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'author' ),
		'priority'    => 35,
		'description' => __( 'Add the URL for each of your social profiles.', 'author' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_author_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'author' ),
				'section'  => 'ct_author_social_media_icons',
				'priority' => $priority,
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = __('Google Plus', 'author');
			} elseif ( $social_site == 'rss' ) {
				$label = __('RSS', 'author');
			} elseif ( $social_site == 'soundcloud' ) {
				$label = __('SoundCloud', 'author');
			} elseif ( $social_site == 'slideshare' ) {
				$label = __('SlideShare', 'author');
			} elseif ( $social_site == 'codepen' ) {
				$label = __('CodePen', 'author');
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'author');
			} elseif ( $social_site == 'deviantart' ) {
				$label = __('DeviantArt', 'author');
			} elseif ( $social_site == 'hacker-news' ) {
				$label = __('Hacker News', 'author');
			} elseif ( $social_site == 'google-wallet' ) {
				$label = __('Google Wallet', 'author');
			} elseif ( $social_site == 'whatsapp' ) {
				$label = __('WhatsApp', 'author');
			} elseif ( $social_site == 'qq' ) {
				$label = __('QQ', 'author');
			} elseif ( $social_site == 'vk' ) {
				$label = __('VK', 'author');
			} elseif ( $social_site == 'ok-ru' ) {
				$label = __('OK.ru', 'author');
			} elseif ( $social_site == 'wechat' ) {
				$label = __('WeChat', 'author');
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'author');
			} elseif ( $social_site == 'paypal' ) {
				$label = __('PayPal', 'author');
			} elseif ( $social_site == 'stack-overflow' ) {
				$label = __('Stack Overflow', 'author');
			} elseif ( $social_site == 'email-form' ) {
				$label = __('Contact Form', 'author');
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_author_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'author' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_author_social_media_icons',
					'priority'    => $priority
				) );
			} else if ( $social_site == 'phone' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_author_sanitize_text'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'text',
					'label'       => $label,
					'section'     => 'ct_author_social_media_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label,
					'section'  => 'ct_author_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'author_blog', array(
		'title'    => _x( 'Blog', 'noun: the blog section',  'author' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_author_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'author' ),
		'section'  => 'author_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'author' ),
			'no'  => __( 'No', 'author' )
		)
	) );
	// setting - comments link
	$wp_customize->add_setting( 'comments_link', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_author_sanitize_yes_no_settings'
	) );
	// control - comments link
	$wp_customize->add_control( 'comments_link', array(
		'label'    => __( 'Show link to comments after posts?', 'author' ),
		'section'  => 'author_blog',
		'settings' => 'comments_link',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'author' ),
			'no'  => __( 'No', 'author' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'author' ),
		'section'  => 'author_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Continue reading', 'author' ),
		'sanitize_callback' => 'ct_author_sanitize_text'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More link text', 'author' ),
		'section'  => 'author_blog',
		'settings' => 'read_more_text',
		'type'     => 'text'
	) );

	/***** Comment Display *****/

	// section
	$wp_customize->add_section( 'ct_author_comments_display', array(
		'title'    => __( 'Comment Display', 'author' ),
		'priority' => 55
	) );
	// setting
	$wp_customize->add_setting( 'comments_display', array(
		'default'           => array( 'post', 'page', 'attachment', 'none' ),
		'sanitize_callback' => 'ct_author_sanitize_comments_setting'
	) );
	// control
	$wp_customize->add_control( new ct_author_multi_checkbox_control(
		$wp_customize, 'comments_display', array(
			'label'    => __( 'Show comments on:', 'author' ),
			'section'  => 'ct_author_comments_display',
			'settings' => 'comments_display',
			'type'     => 'multi-checkbox',
			'choices'  => array(
				'post'       => __( 'Posts', 'author' ),
				'page'       => __( 'Pages', 'author' ),
				'attachment' => __( 'Attachments', 'author' ),
				'none'       => __( 'Do not show', 'author' )
			)
		)
	) );

	/***** Scroll-to-stop  *****/

	// section
	$wp_customize->add_section( 'ct_author_scroll_to_stop', array(
		'title'    => __( 'Scroll-to-Top Arrow', 'author' ),
		'priority' => 60
	) );
	// setting - scroll-to-top arrow
	$wp_customize->add_setting( 'scroll_to_top', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_author_sanitize_yes_no_settings'
	) );
	// control - scroll-to-top arrow
	$wp_customize->add_control( 'scroll_to_top', array(
		'label'    => __( 'Display Scroll-to-top arrow?', 'author' ),
		'section'  => 'ct_author_scroll_to_stop',
		'settings' => 'scroll_to_top',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'author' ),
			'no'  => __( 'No', 'author' )
		)
	) );

	/***** Custom CSS *****/

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
    echo "if existes ";
		// Migrate any existing theme CSS to the core option added in WordPress 4.7.
		$css = get_theme_mod( 'custom_css' );
		if ( $css ) {
      echo "test if ";
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'custom_css' );
			}
		}else{
        echo "test else ";
    }
      echo "test fin ";
	} else {
		// section
		$wp_customize->add_section( 'author_custom_css', array(
			'title'    => __( 'Custom CSS', 'author' ),
			'priority' => 65
		) );
		// setting
		$wp_customize->add_setting( 'custom_css', array(
			'sanitize_callback' => 'ct_author_sanitize_css',
			'transport'         => 'postMessage'
		) );
		// control
		$wp_customize->add_control( 'custom_css', array(
			'type'     => 'textarea',
			'label'    => __( 'Add Custom CSS Here:', 'author' ),
			'section'  => 'author_custom_css',
			'settings' => 'custom_css'
		) );
	}
}
