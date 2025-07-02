<?php
//Begin Really Simple SSL key
define('RSSSL_KEY', 'tT8XRbDlXgZgOYz2TGc7ZlWMToORwPegU6svLoA2BcytLN0zBitZn27GfAzr16ka');
//END Really Simple SSL key

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings
define( 'WP_CACHE', false ); // Added by WP Rocket

/**

 * The base configuration for WordPress

 *

 * The wp-config.php creation script uses this file during the installation.

 * You don't have to use the web site, you can copy this file to "wp-config.php"

 * and fill in the values.

 *

 * This file contains the following configurations:

 *

 * * Database settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */



// ** Database settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'topcampamentos' );



/** Database username */

define( 'DB_USER', 'root' );



/** Database password */

define( 'DB_PASSWORD', 'passwd' );



/** Database hostname */

define( 'DB_HOST', 'localhost' );



/** Database charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );



/** The database collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );



/**#@+

 * Authentication unique keys and salts.

 *

 * Change these to different unique phrases! You can generate these using

 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.

 *

 * You can change these at any point in time to invalidate all existing cookies.

 * This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY',         'DOZfxGUzpO8DeDffFlW4u1y2UHOkuFvqkt8Nj59wgM1eGW3uryUSa6fVd7UfVG2O');

define('SECURE_AUTH_KEY',  'SF58MC3gtQ25xbwP7nWjoEqK2rnyrX3VTYkp1Qs3RoEvCJarm8KF78VFICJJa9a2');

define('LOGGED_IN_KEY',    'BsWrFOdATSlXJY9HhnZPV8uRO892oMslG1Qs3hymAyE7pJeT26waPVUAaPgHs5JC');

define('NONCE_KEY',        'boHT09lpQQ0zDyLnQPEixoykV7WS788tDwBlFPPx91XE9gXCfURN0UrsXEkfAjLU');

define('AUTH_SALT',        'aIEQIqBjYAaC5Z1RcCG4Oithuj21rYjKlTc9Uz4Fnc96ktWDKkyuaXmUMkjTmz1X');

define('SECURE_AUTH_SALT', 'cQuUaIKZZXCuNY0ArFGYgiNu3zNR4qmgTmQHG2o88SZRbso7skHMxavdffvliVpD');

define('LOGGED_IN_SALT',   'cBD0PWGOxMzkKhFYjfMhdkoFzBIu0pTr9Xf2MxzmdAjjnE6wNTKLYxMnHckhdz8T');

define('NONCE_SALT',       'rxqXkxbJGjOjKIF8jwUA669MytWo8LxQOm42QdiSOGtCzTPlHLxo8NRYnIvhOOCd');



/**

 * Other customizations.

 */

define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');





/**#@-*/



/**

 * WordPress database table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'wp_';



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 *

 * For information on other constants that can be used for debugging,

 * visit the documentation.

 *

 * @link https://wordpress.org/support/article/debugging-in-wordpress/

 */


define('WP_DEBUG', false); 
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);


/* Add any custom values between this line and the "stop editing" line. */







/* That's all, stop editing! Happy publishing. */



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}



/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';


// ----- automatic updates disabled ------------

define('AUTOMATIC_UPDATER_DISABLED', true);
define( 'WP_AUTO_UPDATE_CORE', false );

// ----- automatic updates disabled ------------