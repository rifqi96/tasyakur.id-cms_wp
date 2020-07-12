<?php
// Make sure autoload is there
if ( !file_exists( __DIR__ . '/vendor/autoload.php' ) )
    throw new Exception('Autoload is not found. Make sure to do composer install.');
// Load the autoload
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Load dotenv
    // createUnsafeImmutable() to enable getenv(), otherwise we can just use createUImmutable()
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();
}
// Catch error if there's no .env file
catch (\Dotenv\Exception\InvalidPathException $invalidPathException) {
    // continue
}

define( 'WP_CACHE', true ) ;
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
define('DB_NAME', getenv('MYSQL_DATABASE'));

/** MySQL database username */
define('DB_USER', getenv('MYSQL_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('MYSQL_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',        getenv('NONCE_KEY'));
define('AUTH_SALT',        getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',       getenv('NONCE_SALT'));

/**#@-*/

/**
 * App Environment
 * 
 */
define('ENVIRONMENT', getenv('ENVIRONMENT') ?: 'local');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = getenv('TABLE_PREFIX');

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
define('WP_DEBUG', getenv('ENVIRONMENT') === 'local');

/**
 * WP_SITEURL
 *
 * The value defined is the address where your WordPress core files reside.
 * Overrides the wp_options table value for siteurl.
 * Adding this in can reduce the number of database calls when loading your site.
 *
 * WP_HOME
 *
 * Overrides the wp_options table value for home but does not change it in the database.
 * home is the address you want people to type in their browser to reach your WordPress site.
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 */
define('WP_HOME', getenv('SITE_URL'));
define('WP_SITEURL', getenv('SITE_URL'));

/**
 * Post Revisions
 *
 * WordPress, by default, will save copies of each edit made to a post or page,
 * allowing the possibility of reverting to a previous version of that post or page.
 *
 * Cleanup Image Edits
 *
 * By default, WordPress creates a new set of images every time you edit an image and when you restore the original,
 * it leaves all the edits on the server.
 */
define( 'WP_POST_REVISIONS', true );
define( 'IMAGE_EDIT_OVERWRITE', false );

/**
 * Kontinentalist REST API OAuth Configurations
 *
 * ex:
 * define('KONTI_HTTP_ORIGIN, serialize( $array ) );
 *
 * if it left empty or null or even not defined, then all origins are allowed to make request to our Rest API
 */
define('KONTI_HTTP_ORIGIN', serialize( explode(",", getenv('HEADER_ALLOW_ORIGIN'))) );

/**
 * Require SSL for Admin and Logins
 *
 */
define( 'FORCE_SSL_ADMIN', getenv('ENVIRONMENT') !== 'local' );

/**
 * Google analytics settings
 * 
 */
define('GA_CREDENTIALS_PATH', getenv('GA_CREDENTIALS_PATH'));
define('GA_VIEW_ID', getenv('GA_VIEW_ID'));

/**
 * Enable unfiltered uploads
 * Used to enable SVG.
 *
 */
define('ALLOW_UNFILTERED_UPLOADS', true);

/**
 * Disable wordpress auto update
 * 
 */
define( 'WP_AUTO_UPDATE_CORE', false );

/**
 * Redis Cache Settings
 * 
 */
define('WP_REDIS_HOST', getenv('REDIS_HOST'));
define('WP_REDIS_PORT', getenv('REDIS_PORT'));
define('WP_REDIS_PASSWORD', getenv('REDIS_PASSWORD'));
define('WP_CACHE_KEY_SALT', getenv('SITE_URL'));
// define('WP_REDIS_MAXTTL', 3600);

/**
 * Solve ERR_TOO_MANY_REDIRECTS w
 * hen FORCE_SSL_ADMIN is true with AWS load balancers HTTPS
 *
 */
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS']='on';
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');