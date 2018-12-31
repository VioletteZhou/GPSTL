<?php echo "<script type='text/javascript'></script>"; ?>
<?php
/**
 * Add Site Administration Screen
 *
 * @package WordPress
 * @subpackage Multisite
 * @since 3.1.0
 */

/** Load WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

/** WordPress Translation Installation API */
require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );

if ( ! current_user_can( 'create_sites' ) ) {
	wp_die( __( 'Sorry, you are not allowed to add sites to this network.' ) );
}

get_current_screen()->add_help_tab( array(
	'id'      => 'overview',
	'title'   => __('Overview'),
	'content' =>
		'<p>' . __('This screen is for Super Admins to add new sites to the network. This is not affected by the registration settings.') . '</p>' .
		'<p>' . __('If the admin email for the new site does not exist in the database, a new user will also be created.') . '</p>'
) );

get_current_screen()->set_help_sidebar(
	'<p><strong>' . __('For more information:') . '</strong></p>' .
	'<p>' . __('<a href="https://codex.wordpress.org/Network_Admin_Sites_Screen">Documentation on Site Management</a>') . '</p>' .
	'<p>' . __('<a href="https://wordpress.org/support/forum/multisite/">Support Forums</a>') . '</p>'
);

if ( isset($_REQUEST['action']) && 'add-site' == $_REQUEST['action'] ) {
	check_admin_referer( 'add-blog', '_wpnonce_add-blog' );

	if ( ! is_array( $_POST['blog'] ) )
		wp_die( __( 'Can&#8217;t create an empty site.' ) );

	$blog = $_POST['blog'];
	$domain = '';
	if ( preg_match( '|^([a-zA-Z0-9-])+$|', $blog['domain'] ) )
		$domain = strtolower( $blog['domain'] );

	// If not a subdomain installation, make sure the domain isn't a reserved word
	if ( ! is_subdomain_install() ) {
		$subdirectory_reserved_names = get_subdirectory_reserved_names();

		if ( in_array( $domain, $subdirectory_reserved_names ) ) {
			wp_die(
				/* translators: %s: reserved names list */
				sprintf( __( 'The following words are reserved for use by WordPress functions and cannot be used as blog names: %s' ),
					'<code>' . implode( '</code>, <code>', $subdirectory_reserved_names ) . '</code>'
				)
			);
		}
	}

	$title = $blog['title'];

	$blog_type = $blog['blog_type'];
	$blog_desc = $blog['blog_desc'];
	$blog_domain = $blog['domainType'];

	$meta = array(
		'public' => 1
	);

	// Handle translation installation for the new site.
	if ( isset( $_POST['WPLANG'] ) ) {
		if ( '' === $_POST['WPLANG'] ) {
			$meta['WPLANG'] = ''; // en_US
		} elseif ( in_array( $_POST['WPLANG'], get_available_languages() ) ) {
			$meta['WPLANG'] = $_POST['WPLANG'];
		} elseif ( current_user_can( 'install_languages' ) && wp_can_install_language_pack() ) {
			$language = wp_download_language_pack( wp_unslash( $_POST['WPLANG'] ) );
			if ( $language ) {
				$meta['WPLANG'] = $language;
			}
		}
	}

	if ( empty( $domain ) )
		wp_die( __( 'Missing or invalid site address.' ) );

	if ( isset( $blog['email'] ) && '' === trim( $blog['email'] ) ) {
		wp_die( __( 'Missing email address.' ) );
	}

	$email = sanitize_email( $blog['email'] );
	if ( ! is_email( $email ) ) {
		wp_die( __( 'Invalid email address.' ) );
	}

	if ( is_subdomain_install() ) {
		//$newdomain =  $blog_domain.$domain . '.' . preg_replace( '|^www\.|', '', get_network()->domain );

		$newdomain =  $domain . '.' . preg_replace( '|^www\.|', '', get_network()->domain );
		$path      = get_network()->path;
	} else {
		$newdomain =  get_network()->domain;
		$path      = get_network()->path .$domain . '/';
		//$path      = get_network()->path .$blog_domain. $domain . '/';
	}

	$password = 'N/A';
	$user_id = email_exists($email);
	if ( !$user_id ) { // Create a new user with a random password
		/**
		 * Fires immediately before a new user is created via the network site-new.php page.
		 *
		 * @since 4.5.0
		 *
		 * @param string $email Email of the non-existent user.
		 */
		do_action( 'pre_network_site_new_created_user', $email );

		$user_id = username_exists( $domain );
		if ( $user_id ) {
			wp_die( __( 'The domain or path entered conflicts with an existing username.' ) );
		}
		$password = wp_generate_password( 12, false );
		$user_id = wpmu_create_user( $domain, $password, $email );
		if ( false === $user_id ) {
			wp_die( __( 'There was an error creating the user.' ) );
		}

		/**
		  * Fires after a new user has been created via the network site-new.php page.
		  *
		  * @since 4.4.0
		  *
		  * @param int $user_id ID of the newly created user.
		  */
		do_action( 'network_site_new_created_user', $user_id );
	}

	$wpdb->hide_errors();
	$id = wpmu_create_blog( $newdomain, $path, $title, $blog_type, $blog_desc, $user_id, $meta, get_current_network_id() );

	//swith style
	$wpdb->show_errors();
	if ( ! is_wp_error( $id ) ) {
		if ( ! is_super_admin( $user_id ) && !get_user_option( 'primary_blog', $user_id ) ) {
			update_user_option( $user_id, 'primary_blog', $id, true );
		}

		wp_mail(
			get_site_option( 'admin_email' ),
			sprintf(
				/* translators: %s: network name */
				__( '[%s] New Site Created' ),
				get_network()->site_name
			),
			sprintf(
				/* translators: 1: user login, 2: site url, 3: site name/title */
				__( 'New site created by %1$s

Address: %2$s
Name: %3$s' ),
				$current_user->user_login,
				get_site_url( $id ),
				wp_unslash( $title )
			),
			sprintf(
				'From: "%1$s" <%2$s>',
				_x( 'Site Admin', 'email "From" field' ),
				get_site_option( 'admin_email' )
			)
		);
		wpmu_welcome_notification( $id, $user_id, $password, $title, array( 'public' => 1 ) );

		// create youtube video table
			$table_name = 'isir_'.$id.'_video';
			$charset_collate = $wpdb->get_charset_collate();
		        //if table exist or not
		  if($wpdb->get_var("show tables like $table_name") != $table_name) {
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				titre varchar(100) DEFAULT '' NOT NULL,
				url varchar(100) DEFAULT '' NOT NULL,
				isFavoris boolean DEFAULT false NOT NULL,
				publishedAt date ,
				addedAt date ,
				channelTitle varchar(100) ,
				PRIMARY KEY  (id)
			) $charset_collate;";
		        //excute
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		      }
			// end create table


			// create youtube code source table
			$table_name = 'isir_'.$id.'_code_source';
			$charset_collate = $wpdb->get_charset_collate();
		        //if table exist or not
		  	if($wpdb->get_var("show tables like $table_name") != $table_name) {
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name varchar(100) DEFAULT '' NOT NULL,
				html_url varchar(100) DEFAULT '' NOT NULL,
				clone_url varchar(100) ,
				avatar_url varchar(100) ,
				owner varchar(100) ,
				description varchar(100) ,
				language varchar(100) ,
				isFavoris boolean DEFAULT false NOT NULL,
				created_at date ,
				addedAt date ,
				PRIMARY KEY  (id)
			) $charset_collate;";
		        //excute
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		      }
			// end create table



			// create hal table

			if($blog_type == 1){

				$table_name = 'isir_'.$id.'_hal_project';
					$charset_collate = $wpdb->get_charset_collate();
					//if table exist or not
				  if($wpdb->get_var("show tables like $table_name") != $table_name) {
					$sql = "CREATE TABLE $table_name (
						nameProject varchar(50) not null
					) $charset_collate;";
					//excute
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				      }

				$wpdb->insert($table_name, array( 'nameProject'=> $title) );

				$table_name = 'isir_'.$id.'_hal_show';
				$charset_collate = $wpdb->get_charset_collate();
				//if table exist or not
			  if($wpdb->get_var("show tables like $table_name") != $table_name) {
				$sql = "CREATE TABLE $table_name (
					id int NOT NULL,
					label varchar(1000) ,
					url varchar(1000) ,
					type varchar(20),
					PRIMARY KEY  (id)
				) $charset_collate;";
				//excute
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			      }
			}
			else{

				$table_name = 'isir_'.$id.'_hal_team';
					$charset_collate = $wpdb->get_charset_collate();
					//if table exist or not
				  if($wpdb->get_var("show tables like $table_name") != $table_name) {
					$sql = "CREATE TABLE $table_name (
						nameTeam varchar(50) not null
					) $charset_collate;";
					//excute
					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
					dbDelta( $sql );
				      }

				$wpdb->insert($table_name, array( 'nameTeam'=> $title) );

				$table_name = 'isir_'.$id.'_hal_hide';
				$charset_collate = $wpdb->get_charset_collate();
				//if table exist or not
				if($wpdb->get_var("show tables like $table_name") != $table_name) {
				$sql = "CREATE TABLE $table_name (
					id int NOT NULL,
					PRIMARY KEY  (id)
				) $charset_collate;";
				//excute
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
				  }


			}

			

			$table_name = 'isir_'.$id.'_hal';
			$charset_collate = $wpdb->get_charset_collate();
			//if table exist or not
			if($wpdb->get_var("show tables like $table_name") != $table_name) {
			$sql = "CREATE TABLE $table_name (
				id int NOT NULL,
				label varchar(1000) ,
				url varchar(1000) ,
				PRIMARY KEY  (id)
			) $charset_collate;";
			//excute
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			  }


			

			// end create table




		wp_redirect( add_query_arg( array( 'update' => 'added', 'id' => $id ), 'site-new.php' ) );
		exit;
	} else {
		wp_die( $id->get_error_message() );
	}
}

