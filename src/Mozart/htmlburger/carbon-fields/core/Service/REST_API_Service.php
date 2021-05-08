<?php
/**
 * @license GPL-2.0-only
 *
 * Modified by Mike iLL Kilmer on 08-May-2021 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace MZoo\MzMboAccess\Dependencies\Carbon_Fields\Service;

use MZoo\MzMboAccess\Dependencies\Carbon_Fields\REST_API\Router;
use MZoo\MzMboAccess\Dependencies\Carbon_Fields\REST_API\Decorator;

/*
 * Service which provides the ability to do meta queries for multi-value fields and nested fields
 */
class REST_API_Service extends Service {

	/**
	 * Router instance
	 *
	 * @var Router
	 */
	protected $router;

	/**
	 * Decorator instance
	 *
	 * @var Decorator
	 */
	protected $decorator;

	/**
	 * @param Router    $router
	 * @param Decorator $decorator
	 */
	public function __construct( Router $router, Decorator $decorator ) {
		$this->router = $router;
		$this->decorator = $decorator;
	}

	/**
	 * Enable REST API integration
	 */
	protected function enabled() {
		add_action( 'carbon_fields_fields_registered', array( $this, 'boot' ) );
	}

	/**
	 * Disable REST API integration
	 */
	protected function disabled() {
		remove_action( 'carbon_fields_fields_registered', array( $this, 'boot' ) );
	}

	/**
	 * Bootstrap all functionality
	 */
	public function boot() {
		$this->router->boot();
		$this->decorator->boot();
	}
}