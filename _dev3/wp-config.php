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
define('DB_NAME', 'valuvet_dev3');

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
define('AUTH_KEY',         'ne]iX.oCU7XmI=^Hvb=tg-Pw=gbCqsw)A{{|9UEH!i_dBf;tqd@0ukoaoT2F mm}');
define('SECURE_AUTH_KEY',  '?=1S^]]-qwftD!?eP7/}GyGT+kZy[#CvpGjtE4]:8*v}=s#`U+3+v/FTmWI@(fhq');
define('LOGGED_IN_KEY',    'jJ[0/-3YYee/N.z@Ir#igsmh`T:1#zs)o]JLKG{#qi>{s o}y@)|Ysu*O?[Dm(>)');
define('NONCE_KEY',        '6PZfS/h^HXLc$NNV`;O|o#qdzlz7-V0+LuaACHU!!4)>3L=pPwpi-&=4+QWPY.*:');
define('AUTH_SALT',        'abM;CF7E<n|bmAZKl5OwvF+1ExW.WGF85eWQPZ41&=+1IYr|qB0x/z8|jbj-Z&AJ');
define('SECURE_AUTH_SALT', '|^u-Ajq+=T>4jWgTexDK0/`%!3.951~o1Pi:0e=)f+vhY`mr)E=)YHqv`P-HW?cn');
define('LOGGED_IN_SALT',   '?]|# |smk7Wc;xuRr+`xrKk|3V N#,RkN)bbx$G%!F-n<dY8V)+$~gJ3I!Jx,x8:');
define('NONCE_SALT',       '2h:I|3=l+vcsiFq?f(,Mn+p7M]#`>TAh;~Iu{pnXwV*<rI_H.gTMf3S;u:W#$_%t');
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

define('WP_POST_REVISIONS', false);