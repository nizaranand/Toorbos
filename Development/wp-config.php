<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'toorbos');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Thevertex01');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '-VA>R%}Jq=]s7fQ#NuD+rTyGy}lU!$V#HOW9S|iBe)|;M}y-HM_Mo#r[fkiY-Hg|');
define('SECURE_AUTH_KEY',  'Oab 2EhCq~RP_W29pvDb3;=l%6Tw-w~M.CeUG`]|)#_cR y`GJJOqel&d~07LIgK');
define('LOGGED_IN_KEY',    'r>MnESSxeJ0RW~@Qhu+tA&DW%B-#Dwvf{7$aA)LM3:I*`qa5xQo^66E.#q& 9e3d');
define('NONCE_KEY',        ',39ci2{?0s{c%|mRxh:He^bD~6W0DPXz[lAoP`9{uY0l|8n> 7P7n:BPa)mCm;h;');
define('AUTH_SALT',        '5Ud=@3,3QbRV!Vk9]~m+UXr?l?*):6dy[ AvUbAS[:4<}s*bn<ua6[3pX&rxhXa/');
define('SECURE_AUTH_SALT', 'I;<vK4=~I2#5g7:RIe)t*v]1m5DfZB1=Qd,a2aLaT0tozyzCX^9d!avik|wcX]M#');
define('LOGGED_IN_SALT',   '+F+EKS8:=1$0R-;5&g7HYr!dSyx!ySA36ntkZ|y,RxEL6=Rlu`B/Co]{j0e>+}SM');
define('NONCE_SALT',       'w.^`R+OoLID|v@g]@W5McURl3-nXXz1?4JRca}x+T.UV<=g6uJ7zcC-6@|zaSD7[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
