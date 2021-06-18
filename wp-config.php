<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

/**
* Define type of server
*
* Depending on the type other stuff can be configured
* Note: Define them all, don't skip one if other is already defined
*/

define( 'DB_CREDENTIALS_PATH', dirname( ABSPATH )  ); // cache it for multiple use
define( 'WP_LOCAL_SERVER', file_exists( DB_CREDENTIALS_PATH . '/local-config.php' ) );


/**
* Load DB credentials
*/

if ( WP_LOCAL_SERVER )
    require DB_CREDENTIALS_PATH . '/local-config.php';
else
    require DB_CREDENTIALS_PATH . '/production-config.php';


/**
* Authentication Unique Keys and Salts.
*
* Change these to different unique phrases!
* You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
* You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
*/

if ( ! defined( 'AUTH_KEY' ) )
    define('AUTH_KEY',         'Je,~k6aUWAvsPgFVx`BRZY`.=q>|.x|jZMl3+9EZG[Eu2Z*[$S.5Ig(r:hrNI%,*');
if ( ! defined( 'SECURE_AUTH_KEY' ) )
    define('SECURE_AUTH_KEY',  't-|u,#G0)]]*Wn+SU$?>G_u-&.*TSVq]-~Or.O~o`_RTGIAoi91>K(6xxej4O_7w');
if ( ! defined( 'LOGGED_IN_KEY' ) )
    define('LOGGED_IN_KEY',    'D_U%2!81D?9FQz/9VOigu-@,6W+DQGQh6U.9LPkZK,{,2%zGP6+46AD&i$B9b|#;');
if ( ! defined( 'NONCE_KEY' ) )
    define('NONCE_KEY',        'ofB^G[cuZ)}E]Z-3m-^m@fi*0Vt:+1Z=dqt(Zg4jv1AD2}NYy^VOQP=`Kt+<#@I%');
if ( ! defined( 'AUTH_SALT' ) )
    define('AUTH_SALT',        '<MZ;}AOZ(ZNO+4_y<WA,{Ot|~-Y_4!kta4mE!v@RSlBdaWU}-|A2}W((c-aysDmH');
if ( ! defined( 'SECURE_AUTH_SALT' ) )
    define('SECURE_AUTH_SALT', 'Y!Y86+A{56M<|S|`|j&{kM6KS,Y?KzKy%5_OX |0n{o2Ln2}$S#7rO{Dhk)vBs8q');
if ( ! defined( 'LOGGED_IN_SALT' ) )
    define('LOGGED_IN_SALT',   'Q$gCp8tZkGTvz@k<SRt|x|.aep1@:+^.PL%5 ,md)v]3?ndcp0~.`yxOk&S?q~V|');
if ( ! defined( 'NONCE_SALT' ) )
   define('NONCE_SALT',       'G,[DL*0D+U9zn3I1ODML0qT(J7P6+.-QJ:R=C^RFrCIg T}}a8[@t4C^{+7~aSnS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wphfjG_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
/**
* For developers: WordPress debugging mode.
*
* Change this to true to enable the display of notices during development.
* It is strongly recommended that plugin and theme developers use WP_DEBUG
* in their development environments.
*/

if ( WP_LOCAL_SERVER ) {
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
    define( 'WP_DEBUG_DISPLAY', true );

    define( 'SCRIPT_DEBUG', true );
    define( 'SAVEQUERIES', true );

    define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/core');
    define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']);
    define('WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'].'/build');
    define('WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/build');



} else {

    define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
