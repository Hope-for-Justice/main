<?php

/**
 * Class Give_GoCardless_API
 *
 * @since      1.0.0
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/includes
 * @author     GiveWP
 */
class Give_GoCardless_API {

	/**
	 * GoCardless Base URL
	 *
	 * @var     string $baseurl GoCardless base url for the payment.
	 * @since    1.0.0
	 * @access   private
	 */
	private static $baseurl = 'https://api.gocardless.com/';

	/**
	 * GoCardless Sandbox URL
	 *
	 * @var     string $sandbox_base url Gocardless sandbox API url.
	 * @since    1.0.0
	 * @access   private
	 */
	private static $sandbox_baseurl = 'https://api-sandbox.gocardless.com/';

	/**
	 * GoCardless Payment API version
	 *
	 * @var     string $api_version Gocardless API version
	 * @since    1.0.0
	 * @access   private
	 */
	private static $api_version = '2015-07-06';

	/**
	 * API request wrapper to GoCardless.
	 *
	 * @since           1.0.0
	 * @access          protected
	 *
	 * @param   string $httppoint   GoCardless endpoint
	 * @param   array  $args        GoCardless argument list
	 * @param   bool   $is_wp_error Show wp error|Error
	 *
	 * @return  array|WP_Error  $parsed_resp return http response from GoCardless.
	 */
	protected static function _gocardless_request( $httppoint, $args = array(), $is_wp_error = true ) {

		// Get the GoCardless setting.
		$settings = self::get_gocardless_auth_data();

		$base_url = ( 1 === $settings['sandbox'] ) ? self::$sandbox_baseurl : self::$baseurl;

		$url = $base_url . $httppoint;

		// Generating the authentication header.
		$defaults = array(
			'httpversion' => '1.1',
			'method'      => 'GET',
			'timeout'     => 30,
			'headers'     => array(
				'Authorization'      => 'Bearer ' . $settings['access_token'],
				'GoCardless-Version' => self::$api_version,
				'Content-Type'       => 'application/json',
			),
		);

		$args = array_merge( $defaults, $args );

		$resp = wp_remote_request( $url, $args );

		$parsed_resp = json_decode( wp_remote_retrieve_body( $resp ), true );

		if ( ! empty( $parsed_resp['error']['code'] ) && ! empty( $parsed_resp['error']['message'] ) ) {

			$message = $parsed_resp['error']['message'];

			if ( ! empty( $parsed_resp['error']['errors'] ) && is_array( $parsed_resp['error']['errors'] ) ) {
				$message .= '. ' . __( 'Error details: ', 'give-gocardless' );
				$errors = array();
				foreach ( $parsed_resp['error']['errors'] as $err ) {
					$err_item = '';

					if ( ! empty( $err['field'] ) ) {
						$err_item .= $err['field'] . ' - ';
					}

					if ( ! empty( $err['reason'] ) ) {
						$err_item .= $err['reason'] . ' - ';
					}

					if ( ! empty( $err['message'] ) ) {
						$err_item .= $err['message'];
					}

					$errors[] = $err_item;
				}

				if ( ! empty( $errors ) ) {
					$message .= implode( ', ', $errors );
				}
			}

			if ( $is_wp_error ) {
				return new WP_Error( $parsed_resp['error']['code'], $message );
			} else {
				give_set_error( 'give_gocardless_update_subscription_error', $message );
			}

		}

		// Return response.
		return $parsed_resp;
	}

	/**
	 * Define the GoCardless setting.
	 *
	 * @since   1.0.0
	 * @access  private
	 *
	 * @return  array   $setting_args Setting array.
	 */
	private static function get_gocardless_auth_data() {

		$default_args = array(
			'access_token' => '',
			'sandbox'      => 0,
		);

		// Get merge the external argument.
		$setting_args = array_merge( $default_args, get_option( 'give_gocardless_settings', array() ) );

		// Return the actual arguments.
		return $setting_args;
	}

	/**
	 * Create redirect flow.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $params Parameters to create redirect flow.
	 *
	 * @return  WP_Error|array See self::_gocardless_request return value.
	 */
	public static function create_redirect_flow( $params = array() ) {
		$args = array(
			'method' => 'POST',
			'body'   => wp_json_encode( array(
				'redirect_flows' => $params,
			) ),
		);

		return self::_gocardless_request( 'redirect_flows', $args );
	}


	/**
	 * Complete redirect flow.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   string $redirect_flow_id ID from self::create_redirect_flow.
	 * @param   array  $params           Parameters to complete redirect flow.
	 *
	 * @return  array     Get response from gocardless http request.
	 */
	public static function complete_redirect_flow( $redirect_flow_id, $params = array() ) {
		$args = array(
			'method' => 'POST',
			'body'   => wp_json_encode( array(
				'data' => $params,
			) ),
		);

		return self::_gocardless_request( sprintf( 'redirect_flows/%s/actions/complete', $redirect_flow_id ), $args );
	}

	/**
	 * Get a single mandate from give mandate_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   string $mandate_id Mandate ID.
	 *
	 * @return  WP_Error|array See self::_gocardless_request return value.
	 */
	public static function get_mandate( $mandate_id ) {
		return self::_gocardless_request( 'mandates/' . $mandate_id, array(
			'method' => 'GET',
		) );
	}

