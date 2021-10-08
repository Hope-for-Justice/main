<?php
/**
 * Give Recurring - Stripe ACH ( Stripe + Plaid ) Gateway
 *
 * @package   Give
 * @copyright Copyright (c) 2016, GiveWP
 * @license   https://opensource.org/licenses/gpl-license GNU Public License
 * @since     1.6
 */

use Give\ValueObjects\Money;
use GiveRecurring\Infrastructure\Log;
use GiveRecurring\PaymentGateways\DataTransferObjects\SubscriptionDto;
use GiveRecurring\PaymentGateways\Stripe\Actions\RetrieveOrCreatePlan;
use GiveRecurring\PaymentGateways\Stripe\Actions\UpdateSubscriptionAmount;
use Stripe\Subscription;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $give_recurring_stripe_ach;

/**
 * Class Give_Recurring_Stripe_ACH
 *
 * @since 1.6
 */
class Give_Recurring_Stripe_ACH extends Give_Recurring_Gateway {
	/**
	 * Array of API keys.
	 *
	 * @since  1.6
	 * @access private
	 *
	 * @var array
	 */
	private $keys = array();

	/**
	 * Initialize.
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return bool
	 */
	public function init() {

		// Set ID for Recurring.
		$this->id = 'stripe_ach';

		// Bailout, if gateway is not active.
		if ( ! give_is_gateway_active( $this->id ) ) {
			return;
		}

		// Set Plaid Credentials.
		$this->keys = array(
			'client_id'  => trim( give_get_option( 'plaid_client_id' ) ),
			'secret_key' => trim( give_get_option( 'plaid_secret_key' ) ),
			'public_key' => trim( give_get_option( 'plaid_public_key' ) ),
		);

		// Process Recurring Checkout.
		add_action( 'give_recurring_process_checkout', array( $this, 'process_recurring_checkout' ) );

		// Process Refund.
		add_action( 'give_pre_refunded_payment', array( $this, 'process_refund' ) );

		// Cancel Subscription.
		add_action( 'give_recurring_cancel_stripe_ach_subscription', array( $this, 'cancel' ), 10, 2 );

	}

	/**
	 * Cancels a Stripe ACH Subscription.
	 *
	 * @param  Give_Subscription $subscription
	 * @param  bool              $valid
	 *
	 * @since  1.9.10
	 * @access public
	 *
	 * @return bool
	 */
	public function cancel( $subscription, $valid ) {

		if ( empty( $valid ) ) {
			return false;
		}

		try {

			// Get the Stripe customer ID.
			$stripe_customer_id = $this->get_stripe_recurring_customer_id( $subscription->donor->email );

			// Must have a Stripe customer ID.
			if ( ! empty( $stripe_customer_id ) ) {

				$subscription = Subscription::retrieve( $subscription->profile_id );
				$subscription->cancel();

				return true;
			}

			return false;

		} catch ( \Stripe\Error\Base $e ) {

			// There was an issue cancelling the subscription w/ Stripe :(
			give_record_gateway_error( __( 'Stripe Error', 'give-recurring' ), sprintf( __( 'The Stripe Gateway returned an error while cancelling a subscription. Details: %s', 'give-recurring' ), $e->getMessage() ) );
			give_set_error( 'Stripe Error', __( 'An error occurred while cancelling the donation. Please try again.', 'give-recurring' ) );

			return false;

		} catch ( Exception $e ) {

			// Something went wrong outside of Stripe.
			give_record_gateway_error( __( 'Stripe Error', 'give-recurring' ), sprintf( __( 'The Stripe Gateway returned an error while cancelling a subscription. Details: %s', 'give-recurring' ), $e->getMessage() ) );
			give_set_error( 'Stripe Error', __( 'An error occurred while cancelling the donation. Please try again.', 'give-recurring' ) );

			return false;

		}

	}

	/**
	 * Can update subscription details.
	 *
	 * @since 1.8
	 *
	 * @param bool   $ret
	 * @param object $subscription
	 *
	 * @return bool
	 */
	public function can_update( $ret, $subscription ) {

		if (
			'stripe_ach' === $subscription->gateway
			&& ! empty( $subscription->profile_id )
			&& in_array( $subscription->status, array(
				'active',
				'failing'
			), true )
		) {
			return true;
		}

		return $ret;
	}

