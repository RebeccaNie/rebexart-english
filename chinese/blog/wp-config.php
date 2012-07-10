<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'rebexart_wrd02');

/** MySQL database username */
define('DB_USER', 'rebexart_wrd02');

/** MySQL database password */
define('DB_PASSWORD', '3gKl1usfeg');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'SClItqGyogqKhpCf2ZJzR34En7yGNrRxX1mvncvecd1WOJ1AttLsLDL7CIefHmVb');
define('SECURE_AUTH_KEY', 'SClItqGyogqKhpCf2ZJzR34En7yGNrRxX1mvncvecd1WOJ1AttLsLDL7CIefHmVb');
define('LOGGED_IN_KEY', 'SClItqGyogqKhpCf2ZJzR34En7yGNrRxX1mvncvecd1WOJ1AttLsLDL7CIefHmVb');
define('NONCE_KEY', 'SClItqGyogqKhpCf2ZJzR34En7yGNrRxX1mvncvecd1WOJ1AttLsLDL7CIefHmVb');
/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个 WordPress 的需求，请为每个 WordPress 设置不同的数据表前缀。
 * 前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * WordPress语言设置。默认为英语。
 *
 * 本项设定能够让 WordPress 显示您需要的语言。wp-content/languages 内应放置同名的 .mo 语言文件。
 * 要使用 WordPress 简体中文界面，只需填入 zh_CN。
 */
define ('WPLANG', 'zh_CN');

/* 设定完毕，请保存该文件。 */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
?>
