<?php

/**
 * The GoCardless Recurring Class.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 *
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/recurring
 */

/**
 * The GoCardless Recurring functionality.
 *
 * Register and manage the GoCardless gateway recurring method.
 *
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/includes
 * @author     GiveWP
 * @since      1.0.0
 */
class Give_GoCardless_Recurring extends Give_Recurring_Gateway {

	/**
	 * Store gocardless payment gateway slug.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var string $gocardless_gateway GoCardless gateway slug.
	 */
	private $gocardless_gateway;

	/**
	 * Get GoCardless Started.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {

		// As we have to assign the current payment gateway to Give_Recurring_Gateway.
		$this->id = 'gocardless';

		// Register action for to allow the cancellation of the subscription.
		add_action( 'give_recurring_cancel_gocardless_subscription', array( $this, 'cancel' ), 10, 2 );

		// Handle the Gocardless Recurring redirect flow.
		add_action( 'give_gocardless_init', array( $this, 'handle_recurring_redirection' ) );

		// Allow sync on subscriptions.
		add_filter( 'give_recurring_gateway_factory_get_gateway', array( $this, 'sync_get_gateway' ), 10, 3 );

		// Registering the delete recurring action.
		add_action( 'admin_init', array( $this, 'gocardless_recurring_delete_action' ), 1 );

		add_action( 'admin_init', array( $this, 'gocardless_update_subscription_status' ), 1 );

		add_action( 'give_recurring_process_checkout', array( $this, 'gocardless_check_validation' ), 10, 1 );

	}

	/**
	 * Create Payment Profiles.
	 * We will store temporary subscription's profile ID.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function create_payment_profiles() {

		// This is a temporary ID used to look it up later during GoCardless payment creation.
		$this->subscriptions['profile_id'] = 'gocardless-' . $this->purchase_data['purchase_key'];
	}

	/**
	 * Handle delete subscription action.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function gocardless_recurring_delete_action() {

		if ( empty( $_POST['sub_id'] ) ) {
			return;
		}

		if ( empty( $_POST['give_delete_subscription'] ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_give_payments' ) ) {
			return;
		}

		$subscription = new Give_Subscription( absint( $_POST['sub_id'] ) );

		if ( 'gocardless' !== $subscription->gateway ) {
			return;
		}

		// Cancel the subscription in GoCardless and GiveWP both.
		$this->cancel( $subscription, true );

	}

	/**
	 * Handle the action when subscription status is changed.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function gocardless_update_subscription_status() {

		// Need these to continue.
		if ( empty( $_POST['sub_id'] ) || empty( $_POST['give_update_subscription'] ) || ! current_user_can( 'edit_give_payments' ) ) {
			return;
		}

		// Security check.
		if ( ! wp_verify_nonce( $_POST['give-recurring-update-nonce'], 'give-recurring-update' ) ) {
			wp_die( __( 'Nonce verification failed.', 'give-gocardless' ), __( 'Error', 'give-gocardless' ), array( 'response' => 403 ) );
		}

		if ( isset( $_POST['status'] ) && ( 'cancelled' === $_POST['status'] || 'expired' === $_POST['status'] ) ) {

			if ( isset( $_POST['cancel_in_gocardless'] ) && 'on' === $_POST['cancel_in_gocardless'] ) {

				// Get the subscription.
				$subscription = new Give_Subscription( $_POST['profile_id'], true );

				// Cancel subscription in GoCardless if the subscription has run its course.
				$this->cancel( $subscription, true );
			}
		}

	}

	/**
	 * Find or create GoCardless subscription,
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param int      $mandate_id      newly created payment's mandate id, it is required in order to create subscription.
	 * @param int      $payment_id      newly create payment id.
	 * @param string   $return
	 * @param int|null $subscription_id givewp subscription data.
	 *
	 * @return array|WP_Error
	 *
	 * @throws Exception If any error occurred while create subscription.
	 */
	public function gocardless_create_subscription( $mandate_id, $payment_id, $return = 'id', $subscription_id = null ) {

		global $wpdb;

		try {

			// Throw error if subscription id is not found.
			if ( null === $subscription_id ) {
				throw new Exception( __( 'Subscription ID not provided.', 'give-gocardless' ) );
			}

			/* @var WP_Error|$subscription_data Get Subscription data from GoCardless, IF exists. */
			$subscription_data = Give_GoCardless_API::get_subscription( $subscription_id );

			if ( is_wp_error( $subscription_data ) ) {
				throw new Exception( sprintf( __( 'Error while fetching subscription %s', 'give-gocardless' ), $subscription_data->get_error_message() ) );
			}
		} catch ( Exception $e ) {

			$sub_data          = new Give_Subscriptions_DB();
			$subscription_data = $sub_data->get_subscriptions( array(
				'parent_payment_id' => $payment_id,
				'number'            => 1,
			) );

			$gocardless_subscription = get_object_vars( $subscription_data[0] );
			$subscription_name       = gocardless_get_payment_description( $payment_id, 'recurring', (array) $subscription_data[0] );
			$frequency               = ! empty( $gocardless_subscription['frequency'] ) ? intval( $gocardless_subscription['frequency'] ) : 1;

			// The plan does not exist, please create a new plan.
			$args = array(
				'amount'        => intval( $gocardless_subscription['recurring_amount'] * 100 ),
				'interval_unit' => gocardless_convert_interval_unit( $gocardless_subscription['period'] ),
				'interval'      => $frequency,
				'name'          => $subscription_name,
				'currency'      => give_get_payment_currency_code( $payment_id ),
				'links'         => array(
					'mandate' => $mandate_id,
				),
			);

			// Number of times for the recurring donation.
			if ( $gocardless_subscription['bill_times'] > 0 ) {
				$args['count'] = $gocardless_subscription['bill_times'];
			}

			// Get newly created subscription data.
			$subscription_data = Give_GoCardless_API::create_subscription( $args );

			if ( is_wp_error( $subscription_data ) ) {
				wp_send_json_error( array(
					'message' => $subscription_data->get_error_message(),
				) );
				exit;
			}

			// Update subscription profile_id.
			$wpdb->update( $wpdb->prefix . 'give_subscriptions', array(
				'profile_id' => $subscription_data['subscriptions']['id'],
			), array(
				'parent_payment_id' => $gocardless_subscription['parent_payment_id'],
				'customer_id'       => $gocardless_subscription['customer_id'],
			) );
		}// End try().

		if ( 'id' == $return ) {
			return $subscription_data['subscriptions']['id'];
		} else {
			return $subscription_data;
		}
	}

