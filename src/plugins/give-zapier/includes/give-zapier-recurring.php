<?php
/**
 * Give Zapier Adding Recurring Support
 *
 * @package     Give
 * @copyright   Copyright (c) 2018, GiveWP
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// check Give_Zapier_Recurring class does not exists.
if ( ! class_exists( 'Give_Zapier_Recurring' ) ) {
	/**
	 * Class Give_Zapier_Recurring
	 *
	 * @since 1.2.0
	 *
	 * @return void
	 */
	class  Give_Zapier_Recurring {
		/**
		 * Give_Zapier_Recurring constructor.
		 *
		 * @since 1.2.0
		 */
		public function __construct() {

			if ( defined( 'GIVE_RECURRING_VERSION' ) ) {
				// add recurring testing data.
				add_filter( 'give_zapier_testing_data', array( $this, 'add_data' ), 10, 2 );

				// Fire zapier API.
				add_action( 'give_recurring_add_subscription_payment', array( $this, 'add_subscription_payment' ), 10, 1 );
				add_action( 'give_recurring_update_subscription', array( $this, 'subscription_status_updated' ), 10, 3 );

				// Add subscription zapier api hooks
				add_filter( 'give_settings_zapier', array( $this, 'register_hooks' ) );

			} else{

				// Add subscription endpoint to return empty successfully to prevent authentication error when zapier authenticate website
				// and when recurring add-on is disabled.
				add_filter( 'give_api_valid_query_modes', array( $this, 'add_subscriptions_endpoint' ) );
				add_filter( 'give_api_output_data', array( $this, 'process_subscription_endpoint' ), 10, 3 );
			}
		}

		/**
		 * Add 'subscriptions' api endpoint.
		 *
		 * @param $queries
		 *
		 * @return array
		 * @since 1.2.3
		 *
		 */
		public function add_subscriptions_endpoint( $queries ) {
			$queries[]      .= 'subscriptions';
			$this->override = false;

			return $queries;
		}

		/**
		 * Add Subscribers Endpoint
		 *
		 * @param $data
		 * @param $query_mode
		 * @param $api_object
		 *
		 * @return array Empty array
		 * @since 1.2.3
		 *
		 */
		public function process_subscription_endpoint( $data, $query_mode, $api_object ) {

			// Sanity check: don't mess with other API queries!
			if ( 'subscriptions' !== $query_mode ) {
				return $data;
			}

			return array();
		}

		/**
		 * Add subscription zapier api hook buttons
		 *
		 * @since 1.3.0
		 *
		 * @param array $settings
		 *
		 * @return array
		 */
		public function register_hooks( $settings ) {
			foreach ( $settings as $index => $setting ) {
				if ( ! isset( $setting['ids'] ) ) {
					continue;
				}

				$settings[ $index ]['ids'] += array(
					'give_subscription_completed' => esc_html__( 'Subscription Completed', 'give-zapier' ),
					// 'give_subscription_created'   => esc_html__( 'Subscription Created', 'give-zapier' ),
					// 'give_subscription_renewed'   => esc_html__( 'Subscription Renewed', 'give-zapier' ),
					// 'give_subscription_expired'   => esc_html__( 'Subscription Expired', 'give-zapier' ),
					// 'give_subscription_failing'   => esc_html__( 'Subscription Failed', 'give-zapier' ),
					// 'give_subscription_cancelled' => esc_html__( 'Subscription Cancelled', 'give-zapier' ),
				);
			}

			return $settings;
		}

		/**
		 * Fire zapier API when a subscription completed.
		 * Note: only for internal use
		 *
		 * @since 1.3.0
		 *
		 * @param int               $subscription_id
		 * @param array             $new_data
		 * @param Give_Subscription $sub_obj
		 */
		public function subscription_status_updated( $subscription_id, $new_data, $sub_obj ) {
			$allowed           = give_recurring_get_subscription_statuses();
			$is_status_changed = ! empty( $new_data['status'] ) && strtolower( $sub_obj->status ) !== strtolower( $new_data['status'] );

			// Bailout.
			if ( ! $is_status_changed || ! array_key_exists( $new_data['status'], $allowed ) ) {
				return;
			}


			$subs_db                    = new Give_Subscriptions_DB();
			$subscription_data          = (array) $subs_db->get( $subscription_id );
			$subscription_data['donor'] = (array) Give()->donors->get( $subscription_data['customer_id'] );

			$new_subscription_data['info'] = $subscription_data;

			// Remove legacy array keys.
			if ( isset( $new_subscription_data['info']['product_id'] ) ) {
				unset( $new_subscription_data['info']['product_id'] );
			}

			if ( isset( $new_subscription_data['info']['customer_id'] ) ) {
				unset( $new_subscription_data['info']['customer_id'] );
			}

			// Format amount.
			$new_subscription_data['info']['initial_amount'] = give_format_decimal( array(
				'donation_id' => $new_subscription_data['info']['parent_payment_id'],
				'amount'      => $new_subscription_data['info']['initial_amount'],
				'dp'          => true,
			) );

			// Format amount.
			$new_subscription_data['info']['recurring_amount'] = give_format_decimal( array(
				'donation_id' => $new_subscription_data['info']['parent_payment_id'],
				'amount'      => $new_subscription_data['info']['recurring_amount'],
				'dp'          => true,
			) );

			// Format amount.
			$new_subscription_data['info']['donor']['purchase_value'] = give_format_decimal( array(
				'donation_id' => $new_subscription_data['info']['parent_payment_id'],
				'amount'      => $new_subscription_data['info']['donor']['purchase_value'],
				'dp'          => true,
			) );

			$new_subscription_data['info']['form_id']    = give_get_payment_form_id( $new_subscription_data['info']['parent_payment_id'] );
			$new_subscription_data['info']['currency']   = give_get_payment_currency_code( $new_subscription_data['info']['parent_payment_id'] );
			$new_subscription_data['info']['form_title'] = get_the_title( $new_subscription_data['info']['form_id'] );

			Give_Zapier_Connection::push_and_scrub( "give_subscription_{$new_data['status']}", $new_subscription_data );
		}

		/**
		 * Fire zapier API when a subscription donation is made.
		 *
		 * @since 1.2.0
		 *
		 * @param Give_Payment $payment Instances of Give_Payment.
		 *
		 * @return void
		 */
		public function add_subscription_payment( $payment ) {
			$donation_data = give_zapier_get_donation_data( $payment->ID );
			Give_Zapier_Connection::push_and_scrub( 'give_new_donation', $donation_data );
		}

		/**
		 * Add recurring testing data.
		 * Note: only for internal use
		 *
		 * @since 1.2.0
		 *
		 * @param array  $dummy_data testing data for Zapier.
		 * @param string $trigger testing data for Zapier.
		 *
		 * @return  array $data testing data for Zapier.
		 */
		public function add_data( $dummy_data, $trigger = '' ) {
			if ( empty( $trigger ) ) {
				return $dummy_data;
			}

			switch ( $trigger ) {
				case 'give_subscription_created':
				case 'give_subscription_renewed':
				case 'give_subscription_completed':
				case 'give_subscription_expired':
				case 'give_subscription_failing':
				case 'give_subscription_cancelled':
					$dummy_data = array(
						'id'                => '183',
						'donor_id'          => '36',
						'period'            => 'month',
						'initial_amount'    => '16.47',
						'recurring_amount'  => '10.98',
						'bill_times'        => '0',
						'transaction_id'    => '',
						'parent_payment_id' => '845',
						'product_id'        => '8',
						'created'           => '2016-06-13 13:47:24',
						'expiration'        => '2016-07-13 23:59:59',
						'status'            => str_replace( 'give_subscription_', '', $trigger ),
						'profile_id'        => 'ppe-4e3ca7d1c017e0ea8b24ff72d1d23022-8',
						'gateway'           => 'paypalexpress',
						'donor'             => array(
							'id'             => '36',
							'purchase_count' => '2',
							'purchase_value' => '32.93',
							'email'          => 'jane@test.com',
							'emails'         => array(
								'jane@test.com',
							),
							'name'           => 'Jane Doe',
							'date_created'   => '2016-06-13 13:19:50',
							'payment_ids'    => '842,845,846',
							'user_id'        => '1',
							'notes'          => array(
								'These are notes about the donor',
							),
						),
					);

					$dummy_data['info'] = $dummy_data;

					break;

				case 'give_subscription_donation':
				case 'give_subscription_payment':
					$dummy_data = give_zapier_testing_data_for_payment();
					break;
			}

			return $dummy_data;
		}
	}

	return new Give_Zapier_Recurring();
}