	/**
	 * @since 1.12.6
	 *
	 * @param bool $ret
	 * @param Give_Subscription $subscription
	 *
	 * @return bool
	 */
	public function can_update_subscription( $ret, $subscription ) {
		return $this->can_update( $ret, $subscription );
	}

	/**
	 * Can Cancel.
	 *
	 * @param bool $canCancel The value being filtered.
	 * @param $subscription
	 *
	 * @access public
	 *
	 * @since  1.9.10
	 * @since 1.12.2 Return the original filtered value if no change so that failing subscriptions can be canceled.
	 *
	 * @return bool
	 */
	public function can_cancel( $canCancel, $subscription ) {
		if( $subscription->gateway === $this->id ) {
			$canCancel = give_recurring_stripe_can_cancel( $canCancel, $subscription );
		}
		return $canCancel;
	}

	/**
	 * Process Stripe + Plaid Recurring Checkout.
	 *
	 * @param array $donation_data Donation Data.
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return bool
	 */
	public function process_recurring_checkout( $donation_data ) {

		// Bailout, if gateway is not active.
		if ( $this->id !== $donation_data['gateway'] ) {
			return false;
		}

		$stripe_ach_token      = $donation_data['post_data']['give_stripe_ach_token'];
		$stripe_ach_account_id = $donation_data['post_data']['give_stripe_ach_account_id'];

		// Sanity check: must have Plaid token and account id.
		if ( ! isset( $stripe_ach_token ) || empty( $stripe_ach_token ) ) {

			give_record_gateway_error( __( 'Missing Stripe Token', 'give-recurring' ), __( 'The Stripe ACH gateway failed to generate the Plaid token.', 'give-recurring' ) );
			give_send_back_to_checkout( '?payment-mode=stripe_ach' );

		} elseif ( ! isset( $stripe_ach_account_id ) || empty( $stripe_ach_account_id ) ) {

			give_record_gateway_error( __( 'Missing Stripe Account ID', 'give-recurring' ), __( 'The Stripe ACH gateway failed to generate the Plaid account ID.', 'give-recurring' ) );
			give_send_back_to_checkout( '?payment-mode=stripe_ach' );

		}

		$request = wp_remote_post( give_stripe_ach_get_endpoint_url( 'exchange' ), array(
			'body' => json_encode( array(
				'client_id'    => $this->keys['client_id'],
				'secret'       => $this->keys['secret_key'],
				'public_token' => $stripe_ach_token,
			) ),
			'headers' => array(
				'Content-Type' => 'application/json;charset=UTF-8',
			),
		) );

		// Error check.
		if ( is_wp_error( $request ) ) {

			give_record_gateway_error( __( 'Missing Stripe Token', 'give-recurring' ), sprintf( __( 'The Stripe ACH gateway failed to make the call to the Plaid server to get the Stripe bank account token along with the Plaid access token that can be used for other Plaid API requests. Details: %s', 'give-recurring' ), $request->get_error_message() ) );
			give_set_error( 'stripe_ach_request_error', __( 'There was a problem communicating with the payment gateway. Please try again.', 'give-recurring' ) );
			give_send_back_to_checkout( '?payment-mode=stripe_ach' );

			return false;
		}

		// Decode response.
		$response = json_decode( wp_remote_retrieve_body( $request ) );

		$request = wp_remote_post( give_stripe_ach_get_endpoint_url( 'bank_account' ), array(
			'body' => json_encode( array(
				'client_id'    => $this->keys['client_id'],
				'secret'       => $this->keys['secret_key'],
				'access_token' => $response->access_token,
				'account_id'   => $stripe_ach_account_id,
			) ),
			'headers' => array(
				'Content-Type' => 'application/json;charset=UTF-8',
			),
		) );

		$response = json_decode( wp_remote_retrieve_body( $request ) );

		// Is there an error returned from the API?
		if ( isset( $response->error_code ) ) {
			Log::error(
				esc_html__( 'Plaid API Error', 'give-recurring' ),
				[
					'category' => 'Plaid Subscription',
					'Error Message' => sprintf(
						__( 'An error occurred when processing a donation via Plaid\'s API. Details: %s', 'give-recurring' ),
						"$response->error_code (error code) - $response->error_type (error type) - $response->error_message"
					),
					'Stripe Response' => $response
				]
			);
			give_set_error( 'stripe_ach_request_error', __( 'There was an API error received from the payment gateway. Please try again.', 'give-recurring' ) );
			give_send_back_to_checkout( '?payment-mode=stripe_ach' );

			return false;
		}

		// Set Stripe + Plaid bank token to post variables.
		$_POST['give_stripe_payment_method'] = $response->stripe_bank_account_token;
	}