	/**
	 * Create payment.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $params Parameters to create payment.
	 *
	 * @return  array
	 */
	public static function create_payment( $params = array() ) {
		$args = array(
			'method' => 'POST',
			'body'   => wp_json_encode( array(
				'payments' => $params,
			) ),
		);

		return self::_gocardless_request( 'payments', $args );
	}


	/**
	 * Get a single payment from given payment_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   string $payment_id Payment ID.
	 *
	 * @return  array
	 */
	public static function get_payment( $payment_id ) {
		return self::_gocardless_request( 'payments/' . $payment_id, array(
			'method' => 'GET',
		) );
	}

	/**
	 * Get all payments from GoCardless.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param array $params Parameters to get the payments.
	 *
	 * @return  array
	 */
	public static function get_payments( $params = array() ) {

		$endpoint = 'payments';

		if ( ! empty( $params ) ) {
			$endpoint = $endpoint . '?' . http_build_query( $params );
		}

		return self::_gocardless_request( $endpoint );
	}

	/**
	 * Cancel payment.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $payment_id Payment ID.
	 *
	 * @return array
	 */
	public static function cancel_payment( $payment_id ) {
		$args = array(
			'method' => 'POST',
		);

		return self::_gocardless_request( sprintf( 'payments/%s/actions/cancel', $payment_id ), $args );
	}

	/**
	 * Retries a failed payment if the underlying mandate is active.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $payment_id Payment ID.
	 *
	 * @return array
	 */
	public static function retry_payment( $payment_id ) {
		$args = array(
			'method' => 'POST',
		);

		return self::_gocardless_request( sprintf( 'payments/%s/actions/retry', $payment_id ), $args );
	}


	/**
	 * Creates a new refund.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param array $params Parameters to create refund.
	 *
	 * @return WP_Error|array See self::_gocardless_request return value.
	 */
	public static function create_refund( $params = array() ) {
		$args = array(
			'method' => 'POST',
			'body'   => wp_json_encode( array(
				'refunds' => $params,
			) ),
		);

		return self::_gocardless_request( 'refunds', $args );
	}

	/**
	 * Get a single refund from given refund_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $refund_id Refund ID.
	 *
	 * @return WP_Error|array See self::_gocardless_request return value.
	 */
	public static function get_refund( $refund_id ) {
		return self::_gocardless_request( 'refunds/' . $refund_id, array(
			'method' => 'GET',
		) );
	}


	/**
	 * Creates a subscription.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param array $params Parameters to create subscription.
	 *
	 * @return WP_Error|array See self::_request return value.
	 */
	public static function create_subscription( $params = array() ) {
		$args = array(
			'method' => 'POST',
			'body'   => wp_json_encode( array(
				'subscriptions' => $params,
			) ),
		);

		return self::_gocardless_request( 'subscriptions', $args );
	}

	/**
	 * Get a single subscription from given subscription_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $subscription_id Subscription ID.
	 *
	 * @return WP_Error|array See self::_request return value.
	 */
	public static function get_subscription( $subscription_id ) {
		return self::_gocardless_request( 'subscriptions/' . $subscription_id, array(
			'method' => 'GET',
		) );
	}

	/**
	 * Cancel a subscription of a given subscription_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $subscription_id Subscription ID.
	 *
	 * @return WP_Error|array See self::_request return value.
	 */
	public static function cancel_subscription( $subscription_id ) {
		return self::_gocardless_request( sprintf( 'subscriptions/%s/actions/cancel', $subscription_id ), array(
			'method' => 'POST',
		) );
	}

	/**
	 * Update a subscription.
	 *
	 * @since   1.3
	 * @access  public
	 *
	 * @param int $subscription_id Parameters to update subscription.
	 * @param array $params Parameters to create subscription.
	 *
	 * @return mixed|array See self::_request return value.
	 */
	public static function gocardless_update_subscription( $subscription_id, $params = array() ) {
		$args = array(
			'method' => 'PUT',
			'body'   => wp_json_encode( array(
				'subscriptions' => $params,
			) ),
		);

		return self::_gocardless_request( 'subscriptions/' . $subscription_id, $args, false );
	}

	/**
	 * Get a single customer from given customer_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $customer_id Customer ID.
	 *
	 * @return WP_Error|array See self::_request return value.
	 */
	public static function get_customer( $customer_id ) {
		return self::_gocardless_request( 'customers/' . $customer_id, array(
			'method' => 'GET',
		) );
	}

	/**
	 * Update a single customer from given customer_id.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $customer_id Customer ID.
	 * @param array  $params
	 *
	 * @return WP_Error|array See self::_request return value.
	 */
	public static function update_customer( $customer_id, $params = array() ) {
		$args = array(
			'method' => 'PUT',
			'body'   => wp_json_encode( array(
				'customers' => $params,
			) ),
		);

		return self::_gocardless_request( 'customers/' . $customer_id, $args );
	}

	/**
	 * Gets the creditors
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @return WP_Error|array See self::_request return value.
	 */
	public static function get_creditors() {
		$args = array(
			'method' => 'GET',
		);

		return self::_gocardless_request( 'creditors/', $args );
	}

}
