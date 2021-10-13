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
define( 'DB_NAME', 'wfp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'lzgcz9@Hm0VNZ5;{C!l9yixZiiT@O9-0tmB0cuK4+)Gk->X2^62}>7HpC}liTX:X' );
define( 'SECURE_AUTH_KEY',  'H6g.xf?90:q61L1wBqY~X$*L@{fHv$4Wv,_&ETAXQ:ce-1MFnk@#]ptDF:_KJb;?' );
define( 'LOGGED_IN_KEY',    '`L*Re<lp:my9`IaN8Y<F}saFF!1}-8^lpn((KbI;8&CCO`SNV[<w4pA,]>FRCXF]' );
define( 'NONCE_KEY',        'T,rJm$NA}g&Hf^r7RuFcs&Z;B9o=V%c1hH$Hk}aD&9l(S:;D@pJGU-MO)KoFccn|' );
define( 'AUTH_SALT',        'g&#Ejc1TOR1OlK@o[E(s3?q?pNvU4vcsRcSag!]),%v9r;um+#gm+XM WCBc:+9|' );
define( 'SECURE_AUTH_SALT', 'aO^&^V<nD5cspV{8icugUlg?p,pQ+.7OXR2``ill6N6AZ>UY}GQ3hA6t^J1 #A {' );
define( 'LOGGED_IN_SALT',   'O([UBb[Epy+)5Sx97Mam!%5S:7H5OkD&s:.dPq:R/0/).>p?O6F}c$=RU|L^&YI,' );
define( 'NONCE_SALT',       '1o45b.gHm2O20Z:ma$U/xO@ 95c3zIT@M`6itX_^j9H/tu9wa5*TdgoykQ.<`5n/' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