	/**
	 * Create Payment Profiles.
	 *
	 * Setup customers and plans in Stripe for the sign up.
	 *
	 * @since  1.6
	 * @since 1.12.6 Implement createOrRetrieveStripePlan function
	 *
	 * @access public
	 */
	public function create_payment_profiles() {

		// Check if Stripe payment method is defined. If not, log error and return.
		if ( ! empty( $_POST['give_stripe_payment_method'] ) ) {
			$source = give_clean( $_POST['give_stripe_payment_method'] );
		} else {
			Log::error(
				'Plaid API Error',
				[
					'category' => 'Plaid Subscription',
					'Description' => 'Required ACH Stripe payment method was not found in request.',
					'Data' => give_clean( $_POST )
				]
			);

			give_set_error(
				'stripe_ach_payment_method_empty_error',
				esc_html__( 'There was an API error received from the payment gateway. Please try again.', 'give-recurring' )
			);

			return false;
		}

		$email     = $this->purchase_data['user_email'];

		try {
			$currencyCode = give_get_currency( $this->subscriptions['form_id'] );
			$stripePlan = give( RetrieveOrCreatePlan::class )->handle( SubscriptionDto::fromArray(
				[
					'formId' => $this->subscriptions['form_id'],
					'priceId' => $this->subscriptions['price_id'],
					'recurringDonationAmount' => Money::of( $this->subscriptions['recurring_amount'], $currencyCode ),
					'period' => $this->subscriptions['period'],
					'frequency' => $this->subscriptions['frequency'],
					'currencyCode' => $currencyCode,
				]
			)  );

		} catch ( Exception $e ) {
			Log::error(
				'Stripe Error',
				[
					'Description' => $e->getMessage(),
					'Subscription Data' => $this->subscriptions
				]
			);
			give_set_error(
				'give_recurring_stripe_create_subscription',
				esc_html__( 'An error occurred while processing the donation. Please try again.', 'give-recurring' )
			);
			give_send_back_to_checkout( '?payment-mode=stripe' );
		}

		// Create a new customer or fetch the existing customer.
		$give_stripe_customer = new Give_Stripe_Customer( $email, $source );
		$stripe_customer      = $give_stripe_customer->customer_data;

		$this->subscribe_customer_to_plan( $stripe_customer, $source, $stripePlan->id );
	}

	/**
	 * Subscribes a Stripe Customer to a plan.
	 *
	 * @param  \Stripe\Customer $stripe_customer Customer ID.
	 * @param  string|array     $source          Source ID.
	 * @param  string           $plan_id         Plan ID.
	 *
	 * @return bool|Subscription
	 *@since 1.12.5 Add `default_payment_method` param to Stripe subscription cretation request
	 * @access public
	 *
	 * @since  1.6
	 */
	public function subscribe_customer_to_plan( $stripe_customer, $source, $plan_id ) {

		if ( $stripe_customer instanceof \Stripe\Customer ) {

			try {
				// Get metadata.
				$metadata = give_stripe_prepare_metadata( $this->payment_id, $this->purchase_data );

				// Set Application Information.
				give_stripe_set_app_info();

				$args                              = array(
					'plan'     => $plan_id,
					'metadata' => $metadata,
					'default_source' => $stripe_customer->default_source
				);
				$subscription                      = $stripe_customer->subscriptions->create( $args, give_stripe_get_connected_account_options() );
				$this->subscriptions['profile_id'] = $subscription->id;

				return $subscription;

			} catch ( \Stripe\Error\Base $e ) {

				// There was an issue subscribing the Stripe customer to a plan.
				$this->log_error( $e );

			} catch ( Exception $e ) {

				// Something went wrong outside of Stripe.
				give_record_gateway_error( __( 'Stripe Error', 'give-recurring' ), sprintf( __( 'An error while subscribing a customer to a plan. Details: %s', 'give-recurring' ), $e->getMessage() ) );
				give_set_error( 'Stripe Error', __( 'An error occurred while processing the donation. Please try again.', 'give-recurring' ) );
				give_send_back_to_checkout( '?payment-mode=stripe_ach' );

			}
		}// End if().

		return false;
	}

