<?php

/**
 * The GoCardless Payment Gateway Class.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 *
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/gateway
 */

/**
 * The GoCardless Gateway functionality.
 *
 * Register and manage the GoCardless gateway method.
 *
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/includes
 * @author     GiveWP
 * @since      1.0.0
 */
class Give_GoCardless_Gateway {

	/**
	 * Admin notice text
	 *
	 * @var     string $_admin_notice store admin notice.
	 * @since   1.0.0
	 */
	private $_admin_notice = '';

	/**
	 * Give_GoCardless_Gateway constructor.
	 *
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct() {
		// Look for access token.
		$this->look_for_access_token();

		// Handle GoCardless payment
		add_action( 'give_gocardless_init', array( $this, 'payment_handler' ) );

		// Handle webhook of GoCardless.
		add_action( 'give_gocardless_init', array( $this, 'give_listen_for_gocardless_webhook' ) );

		// Register hooks for GoCardless refund.
		add_action( 'give_update_payment_status', array( $this, 'process_refund' ), 200, 3 );

		// Register hooks for GoCardless cancellation.
		add_action( 'give_update_payment_status', array( $this, 'process_cancel' ), 200, 3 );

	}

	/**
	 * The role of this method is to store and destroy access token from the database.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @return  bool
	 */
	public function look_for_access_token() {

		// Return false, if it is not admin.
		if ( ! is_admin() ) {
			return false;
		}

		if ( $this->_maybe_save_access_token() ) {

			// Show success message when successfully authenticated with GiveWP GoCardless.
			$auth_message = __( 'You have successfully authenticated with GiveWP GoCardless.', 'give-gocardless' );
			$this->_show_admin_notice( $auth_message );

		} elseif ( $this->_disconnect_authentication() ) {

			// Show success message.
			$auth_message = __( 'You have successfully disconnected from GiveWP GoCardless.', 'give-gocardless' );
			$this->_show_admin_notice( $auth_message );
		}

	}

	/**
	 * May be user has just authenticated with GoCardless.
	 *
	 * @access  protected
	 * @since   1.0.0
	 *
	 * @return  bool
	 */
	protected function _maybe_save_access_token() {

		// Require the access token.
		if ( empty( $_GET['give_gocardless_access_token'] ) ) {
			return false;
		}

		// Require the nonce.
		if ( empty( $_GET['give_gocardless_nonce'] ) ) {
			return false;
		}

		// Here, we are verifying the nonce.
		if ( ! wp_verify_nonce( $_GET['give_gocardless_nonce'], 'give_gocardless_nonce' ) ) {
			wp_die( __( 'Invalid connection request.', 'give-gocardless' ) );
		}

		// If we already have a token, ignore this request.
		$existing_access_token = get_option( 'give_gocardless_settings', '' );

		if ( ! empty( $existing_access_token['access_token'] ) ) {
			return false;
		}

		$access_token = sanitize_text_field( $_GET['give_gocardless_access_token'] );
		if ( empty( $access_token ) ) {
			return false;
		}

		$settings = self::get_gocardless_auth_data();

		$settings['access_token'] = $access_token;
		$settings['sandbox']      = ( 1 === intval( $_GET['sandbox'] ) ) ? intval( $_GET['sandbox'] ) : 0;

		// Update the values inside database.
		update_option( 'give_gocardless_settings', $settings );

		return true;
	}

	/**
	 * Set message to show in admin notice.
	 *
	 * @access  protected
	 * @since   1.0.0
	 *
	 * @param   string $message Message to show in admin notice.
	 *
	 * @return  void
	 */
	protected function _show_admin_notice( $message ) {

		// Set message for show in admin notice.
		$this->_admin_notice = $message;

		// Call admin notice
		add_action( 'admin_notices', array( $this, 'gocardless_render_admin_notice' ) );

	}

