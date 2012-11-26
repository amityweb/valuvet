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
define('DB_NAME', 'valuvet_dev2');

/** MySQL database username */
define('DB_USER', 'valuvetcomau');

/** MySQL database password */
define('DB_PASSWORD', 'reweQtdm');

/** MySQL hostname */
define('DB_HOST', 'mysql.valuvet.com.au');

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
define('AUTH_KEY',         'XzCbIObO0mwf_NC!5pTZvjVG/YrjL=;p!leaQGpum7#qs59UnsYbeVUv52Q:p-K?55wMu_Lw!UfX');
define('SECURE_AUTH_KEY',  '~#MbixL$g7|z/J9i^b;LnO\`I?rMQrJRA39NX28wdMk2AU>C29iD6kWm8lp=Zg2jFz^F~Ml');
define('LOGGED_IN_KEY',    'Nv-OcWLTw:W?0T!n^BaiMW3?VUbNXxpUzUIzp/#o/oj/s/nY*GcsGj4R)A!NwHe?NEO/~)s)');
define('NONCE_KEY',        'txLJW|@nodusJz4f8;4Wtv|=#TU/eRE$9b<QVE5(cx95BIqbW4fnLF3EUquu2C-fC=cg>-$r');
define('AUTH_SALT',        ')yk>vaEO6drCf>?FvEM?jrI1vb:XL^y(rY_Oef6@kTW45i6M_wgE5)QR5>NwNjl)(suNlj');
define('SECURE_AUTH_SALT', 'l0:gTcDgyze1pOeQ;gCVB:8/EyUSV8TMOA|YuVaI<U|L!(!$)E9W8KF=yjy@vIj)xql</2:rihulkEv_');
define('LOGGED_IN_SALT',   'L;dj)4dPebWl\`)klmhrsyzB6BZV5uB#?l?D(p4q\`$^-E1Ycy^9i7hgTCrgN@464i?6T_8$9R0d$O');
define('NONCE_SALT',       '/lvMCkoXaRl*Lv1\`4-a)?@>Cmb/z15k^CP4pMF3:mAsG(EyM8boAuxL*SIpv7rDY$2xO(L/uD55)>@nU');

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
