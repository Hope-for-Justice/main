<?php
/**
 * Give Currency Switcher Exchange rates API.
 *
 * @package    Give_Currency_Switcher
 * @copyright  Copyright (c) 2016, GiveWP
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetch the exchange rates from Open Exchange Rates website.
 *
 * @link  https://openexchangerates.org/
 * @since 1.0
 */
class Give_OpenExchange_API {

	/**
	 * Store API url.
	 *
	 * @var string $api_url Store API URL.
	 */
	private $api_url = 'http://openexchangerates.org/api/latest.json';

	/**
	 * Open Exchange API
	 *
	 * @since  1.0
	 *
	 * @var string $app_id APP ID.
	 */
	private $app_id;

	/**
	 * Base currency.
	 *
	 * @since 1.0
	 *
	 * @var string $base_currency Store base currency.
	 */
	private $base_currency;

	/**
	 * Target currency.
	 *
	 * @since 1.0
	 *
	 * @var string $target_currency Target Currency.
	 */
	private $target_currency;

	/**
	 * Store Error.
	 *
	 * @since 1.0
	 *
	 * @var string|array $error Store Errors.
	 */
	private $error;

	/**
	 * Give_OpenExchange_API constructor.
	 *
	 * @since  1.0
	 *
	 * @access public
	 *
	 * @param string $app_id          APP ID.
	 * @param string $target_currency Target Currency.
	 * @param string $base_currency   Base Currency
	 */
	public function __construct( $app_id = '', $base_currency = '', $target_currency = '' ) {

		$this->app_id          = $app_id;
		$this->base_currency   = ! empty( $base_currency ) ? $base_currency : give_get_currency();
		$this->target_currency = $target_currency;
	}

	/**
	 * Get the Exchange Rates.
	 *
	 * @since  1.0
	 *
	 * @access public
	 * @return array
	 */
	public function get_rates() {
		// Request API url.
		$request_api = $this->get_api_request_url();
		$response    = wp_remote_get( $request_api );

		// Get the response from the API.
		$response_array = json_decode( wp_remote_retrieve_body( $response ) );

		// Store the error message.
		$error_message = null;
		$success       = true;

		// If failed.
		if ( isset( $response_array->error ) && true === $response_array->error ) {
			$error_message = $response_array->description;
			$success       = false;
		} else {
			// Get the exchange rate.
			$rates_array = isset( $response_array->rates ) ? get_object_vars( $response_array->rates ) : array();
		}

		// Return all currencies exchange rates.
		$response = array(
			'rates'         => ! empty( $rates_array ) ? $rates_array : false,
			'success'       => $success,
			'error_message' => $error_message,
		);

		return $response;
	}

	/**
	 * Generate API request URL.
	 *
	 * @since  1.0
	 *
	 * @access public
	 *
	 * @return string $api_url Generated API url.
	 */
	private function get_api_request_url() {

		// Add parameters to API URL.
		$api_url = add_query_arg( array(
			'app_id' => $this->app_id,
			'base'   => $this->base_currency,
		), $this->api_url );

		return $api_url;
	}
}