if ( isset($_GET['update']) ) {
	$messages = array();
	if ( 'added' == $_GET['update'] )
		$messages[] = sprintf(

			/* translators: 1: dashboard url, 2: network admin edit url */
			__( 'Site added. <a href="%1$s">Visit Dashboard</a> or <a href="%2$s">Edit Site</a>' ),
			esc_url( get_admin_url( absint( $_GET['id'] ) ) ),
			network_admin_url( 'site-info.php?id=' . absint( $_GET['id'] ) )
		);
}

$title = __('Add New Site');
$parent_file = 'sites.php';

wp_enqueue_script( 'user-suggest' );

require( ABSPATH . 'wp-admin/admin-header.php' );

?>



<div class="wrap">
<h1 id="add-new-site"><?php _e( 'Add New Site' ); ?></h1>
<?php
if ( ! empty( $messages ) ) {
	foreach ( $messages as $msg )
		echo '<div id="message" class="updated notice is-dismissible"><p>' . $msg . '</p></div>';
} ?>
<form method="post" action="<?php echo network_admin_url( 'site-new.php?action=add-site' ); ?>" novalidate="novalidate">

<?php wp_nonce_field( 'add-blog', '_wpnonce_add-blog' ) ?>
	<table class="form-table">
		<tr class="form-field form-required">
			<th scope="row"><label for="site-type"><?php _e( 'Site Type' ) ?></label></th>
			<td>
				<select id="siteType" onchange="change_site_type();">
           <option value ="project">Project</option>
           <option value ="team">Team</option>
        </select>

