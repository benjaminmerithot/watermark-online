<?php
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
define( 'DB_NAME', 'watermark' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define('AUTH_KEY',         'v_c+k|CbqH;lCr${z?`INs1;QkWmu>2mH=;rFh@ FMF(vNh$&~0.+60ceoFEpf0z');
define('SECURE_AUTH_KEY',  'x-`RSTW+<+pG0xkSzV5IJQ{OWVJej+9JHxyfj+d`Vo}^O}SBhB<I&V|KZ!dS,YNv');
define('LOGGED_IN_KEY',    'bbul17r+(gcQVrIsU?<ymK~:qQsgv)RW}xwbTq6Ym,/P>uYDAQuQ[.WzF!+xxG<]');
define('NONCE_KEY',        '2f)eH<+s1/hFX>*t=`ff6lRtC]AN+,*eq1fnvE]I8lXfH|k>v~|nt{zu-wT[$05q');
define('AUTH_SALT',        '6(wQh8NM)2Rs.H&4TV+}8LA)rrh pl?@Q(d]eFKb[zsl.~iLC.1@OLT]Y8EzPb`y');
define('SECURE_AUTH_SALT', 'FyrEPrj+-C2Ngn|JU+Vjh2`By+WDQnNW#lgmGH~x|eV$?0YJD3-W|I3YS&wX(& .');
define('LOGGED_IN_SALT',   'n&)~-IjWZNc$^UU8l$q^Szb#$$%q0lE5=8go>$xr%4-hMDqmg,.uTF~ycHd2rIex');
define('NONCE_SALT',       ',mm(<rJ<bsmoi.-OL-C/<gk?qRjqkeSE?S>D#BYe1G?L6L>K+=7x]`[(K_.c{6^k');

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_SCRIPT_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */
define( 'WP_MEMORY_LIMIT', '512M' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
