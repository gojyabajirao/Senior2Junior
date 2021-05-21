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
define( 'DB_NAME', 'Senior2Junior' );

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
define( 'AUTH_KEY',         'wit`}UEms?Q7Qtje;|hx*g`e?qG=<zLRQ,:o{#W7C^>v8| ^53C(JjUt9{T7>?Cs' );
define( 'SECURE_AUTH_KEY',  'a6pl?(k#V1vv&_+ZiD|@0&w9 0:NR$jI=*ns.n-,E^?HwL=|O];Yk}b6TunsZBV(' );
define( 'LOGGED_IN_KEY',    'ZS [/$lQVd8P3Fl,+&6Y.WA7BP%^=o~ XuV(6:(eaG7i|o68mTT~6O>XSyI9J5WP' );
define( 'NONCE_KEY',        'a.`^Px=Zc5]ais[Fq&_cs-<k3t+}_{T>B9: QWJQLM)Bh&[U,5B)MTM(W:$)P:>+' );
define( 'AUTH_SALT',        'i18^C%.+iM{33-)^^#W;%yR8PR]C(5.&MW!M<HslRq%Y|b[hF4TP:l.N4Do/s<%%' );
define( 'SECURE_AUTH_SALT', 'YZDEL&Zye%T_l[FuIx])eO:WnDHT/!b6HN7oE<lokS-^Z(%gslVY;)u|F%5Tu7m{' );
define( 'LOGGED_IN_SALT',   'dUJvAcLllGY}*/bgdu>GH(34 7As0w>4WSeYZ]&y 1ut6t|Lbq|X5L2tosYC?bE;' );
define( 'NONCE_SALT',       '2UF8|.^tn,eVKx (e^iOgwIgMAZ8MHgg0wRo9XY6LLK+(/JLoEFo|C6:I5&=d:f6' );

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