	/**
	 * Create new subscription payment and redirect to GoCardless payment checkout page.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return bool  if error occurred while process or redirect to GoCardless checkout page.
	 */
	public function record_signup() {
		// Set subscription_payment.
		give_update_payment_meta( $this->payment_id, '_give_subscription_payment', true );

		// Now create the subscription record.
		$subscriber = new Give_Recurring_Subscriber( $this->customer_id );

		if ( isset( $this->subscriptions['status'] ) ) {
			$status = $this->subscriptions['status'];
		} else {
			$status = $this->offsite ? 'pending' : 'active';
		}

		$frequency = ! empty( $this->subscriptions['frequency'] ) ? intval( $this->subscriptions['frequency'] ) : 1;
		$give_recurring_version = preg_replace( '/[^0-9.].*/', '', get_option( 'give_recurring_version' ) );
		if ( version_compare( $give_recurring_version, '1.6', '<' ) ) {
			$subscription_expiration = $subscriber->get_new_expiration( $this->subscriptions['id'], $this->subscriptions['price_id'] );
		} else {
			$subscription_expiration = $subscriber->get_new_expiration( $this->subscriptions['id'], $this->subscriptions['price_id'], $frequency, $this->subscriptions['period'] );
		}

		$args = array(
			'product_id'        => $this->subscriptions['id'],
			'parent_payment_id' => $this->payment_id,
			'status'            => $status,
			'period'            => $this->subscriptions['period'],
			'initial_amount'    => give_maybe_sanitize_amount( $this->subscriptions['initial_amount'] ),
			'recurring_amount'  => give_maybe_sanitize_amount( $this->subscriptions['recurring_amount'] ),
			'bill_times'        => $this->subscriptions['bill_times'],
			'frequency'         => $frequency,
			'expiration'        => $subscription_expiration,
			'profile_id'        => $this->subscriptions['profile_id'],
			'form_id'           => $this->subscriptions['form_id'],
		);

		// Support user_id if it is present in purchase_data.
		if ( isset( $this->purchase_data['user_info']['id'] ) ) {
			$args['user_id'] = $this->purchase_data['user_info']['id'];
		}

		// Add subscription data.
		$subscriber->add_subscription( $args );

		// Generating the arguments for the create a redirect flow.
		$redirect_flow_params = array(
			'description'          => gocardless_get_payment_description( $this->payment_id, 'recurring', $this->subscriptions ),
			'session_token'        => $this->purchase_data['purchase_key'],
			'success_redirect_url' => self::get_success_page( $this->payment_id ),
			'prefilled_customer'   => array(
				'given_name'  => $this->purchase_data['post_data']['give_first'],
				'family_name' => $this->purchase_data['post_data']['give_last'],
				'email'       => $this->purchase_data['post_data']['give_email'],
			),
		);

		// Check the billing option enable or not in GoCardless setting page.
		$is_billing_enabled = give_is_setting_enabled( give_get_gocardless_setting( 'gocardless_billing_details' ) );

		// Setting up billing details if submitted through Donation form.
		if ( $is_billing_enabled ) {

			$redirect_flow_params['prefilled_customer']['address_line1'] = $this->purchase_data['post_data']['card_address'];
			$redirect_flow_params['prefilled_customer']['address_line2'] = $this->purchase_data['post_data']['card_address_2'];
			$redirect_flow_params['prefilled_customer']['city']          = $this->purchase_data['post_data']['card_city'];
			$redirect_flow_params['prefilled_customer']['postal_code']   = $this->purchase_data['post_data']['card_zip'];
			$redirect_flow_params['prefilled_customer']['country_code']  = $this->purchase_data['post_data']['billing_country'];
			$redirect_flow_params['prefilled_customer']['region']        = $this->purchase_data['post_data']['card_state'];
		}

		// Get the value of direct debit drop-down.
		$scheme = give_get_gocardless_setting( 'direct_debit_scheme', '' );

		if ( ! empty( $scheme ) ) {

			/**
			 * If Autogiro, Bacs, SEPA Core, or SEPA COR1 is specified, the payment pages will only allow
			 * the set-up of a mandate for the specified scheme. If auto detect is specified, failed validation
			 * may occur in case currency in the order is not supported by the scheme.
			 *
			 * @see https://developer.gocardless.com/api-reference/2015-07-06/#overview-supported-direct-debit-schemes
			 */
			$redirect_flow_params['scheme'] = $scheme;
		}

		/** @var WP_Error|array $response_data if there is any error occurred while creating redirect flow */
		$response_data = Give_GoCardless_API::create_redirect_flow( $redirect_flow_params );

		// Send back to Donation form if not get response.
		if ( isset( $response_data ) && empty( $response_data ) ) {
			give_set_error( 'request_error', __( 'There was a problem connecting to the payment gateway.', 'give-gocardless' ) );
			give_send_back_to_checkout( '?payment-mode=' . GIVE_GOCARDLESS_GATEWAY_SLUG );
			exit;
		}

		// Send back to Donation form if have any error.
		if ( is_wp_error( $response_data ) ) {
			give_set_error( 'request_error', $response_data->get_error_message() );
			give_send_back_to_checkout( '?payment-mode=' . GIVE_GOCARDLESS_GATEWAY_SLUG );
			exit;
		}

		// Get response key.
		$response_data_key = array_keys( $response_data );

		if ( ! isset( $response_data_key[0] ) ) {
			return false;
		}

		// Get the type of response, It should be 'redirect_flows'.
		$redirect_type = $response_data_key[0];

		// Update payment meta data.
		Give_GoCardless_Gateway::update_payment_resource( $this->payment_id, 'redirect_flows', $response_data[ $redirect_type ] );

		if ( ! empty( $response_data['redirect_flows']['redirect_url'] ) ) {

			$payment_url = $response_data['redirect_flows']['redirect_url'];

			// Redirect to GoCardless payment checkout page.
			wp_redirect( $payment_url );
			exit;

		} else {
			return false;
		}
	}

