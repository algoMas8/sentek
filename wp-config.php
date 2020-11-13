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
define( 'DB_NAME', 'sentek' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
 define('AUTH_KEY',         '7k[+m)OBL*ia~hygXp0ShC&6C*Yv)+>xSNm[9(8.!W+@af48voVmHz&|zIAZl^?0');
 define('SECURE_AUTH_KEY',  '&4DKpH#qK0AI{{isFn~A5]8 >X_hZ7j+0J^1EXadO;2%_&BdAh$SI!|X`Ac-YEUD');
 define('LOGGED_IN_KEY',    '~@a4q]ln2_J.^XC4V^G}qi7wM,tf /#l@Ej%-LJJ;gpha9p`wupKVK0||i*LDwX9');
 define('NONCE_KEY',        'q-*Ge?H>[sjVj GJ*f~h$<Q$o)oc%;+Nsz-P!X]+QiHQ2JOXDxASIr>jzO[pg]<8');
 define('AUTH_SALT',        'tWYylOAqq#|kVx-o@62^-,@%~kAO$!L`EjPNCF(7Z}im^+nRMFJh0kmO0KmA%J g');
 define('SECURE_AUTH_SALT', 'n>Dw}|7>8Ep+3P-rK#5~DhH:anK+}&~-:@l(xH.)tsf}N7GQg/T&g&3n*2-8/kfF');
 define('LOGGED_IN_SALT',   '?/$&n[<ykSvnhZO<+#WdQ=v@%TO{|E=?cJEPa$*:.b)dbQ#/lC][%t]w}-!rKu]7');
 define('NONCE_SALT',       '(GIN)31|LM0&aq_AH|}iXm!3H[K#<;,dC} 0EM[5Pv;;n!.8q]J -:BJy*% F6[u');

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
