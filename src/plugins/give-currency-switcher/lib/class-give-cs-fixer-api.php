<?php
/**
 * Give Currency Switcher Fixer.io API
 *
 * @package    Give_Currency_Switcher
 * @copyright  Copyright (c) 2016, GiveWP
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetch the exchange rates from Fixer.io website.
 *
 * @link  http://fixer.io
 * @since 1.0.4
 */
class Give_CS_Fixer_API {

	/**
	 * Fixer.io API endpoint URL.
	 *
	 * @since 1.0.4
	 *
	 * @var string
	 */
	private $endpoint_url = 'http://data.fixer.io/api/';

	/**
	 * Store the base currency.
	 *
	 * @since 1.0.4
	 * @var string $base_currency
	 */
	private $base_currency;

	/**
	 * Set the target currency.
	 *
	 * @since 1.0.4
	 * @var string $target_currency
	 */
	private $target_currency;

	/**
	 * Store fixer.io access key.
	 *
	 * @since 1.0.4
	 * @var string $access_key
	 */
	private $access_key;

	/**
	 * Store error message.
	 *
	 * @var string
	 */
	private $error;

	/**
	 * Give_CS_Fixer_API constructor.
	 *
	 * @since 1.0.4
	 */
	public function __construct() {
		// Get fixer.io exchange access key.
		$api_access_key = give_cs_get_option( 'cs_fixer_access_key' );

		// Set endpoint URL.
		$this->setAccessKey( $api_access_key );

		// Set endpoint URL.
		$this->setEndpointUrl( 'http://data.fixer.io/api/latest' );
	}

	/**
	 * Get currency rates.
	 *
	 * @since 1.0.4
	 *
	 * @return array
	 */
	public function get_rates() {
		// Request API url.
		$request_api    = $this->get_request_url();
		$fixer_response = wp_remote_get( $request_api );

		// Get the WP response.
		$response_array = json_decode( wp_remote_retrieve_body( $fixer_response ) );

		// If failed.
		if ( isset( $response_array->success ) && false === $response_array->success && empty( $this->error ) ) {
			$error_message = isset( $response_array->error->info ) ? $response_array->error->info : $this->get_error_message( $response_array->error->type );
			$this->setErrors( $error_message );
		}

		$response = array(
			'rates'         => ! empty( $response_array->rates ) ? (array) $response_array->rates : false,
			'success'       => ! empty( $this->error ) ? false : true,
			'error_message' => $this->error,
		);

		return $response;
	}

	/**
	 * Get the fixer.io error message.
	 *
	 * @since 1.0.4
	 *
	 * @param string|bool $type error type.
	 *
	 * @return mixed
	 */
	public function get_error_message( $type = false ) {
		switch ( $type ) {
			case 'base_currency_access_restricted':
				$error_msg = __( 'Your fixer.io account supports EUR as base currency only. Visit http://fixer.io for more information.', 'give-currency-switcher' );
				break;
			default:
				// Default error message.
				$error_msg = sprintf( __( 'Something went wrong! couldn\'t fetch the exchange rates.', 'give-currency-switcher' ) );
		}

		/**
		 * Allow Developer to modify the error message.
		 *
		 * @since 1.0.4
		 *
		 * @param string $error_msg Error message.
		 * @param string $type      Error type.
		 */
		return apply_filters( 'give_cs_fixer_io_error_msg', $error_msg, $type );
	}

	/**
	 * Get the API url to fetch exchange rates.
	 *
	 * @see   https://fixer.io/documentation
	 * @since 1.0.4
	 * @return mixed
	 */
	public function get_request_url() {
		// Create fixer.io api request URL.
		$request_url = add_query_arg( array(
			'access_key' => $this->getAccessKey(),
			'base'       => $this->getBaseCurrency(),
		), $this->getEndpointUrl() );

		/**
		 * Allow developer to modify the api request URL.
		 *
		 * @since 1.0.4
		 *
		 * @param string $request_url
		 */
		return apply_filters( 'give_cs_fixer_api_url', $request_url );
	}

	/**
	 * Get the endpoint URL.
	 *
	 * @since 1.0.4
	 * @return string
	 */
	public function getEndpointUrl() {
		return $this->endpoint_url;
	}

	/**
	 * Set the endpointURL.
	 *
	 * @since 1.0.4
	 *
	 * @param string $endpoint_url
	 */
	public function setEndpointUrl( $endpoint_url ) {
		$this->endpoint_url = $endpoint_url;
	}

	/**
	 * Get the base currency.
	 *
	 * @return string
	 */
	public function getBaseCurrency() {
		return $this->base_currency;
	}

	/**
	 * In free fixer.io only EUR can be set as base currency.
	 *
	 * @param string $base_currency
	 */
	public function setBaseCurrency( $base_currency ) {
		$this->base_currency = $base_currency;
	}

	/**
	 * Get target currency.
	 *
	 * @return string
	 */
	public function getTargetCurrency() {
		return $this->target_currency;
	}

	/**
	 * Set target currency.
	 *
	 * @param string $target_currency
	 */
	public function setTargetCurrency( $target_currency ) {
		$this->target_currency = $target_currency;
	}

	/**
	 * Get access key.
	 *
	 * @return string
	 */
	public function getAccessKey() {
		return $this->access_key;
	}

	/**
	 * @param string $error
	 */
	public function setErrors( $error ) {
		$this->error = $error;
	}

	/**
	 * Set access key.
	 *
	 * @param string $access_key
	 */
	public function setAccessKey( $access_key ) {
		$this->access_key = $access_key;
	}
}