<script type="text/javascript">

	var e = document.getElementById("siteType");
	var strUser = e.options[e.selectedIndex].value;
	 var domainType = strUser+"s/";
 </script>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row"><label for="site-address"><?php _e( 'Site Address (URL)' ) ?></label></th>
			<td>
			<?php if ( is_subdomain_install() ) { ?>
				<input name="blog[domain]" type="text" class="regular-text" id="site-address" aria-describedby="site-address-desc" autocapitalize="none" autocorrect="off"/><span class="no-break">.<?php echo preg_replace( '|^www\.|', '', get_network()->domain ); ?><span id=domainTypeDiv><script>document.write(domainType)</script></span></span>
			<?php } else {
				echo get_network()->domain . get_network()->path ?><span id=domainTypeDiv><script>document.write(domainType)</script></span>
<input name = "blog[blog_type]" type="text" id= "blog_type" value = "1" style="display: none;"></input><input name="blog[domain]" type="text" class="regular-text" id="site-address" aria-describedby="site-address-desc"  autocapitalize="none" autocorrect="off" />
			<?php }
			echo '<p class="description" id="site-address-desc">' . __( 'Only lowercase letters (a-z), numbers, and hyphens are allowed.' ) . '</p>';
			?>
			</td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row"><label for="site-title"><?php _e( 'Site Title' ) ?></label></th>
			<td><input name="blog[title]" type="text" class="regular-text" id="site-title" /></td>
		</tr>
		<tr class="form-field form-required">
			<th scope="row"><label for="site-desc"><?php _e( 'Site Description' ) ?></label></th>
			<td><input name="blog[blog_desc]" type="text" class="regular-text" id="site-title" /></td>
		</tr>
