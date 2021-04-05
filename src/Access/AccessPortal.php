<?php
/**
 * Access Portal
 *
 * Ajax methods for client interface.
 *
 * @package MZMBOACCESS
 */

namespace MZoo\MzMboAccess\Access;

use MZoo\MzMboAccess as NS;
use MZoo\MzMindbody as MZ;
use MZoo\MzMboAccess\Core as Core;
use MZoo\MzMboAccess\Client as Client;
use MZoo\MzMindbody\Common as Common;
use MZoo\MzMindbody\Common\Interfaces as Interfaces;

/**
 * Access Portal Class
 *
 * @since 1.0.0
 *
 * Ajax methods to MBO access utilities.
 */
class AccessPortal extends AccessUtilities {

	/**
	 * Check Access Permissions
	 *
	 * @since 2.5.7
	 *
	 * Log client in and echo true if active membership
	 * matches one in received array (or string).
	 */
	public function ajax_login_check_access_permissions() {
		/*
		 * Generated in
		 *      Access\AccessDisplay localizeScript()
		 *      OnDemandYoga Frontend\Frontend enqueue_scripts()
		 */
		check_ajax_referer( 'ajax_login_check_access_permissions', 'nonce' );

		// Crate the MBO Object.
		$this->get_mbo_results();

		$result = array();

		// Init message.
		$result['logged'] = '';

		$result['client_access_level'] = 0;

		$result['type'] = 'success';

		// Parse the serialized form into an array.
		$params = array();
		parse_str( $_REQUEST['form'], $params );

		if ( empty( $params ) || ! is_array( $params ) ) {
			$result['type'] = 'error';
		} else {
			$credentials = array(
				'Username' => $params['email'],
				'Password' => $params['password'],
			);

			$client = new Client\RetrieveClient();

			$login = $client->log_client_in( $credentials );

			if ( 'error' === $login['type'] ) {
				$result['type'] = 'error';
			}

			$result['logged'] = $login['message'];

			$result['client_id'] = $login['client_id'];
		}

		$access_level = $this->check_access_permissions( $result['client_id'] );

		if ( 0 !== $access_level ) {
			$result['client_access_level'] = $access_level;
		}

		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) &&
			'xmlhttprequest' === strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
			$result = wp_json_encode( $result );
			echo $result;

		} else {
			header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
		}

		die();
	}


	/**
	 * Check Access Permissions
	 *
	 * @since 2.5.7
	 *
	 * Echo true if active membership matches one in received array (or string).
	 */
	public function ajax_check_access_permissions() {

		// Generated in OnDemandYoga Frontend\Frontend enqueue_scripts().
		check_ajax_referer( 'ajax_check_access_permissions', 'nonce' );

		// Crate the MBO Object.
		$this->get_mbo_results();

		$result = array();

		// Init message.
		$result['logged'] = '';

		$result['client_access_level'] = 0;

		$result['type'] = 'error';

		if ( $_REQUEST['client_id'] ) {
			$access_level   = $this->check_access_permissions( $_REQUEST['client_id'] );
			$result['type'] = 'success';
		}

		if ( 0 !== $access_level ) {
			$result['client_access_level'] = $access_level;
		}

		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) &&
			'xmlhttprequest' === strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
			$result = wp_json_encode( $result );
			echo $result;

		} else {
			header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
		}

		die();
	}
}
