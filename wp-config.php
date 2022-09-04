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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'isokoma' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'yAr``(P8s5V#NGb<A4Uso/u-S8Y%|4<kS+XL pTo+Vn>D`g@:ah9D-F`79.wZ{HJ' );
define( 'SECURE_AUTH_KEY',  'GM.o.B.<~}CI0M[ lqTyz4r2c<X1#Jk7Mo6Zp a{.Hn5ogGPZ=,N[s6|Dj,Ka/mQ' );
define( 'LOGGED_IN_KEY',    '->l}!seK+-+WPLo`)ycO&l}n.mAnxWcP}ZI#oZ5|8EO4S-i^y++l4y&FMXa(/7T!' );
define( 'NONCE_KEY',        '>l!a.Zk8oWxp!,5sq[cyIFk#jma5uJRIPmFG~IZY2Bc-yRe146^nT}UOSzP*!uQO' );
define( 'AUTH_SALT',        ')HB@{)<j.KtiWv7RjR=V;t^VZ,fMTj|w/3A7iErcBL|J=1d:#MiZ p1hyo;P|*)$' );
define( 'SECURE_AUTH_SALT', ' N/v1FuV&*7N>CnlZIPO6w 03$@Ow9}Cm:M0m}}dC>mcs( [:4 sVSLbsXL>eM!W' );
define( 'LOGGED_IN_SALT',   '(`6aP`lsLi+vN2C$D/{C{@D`aFXW5/]6WLAcEL&_}^PngTJCR_?G69TV+uDBs}qg' );
define( 'NONCE_SALT',       'RW]Kv2`_&rnQK2z1]tHwddJ_nhtKMVh-83g+XNr>k@zV,b].i k6W)eX=l`Q]#qO' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