	/**
	 * Processes webhooks from the Authorize.net payment processor.
	 *
	 * @access      public
	 * @since       1.0.0
	 *
	 * @return      bool|void
	 */
	public function recurring_process_webhooks() {

		// retrieve the request's body and parse it as JSON
		$response_data = @file_get_contents( 'php://input' );
		$data          = json_decode( $response_data );

		if ( empty( $data->events[0] ) ) {
			wp_send_json_error( __( 'Something went wrong!', 'give-gocardless' ) );
			exit;
		}

		foreach ( $data->events as $event ) {
			if ( 'subscriptions' === $event->resource_type ) {
				// Handle Webhook events.
				$this->handle_subscription_event( $event->action, $event->links, $event );
			}
		}
	}

	/**
	 * Handle GoCardless recurring webhook.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param string $event        subscription webhook event.
	 * @param object $subscription subscription data.
	 * @param object $eventdata    Webhook event data.
	 *
	 * @return bool
	 */
	public function handle_subscription_event( $event, $subscription, $eventdata ) {

		if ( empty( $event ) || ! isset( $subscription ) ) {
			return false;
		}

		// Get the gocardless subscription data.
		$gocardless_subscription = new Give_Subscription( $subscription->subscription, true );

		// Check subscription webhook event.
		if ( 'payment_created' === $event ) {
			$this->_maybe_add_payment( $subscription, $eventdata );
		} elseif ( 'cancelled' === $event ) {
			$gocardless_subscription->cancel();
		} elseif ( 'finished' === $event ) {
			$gocardless_subscription->complete();
		}

		return true;
	}