	/**
	 * Log a Stripe Error.
	 *
	 * Logs in the Give db the error and also displays the error message to the donor.
	 *
	 * @param \Stripe\Error\Base|\Stripe\Error\Card $exception    Exception Object.
	 * @param string                                $payment_mode Mode of Payment.
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return bool
	 */
	public function log_error( $exception, $payment_mode = 'stripe_ach' ) {

		$body = $exception->getJsonBody();
		$err  = $body['error'];

		$log_message = __( 'The Stripe payment gateway returned an error while processing the donation.', 'give-recurring' ) . '<br><br>';

		// Bad Request of some sort.
		if ( isset( $err['message'] ) ) {
			$log_message .= sprintf( __( 'Message: %s', 'give-recurring' ), $err['message'] ) . '<br><br>';
			if ( isset( $err['code'] ) ) {
				$log_message .= sprintf( __( 'Code: %s', 'give-recurring' ), $err['code'] );
			}

			give_set_error( 'stripe_request_error', $err['message'] );
		} else {
			give_set_error( 'stripe_request_error', __( 'The Stripe API request was invalid, please try again.', 'give-recurring' ) );
		}

		// Log it with DB
		give_record_gateway_error( __( 'Stripe Error', 'give-recurring' ), $log_message );
		give_send_back_to_checkout( '?payment-mode=' . $payment_mode );

		return false;

	}

	/**
	 * Gets a stripe plan if it exists otherwise creates a new one.
	 *
	 * @param  array  $subscription The subscription array set at process_checkout before creating payment profiles.
	 * @param  string $return       if value 'id' is passed it returns plan ID instead of Stripe_Plan.
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return string|\Stripe\Plan
	 */
	public function get_or_create_stripe_plan( $subscription, $return = 'id' ) {

		$stripe_plan_name = give_recurring_generate_subscription_name( $subscription['form_id'], $subscription['price_id'] );
		$stripe_plan_id   = $this->generate_stripe_plan_id( $stripe_plan_name, give_maybe_sanitize_amount( $subscription['recurring_amount'] ), $subscription['period'], $subscription['frequency'] );

		try {
			// Check if the plan exists already.
			$stripe_plan = \Stripe\Plan::retrieve( $stripe_plan_id );

		} catch ( Exception $e ) {

			// The plan does not exist, please create a new plan.
			$args = array(
				'amount'               => give_stripe_dollars_to_cents( $subscription['recurring_amount'] ),
				'interval'             => $subscription['period'],
				'interval_count'       => $subscription['frequency'],
				'currency'             => give_get_currency(),
				'id'                   => $stripe_plan_id,
			);

			// Create a Subscription Product Object and Pass plan parameters as per the latest version of stripe api.
			$args['product'] = \Stripe\Product::create( array(
				'name'                 => $stripe_plan_name,
				'statement_descriptor' => give_stripe_get_statement_descriptor( $subscription ),
				'type'                 => 'service',
			) );

			$stripe_plan = $this->create_stripe_plan( $args );

		}

		if ( 'id' == $return ) {
			return $stripe_plan->id;
		} else {
			return $stripe_plan;
		}

	}

