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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'poweri33_wp577');

/** MySQL database username */
define('DB_USER', 'poweri33_wp577');

/** MySQL database password */
define('DB_PASSWORD', '9T)(pKS7n4');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'oxoetpwejrk7d0tplkzwdwpycs34nydwo0vsy2ijavawqdqr6jnxntwzn3wgunlj');
define('SECURE_AUTH_KEY',  'utnhwbkqetpxbea9wrrnz0em8zl9usadpedrqtw4wuic5wfuqywm6bi9tqk1mnmp');
define('LOGGED_IN_KEY',    'bgbryo24xnmvgkmgcf4xtneh442ih3bvv8ntd8gicuhgmz2yk4nc6i51q6efa2az');
define('NONCE_KEY',        'sdrfnob8wonpjjkbkiix414dszd39cotwty9du2efr3osjz2xp0znoxpuy8nhyno');
define('AUTH_SALT',        '0orkwfjtyh0het6sv8sja1g2f6sxnel6ruy96moqfnvex86mjldqbpnhsraitwtb');
define('SECURE_AUTH_SALT', 'ue06lugp9pr6aao5oargudzjsrgrgda3sagtyyenhczvogefwuggsg3tg7csilht');
define('LOGGED_IN_SALT',   'cxajq4hkoi12ivluufcb6anlnraiqvnzl2cmkty1quzeip067uqzlf26nkvwv56c');
define('NONCE_SALT',       's1udmgkwlivnhdteif7wdohrc7nrr402c5cc1xzdkzwppka5d09zuvf8dbywnnu0');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpht_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', false);
define( 'WP_MEMORY_LIMIT', '128M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