	/**
	 * When a renew payment is created in GoCardless subscription,
	 * we have to create the payment for particular donation in our system.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param object $subscription_data Donation subscription data comes with the webhook.
	 * @param object $eventdetails      Subscription event details form gocardless webhook.
	 *
	 * @return bool
	 */
	public function _maybe_add_payment( $subscription_data, $eventdetails ) {

		// If subscription ID is not set, return false.
		if ( ! isset( $subscription_data->subscription ) ) {
			return false;
		}

		// Get subscription through profile ID.
		$subscription = new Give_Subscription( $subscription_data->subscription, true );

		// Check for subscription ID.
		if ( 0 === $subscription->id ) {
			return false;
		}

		$total_payments = (int) $subscription->get_total_payments();
		$bill_times     = (int) $subscription->bill_times;

		// Instance of Give_GoCardless_Gateway.
		$gocardless_gateway = new Give_GoCardless_Gateway();

		// If subscription is ongoing or bill_times is less than total payments.
		if ( $bill_times == 0 || $total_payments < $bill_times ) {

			$amount         = give_donation_amount( $subscription->parent_payment_id );
			$transaction_id = $subscription_data->payment;

			// Look to see if we have set the transaction ID on the parent payment yet.
			if ( ! $subscription->get_transaction_id() ) {

				// This is the initial transaction payment aka first subscription payment.
				$subscription->set_transaction_id( $transaction_id );

				$payment_data = Give_GoCardless_API::get_payment( $transaction_id );

				// Insert description with the payment id.
				give_insert_payment_note( $subscription->parent_payment_id, $eventdetails->details->description );

				// Set payment to processing status.
				give_update_payment_status( $subscription->parent_payment_id, 'processing' );

				$gocardless_gateway::update_payment_resource( $subscription->parent_payment_id, 'payment', $payment_data['payments'] );

			} else {

				// Store payment details.
				$child_payment_id = give_get_purchase_id_by_transaction_id( $transaction_id );

				if ( $child_payment_id ) {
					return false;
				}

				// We have a renewal.
				$subscription->add_payment( array(
					'amount'         => $amount,
					'transaction_id' => $transaction_id,
				) );

				$subscription->renew();

				$payment_id = give_get_purchase_id_by_transaction_id( $transaction_id );

				give_insert_payment_note( $payment_id, $eventdetails->details->description );

				// Get payment details from the gocardless.
				$payment_details = Give_GoCardless_API::get_payment( $transaction_id );

				if ( ! empty( $payment_details ) ) {
					// Store payment details into payment meta data.
					$gocardless_gateway::update_payment_resource( $payment_id, 'payment', $payment_details['payments'] );
				}

				// Check if this subscription is complete.
				$this->is_subscription_completed( $subscription, $total_payments, $bill_times );
			}// End if().
		}// End if().

	}

