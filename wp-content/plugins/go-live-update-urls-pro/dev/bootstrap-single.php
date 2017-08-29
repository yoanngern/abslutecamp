<?php

$GLOBALS['wp_tests_options']['active_plugins'][] = 'go-live-update-urls/go-live-update-urls.php';
$GLOBALS['wp_tests_options']['active_plugins'][] = 'go-live-update-urls-pro/go-live-update-urls-pro.php';

$GLOBALS['wp_tests_options']['permalink_structure'] = '%postname%/';

require( 'wp-tests-config-single.php' );

global $wp_version; // wp's test suite doesn't globalize this, but we depend on it for loading core

require 'E:/SVN/wordpress-tests/includes/bootstrap-no-install.php';
