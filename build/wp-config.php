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
switch ($_SERVER['HTTP_HOST']) {
  case 'dev-rhmpk-site.pantheonsite.io':
    $config_file = 'wp-config/wp-config.pantheonsite.php';
    //define('WP_CACHE', true); //Added by WP-Cache Manager
    break;

  case 'test-rhmpk-site.pantheonsite.io':
    $config_file = 'wp-config/wp-config.pantheonsite.php';
    //define('WP_CACHE', true); //Added by WP-Cache Manager
    break;

  case 'live-rhmpk-site.pantheonsite.io':
    $config_file = 'wp-config/wp-config.pantheonsite.php';
    //define('WP_CACHE', true); //Added by WP-Cache Manager
    break;

  default:
    $config_file = 'wp-config/wp-config.local.php';
    //define('WP_CACHE', false); //Added by WP-Cache Manager
    break;
}
$config_file = __DIR__ . '/' . $config_file;
if (file_exists($config_file)) {
  include_once($config_file);
}

// Load packages from Composer
if ( file_exists( __DIR__ . '/wp-content/vendor/autoload.php')) {
  require_once( __DIR__  . '/wp-content/vendor/autoload.php');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
if (!isset($_SERVER['PANTHEON_ENVIRONMENT'])) {
define('AUTH_KEY',         'DboWs?|TfFpUe,[eJg|1ePqVAL7Eo2Q(|v7(MO9bj1+`XsT=_E>C5+C`%2Efl;]7');
define('SECURE_AUTH_KEY',  '~l6pr*U`zvPDQSH*=U^)R<atm/eE6,I!]ghMYK&JQoFZ[Y,v=[x*z@KAi9wV^;Vj');
define('LOGGED_IN_KEY',    '[Nu3=4D@&^27VmhnM(5!:pr<}fEb(n5_kb?g2Yg(wfT[0R9f]8K+2:se.YULnY|T');
define('NONCE_KEY',        '[Hy6rh)/6>m3 SrxnI V~~}xuk`>0@`F66vvLZbta{^2z?Lm}5+x(Zb|{7?s<=,K');
define('AUTH_SALT',        'ukVK$h0zYsrp+Y|UkK4 .Bw}1A0Z~5sxK|8Dq+q&8Q>/<,s-2PpoF:C/6I[m3(aF');
define('SECURE_AUTH_SALT', 'nVLTt2$c;z`S{]kC^,H%5x>coo4Zzxd9f,,/a>nXEk=VP0h SbJzDsj,/)f{Ul9 ');
define('LOGGED_IN_SALT',   'CudY*3S$izsSX$?THT.S*?o!,_#~an|b0*G[|=T4-G:d9Je6-tG1W0vl5v%c}#z3');
define('NONCE_SALT',       '$C_c24`l3- a)))IL]ooN1pb<y--<*f}]z!D,F>s76afYe&VI b)8qeIr^+.YgY#');
}
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', true);
define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
