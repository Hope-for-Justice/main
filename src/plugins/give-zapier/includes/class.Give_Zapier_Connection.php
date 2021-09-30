<?php

use Give\Log\Log;
use Give\Log\ValueObjects\LogType;

/**
 * Give Zapier Connection
 *
 * @package     Give
 * @since       1.0
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @copyright   Copyright (c) 2016, WordImpress
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Give_Zapier_Connection
 */
class Give_Zapier_Connection {

	/**
	 * Push event data to Zapier subscriptions and remove invalid subscriptions.
	 *
	 * @since 1.0
	 *
	 * @param  array  $data  Event data.
	 *
	 * @param  string  $event  Event trigger.
	 */
	public static function push_and_scrub( $event = '', $data = [] ) {
		$subscriptions = self::event_push( $event, $data );
		self::delete_invalid_subscriptions( $subscriptions );
	}

	/**
	 * Push new event data to Zapier subscriptions.
	 *
	 * @since  1.0
	 *
	 * @param  array  $data  Event data.
	 *
	 * @param  string  $event  Event trigger.
	 *
	 * @return array         Remote response codes.
	 */
	public static function event_push( $event = '', $data = [] ) {
		$data          = apply_filters( 'give_zapier_' . $event . '_data', $data );
		$subscriptions = Give_Zapier_Subscription_Factory::get_subscriptions( $event );

		// early exit if zapier hook does not exist for event.
		if ( empty( $subscriptions ) ) {
			return [];
		}

		foreach ( $subscriptions as $key => $subscription ) {
			$response_code                   = self::api_post( $subscription->url, $data, $event );
			$subscriptions[ $key ]->is_valid = 410 !== $response_code;
		}

		self::maybe_log_event(
			sprintf( esc_html__( 'Trigger sent for  %1$s', 'give-zapier' ), $event ),
			[
				'Trigger data'     => $data,
				'List of triggers' => $subscriptions,
			],
			'http'
		);

		return $subscriptions;
	}

	/**
	 * Send log if the setting
	 *
	 * @since  1.3.1
	 *
	 * @param  string $title  Event data.
	 * @param  array  $data  Event data.
	 * @param  string $type  Log Type.
	 */
	public static function maybe_log_event( $title, $data, $type = 'info' ) {
		if ( give_is_setting_enabled( give_get_option( 'zapier_logging' ) ) ) {
			$context = wp_parse_args(
				[
					'category' => 'Zapier',
					'source'   => 'Zapier Add-on',
				],
				$data
			);

			$logType = LogType::isValid( $type ) ? $type : LogType::INFO;

			Log::$logType( $title, $context );
		}
	}

	/**
	 * Send data to a Zapier subscription URL.
	 *
	 * @since 1.4.0 Log error if api request was not successful.
	 * @since 1.0
	 *
	 * @param  array  $data  Event data.
	 * @param  string  $event
	 *
	 * @param  string  $url  Zapier URL.
	 *
	 * @return integer       Remote HTTP response code.
	 */
	public static function api_post( $url = '', $data = [], $event = '' ) {
		$response = wp_remote_post(
			esc_url( $url ),
			[
				'headers' => [ 'content-type' => 'application/json' ],
				'body'    => wp_json_encode( $data ),
			]
		);

		$response_code = absint( wp_remote_retrieve_response_code( $response ) );

		if ( is_wp_error( $response ) || ( 200 !== $response_code ) ) {
			$context = [
				'Request URL'   => $url,
				'Request body'  => $data,
				'Response code' => $response_code,
				'Response body' => wp_remote_retrieve_body( $response ),
			];

			self::maybe_log_event(
				sprintf( esc_html__( 'Error occurred when sending %s event trigger', 'give-zapier' ), $event ),
				$context,
				'error'
			);
		}

		return $response_code;
	}

	/**
	 * Delete all invalid subscriptions.
	 *
	 * @since 1.0
	 *
	 * @param  array  $subscriptions  Subscription objects.
	 */
	public static function delete_invalid_subscriptions( $subscriptions ) {
		foreach ( $subscriptions as $subscription ) {
			if ( ! $subscription->is_valid ) {
				Give_Zapier_Subscription_Factory::delete_subscription( $subscription->ID );
			}
		}
	}

	/**
	 * Push sample data to all Zapier subscriptions.
	 *
	 * @since  1.0.0
	 *
	 * @param  string  $trigger  Trigger name.
	 */
	public static function sample_data_push( $trigger = '' ) {
		$trigger_data = self::get_trigger_data( $trigger );
		self::push_and_scrub( $trigger, $trigger_data );
	}

	/**
	 * Get sample data for a given trigger.
	 *
	 * @since  1.0.0
	 *
	 * @param  string  $trigger  Trigger name.
	 *
	 * @return array           Trigger data.
	 */
	public static function get_trigger_data( $trigger = '' ) {
		switch ( $trigger ) {
			case 'give_new_donor':
			case 'give_updated_donor':
				$trigger_data = [
					'info'  => [
						'user_id'      => 1234,
						'customer_id'  => 568,
						'username'     => 'jdoe123',
						'display_name' => 'John Doe',
						'first_name'   => 'John',
						'last_name'    => 'Doe',
						'email'        => 'johndoe123@test.com',
					],
					'stats' => [
						'total_spent'     => '23.50',
						'total_donations' => 1,
					],
				];
				break;
			case 'give_delete_donation':
			case 'give_publish_donation':
			case 'give_cancelled_donation':
			case 'give_refunded_donation':
			case 'give_revoked_donation':
			case 'give_pending_donation':
			case 'give_failed_donation':
			case 'give_abandoned_donation':
			default:
				$trigger_data = give_zapier_testing_data_for_payment();
				break;
		}

		/**
		 * Filter to add/alter testing data for zapier
		 *
		 * @since 2.1
		 *
		 * @param  string  $trigger  Zapier testing data on basis of $trigger
		 *
		 * @param  array  $trigger_data  Zapier testing data
		 *
		 * @return array $trigger_data Zapier testing data
		 */
		return (array) apply_filters( 'give_zapier_testing_data', $trigger_data, $trigger );
	}

}