	/**
	 * When subscription is created on GoCardless it returns user back to our
	 * website with recurring=1 query string to identify that it was recurring payment.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @return bool return false if required data is missing or redirect to success.
	 *
	 * @throws Exception if something went wrong!
	 */
	public function handle_recurring_redirection() {

		// Return false if it is not about recurring.
		if ( ! isset( $_GET['is_recurring'] ) ) {
			return false;
		}

		try {

			if ( empty( $_GET['redirect_flow_id'] ) || empty( $_GET['payment_id'] ) ) {
				throw new Exception( __( 'Invalid redirect flow request.', 'give-gocardless' ) );
			}

			// Get payment ID from query variable.
			$payment_id       = absint( $_GET['payment_id'] );
			$redirect_flow_id = $_GET['redirect_flow_id'];

			// Get the instance of Give GoCardless payment gateway.
			$gocardless_gateway = new Give_GoCardless_Gateway();

			/**
			 * This creates a customer, customer bank account, and mandate using the details
			 * supplied by your customer and returns the ID of the created mandate.
			 */
			$redirect_flow = $gocardless_gateway->maybe_complete_redirect_flow( $payment_id, $redirect_flow_id );

			if ( ! $redirect_flow ) {
				return false;
			}

			// Get mandate id from redirect flow response.
			$mandate_id = $redirect_flow['links']['mandate'];

			// Create the subscription on GoCardless through mandate id and donation payment ID.
			$subscription_id = $this->gocardless_create_subscription( $mandate_id, $payment_id );

			// If subscription wasn't created throw error.
			if ( empty( $subscription_id ) ) {
				throw new Exception( __( 'Subscription couldn\'t created!', 'give-gocardless' ) );
			}

			// Redirect to give success page, if everything is okay.
			give_send_to_success_page();

		} catch ( Exception $e ) {

			give_record_gateway_error( __( 'Payment Error:', 'give-gocardless' ), $e->getMessage() );
			wp_send_json_error( array(
				'message' => $e->getMessage(),
			) );
			exit;
		}// End try().
	}

	/**
	 * Triggers the validate_fields() method for the gateway during checkout submission
	 *
	 * @since       1.0.0
	 * @access      public
	 *
	 * @param array $data
	 *
	 * @return      void
	 */
	public function checkout_errors( $data ) {

		// Return, if gateway is not gocardless.
		if ( ! empty( $_POST['give-gateway'] ) && $this->id !== $_POST['give-gateway'] ) {
			return;
		}

		$this->validate_fields( $data, $_POST );
	}

	/**
	 * Generate the success url on which user will be returned
	 * when payment is successfully created on gocardless.
	 *
	 * @param   int $payment_id Donation payment id.
	 *
	 * @access      protected
	 * @since       1.0.0
	 *
	 * @return  string $success_redirect get give donation url with some query string.
	 */
	protected static function get_success_page( $payment_id ) {

		$success_redirect = add_query_arg( array(
			'payment_id'   => $payment_id,
			'is_recurring' => 1,
		), get_permalink( give_get_option( 'success_page' ) ) );

		return $success_redirect;
	}