	/**
	 * Render admin notice.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function gocardless_render_admin_notice() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><b><?php printf( '%1$s', esc_attr( $this->_admin_notice ) ); ?></b></p>
		</div>
		<?php
	}

	/**
	 * Disconnect from authentication.
	 *
	 * @access  protected
	 * @since   1.0.0
	 *
	 * @return  bool    true if successfully disconnected.
	 */
	protected function _disconnect_authentication() {

		// Check if user requested for disconnect.
		if ( empty( $_GET['give_gocardless_disconnect'] ) ) {
			return false;
		}

		// We need nonce, return false if nonce is not available.
		if ( empty( $_GET['give_gocardless_disconnect_nonce'] ) ) {
			return false;
		}

		// Verify nonce.
		if ( ! wp_verify_nonce( $_GET['give_gocardless_disconnect_nonce'], 'give_disconnect_gocardless' ) ) {
			wp_die( __( 'Invalid disconnection request.', 'give-gocardless' ) );
		}

		// If we don't have a token, ignore this request.
		$existing_access_token = self::get_gocardless_auth_data();

		if ( empty( $existing_access_token['access_token'] ) ) {
			return false;
		}

		// Get the Give_GoCardless Setting
		$settings = get_option( 'give_gocardless_settings' );

		// unset the access_token.
		$settings['access_token'] = '';
		$settings['sandbox']      = '';

		// Update option without access token.
		update_option( 'give_gocardless_settings', $settings );

		// Return true, if everything is okay.
		return true;
	}

	/**
	 * Update GoCardless resource in payment meta.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param   int    $payment_id    Payment ID.
	 * @param   string $resource_type GoCardless resource type ('payment', 'refund' etc) in singular noun.
	 * @param   array  $resource      Resource data.
	 *
	 * @return  void
	 */
	public static function update_payment_resource( $payment_id, $resource_type, $resource = array() ) {

		switch ( $resource_type ) {

			case 'redirect_flows':
				give_update_meta( $payment_id, '_gocardless_redirect_flow', $resource );
				give_update_meta( $payment_id, '_gocardless_redirect_flow_id', $resource['id'] );
				break;

			case 'payment':
				give_update_meta( $payment_id, '_gocardless_payment', $resource );
				give_update_meta( $payment_id, '_gocardless_payment_id', $resource['id'] );
				give_update_meta( $payment_id, '_gocardless_payment_status', $resource['status'] );
				break;

			case 'mandate':
				give_update_meta(
					$payment_id, '_gocardless_mandate', array(
						'id' => $resource['id'],
					)
				);
				give_update_meta( $payment_id, '_gocardless_mandate_id', $resource['id'] );
				break;

			case 'refund':
				give_update_meta( $payment_id, '_gocardless_refund', $resource );
				give_update_meta( $payment_id, '_gocardless_refund_id', $resource['id'] );
				break;
		}
	}

	/**
	 * Get GoCardless oAuth data.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @return  array $gateway_data Get GoCardless authentication data.
	 */
	public static function get_gocardless_auth_data() {

		// Retrieve GoCardless authentication setting data.
		$gateway_data = get_option( 'give_gocardless_settings' );

		return $gateway_data;
	}

