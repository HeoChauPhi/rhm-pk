<?php

// COPY THIS FILE TO wp-config.local.php and enter your local DB settings


// MySQL settings
/** The name of the database for WordPress */

define('DB_NAME', 'env_db_name');

/** MySQL database username */
define('DB_USER', 'env_db_user');

/** MySQL database password */
define('DB_PASSWORD', 'env_db_password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */

// used to override the wp_options and
// dynamically set the site for this environment
// http://codex.wordpress.org/Editing_wp-config.php
define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME']);
define('WP_HOME', 'http://' . $_SERVER['SERVER_NAME']);

// used to determine environment from easily accessible constant
define('VIA_ENVIRONMENT', 'production');