<input type = "hidden" id="domainInput" name = "blog[domainType]" value = "null" />

<script type="text/javascript">
	document.getElementById("domainInput").value = domainType;
 </script>
		<?php
		$languages    = get_available_languages();
		$translations = wp_get_available_translations();
		if ( ! empty( $languages ) || ! empty( $translations ) ) :
			?>
			<tr class="form-field form-required">
				<th scope="row"><label for="site-language"><?php _e( 'Site Language' ); ?></label></th>
				<td>
					<?php
					// Network default.
					 $lang = get_site_option( 'WPLANG' );

					// Use English if the default isn't available.
					if ( ! in_array( $lang, $languages ) ) {
						$lang = '';
					}

					wp_dropdown_languages(
						array(
							'name'                        => 'WPLANG',
							'id'                          => 'site-language',
							'selected'                    => 'en-US',
							'languages'                   => $languages,
							'translations'                => $translations,
							'show_available_translations' => current_user_can( 'install_languages' ) && wp_can_install_language_pack(),
						)
					);
					?>
				</td>
			</tr>
		<?php endif; // Languages. ?>
		<tr class="form-field form-required">
			<th scope="row"><label for="admin-email"><?php _e( 'Admin Email' ) ?></label></th>
			<td><input name="blog[email]" type="email" class="regular-text wp-suggest-user" id="admin-email" data-autocomplete-type="search" data-autocomplete-field="user_email" /></td>
		</tr>
		<tr class="form-field">
			<td colspan="2"><?php _e( 'A new user will be created if the above email address is not in the database.' ) ?><br /><?php _e( 'The username and a link to set the password will be mailed to this email address.' ) ?></td>
		</tr>
	</table>

	<?php
	/**
	 * Fires at the end of the new site form in network admin.
	 *
	 * @since 4.5.0
	 */
	do_action( 'network_site_new_form' );

	submit_button( __( 'Add Site' ), 'primary', 'add-site' );
	?>
	</form>
</div>
<script type="text/javascript">
     function change_site_type(){
			 var  myselect = document.getElementById("siteType");
			 var index=myselect.selectedIndex ;

			 var blog_type = document.getElementById("blog_type");

			 if(index == 0){
				 blog_type.value = 1;
				domainType = "projects/";
				
			 }else{
				 blog_type.value = 2;
				domainType = "teams/";
			 }
			document.getElementById("domainTypeDiv").innerHTML = domainType;
			document.getElementById("domainInput").value = domainType;
			

		 }
	// alert("kjhbg");
	// var  myselect=document.getElementById("type");
	// var index=myselect.selectedIndex ;
	// alert(myselect.options[index].value);
	//return t1;

</script>
<?php
require( ABSPATH . 'wp-admin/admin-footer.php' );