	/**
	 * GoCardless process the payment.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param   array $payment_data Pass submitted payment data.
	 *
	 * @return  bool | false            if process payment failed or there is any error
	 *                                  occurred while doing payment process.
	 */
	public static function process_payment( $payment_data ) {

		// Validate the gateway_nonce.
		give_validate_nonce( $payment_data['gateway_nonce'], 'give-gateway' );

		// Create new payment for donation.
		$payment_id = self::gocardless_create_payment( $payment_data );

		// Check if payment is created.
		if ( empty( $payment_id ) ) {

			// Record the error.
			give_record_gateway_error( __( 'Payment Error', 'give-gocardless' ), sprintf( __( 'Payment creation failed before sending donor to GoCardless. Payment data: %s', 'give-gocardless' ), wp_json_encode( $payment_data ) ), $payment_id );

			give_set_error( 'payment_creation_error', __( 'Payment creation failed. Please try again', 'give-gocardless' ) );

			// Problems? Send back.
			give_send_back_to_checkout( '?payment-mode=' . GIVE_GOCARDLESS_GATEWAY_SLUG );
		}

		// Generating the arguments for the create a redirect flow.
		$redirect_flow_params = array(
			'description'          => gocardless_get_payment_description( $payment_id ),
			'session_token'        => $payment_data['purchase_key'],
			'success_redirect_url' => self::get_success_page( $payment_id ),
			'prefilled_customer'   => array(
				'given_name'  => $payment_data['post_data']['give_first'],
				'family_name' => $payment_data['post_data']['give_last'],
				'email'       => $payment_data['post_data']['give_email'],
			),
		);

		// Check the billing option enable or not in GoCardless setting page.
		$is_billing_enabled = give_is_setting_enabled( give_get_gocardless_setting( 'gocardless_billing_details' ) );

		// Setting up billing details if submitted through Donation form.
		if ( $is_billing_enabled ) {
			$redirect_flow_params['prefilled_customer']['address_line1'] = $payment_data['post_data']['card_address'];
			$redirect_flow_params['prefilled_customer']['address_line2'] = $payment_data['post_data']['card_address_2'];
			$redirect_flow_params['prefilled_customer']['city']          = $payment_data['post_data']['card_city'];
			$redirect_flow_params['prefilled_customer']['postal_code']   = $payment_data['post_data']['card_zip'];
			$redirect_flow_params['prefilled_customer']['country_code']  = $payment_data['post_data']['billing_country'];
			$redirect_flow_params['prefilled_customer']['region']        = $payment_data['post_data']['card_state'];
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

		/** @var WP_Error|array $response_data if there is any error while creating redirect flow */
		$response_data = Give_GoCardless_API::create_redirect_flow( $redirect_flow_params );

		if ( is_wp_error( $response_data ) ) {

			give_record_gateway_error( __( 'GoCardless Error', 'give-gocardless' ), $response_data->get_error_message() );

			give_set_error( 'request_error', $response_data->get_error_message() );
			give_send_back_to_checkout( '?payment-mode=' . GIVE_GOCARDLESS_GATEWAY_SLUG );
			exit;
		}

		// Get Response key.
		$response_data_key = array_keys( $response_data );

		if ( ! isset( $response_data_key[0] ) ) {
			return false;
		}

		// Get Response type.
		$redirect_type = $response_data_key[0];

		// Update payment meta data.
		self::update_payment_resource( $payment_id, $redirect_type, $response_data[ $redirect_type ] );

		if ( ! empty( $response_data['redirect_flows']['redirect_url'] ) ) {

			$payment_url = $response_data['redirect_flows']['redirect_url'];

			// Redirect to GoCardless payment page.
			wp_redirect( $payment_url );

		} else {
			return false;
		}

	}

	/**
	 * GoCardless refund process.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param   int    $payment_id Donation payment id.
	 * @param   string $new_status New payment status.
	 * @param   string $old_status Old payment status.
	 *
	 * @return  bool|WP_Error
	 */
	public function process_refund( $payment_id, $new_status, $old_status ) {

		// Only move forward if refund requested.
		if ( empty( $_POST['give_refund_in_gocardless'] ) ) {
			return false;
		}

		// Get all posted data.
		$payment_data = $_POST;

		if ( 'refunded' != $new_status || ! isset( $payment_data ) ) {
			return false;
		}

		// Get GoCardless payment id.
		$charge_id = give_get_payment_transaction_id( $payment_id );

		// If no charge ID, look in the payment notes.
		if ( empty( $charge_id ) ) {
			return new WP_Error( 'missing_payment', sprintf( __( 'Unable to refund order #%s. Order does not have payment ID. Make sure payment has been created.', 'give-gocardless' ), $payment_id ) );
		}

		// Calculate the total.
		$amount_in_cents       = intval( 100 * $payment_data['give-payment-total'] );
		$total_amount_in_cents = intval( 100 * $payment_data['give-payment-total'] );

		$refund_params = array(
			'amount'                    => $amount_in_cents,
			'total_amount_confirmation' => $total_amount_in_cents,
			'links'                     => array(
				'payment' => $charge_id,
			),
			'metadata'                  => array(
				'order_id'    => (string) $payment_id,
				'order_total' => (string) $payment_data['give-payment-total'],
				'reason'      => sprintf( __( 'Order refunded manually for # %s', 'give-gocardless' ), $charge_id ),
			),
		);

		// Create refund on GoCardless.
		$refund = Give_GoCardless_API::create_refund( $refund_params );

		if ( is_wp_error( $refund ) ) {
			give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund via GoCardless: %s', 'give-gocardless' ), $refund->get_error_message() ) );

			// Change it to previous status.
			give_update_payment_status( $payment_id, $old_status );

			return false;
		}

		if ( empty( $refund['refunds']['id'] ) ) {
			give_insert_payment_note( $payment_id, __( 'Unable to refund via GoCardless. GoCardless returns unexpected refund response.', 'give-gocardless' ) );

			return false;
		}

		if ( isset( $refund['refunds'] ) ) {

			// Add refund id into payment.
			give_update_meta( $payment_id, 'gocardless_refunded_id', $refund['refunds']['id'] );

			// Insert note about refund.
			give_insert_payment_note( $payment_id, esc_html( $refund['refunds']['metadata']['reason'] ) );

		}
		// Store Refund data into payment.
		self::update_payment_resource( $payment_id, 'refund', $refund['refunds'] );

		return true;
	}

	/**
	 * GoCardless payment cancellation process.
	 *
	 * @access  public
	 * @since   1.0.0
	 *
	 * @param   int    $payment_id Donation payment id.
	 * @param   string $new_status New payment status.
	 * @param   string $old_status Old payment status.
	 *
	 * @return  bool|WP_Error
	 */
	public function process_cancel( $payment_id, $new_status, $old_status ) {

		// Get all posted data.
		$payment_data = $_POST;

		// Only move forward if cancel requested.
		if ( empty( $_POST['give_cancellation_in_gocardless'] ) ) {
			return false;
		}

		if ( 'cancelled' !== $new_status || ! isset( $payment_data ) ) {
			return false;
		}

		// Retrieve payment's gateway method.
		$payment_gateway = give_get_payment_gateway( $payment_id );

		// If payment gateway is not correct.
		if ( GIVE_GOCARDLESS_GATEWAY_SLUG !== $payment_gateway ) {
			return false;
		}

		// Get GoCardless payment id.
		$charge_id = give_get_payment_transaction_id( $payment_id );

		// If no charge ID, look in the payment notes.
		if ( empty( $charge_id ) ) {
			return new WP_Error( 'missing_payment', sprintf( __( 'Unable to cancel payment #%s. Payment does not have ID. Make sure payment has been created.', 'give-gocardless' ), $payment_id ) );
		}

		/* @var WP_Error|$cancel_payment Cancel payment on GoCardless . */
		$cancel_payment = Give_GoCardless_API::cancel_payment( $charge_id );

		if ( is_wp_error( $cancel_payment ) ) {
			give_insert_payment_note( $payment_id, sprintf( __( 'Unable to cancel payment via GoCardless: %s', 'give-gocardless' ), $cancel_payment->get_error_message() ) );

			// Change it to previous status.
			give_update_payment_status( $payment_id, $old_status );

			return false;
		}

		// Insert payment cancellation note.
		give_insert_payment_note( $payment_id, __( 'Payment cancelled successfully via GoCardless', 'give-gocardless' ) );

		return true;
	}

	/**
	 * Handle GoCardless Webhook refund request.
	 *
	 * @since   1.0.0
	 * @access  protected
	 *
	 * @param   array $event GoCardless Webhook request data.
	 *
	 * @return  bool|false|int
	 */
	protected function webhook_refund_process( $event ) {

		// Return false if refund id is blank or not set.
		if ( ! isset( $event['links']['refund'] ) ) {
			return false;
		}

		$refund_id = $event['links']['refund'];
		$refund    = Give_GoCardless_API::get_refund( $refund_id );

		// Get Refund Payment ID.
		$refund_payment_id = $refund['refunds']['links']['payment'];

		// Return false if there is no payment id.
		if ( ! $refund_payment_id ) {
			return false;
		}

		$payment = give_get_payments(
			array(
				'meta_key'       => '_give_payment_transaction_id',
				'meta_value'     => $refund_payment_id,
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		if ( $payment ) {
			$payment = new Give_Payment( $payment[0] );
		}

		// Retrieve payment's gateway method.
		$payment_gateway = give_get_payment_gateway( $payment->ID );

		// If payment gateway is not correct.
		if ( GIVE_GOCARDLESS_GATEWAY_SLUG !== $payment_gateway ) {
			return false;
		}

		// Change payment status to refund.
		give_update_payment_status( $payment->ID, 'refunded' );

		// Update payment meta data if everything is okay.
		if ( ! is_wp_error( $refund ) && ! empty( $refund['refunds'] ) ) {
			self::update_payment_resource( $payment->ID, 'refund', $refund['refunds'] );
		}

		// Add latest webhook event to payment post.
		return give_update_payment_meta( $payment->ID, '_give_gocardless_webhook_events', $event, false );
	}

	/**
	 * GoCardless Webhook listener.
	 *
	 * Verify webhook signature between the GoCardless and our website configuration and handle the various event
	 * if webhook verified and has some event in it.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @return  void
	 * @throws Exception     Throws an GoCardless error message.
	 */
	public function give_listen_for_gocardless_webhook() {

		if ( isset( $_GET['give-listener'] ) && 'gocardless' === $_GET['give-listener'] ) {

			// Get GoCardless webhook secret key.
			$webhook_secret = give_get_gocardless_setting( 'gocardless_webhook_secret', '' );

			// Get the data from webhook request.
			$raw_payload = file_get_contents( 'php://input' );
			$signature   = ! empty( $_SERVER['HTTP_WEBHOOK_SIGNATURE'] ) ? $_SERVER['HTTP_WEBHOOK_SIGNATURE'] : '';

			// Generating web hook signature.
			$calc_signature = hash_hmac( 'sha256', $raw_payload, $webhook_secret );

			try {

				// Verifying webhook signature.
				if ( $signature !== $calc_signature ) {
					header( 'HTTP/1.1 498 Invalid signature' );
					throw new Exception( __( 'Invalid signature.', 'give-gocardless' ) );
				}

				$payload = json_decode( $raw_payload, true );
				if ( empty( $payload['events'] ) ) {
					header( 'HTTP/1.1 400 Bad request' );
					throw new Exception( __( 'Missing events in payload.', 'give-gocardless' ) );
				}

				$this->webhook_process_payload( $payload );

			} catch ( Exception $e ) {

				give_record_gateway_error( __( 'GoCardless Error', 'give-gocardless' ), esc_html( $e->getMessage() ) );
				wp_send_json_error(
					array(
						'message' => $e->getMessage(),
					)
				);
			}
			exit;
		}

	}

	/**
	 * GoCardless handle webhook request.
	 *
	 * @since   1.0.0
	 * @access  protected
	 *
	 * @param   array $payload GoCardless payload data.
	 */
	protected function webhook_process_payload( $payload ) {

		// Must have events key
		if ( ! isset( $payload['events'] ) ) {
			return;
		}

		foreach ( $payload['events'] as $event ) {

			switch ( $event['resource_type'] ) {
				case 'payments':
					$this->webhook_payment_process( $event );
					break;
				case 'refunds':
					$this->webhook_refund_process( $event );
					break;
				case 'mandates':
					$this->webhook_process_mandates( $event );
					break;
				case 'subscriptions':
					// Check if Give Recurring class is exists or not.
					if ( class_exists( 'Give_Recurring' ) ) {
						if ( in_array( 'gocardless', array_keys( Give_Recurring::$gateways ) ) ) {

							// Get the instance of the GoCardless recurring class.
							$gocardless_recurring = new Give_GoCardless_Recurring();
							// Handle webhook for recurring.
							$gocardless_recurring->recurring_process_webhooks();
						}
					}
					break;
				default:
					echo sprintf( __( '%1$s - Unhandled webhook event %2$s', 'give-gocardless' ), __METHOD__, $event['resource_type'] );
			}
		}
	}

	/**
	 * Manage the mandate webhook request from GoCardless.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param array $event webhook response.
	 *
	 * @return bool
	 */
	public function webhook_process_mandates( $event ) {

		// Return, if action blank.
		if ( ! isset( $event['action'] ) ) {
			return false;
		}

		// Get payment post through resource event and key.
		$donation_payment = $this->get_payment_from_resoureces( 'mandate', 'id', $event['links']['mandate'] );

		if ( ! isset( $donation_payment->ID ) ) {
			return false;
		}

		// Get the payment id.
		$payment_id = $donation_payment->ID;

		// Insert description with the payment id.
		give_insert_payment_note( $payment_id, $event['details']['description'] );

	}

	/**
	 * Process payment event from webhook request from GoCardless.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $event Get GoCardless webhook request type.
	 *
	 * @return  bool
	 */
	public function webhook_payment_process( $event ) {

		// Request must not be subscription.
		if ( isset( $event['links']['subscription'] ) ) {
			return false;
		}

		// Get payment post through resource event and key.
		$donation_payment = $this->get_payment_from_resoureces( 'payment', 'id', $event['links']['payment'] );

		// Return false, if there is no such posts.
		if ( ! isset( $donation_payment->ID ) ) {
			return false;
		}

		// Get payment ID.
		$payment_id = $donation_payment->ID;

		// Retrieve payment's gateway method.
		$payment_gateway = give_get_payment_gateway( $payment_id );

		// If payment gateway is not correct.
		if ( GIVE_GOCARDLESS_GATEWAY_SLUG !== $payment_gateway ) {
			return false;
		}

		$payment_new_status = '';

		// Handle webhook action.
		switch ( $event['action'] ) {
			case 'paid_out':
			case 'confirmed':
				$payment_new_status = 'publish';
				break;
			case 'failed':
				$payment_new_status = 'failed';
				break;
			case 'cancelled':
				$payment_new_status = 'cancelled';
				break;
			case 'charged_back':
				$payment_new_status = 'refunded';
				break;
			case 'created':
				$payment_new_status = 'processing';
				break;
		}

		// Change the payment status and add note.
		$this->payment_complete_with_note( $payment_id, $payment_new_status, $event['links']['payment'], $event['details']['description'] );

		// Get payment through GoCardless API.
		$payment = Give_GoCardless_API::get_payment( $event['links']['payment'] );

		// Update payment meta data if everything is okay.
		if ( ! is_wp_error( $payment ) && ! empty( $payment['payments'] ) ) {
			self::update_payment_resource( $payment_id, 'payment', $payment['payments'] );
		}

		// Add latest webhook event to payment post.
		return give_update_payment_meta( $payment_id, '_give_gocardless_webhook_events', $event, false );
	}

	/**
	 * Change Payment note and status according to received webhook request.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   int    $payment_id     Donation Payment ID.
	 * @param   string $payment_status Payment Status.
	 * @param   string $txn_id         GoCardless  Transaction ID.
	 * @param   string $reason         Reason behind the action.
	 *
	 * @return void
	 */
	public function payment_complete_with_note( $payment_id, $payment_status, $txn_id, $reason ) {

		// GoCardless available status.
		$available_status = array( 'publish', 'failed', 'cancelled', 'refunded', 'processing' );

		if ( in_array( $payment_status, $available_status ) ) {

			give_insert_payment_note( $payment_id, sprintf( __( 'GoCardless Payment ID: %1$s - %2$s', 'give-gocardless' ), $txn_id, $reason ) );
			give_update_payment_status( $payment_id, $payment_status );
			give_set_payment_transaction_id( $payment_id, $txn_id );
		}

	}

	/**
	 * Get GoCardless resources data by payment id and resource type.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   int    $payment_id    Donation payment ID.
	 * @param   string $resource_type GoCardless resource type.
	 * @param   null   $key           GoCardless resources's key if exists.
	 *
	 * @return string|array
	 */
	public static function get_payment_resource( $payment_id, $resource_type, $key = null ) {
		if ( is_null( $key ) ) {
			$meta_key = sprintf( '_gocardless_%s', $resource_type );
		} else {
			$meta_key = sprintf( '_gocardless_%s_%s', $resource_type, $key );
		}

		return give_get_meta( $payment_id, $meta_key, true );
	}

	/**
	 * Get donation payment from give resources.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   string $resource_type   GoCardless resource type ('payment', 'refund' etc)
	 *                                  in singular noun. Mandate is excluded because
	 *                                  one mandate can be used in more than one order.
	 * @param   string $key             Meta Key in resource array (e.g. 'id', 'status', etc).
	 * @param   string $value           Value of a given resource key.
	 *
	 * @return  bool|object If everything is valid then return payment data object otherwise return false.
	 */
	public function get_payment_from_resoureces( $resource_type, $key, $value ) {

		global $wpdb;

		$meta_key = sprintf( '_gocardless_%s_%s', $resource_type, $key );

		$payment_id = $wpdb->get_var( $wpdb->prepare( "SELECT donation_id FROM {$wpdb->donationmeta} WHERE meta_key = %s AND meta_value = %s", $meta_key, $value ) );

		if ( ! $payment_id ) {
			return false;
		}

		// Get payment post data by payment id.
		$payment_data = give_get_payment_by( 'id', $payment_id );

		if ( ! $payment_data ) {
			return false;
		}

		return $payment_data;
	}

	/**
	 * Get success donation page url.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   int $payment_id Donation payment id.
	 *
	 * @return  string get give donation url with some query string.
	 */
	protected static function get_success_page( $payment_id ) {

		$success_redirect = add_query_arg(
			array(
				'payment_id'              => $payment_id,
				'gocardless_request_type' => 'redirect_flow',
			), get_permalink( give_get_option( 'success_page' ) )
		);

		return $success_redirect;
	}

	/**
	 * GoCardless Payment handler.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @throws Exception     Throws an exception if the request type is not correct.
	 */
	public function payment_handler() {

		if ( isset( $_GET['gocardless_request_type'] ) ) {

			try {
				if ( empty( $_GET['gocardless_request_type'] ) ) {
					throw new Exception( __( 'Missing request type.', 'give-gocardless' ) );
				}

				switch ( $_GET['gocardless_request_type'] ) {
					case 'redirect_flow':
						$this->handle_gocardless_payment();
						break;
					default:
						throw new Exception( __( 'Unknown request type.', 'give-gocardless' ) );
						break;
				}
			} catch ( Exception $e ) {
				header( 'HTTP/1.1 400 Bad request' );
				// Record the error into givewp.
				give_record_gateway_error( __( 'Missing Request type', 'give-gocardless' ), esc_html( $e->getMessage() ) );
				wp_send_json_error(
					array(
						'message' => $e->getMessage(),
					)
				);
			}
		}
	}

	/**
	 * Create a new payment.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $payment_data Donation payment data.
	 *
	 * @return  int     Get payment ID.
	 */
	public static function gocardless_create_payment( $payment_data ) {

		$form_id  = intval( $payment_data['post_data']['give-form-id'] );
		$price_id = isset( $payment_data['post_data']['give-price-id'] ) ? $payment_data['post_data']['give-price-id'] : '';

		// Collect payment data.
		$insert_payment_data = array(
			'price'           => $payment_data['price'],
			'give_form_title' => $payment_data['post_data']['give-form-title'],
			'give_form_id'    => $form_id,
			'give_price_id'   => $price_id,
			'date'            => $payment_data['date'],
			'user_email'      => $payment_data['user_email'],
			'purchase_key'    => $payment_data['purchase_key'],
			'currency'        => give_get_currency(),
			'user_info'       => $payment_data['user_info'],
			'status'          => 'pending',
			'gateway'         => GIVE_GOCARDLESS_GATEWAY_SLUG,
		);

		// Record the pending payment.
		return give_insert_payment( $insert_payment_data );
	}

	/**
	 * Handle redirect flow.
	 *
	 * @since   1.0.0
	 * @access  protected
	 *
	 * @return  bool
	 * @throws Exception     Throws an exception while handling payment.
	 */
	protected function handle_gocardless_payment() {

		try {
			if ( empty( $_GET['redirect_flow_id'] ) || empty( $_GET['payment_id'] ) ) {
				throw new Exception( __( 'Invalid redirect flow request.', 'give-gocardless' ) );
			}
			$order_id         = absint( $_GET['payment_id'] );
			$redirect_flow_id = $_GET['redirect_flow_id'];

			$redirect_flow = $this->maybe_complete_redirect_flow( $order_id, $redirect_flow_id );

			if ( ! $redirect_flow ) {
				return false;
			}

			// Get mandate id from redirect flow response.
			$mandate_id = $redirect_flow['links']['mandate'];

			// Create payment on GoCardless through order_id and mandate_id.
			$this->_maybe_create_payment( $order_id, $mandate_id );

			// Redirect to give success page.
			give_send_to_success_page();

		} catch ( Exception $e ) {

			give_record_gateway_error( __( 'Payment Error:', 'give-gocardless' ), esc_html( $e->getMessage() ) );
			wp_send_json_error(
				array(
					'message' => $e->getMessage(),
				)
			);
			exit;
		}
	}

	/**
	 * Create payment on GoCardless through payment_id and mandate_id.
	 *
	 * @since   1.0.0
	 * @access  protected
	 *
	 * @param   int    $payment_id Donation payment id.
	 * @param   string $mandate_id Mandate ID.
	 * @param   null   $amount     Pass amount if available, otherwise null.
	 *
	 * @throws Exception     Throws an exception if the field is invalid.
	 */
	protected function _maybe_create_payment( $payment_id, $mandate_id, $amount = null ) {

		// Get payment post.
		$payment_post = get_post( $payment_id );

		if ( ! $payment_post ) {
			throw new Exception( __( 'Invalid Donation.', 'give-gocardless' ) );
		}

		if ( ! $amount ) {
			$amount = give_get_meta( $payment_id, '_give_payment_total', true );
		}

		$amount = intval( $amount * 100 );

		$payment_params = array(
			'amount'      => $amount,
			'description' => gocardless_get_payment_description( $payment_id ),
			'currency'    => give_get_payment_currency_code( $payment_id ),
			'links'       => array(
				'mandate' => $mandate_id,
			),
			'metadata'    => array(
				'order_id' => (string) $payment_id,
			),
		);

		$payment = Give_GoCardless_API::create_payment( $payment_params );

		/** @var WP_Error|$payment Get the wp error. */
		if ( is_wp_error( $payment ) ) {
			throw new Exception( $payment->get_error_message() );
		}

		if ( empty( $payment['payments']['id'] ) ) {
			throw new Exception( __( 'Unexpected payment response from GoCardless', 'give-gocardless' ) );
		}

		// Set the payment transaction ID.
		give_set_payment_transaction_id( $payment_id, $payment['payments']['id'] );

		// Store payment data in respective payment id.
		self::update_payment_resource( $payment_id, 'payment', $payment['payments'] );
	}

	/**
	 * Complete Redirect flow.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   int $payment_id       Donation payment id.
	 * @param   int $redirect_flow_id Redirect flow id.
	 *
	 * @return mixed         Redirect flow response or exception is thrown.
	 * @throws Exception     Throws an exception if the field is invalid.
	 */
	public function maybe_complete_redirect_flow( $payment_id, $redirect_flow_id ) {

		// Return false if payment_id or redirect flow id is missing.
		if ( ! isset( $payment_id ) || ! isset( $redirect_flow_id ) ) {
			return false;
		}

		// Get the payment resources.
		$payment_resources = self::get_payment_resource( $payment_id, 'redirect_flow' );

		// If Session token is empty then through error message.
		if ( empty( $payment_resources['session_token'] ) ) {
			throw new Exception( __( 'Order does not have redirect flow session token.', 'give-gocardless' ) );
		}

		// If redirect_flow id in meta and in query string is not matched then.
		if ( $redirect_flow_id !== $payment_resources['id'] ) {
			throw new Exception( __( 'Invalid redirect flow ID.', 'give-gocardless' ) );
		}

		/** @var WP_Error|$redirect_response Get error if there is any. */
		$redirect_response = Give_GoCardless_API::complete_redirect_flow(
			$redirect_flow_id, array(
				'session_token' => $payment_resources['session_token'],
			)
		);

		// Throw error message if redirect response has any error.
		if ( is_wp_error( $redirect_response ) ) {
			throw new Exception( sprintf( __( 'Unable to complete redirect flow: %s.', 'give-gocardless' ), $redirect_response->get_error_message() ) );
		}

		// Throw error message if Mandate is missing.
		if ( empty( $redirect_response['redirect_flows']['links']['mandate'] ) ) {
			throw new Exception( __( 'Mandate is missing from redirect flow response.', 'give-gocardless' ) );
		}

		self::update_payment_resource( $payment_id, 'redirect_flow', $redirect_response['redirect_flows'] );

		$mandate_id = $redirect_response['redirect_flows']['links']['mandate'];

		// Get mandate data from GoCardless.
		$mandate = Give_GoCardless_API::get_mandate( $mandate_id );

		if ( is_wp_error( $mandate ) ) {
			throw new Exception( __( 'Failed to retrieve mandate.', 'give-gocardless' ) );
		}

		// Update mandate data.
		self::update_payment_resource( $payment_id, 'mandate', $mandate['mandates'] );

		if ( isset( $redirect_response['redirect_flows'] ) ) {
			// Return response got from GoCardless.
			return $redirect_response['redirect_flows'];
		} else {
			// Otherwise, return false.
			return false;
		}
	}

}
