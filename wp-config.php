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
define('DB_NAME', 'learnplugins');

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

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '{:X),4Nxn>TLj}gx#uD7OK]re?KuS4{o8zCQXmSB0qpbKZ/*]_QDZ&t ?$.g<s*o');
define('SECURE_AUTH_KEY',  'pGO&a{|R_B&SKNoh4/3M`CeK9YR18ymBTQ[[Po{9D@YC@y_!|?&t#&s4zACHt~mN');
define('LOGGED_IN_KEY',    'a<BX6>GE$^6swu~)>X/*F9iKs#.[N~#?6nN%O+Hkm7EhGCPnBqrD</iH6`!Rl-Au');
define('NONCE_KEY',        'c7 ZPk(,21cS(4#<($AGsE]<l&$|a2cQH09k/plMxgt{Fy!MVD<7<Z:!M%9v(:uy');
define('AUTH_SALT',        'bIVB>_+_H%Q-&YApRE4fQOj]8/vNOiZ0Jq55OOEwrC%ZCfk/Y,Q&#6pV{kr?P/A&');
define('SECURE_AUTH_SALT', '58.<Q8JskmZ5,Oec[lQcV?Cjz3*(k5gUt5=)H,nV}Qh^ =!01*IIDcB7ysG!XcR.');
define('LOGGED_IN_SALT',   'SP/@/X 6e v$;-[cu*Ol1-%SBPh;OA?6)t3@]E3%^,5#Sw|SV=M%MsH&p?a}q$e!');
define('NONCE_SALT',       ',(28{Bvt=+vre-}sNhB|55zyi[p@>mr?7~+Gl)2%G~uW2-(li1P9cHyRy,(PxN_Z');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
