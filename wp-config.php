<?php
define( 'WP_CACHE', true );
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u637190285_EnJ7z' );

/** Database username */
define( 'DB_USER', 'u637190285_JgSLm' );

/** Database password */
define( 'DB_PASSWORD', 'IQfibiGBKO' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',          'S)5q^+u(G!-i|KaKwNL{q%9.j}?;Se1<.B<HoD$B]]fcw@6ZzspZz;YM9%SHYf,&' );
define( 'SECURE_AUTH_KEY',   'GqYo{WB+KS$67<%7pZO~Qh/-KSW`@>Vaok`mM*E(j1|.V#6I0:xHvQu!b@dF;w64' );
define( 'LOGGED_IN_KEY',     'rO%6Z9l4>wS[N,9C6=~2-=0Ds_G3bLZLX.eP3VWOyLcE~jd9a[d.eoc$X1h/+g>v' );
define( 'NONCE_KEY',         '52enc3{]Dgufl>y*.wtg,kY9OsmXz3l,-]cY)fAHFc?&P@r}M0!diS p>#[jRo@y' );
define( 'AUTH_SALT',         'ysmg8C]^h:}Xerq*8/D2zRP.QY/ yPer3k{Z3E&;.v#j])x8BHx*4|dADDxtsex}' );
define( 'SECURE_AUTH_SALT',  'z-^qKmMerp=$}xv6qM^#ts*zFg|O^*t)!Bt?wR*Nb>=2uOo5vyxlmr2TT9D7BRO:' );
define( 'LOGGED_IN_SALT',    'KU#<Zd4BCFi*11g`Z&f98E)iZv>CMO+D<~?~MVkaXz>h8 &NwiE.1c[?IbNN-]?w' );
define( 'NONCE_SALT',        'BLGHBtlP?QBxL,oR[=K#!GiTWeMv.z?0lkO<V`$$^G?Wtr:585^)v#|Q[d,41}k7' );
define( 'WP_CACHE_KEY_SALT', '.,K8M1_i&}D/LId25<c>Vzas|!)5BO[TqV]!&R&(A.VIa.b+hMrBm-l1iFniuq3*' );


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
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