	/**
	 * Is Subscription Completed?
	 *
	 * After a sub renewal comes in from Stripe we check to see if total_payments
	 * is greater than or equal to bill_times; if it is, we cancel the stripe sub for the customer.
	 *
	 * @param $subscription Give_Subscription
	 * @param $total_payments
	 * @param $bill_times
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return bool
	 */
	public function is_subscription_completed( $subscription, $total_payments, $bill_times ) {

		if ( $total_payments >= $bill_times && $bill_times != 0 ) {
			// Cancel subscription in stripe if the subscription has run its course.
			$this->cancel( $subscription, true );
			// Complete the subscription w/ the Give_Subscriptions class.
			$subscription->complete();

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Refund subscription charges and cancels the subscription if the parent donation.
	 * Triggered when refunding in wp-admin donation details.
	 *
	 * @param $payment Give_Payment
	 *
	 * @access public
	 * @since  1.6
	 *
	 * @return void
	 */
	public function process_refund( $payment ) {

		// Bailout.
		if ( empty( $_POST['give_refund_in_stripe'] ) ) {
			return;
		}

		$statuses = array( 'give_subscription', 'publish' );

		if ( ! in_array( $payment->old_status, $statuses ) ) {
			return;
		}

		if ( 'stripe' !== $payment->gateway ) {
			return;
		}

		switch ( $payment->old_status ) {

			case 'give_subscription' :

				// Refund renewal payment.
				if ( empty( $payment->transaction_id ) || $payment->transaction_id == $payment->ID ) {

					// No valid charge ID.
					return;
				}

				try {

					$refund = \Stripe\Refund::create( array(
						'charge' => $payment->transaction_id,
					) );

					$payment->add_note( sprintf( __( 'Charge %1$s refunded in Stripe. Refund ID: %1$s', 'give-recurring' ), $payment->transaction_id, $refund->id ) );

				} catch ( Exception $e ) {

					// some sort of other error.
					$body = $e->getJsonBody();
					$err  = $body['error'];

					if ( isset( $err['message'] ) ) {
						$error = $err['message'];
					} else {
						$error = __( 'Something went wrong while refunding the charge in Stripe.', 'give-recurring' );
					}

					wp_die( $error, __( 'Error', 'give-recurring' ), array(
						'response' => 400,
					) );

				}

				break;

			case 'publish' :

				// Refund & cancel initial subscription donation.
				$db   = new Give_Subscriptions_DB();
				$subs = $db->get_subscriptions( array(
					'parent_payment_id' => $payment->ID,
					'number' => 100,
				) );

				if ( empty( $subs ) ) {
					return;
				}

				foreach ( $subs as $subscription ) {

					try {

						$refund = \Stripe\Refund::create( array(
							'charge' => $subscription->transaction_id,
						) );

						$payment->add_note( sprintf( __( 'Charge %s refunded in Stripe.', 'give-recurring' ), $subscription->transaction_id ) );
						$payment->add_note( sprintf( __( 'Charge %1$s refunded in Stripe. Refund ID: %1$s', 'give-recurring' ), $subscription->transaction_id, $refund->id ) );

					} catch ( Exception $e ) {

						// some sort of other error.
						$body = $e->getJsonBody();
						$err  = $body['error'];

						if ( isset( $err['message'] ) ) {
							$error = $err['message'];
						} else {
							$error = __( 'Something went wrong while refunding the charge in Stripe.', 'give-recurring' );
						}

						$payment->add_note( sprintf( __( 'Charge %1$s could not be refunded in Stripe. Error: %1$s', 'give-recurring' ), $subscription->transaction_id, $error ) );

					}

					// Cancel subscription.
					$this->cancel( $subscription, true );
					$subscription->cancel();
					$payment->add_note( sprintf( __( 'Subscription %d cancelled.', 'give-recurring' ), $subscription->id ) );

				}

				break;

		}// End switch().

	}

	/**
	 * Generates a plan ID to be used with Stripe.
	 *
	 * @param  string $subscription_name Name of the subscription generated from
	 *                                   give_recurring_generate_subscription_name.
	 * @param  string $recurring_amount  Recurring amount specified in the form.
	 * @param  string $period            Can be either 'day', 'week', 'month' or 'year'. Set from form.
	 * @param  int    $frequency         Can be either 1,2,..6 Set from form.
	 *
	 * @return string
	 */
	public function generate_stripe_plan_id( $subscription_name, $recurring_amount, $period, $frequency ) {
		$subscription_name = sanitize_title( $subscription_name );

		return sanitize_key( $subscription_name . '_' . $recurring_amount . '_' . $period . '_' . $frequency );
	}

	/**
	 * Get transactions.
	 *
	 * @param Give_Subscription $subscription
	 * @param string            $date
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return array
	 */
	public function get_gateway_transactions( $subscription, $date = '' ) {

		$subscription_invoices = $this->get_invoices_for_give_subscription( $subscription, $date = '' );
		$transactions          = array();

		foreach ( $subscription_invoices as $invoice ) {

			$transactions[] = array(
				'amount'         => give_stripe_cents_to_dollars( $invoice->amount_due ),
				'date'           => $invoice->created,
				'transaction_id' => $invoice->charge,
			);
		}

		return $transactions;
	}

    /**
     * Creates a Stripe Plan using the API.
     *
     * @param  array $args
     * @access private
     *
     * @return bool|\Stripe\Plan
     */
    private function create_stripe_plan( $args = array() ) {

        try {
            return \Stripe\Plan::create( $args );
        } catch ( \Stripe\Error\Base $e ) {

            // There was an issue creating the Stripe plan.
            Give_Stripe_Logger::log_error( $e, $this->id );
        } catch ( Exception $e ) {

            // Something went wrong outside of Stripe.
            give_record_gateway_error( __( 'Stripe Error', 'give-recurring' ), sprintf( __( 'The Stripe Gateway returned an error while creating a plan. Details: %s', 'give-recurring' ), $e->getMessage() ) );
            give_set_error( 'Stripe Error', __( 'An error occurred while processing the donation. Please try again.', 'give-recurring' ) );
            give_send_back_to_checkout( '?payment-mode=stripe' );
        }

        return false;
    }

	/**
	 * Get invoices for a Give subscription.
	 *
	 * @param Give_Subscription $subscription
	 * @param string            $date
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return array
	 */
	private function get_invoices_for_give_subscription( $subscription, $date = '' ) {
		$subscription_invoices = array();

		if ( $subscription instanceof Give_Subscription ) {

			$stripe_subscription_id = $subscription->profile_id;

			/**
			 * Customer ID is also saved in the give_donationmeta table when a donation is made with Stripe PG.
			 * We have to check if the customer ID is in the give_donationmeta table because if multiple Stripe accounts are connected,
			 * the same donor will have a different customer ID for each connected account.
			 */
			$stripe_customer_id = Give()->payment_meta->get_meta( $subscription->parent_payment_id, '_give_stripe_customer_id', true );

			if ( ! $stripe_customer_id ) {
				$stripe_customer_id = $this->get_stripe_recurring_customer_id( $subscription->donor->email );
			}

			$subscription_invoices  = $this->get_invoices_for_subscription( $stripe_customer_id, $stripe_subscription_id, $date );
		}

		return $subscription_invoices;
	}

	/**
	 * Get invoices for subscription.
	 *
	 * @param string $stripe_customer_id     Customer ID.
	 * @param string $stripe_subscription_id Subscription ID.
	 * @param        $date
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return array
	 */
	public function get_invoices_for_subscription( $stripe_customer_id, $stripe_subscription_id, $date ) {
		$subscription_invoices = array();
		$invoices              = $this->get_invoices_for_customer( $stripe_customer_id, $date );

		foreach ( $invoices as $invoice ) {
			if ( $invoice->subscription == $stripe_subscription_id ) {
				$subscription_invoices[] = $invoice;
			}
		}

		return $subscription_invoices;
	}

	/**
	 * Get invoices for Stripe customer.
	 *
	 * @param string $stripe_customer_id Customer ID.
	 * @param string $date
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return array|bool
	 */
	private function get_invoices_for_customer( $stripe_customer_id = '', $date = '' ) {
		$args     = array(
			'limit' => 100,
			'status' => 'paid'
		);
		$has_more = true;
		$invoices = array();

		if ( ! empty( $date ) ) {
			$date_timestamp = strtotime( $date );
			$args['date']   = array(
				'gte' => $date_timestamp,
			);
		}

		if ( ! empty( $stripe_customer_id ) ) {
			$args['customer'] = $stripe_customer_id;
		}

		while ( $has_more ) {
			try {
				$collection             = \Stripe\Invoice::all( $args );
				$invoices               = array_merge( $invoices, $collection->data );
				$has_more               = $collection->has_more;
				$last_obj               = end( $invoices );
				$args['starting_after'] = $last_obj->id;

			} catch ( \Stripe\Error\Base $e ) {

				$this->log_error( $e );

				return false;

			} catch ( Exception $e ) {

				// Something went wrong outside of Stripe.
				give_record_gateway_error( __( 'Stripe Error', 'give-recurring' ), sprintf( __( 'The Stripe Gateway returned an error while getting invoices a Stripe customer. Details: %s', 'give-recurring' ), $e->getMessage() ) );

				return false;

			}
		}

		return $invoices;
	}

	/**
	 * Stripe Recurring Customer ID.
	 *
	 * The Give Stripe gateway stores it's own customer_id so this method first checks for that, if it exists.
	 * If it does it will return that value. If it does not it will return the recurring gateway value.
	 *
	 * @param string $user_email Customer Email.
	 *
	 * @since  1.6
	 * @access public
	 *
	 * @return string The donor's Stripe customer ID.
	 */
	public function get_stripe_recurring_customer_id( $user_email ) {

		// First check user meta to see if they have made a previous donation
		// w/ Stripe via non-recurring donation so we don't create a duplicate Stripe customer for recurring.
		$customer_id = give_stripe_get_customer_id( $user_email );

		// If no data found check the subscribers profile to see if there's a recurring ID already.
		if ( empty( $customer_id ) ) {

			$subscriber = new Give_Recurring_Subscriber( $user_email );

			$customer_id = $subscriber->get_recurring_donor_id( $this->id );
		}

		return $customer_id;

	}

	/**
	 * @inheritdoc
	 *
	 * @since 1.12.6 implement updateSubscriptionAmountOnStripe function
	 */
	public function update_subscription( $subscriber, $subscription, $data = null ) {
		if ( $data === null ) {
			$data = give_clean( $_POST ); // WPCS: input var ok, sanitization ok, CSRF ok.
		}
		$renewalAmount = $this->getNewRenewalAmount( $data );

		if ( give_get_errors() ) {
			return;
		}

		try{
			give( UpdateSubscriptionAmount::class )->handle( $subscription, $renewalAmount  );
		} catch ( Exception $e ) {
			give_set_error(
				'give_recurring_stripe_update_subscription',
				esc_html__(
					'The Stripe gateway returned an error while updating the subscription.',
					'give-recurring'
				)
			);

			Log::error(
				'Stripe Subscription Update Error',
				[
					'Description' => $e->getMessage(),
					'Subscription Data' => $subscription,
					'Renewal Amount' => $renewalAmount,
					'Subscriber' => $subscriber
				]
			);
		}
	}

	/**
	 * Can Sync.
	 *
	 * @param bool              $ret          Default Value.
	 * @param Give_Subscription $subscription Subscription Object.
	 *
	 * @since  1.8.11
	 * @access public
	 *
	 * @return bool
	 */
	public function can_sync( $ret, $subscription ) {

		if (
			$subscription->gateway === $this->id
			&& ! empty( $subscription->profile_id )
		) {
			$ret = true;
		}

		return $ret;
	}

	/**
	 * Link the recurring profile in Stripe.
	 *
	 * @since  1.8.11
	 * @access public
	 *
	 * @param  string $profile_id   The recurring profile id.
	 * @param  object $subscription The Subscription object.
	 *
	 * @return string               The link to return or just the profile id.
	 */
	public function link_profile_id( $profile_id, $subscription ) {

		if ( ! empty( $profile_id ) ) {
			$payment    = new Give_Payment( $subscription->parent_payment_id );
			$html       = '<a href="%s" target="_blank">' . $profile_id . '</a>';
			$base_url   = 'live' === $payment->mode ? 'https://dashboard.stripe.com/' : 'https://dashboard.stripe.com/test/';
			$link       = esc_url( $base_url . 'subscriptions/' . $profile_id );
			$profile_id = sprintf( $html, $link );
		}

		return $profile_id;

	}

	/**
	 * Get subscription details.
	 *
	 * @since  1.8.11
	 * @access public
	 *
	 * @param Give_Subscription $subscription
	 *
	 * @return array|bool
	 */
	public function get_subscription_details( $subscription ) {

		$stripe_subscription = $this->get_gateway_subscription( $subscription );
		if ( false !== $stripe_subscription ) {

			$subscription_details = array(
				'status'         => $stripe_subscription->status,
				'created'        => $stripe_subscription->created,
				'billing_period' => $stripe_subscription->plan->interval,
				'frequency'      => $stripe_subscription->plan->interval_count,
			);

			return $subscription_details;
		}

		return false;
	}

	/**
	 * Get gateway subscription.
	 *
	 * @param $subscription
	 *
	 * @since  1.8.11
	 * @access public
	 *
	 * @return bool|mixed
	 */
	public function get_gateway_subscription( $subscription ) {

		if ( $subscription instanceof Give_Subscription ) {

			$stripe_subscription_id = $subscription->profile_id;

			$stripe_subscription = $this->get_stripe_subscription( $stripe_subscription_id );

			return $stripe_subscription;
		}

		return false;
	}

	/**
	 * Get Stripe Subscription.
	 *
	 * @param $stripe_subscription_id
	 *
	 * @since  1.8.11
	 * @access public
	 *
	 * @return mixed
	 */
	public function get_stripe_subscription( $stripe_subscription_id ) {

		$stripe_subscription = Subscription::retrieve( $stripe_subscription_id );

		return $stripe_subscription;

	}

}

$give_recurring_stripe_ach = new Give_Recurring_Stripe_ACH();
