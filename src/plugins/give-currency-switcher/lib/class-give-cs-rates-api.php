<?php
/**
 * Exchange Rates Exchange rate Key-less APIs.
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
 * Class Give_CS_Rates_API Exchange Rate API.
 *
 * @since 1.0
 */
class Give_CS_Rates_API {

	/**
	 * List of the exchange rate APIs.
	 *
	 * @since 1.0
	 *
	 * @var array $list_of_exchange_apis Store exchange rate APIs.
	 */
	private $exchange_rate_apis;

	/**
	 * Store base currency.
	 *
	 * @since 1.0
	 *
	 * @var string $base_currency Base Currency.
	 */
	private $base_currency;

	/**
	 * Store the target currency.
	 *
	 * @since 1.0
	 *
	 * @var string $target_currency Target currency.
	 */
	private $target_currency;

	/**
	 * Give_CS_Rates_API constructor.
	 *
	 * @since 1.0
	 *
	 * @since 1.0.4 Deprecated Google Finance API
	 *
	 * @param string $base_currency   Pass base currency code.
	 * @param string $target_currency Pass currency code in which you want to convert the amount.
	 */
	public function __construct( $base_currency = '', $target_currency = '' ) {

		// Set the currency.
		$this->base_currency   = urlencode( $base_currency );
		$this->target_currency = urlencode( $target_currency );

		// Exchange rate APIs.
		$aggregator = array(
			'xe'                  => __( 'Xe.com', 'give-currency-switcher' ),
			'ecb'                 => __( 'European Central Bank', 'give-currency-switcher' ),
			'fixer'               => __( 'Fixer.io', 'give-currency-switcher' ),
			'open-exchange-rates' => __( 'Open Exchange Rates', 'give-currency-switcher' ),
		);

		// Allow developer to add more exchange rates.
		$this->exchange_rate_apis = apply_filters( 'give_cs_exchange_rates_aggregator', $aggregator );
	}

	/**
	 * Fetch exchange rates from the APIs.
	 *
	 * @since 1.0
	 *
	 * @param string         $aggregator API id.
	 * @param string|integer $form_id    Donation Form ID.
	 *
	 * @return float|array
	 */
	public function fetch_rates( $aggregator = '', $form_id = '' ) {
		// Get all of the active currencies.
		$support_currencies = give_cs_get_option( 'cs_supported_currency', $form_id );

		// Store exchange rates.
		$final_rates = array();

		// Fetch from the chosen aggregator.
		switch ( $aggregator ) {
			case 'xe':
				// Pattern to get the value from DOM.
				$dom_pattern = "#<td class=\"resultColRght\">(.*?)<\/td>#ui";

				// If supported currency is not empty.
				if ( ! empty( $support_currencies ) ) {

					// Go through each of the currency and get the rates.
					foreach ( $support_currencies as $currency ) {

						// Create API url.
						$api_url = add_query_arg(
							array( 'template' => 'mobile', 'Amount' => 1, 'From' => $this->base_currency, 'To' => $currency ),
							'http://www.xe.com/ucc/convert.cgi'
						);

						// Get the API response body.
						$api_response = wp_remote_retrieve_body( wp_remote_get( $api_url ) );

						// Find the DOm in HTML content.
						preg_match( $dom_pattern, $api_response, $dom_result );

						// Get and store rates in array.
						$final_rates[ $currency ] = isset( $dom_result[1] ) ? (float) preg_replace( "/[^0-9\.]/", "", $dom_result[1] ) : false;
					}
				}
				break;
			case 'ecb':
				$api_url = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
				$res     = file_get_contents( $api_url );
				$rates   = array();

				// Get xml data.
				$currency_data = simplexml_load_string( $res );

				foreach ( $currency_data->Cube->Cube->Cube as $xml ) {
					$att                                      = (array) $xml->attributes();
					$rates[ $att['@attributes']['currency'] ] = (float) $att['@attributes']['rate'];
				}

				$final_rates = array();

				if ( ! empty( $rates ) ) {
					foreach ( $support_currencies as $currency_code ) {
						if ( 'EUR' !== $this->base_currency ) {
							if ( 'EUR' !== $currency_code ) {
								$final_rates[ $currency_code ] = (float) $rates[ sanitize_text_field( esc_html( $currency_code ) ) ] / $rates[ $this->base_currency ];
							} else {
								$final_rates[ $currency_code ] = 1 / $rates[ $this->base_currency ];
							}
						} else {
							if ( 'EUR' !== $currency_code ) {
								if ( $rates[ $currency_code ] < 1 ) {
									$final_rates[ $currency_code ] = 1 / $rates[ $currency_code ];
								} else {
									$final_rates[ $currency_code ] = $rates[ $currency_code ];
								}
							} else {
								$final_rates[ $currency_code ] = 1;
							}
						}
					}
				}
				break;
			default:
				/**
				 * Allow developers to add their own exchange rate API.
				 *
				 * @since 1.0
				 */
				do_action( 'give_cs_exchange_rate_' . $aggregator, $this );
		}

		$response = array(
			'rates'         => ! empty( $final_rates ) ? $final_rates : false,
			'success'       => true,
			'error_message' => '',
		);

		return $response;
	}

	/**
	 * Get the exchange rates APIs.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function get_exchange_rates_api() {
		return apply_filters( 'give_cs_exchange_rates_api', $this->exchange_rate_apis );
	}
}