	/**
	 * GoCardless Subscription Cancellation
	 *
	 * @access      public
	 * @since       1.0.0
	 *
	 * @param object $subscription subscription data.
	 * @param bool   $valid
	 *
	 * @return bool
	 *
	 * @throws Exception if something went wrong!
	 */
	public function cancel( $subscription, $valid ) {

		if ( empty( $valid ) ) {
			return false;
		}

		try {
			// Send request to cancel subscription on GoCardless.
			$cancel_subscription = Give_GoCardless_API::cancel_subscription( $subscription->profile_id );

			// Get the all payment from the gocardless subscription.
			$payments = $this->get_invoice_from_subscription( $subscription->profile_id );

			foreach ( $payments as $payment ) {
				// Check if payment is pending.
				if ( 'pending_submission' === $payment['status'] ) {
					// Cancel the payment.
					Give_GoCardless_API::cancel_payment( $payment['id'] );
				}
			}

			if ( is_wp_error( $cancel_subscription ) ) {
				throw new Exception( $cancel_subscription->get_error_message() );
			}

			return false;

		} catch ( Exception $e ) {

			// Something went wrong outside of GoCardless.
			give_record_gateway_error( __( 'GoCardless Error', 'give-gocardless' ), sprintf( __( 'The GoCardless Gateway returned an error while cancelling a subscription. Details: %s', 'give-gocardless' ), $e->getMessage() ) );
			give_set_error( 'GoCardless Error', __( 'An error occurred while cancelling the donation. Please try again.', 'give-gocardless' ) );

			return false;
		}
	}

	/**
	 * Can Cancel.
	 *
	 * @param $ret
	 * @param $subscription
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function can_cancel( $ret, $subscription ) {

		if ( $subscription->gateway === $this->id && ! empty( $subscription->profile_id ) && 'active' === $subscription->status ) {
			$ret = true;
		}

		return $ret;
	}

	/**
	 * Can Sync.
	 *
	 * @param bool $ret
	 * @param      $subscription
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return bool
	 */
	public function can_sync( $ret, $subscription ) {

		if ( $subscription->gateway === $this->id && ! empty( $subscription->profile_id ) ) {
			$ret = true;
		}

		return $ret;
	}

	/**
	 * Get the Give_GoCardless_Recurring for Synchronizer.
	 *
	 * For synchronize to properly initialize the class b/c the ID and class name differ.
	 *
	 * @since  1.0.0
	 *
	 * @param                   $ret
	 * @param                   $gateway
	 * @param Give_Subscription $subscription
	 *
	 * @return Give_GoCardless_Recurring $this
	 */
	function sync_get_gateway( $ret, $gateway, $subscription ) {

		// Return this class if gateway matches.
		if ( $subscription->gateway === $this->id ) {
			return $this;
		}

		// Always return original filter value.
		return $ret;
	}

	/**
	 * Get transactions.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param object $subscription
	 * @param string $date
	 *
	 * @return array
	 */
	public function get_gateway_transactions( $subscription, $date = '' ) {

		// GoCardless Transaction.
		$transactions = array();

		// Get GoCardless transaction from specific subscription id.
		$recurring_transaction = $this->get_invoice_from_subscription( $subscription->profile_id );

		foreach ( $recurring_transaction as $invoice ) {

			// Collect GoCardless transaction data.
			$transactions[ $invoice['id'] ] = array(
				'amount'         => $invoice['amount'] / 100,
				'date'           => strtotime( $invoice['created_at'] ),
				'transaction_id' => $invoice['id'],
			);
		}

		return $transactions;
	}

	/**
	 * Get invoices for GoCardless customer.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @param string $subscription_id GoCardless subscription ID.
	 * @param string $date            Subscription ID.
	 *
	 * @return array $transaction get the transaction data.
	 */
	private function get_invoice_from_subscription( $subscription_id, $date = '' ) {

		$subscription_args = array(
			'subscription' => $subscription_id,
		);

		// Get all payments from this subscription.
		$payments = Give_GoCardless_API::get_payments( $subscription_args );

		// Return all the payment from subscription.
		return $payments['payments'];
	}

	/**
	 * Get subscription details.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param Give_Subscription $subscription
	 *
	 * @return array|bool
	 */
	public function get_subscription_details( $subscription ) {

		$gocardless_subscription = $this->get_gocardless_subscription( $subscription );

		if ( false !== $gocardless_subscription ) {

			$subscription_details = array(
				'status'         => $gocardless_subscription['status'],
				'created'        => strtotime( $gocardless_subscription['created_at'] ),
				'billing_period' => gocardless_convert_interval_unit( $gocardless_subscription['interval_unit'] ),
				'frequency'      => ! empty( $gocardless_subscription['interval'] ) ? intval( $gocardless_subscription['interval'] ) : 1,
			);

			return $subscription_details;
		}

		return false;
	}

