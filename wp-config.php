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
define( 'DB_NAME', 'corpoy_afiliado' );

/** MySQL database username */
define( 'DB_USER', 'corpoy_15' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ZxfPw1QpqSFjvG5S' );

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
define( 'AUTH_KEY',         '^A@xt?Oh$%_$%$)bDW+m>,;P %LNOmmNq4ZvTm$ddM!p}<(KhF{TBle:ddjOX2hQ' );
define( 'SECURE_AUTH_KEY',  'W_LE!bW`A3Pk!YhG@[:IMUqPpIt-qkKc.3!EZ/38lQ-;,9sl4Nm9w<8xX~^x%Yo%' );
define( 'LOGGED_IN_KEY',    '_|hijNo2_r)X?XY.vMUCI bN8 TWqtj>xC8nC2c1aGNA1aN.+LgL.5@s7mo]ooII' );
define( 'NONCE_KEY',        'R;e~1YJ~Zq2pJe;R54W!u6<}&J<Hl5Z>(K.nNhei1Y7J[^VYX-3yhTY#}1/|iyWG' );
define( 'AUTH_SALT',        'RZP!-YHMLbi0S[U*;}gIK{e6zp*qU[c]oH6EryL0c8gMvcHz^Y(neEc?qV{uVe)v' );
define( 'SECURE_AUTH_SALT', 'f=s[K5D<?C&d;P&0Kb}>]o$t`-fz:sV)@x.tq8$P1wfVO=Xg8sc#6coDW4@p$w.n' );
define( 'LOGGED_IN_SALT',   'TbprAI^;:Z2,fND-LKpj,[k6 cU=}#lf#yatT+g_kCCT@gB.?b+zU@%Cr(0U=}F/' );
define( 'NONCE_SALT',       '!9^<)2HAR;SA7K<.A@Rv#.xe#QMOStv3t[&ieyMl)=a7 s^eI`x};7ns;*>w&dSL' );

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
