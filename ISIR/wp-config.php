<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ISIR');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_ALLOW_MULTISITE', true);

define('WPLANG', '');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ']:,D%/ 0O>T#=aEOH;a$|V</{/MuH4Mr|)onZZ]klde5k5gQH-`^Q/!ushypCpCT');
define('SECURE_AUTH_KEY',  'z?1]7gvC9Y iD]0)vge0MkgB{`PPvq/}9y!(FmkvFs/r?nv^}MWS84wG_Hyql<^(');
define('LOGGED_IN_KEY',    '1BWaKn&0-u@tO[tk&o>l5<ggL2 kk)qyOnl^u]@T3FdOjIjZaNH$b F#Cf/pw#<e');
define('NONCE_KEY',        'V!g17d4]+sOowLTX6&b-6JJov {#cee%2:nEY#ro![ e{W]HI8O=*o4^bb/dv_x5');
define('AUTH_SALT',        '7[ZH?g~u)%r43Uolh8bq@b$qI|[)]|QH==i/o;mIa#WjAqT4iR@IbS^p1-@Vw0Ik');
define('SECURE_AUTH_SALT', 'Ng~UCTDABJj2uPb./L_+BEO-`sz|Wci[%GN8R2(walC9xtUq,0*iT{Z@_|#4pIXS');
define('LOGGED_IN_SALT',   'BR;d,A(8~7>u^C)JdQijmg:KU L9%d`[T;a6>k[o? Y})H)@%%V6ZD8X(HU<Lw@T');
define('NONCE_SALT',       'dRaAS%p]oJYd*ujbk{@H{pR,97J<8,DKJa nZ[*oLuAjk@6m4{H..C.1Jxv1]~8O');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'isir_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);


define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/ISIR/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
