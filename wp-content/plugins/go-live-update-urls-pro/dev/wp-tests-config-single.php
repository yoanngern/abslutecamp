<?php


define( 'ABSPATH', "E:/SVN/single/wp/" );
define( 'WP_TESTS_DIR', 'E:/SVN/single-tests/' );
define( 'WP_CONTENT_DIR', 'E:/SVN/single/content' );
define(	'WP_CONTENT_URL' ,'http://single.loc/content' );


// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
define( 'WP_TESTS_MULTISITE', false);

// Test with single debug mode (default).
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', true );

$_SERVER[ 'REMOTE_ADDR' ] = "127.0.0.1";

define( 'DB_NAME', 'single' );
define( 'DB_USER', 'mat' );
define( 'DB_PASSWORD', 'mypass' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix  = 'wp_';   // Only numbers, letters, and underscores please!

define( 'WP_TESTS_DOMAIN', 'single.loc' );
define( 'WP_TESTS_EMAIL', 'mat@matlipe.com' );
define( 'WP_TESTS_TITLE', 'GLUU testing' );
define( 'WP_PHP_BINARY', 'php' );