	/**
	 * Get gateway subscription.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param object $subscription GoCardless recurring payment.
	 *
	 * @return bool|mixed
	 */
	public function get_gocardless_subscription( $subscription ) {

		if ( $subscription instanceof Give_Subscription ) {

			// Get the GoCardless subscription ID.
			$gocardless_subscription_id = $subscription->profile_id;

			if ( empty( $gocardless_subscription_id ) ) {
				return false;
			}

			// Get the subscription data from GoCardless.
			$gocardless_subscription = Give_GoCardless_API::get_subscription( $gocardless_subscription_id );

			return $gocardless_subscription['subscriptions'];

		}

		return false;
	}

	/**
	 * Is Subscription Completed?
	 *
	 * After a sub renewal comes in from Stripe we check to see if total_payments
	 * is greater than or equal to bill_times; if it is, we cancel the GoCardless sub for the customer.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param $subscription Give_Subscription
	 * @param $total_payments
	 * @param $bill_times
	 *
	 * @return bool
	 */
	public function is_subscription_completed( $subscription, $total_payments, $bill_times ) {

		if ( $total_payments >= $bill_times && $bill_times != 0 ) {

			// Cancel subscription in GoCardless if the subscription has run its course.
			$this->cancel( $subscription, true );

			// Complete the subscription.
			$subscription->complete();

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate before process.
	 *
	 * @param array $donation_data
	 *
	 * @since 1.1.3
	 *
	 * @return bool
	 */
	public function gocardless_check_validation( $donation_data ) {
		if ( ( ! empty( $donation_data['gateway'] ) && GIVE_GOCARDLESS_GATEWAY_SLUG === $donation_data['gateway'] )
		     && ( ! empty( $donation_data['period'] ) && 'day' === $donation_data['period'] )
		) {
			give_set_error( 'recurring_validate_period', __( 'Period \'day\' is not supported by GoCardless gateway.', 'give-gocardless' ) );

			return false;
		}

		return true;

	}

	/**
	 * Can update subscription details.
	 *
	 * @since 1.3
	 *
	 * @param bool   $ret
	 * @param object $subscription
	 *
	 * @return bool
	 */
	public function can_update_subscription( $ret, $subscription ) {

		if (
			'gocardless' === $subscription->gateway
			&& ! empty( $subscription->profile_id )
			&& in_array( $subscription->status, array(
				'active',
			), true )
		) {
			return true;
		}
		return $ret;
	}

	/**
	 * Process the update subscription.
	 *
	 * @since  1.3.7 add third argument to make function compatible with recurring add-on 1.12.0
	 * @since  1.3
	 *
	 * @param  Give_Recurring_Subscriber  $subscriber  Give_Recurring_Subscriber
	 * @param  Give_Subscription  $subscription  Give_Subscription
	 * @param  array                            (optional) $data Array of update arguments
	 *
	 * @return void
	 */
	public function update_subscription( $subscriber, $subscription, $data = null ) {

		// Sanitize the values submitted with donation form.
		$post_data = $data === null ? give_clean( $_POST ) : $data; // WPCS: input var ok, sanitization ok, CSRF ok.

		// Get update renewal amount.
		$renewal_amount           = isset( $post_data['give-amount'] ) ? give_maybe_sanitize_amount( $post_data['give-amount'] ) : 0;
		$current_recurring_amount = give_maybe_sanitize_amount( $subscription->recurring_amount );
		$check_amount             = number_format( $renewal_amount, 0 );

		// Set error if renewal amount not valid.
		if (
			empty( $check_amount ) ||
			$renewal_amount === $current_recurring_amount
		) {
			give_set_error( 'give_recurring_invalid_subscription_amount', __( 'Please enter the valid subscription amount.', 'give-gocardless' ) );
		}

		// Is errors?
		$errors = give_get_errors();

		if ( ! $errors ) {
			Give_GoCardless_API::gocardless_update_subscription( $subscription->profile_id,
				array(
					'amount'  => $renewal_amount * 100,
					'app_fee' => 0,
				)
			);
		}

	}
}

new Give_GoCardless_Recurring();
