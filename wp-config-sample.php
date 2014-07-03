<?php
/**
 * Custom WordPress configurations on "wp-config.php" file.
 *
 * This file has the following configurations: MySQL settings, Table Prefix, Secret Keys, WordPress Language, ABSPATH and more.
 * For more information visit {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php} Codex page.
 *
 * @package WordPress
 * @generator GenerateWP.com
 */


/* MySQL settings */
define( 'DB_NAME',     'database_name_here' );
define( 'DB_USER',     'username_here' );
define( 'DB_PASSWORD', 'password_here' );
define( 'DB_HOST',     'localhost' );
define( 'DB_CHARSET',  'utf8' );


/* MySQL database table prefix. */
$table_prefix = 'wp_';


/* Authentication Unique Keys and Salts. */
define('AUTH_KEY',         'X3T(=aP_+pYN`m0;~[gFWJqLTgbL|Kg+L4PX?X_>lEmS@%!Z@-^FDLtRg%lMs~ZN');
define('SECURE_AUTH_KEY',  '/xw&dDF0mX$M&C:;Z`5xjv>|68USOw>U`F+{H7kN-;Q`Jz_Y?xQHmaqbFg/3W,Xu');
define('LOGGED_IN_KEY',    '*]wAS6-V277s}z;7Lso<.#Q8kip#xd-E_qWax?Ls]VE)_*9:51/P4m2j]MR58cH-');
define('NONCE_KEY',        '-ts:wfm0&)V+ +Bq$sXKe@aQYK+ImL{7=^ww1B5k-HjW9,{lNpQOl8hSv)Ur{!tP');
define('AUTH_SALT',        '47att=F2_hJ:wXt^.!%F$Ss+-r&%X;btTECp2Du+wTs!r+y5JE]l|6u70Z<<2');
define('NONCE_SALT',       '_iS%*94Yw~p+Q0oIpL= -}9IQp9T=B^M_o~,VTarA(A@[_XGfphf|sz>h++rraq#');


/* WordPress Localized Language. */
define( 'WPLANG', 'it_IT' );


/* Disable Post Revisions. */
define( 'WP_POST_REVISIONS', false );
/* Trash Days. */
define( 'EMPTY_TRASH_DAYS', '2' );


/* Multisite. */
define( 'WP_ALLOW_MULTISITE', false );


/* WordPress debug mode for developers. */
define( 'WP_DEBUG',         true );
define( 'WP_DEBUG_LOG',     true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG',     true );
define( 'SAVEQUERIES',      true );


/* Updates */
define( 'DISALLOW_FILE_MODS', true );
define( 'DISALLOW_FILE_EDIT', true );


/* Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/wp/');

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
