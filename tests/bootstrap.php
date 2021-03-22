<?php

/**
 * PHPUnit bootstrap file
 *
 * @package Mz_MBO_Access
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	throw new Exception( "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */

require dirname( dirname( __FILE__ ) ) . '/mz-mbo-access.php';


// Start up the WP testing environment.
require_once $_tests_dir . '/includes/bootstrap.php';

// Register our Autoload function
// TODO maybe make this work
// require __DIR__ . "/Autoload.php";
// spl_autoload_register( [ new MBOLoader\Autoload( 'MBOTests', __DIR__ . '/' ), 'load' ] );
