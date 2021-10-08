<?php
/**
 * Give Recurring - Add support for Stripe Checkout
 *
 * @package    Give-Recurring
 * @subpackage Stripe
 * @copyright  Copyright (c) 2019, GiveWP
 * @license    https://opensource.org/licenses/gpl-license GNU Public License
 */

use Give\ValueObjects\Money;
use GiveRecurring\Infrastructure\Log;
use GiveRecurring\PaymentGateways\DataTransferObjects\SubscriptionDto;
use GiveRecurring\PaymentGateways\Stripe\Actions\RetrieveOrCreatePlan;
use GiveRecurring\PaymentGateways\Stripe\Actions\UpdateSubscriptionAmount;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Give_Recurring_Stripe_Checkout
 *
 * @since 1.9.4
 */
class Give_Recurring_Stripe_Checkout extends Give_Recurring_Gateway {
	/**
	 * Invoice object for Stripe.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @var Give_Stripe_Invoice
	 */
	public $invoice;

	/**
	 * Payment Intent Object for Stripe.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @var Give_Stripe_Payment_Intent
	 */
	public $payment_intent;

	/**
	 * Stripe Gateway Object for Stripe.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @var Give_Stripe_Gateway
	 */
	public $stripe_gateway;

	/**
	 * Checkout Session of Stripe.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @var Give_Stripe_Checkout_Session
	 */
	public $stripe_checkout_session;

	/**
	 * Get Stripe Started.
	 *
	 * @since 1.9.4
	 *
	 * @return void
	 */
	public function init() {

		$this->id = 'stripe_checkout';

		if (
			defined( 'GIVE_STRIPE_VERSION' ) &&
			version_compare( GIVE_STRIPE_VERSION, '2.2.1', '<' )
		) {
			add_action( 'admin_notices', array( $this, 'old_api_upgrade_notice' ) );

			// No Stripe SDK. Bounce.
			return;
		}

		// Bailout, if gateway is not active.
		if ( ! give_is_gateway_active( $this->id ) ) {
			return;
		}

		$this->offsite                 = 'redirect' === give_stripe_get_checkout_type();
		$this->stripe_gateway          = new Give_Stripe_Gateway();
		$this->invoice                 = new Give_Stripe_Invoice();
		$this->payment_intent          = new Give_Stripe_Payment_Intent();
		$this->stripe_checkout_session = new Give_Stripe_Checkout_Session();

		add_action( 'give_pre_refunded_payment', array( $this, 'process_refund' ) );
		add_action( 'give_recurring_cancel_stripe_checkout_subscription', array( $this, 'cancel' ), 10, 2 );
	}

	/**
	 * Upgrade notice.
	 *
	 * Tells the admin that they need to upgrade the Stripe gateway.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @return void
	 */
	public function old_api_upgrade_notice() {

		$message = sprintf(
			/* translators: 1. GiveWP account login page, 2. GiveWP Account downloads page */
			__( '<strong>Attention:</strong> The Recurring Donations plugin requires the latest version of the Stripe gateway add-on to process donations properly. Please update to the latest version of Stripe to resolve this issue. If your license is active you should see the update available in WordPress. Otherwise, you can access the latest version by <a href="%1$s" target="_blank">logging into your account</a> and visiting <a href="%1$s" target="_blank">your downloads</a> page on the Give website.', 'give-recurring' ),
			'https://givewp.com/wp-login.php',
			'https://givewp.com/my-account/#tab_downloads'
		);

		if ( class_exists( 'Give_Notices' ) ) {
			Give()->notices->register_notice(
				array(
					'id'          => 'give-activation-error',
					'type'        => 'error',
					'description' => $message,
					'show'        => true,
				)
			);
		} else {
			$class = 'notice notice-error';
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}
	}

	/**
	 * Create Payment Profiles.
	 *
	 * Setup customers and plans in Stripe for the sign up.
	 *
	 * @since  1.9.4
	 * @since 1.12.6 Implement createOrRetrieveStripePlan function
	 *
	 * @return void
	 */
	public function create_payment_profiles() {

		$source_id = ! empty( $_POST['give_stripe_payment_method'] ) ? give_clean( $_POST['give_stripe_payment_method'] ) : '';
		$email     = $this->purchase_data['user_email'];

		// Get Stripe Customer based on the type of the checkout. Here we check checkout type based on existing of token/source.
		$this->stripe_customer = ! empty( $source_id ) ? new Give_Stripe_Customer( $email, $source_id ) : new Give_Stripe_Customer( $email );
		$stripe_customer       = $this->stripe_customer->customer_data;
		$stripe_customer_id    = $this->stripe_customer->get_id();

		// Add donation note for customer ID.
		if ( ! empty( $stripe_customer_id ) ) {

			if( $source_id ) {
				$source_id = $this->stripe_customer->attached_payment_method->id;
			}

			// Assign to purchase data.
			$this->purchase_data['customer_id'] = $stripe_customer_id;

			give_insert_payment_note( $this->payment_id, 'Stripe Customer ID: ' . $stripe_customer_id );

			// Save Stripe Customer ID into Donor meta.
			$this->stripe_gateway->save_stripe_customer_id( $stripe_customer_id, $this->payment_id );

			// Save customer id to donation.
			give_update_meta( $this->payment_id, '_give_stripe_customer_id', $stripe_customer_id );
		}

		try {
			$currencyCode = give_get_currency( $this->subscriptions['form_id'] );
			$stripePlan =give( RetrieveOrCreatePlan::class )->handle( SubscriptionDto::fromArray(
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

		$this->purchase_data['plan_id'] = $stripePlan->id;

		// Process recurring donation as per the checkout type selected by admin.
		if ( 'redirect' === give_stripe_get_checkout_type() ) {
			$this->process_stripe_checkout( $this->payment_id, $this->purchase_data );
		} elseif ( 'modal' === give_stripe_get_checkout_type() ) {

			// Add source to donation notes and meta.
			give_insert_payment_note( $this->payment_id, 'Stripe Token ID: ' . $source_id );
			give_update_payment_meta( $this->payment_id, '_give_stripe_token_id', $source_id );

			$this->subscribe_customer_to_plan( $stripe_customer, $source_id, $stripePlan->id );
		}
	}

	/**
	 * This function is used to process donations via Stripe Checkout 2.0.
	 *
	 * @param int   $donation_id Donation ID.
	 * @param array $data        List of submitted data for donation processing.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @return void
	 */
	public function process_stripe_checkout( $donation_id, $data ) {

		// Define essential variables.
		$form_id          = ! empty( $data['post_data']['give-form-id'] ) ? intval( $data['post_data']['give-form-id'] ) : 0;
		$form_name        = ! empty( $data['post_data']['give-form-title'] ) ? $data['post_data']['give-form-title'] : false;
		$donation_summary = give_payment_gateway_donation_summary( $data, false );
		$plan_id          = ! empty( $data['plan_id'] ) ? $data['plan_id'] : '';
		$redirect_to_url  = ! empty( $data['post_data']['give-current-url'] ) ? $data['post_data']['give-current-url'] : site_url();

		// Fetch whether the billing address collection is enabled in admin settings or not.
		$is_billing_enabled = give_is_setting_enabled( give_get_option( 'stripe_collect_billing' ) );

		$session_args = array(
			'customer'                   => $data['customer_id'],
			'client_reference_id'        => $data['purchase_key'],
			'billing_address_collection' => $is_billing_enabled ? 'required' : 'auto',
			'payment_method_types'       => [ 'card' ],
			'mode'                       => 'subscription',
			'subscription_data'          => [
				'items'    => [[
					'plan'     => $plan_id,
					'quantity' => 1,
				]],
				'metadata' => give_stripe_prepare_metadata( $this->payment_id, $this->purchase_data ),
			],
			'success_url'                => give_get_success_page_uri(),
			'cancel_url'                 => give_get_failed_transaction_uri(),
		);

		// Create Checkout Session.
		$session    = $this->stripe_checkout_session->create( $session_args );
		$session_id = ! empty( $session->id ) ? $session->id : false;

		// Set Checkout Session ID as Transaction ID.
		if ( ! empty( $session_id ) ) {
			give_insert_payment_note( $donation_id, 'Stripe Checkout Session ID: ' . $session_id );
			give_update_meta( $donation_id, '_give_stripe_checkout_session_id', $session_id );
		}

		// Save donation summary to donation.
		give_update_meta( $donation_id, '_give_stripe_donation_summary', $donation_summary );

		// Record the subscription in Give.
		$this->record_signup();

		// Redirect to show loading area to trigger redirectToCheckout client side.
		wp_safe_redirect( add_query_arg(
			array(
				'action'  => 'checkout_processing',
				'session' => $session_id,
				'id'      => $form_id,
			),
			$redirect_to_url
		) );

		// Don't execute code further.
		give_die();
	}

	/**
	 * Subscribes a Stripe Customer to a plan.
	 *
	 * @param \Stripe\Customer $stripe_customer Stripe Customer Object.
	 * @param string           $source_id       Stripe Source ID/Object.
	 * @param string           $plan_id         Stripe Plan ID.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @return bool|\Stripe\Subscription
	 */
	public function subscribe_customer_to_plan( $stripe_customer, $source_id, $plan_id ) {

		// Bailout, if `$stripe_customer` is not instance of Stripe Customer.
		if ( ! $stripe_customer instanceof \Stripe\Customer ) {
			return false;
		}

		try {
			// Get metadata.
			$metadata = give_stripe_prepare_metadata( $this->payment_id, $this->purchase_data );
			$args     = array(
				'customer' => $stripe_customer->id,
				'items'    => array(
					array(
						'plan' => $plan_id,
					),
				),
				'metadata' => $metadata,
			);

			if ( give_stripe_is_source_type( $source_id, 'pm' ) ) {
				$args['default_payment_method'] = $source_id;
			} else {
				$args['default_source'] = $source_id;
			}

			$subscription                      = \Stripe\Subscription::create( $args, give_stripe_get_connected_account_options() );
			$this->subscriptions['profile_id'] = $subscription->id;

			// Need additional authentication steps as subscription is still incomplete.
			if ( 'incomplete' ===  $subscription->status ) {

				// Verify the initial payment with invoice created during subscription.
				$invoice = $this->invoice->retrieve( $subscription->latest_invoice );

				// Set Payment Intent ID.
				give_insert_payment_note( $this->payment_id, 'Stripe Payment Intent ID: ' . $invoice->payment_intent );

				// Retrieve payment intent details.
				$intent_details = $this->payment_intent->retrieve( $invoice->payment_intent );

				$confirm_args = array(
					'return_url' => give_get_success_page_uri(),
				);

				if (
					give_stripe_is_source_type( $source_id, 'tok' ) ||
					give_stripe_is_source_type( $source_id, 'src' )
				) {
					$confirm_args['source'] = $source_id;
				} elseif ( give_stripe_is_source_type( $source_id, 'pm' ) ) {
					$confirm_args['payment_method'] = $source_id;
				}

				$intent_details->confirm( $confirm_args );

				// Record the subscription in Give.
				$this->record_signup();

				// Process additional authentication steps for SCA or 3D secure.
				give_stripe_process_additional_authentication( $this->payment_id, $intent_details );
			}

			return $subscription;
		} catch ( \Stripe\Error\Base $e ) {

			// There was an issue subscribing the Stripe customer to a plan.
			Give_Stripe_Logger::log_error( $e, $this->id );
		} catch ( Exception $e ) {

			// Something went wrong outside of Stripe.
			give_record_gateway_error(
				__( 'Stripe Error', 'give-recurring' ),
				sprintf(
					/* translators: %s Exception Message. */
					__( 'An error while subscribing a customer to a plan. Details: %s', 'give-recurring' ),
					$e->getMessage()
				)
			);
			give_set_error( 'Stripe Error', __( 'An error occurred while processing the donation. Please try again.', 'give-recurring' ) );
			give_send_back_to_checkout( '?payment-mode=stripe' );
		} // End try().

		return false;
	}

	/**
	 * Refund subscription charges and cancels the subscription if the parent donation triggered when refunding in wp-admin donation details.
	 *
	 * @param $payment Give_Payment Give Payment.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @return void
	 */
	public function process_refund( $payment ) {

		if ( empty( $_POST['give_refund_in_stripe'] ) ) {
			return;
		}
		$statuses = array( 'give_subscription', 'publish' );

		if ( ! in_array( $payment->old_status, $statuses ) ) {
			return;
		}

		if ( 'stripe_checkout' !== $payment->gateway ) {
			return;
		}

		switch ( $payment->old_status ) {

			case 'give_subscription' :

				// Refund renewal payment
				if ( empty( $payment->transaction_id ) || $payment->transaction_id == $payment->ID ) {

					// No valid charge ID
					return;
				}

				try {

					$refund = \Stripe\Refund::create( array(
						'charge' => $payment->transaction_id,
					) );

					$payment->add_note( sprintf( __( 'Charge %1$s refunded in Stripe. Refund ID: %1$s', 'give-recurring' ), $payment->transaction_id, $refund->id ) );

				} catch ( Exception $e ) {

					// some sort of other error
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
					'number'            => 100,
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

						// some sort of other error
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
					$this->cancel( $subscription, false );
					$subscription->cancel();
					$payment->add_note( sprintf( __( 'Subscription %d cancelled.', 'give-recurring' ), $subscription->id ) );

				}

				break;

		}// End switch().

	}

	/**
	 * Can update subscription CC details.
	 *
	 * @since 1.9.4
	 * @access public
	 *
	 * @param bool   $ret
	 * @param object $subscription
	 *
	 * @return bool
	 */
	public function can_update( $ret, $subscription ) {

		if (
			$subscription->gateway === $this->id &&
			! empty( $subscription->profile_id ) &&
			in_array( $subscription->status, array(
				'active',
				'failing',
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
	 * Stripe Recurring Customer ID.
	 *
	 * The Give Stripe gateway stores it's own customer_id so this method first checks for that, if it exists.
	 * If it does it will return that value. If it does not it will return the recurring gateway value.
	 *
	 * @param string $user_email Donor Email.
	 *
	 * @since  1.9.4
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
	 * Get Stripe Subscription.
	 *
	 * @param string $stripe_subscription_id Subscription ID of Stripe.
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @return mixed
	 */
	public function get_stripe_subscription( $stripe_subscription_id ) {

		$stripe_subscription = \Stripe\Subscription::retrieve( $stripe_subscription_id );

		return $stripe_subscription;

	}

	/**
	 * Get gateway subscription.
	 *
	 * @param Give_Subscription $subscription Give Subscription.
	 *
	 * @since  1.9.4
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
	 * Get subscription details.
	 *
	 * @param Give_Subscription $subscription Give Subscription.
	 *
	 * @since  1.9.4
	 * @access public
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
	 * Get transactions.
	 *
	 * @param  Give_Subscription $subscription Give Subscription.
	 * @param string             $date         Date.
	 *
	 * @since  1.9.4
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
	 * Get invoices for a Give subscription.
	 *
	 * @param Give_Subscription $subscription Give Subscription.
	 * @param string            $date         Date.
	 *
	 * @since  1.9.4
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
	 * @param string $stripe_customer_id     Customer ID from Stripe.
	 * @param string $stripe_subscription_id Subscription ID from Stripe.
	 * @param string $date                   Date.
	 *
	 * @since  1.9.4
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
	 * @param string $stripe_customer_id Customer ID from Stripe.
	 * @param string $date               Date.
	 *
	 * @since  1.9.4
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

				Give_Stripe_Logger::log_error( $e, $this->id );

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
	 * Outputs the payment method update form
	 *
	 * @since  1.9.4
	 * @access public
	 *
	 * @param Give_Subscription $subscription The subscription object.
	 *
	 * @return void
	 */
	public function update_payment_method_form( $subscription ) {

		if ( $subscription->gateway !== $this->id ) {
			return;
		}

		// addCreditCardForm() only shows when Stripe Checkout is enabled so we fake it
		add_filter( 'give_get_option_stripe_checkout', '__return_false' );

		// Remove Billing address fields.
		if ( has_action( 'give_after_cc_fields', 'give_default_cc_address_fields' ) ) {
			remove_action( 'give_after_cc_fields', 'give_default_cc_address_fields', 10 );
		}

		$form_id           = ! empty( $subscription->form_id ) ? absint( $subscription->form_id ) : 0;
		$args['id_prefix'] = "$form_id-1";
		$stripeCard = new Give_Stripe_Card();
		$stripeCard->addCreditCardForm( $form_id, $args );
	}

	/**
	 * @inheritdoc
	 */
	public function update_payment_method( $subscriber, $subscription, $data = null ) {

		if ( $data === null ) {
			$post_data = give_clean( $_POST );
		} else {
			$post_data = $data;
		}

		// Check for any existing errors.
		$errors    = give_get_errors();
		$form_id   = ! empty( $subscription->form_id ) ? $subscription->form_id : false;

		// Set App info.
		give_stripe_set_app_info( $form_id );

		if ( empty( $errors ) ) {

			$source_id   = ! empty( $post_data['give_stripe_payment_method'] ) ? $post_data['give_stripe_payment_method'] : 0;
			$customer_id = Give()->donor_meta->get_meta( $subscriber->id, give_stripe_get_customer_key(), true );

			// We were unable to retrieve the customer ID from meta so let's pull it from the API
			try {

				$stripe_subscription = \Stripe\Subscription::retrieve( $subscription->profile_id );

			} catch ( Exception $e ) {

				give_set_error( 'give_recurring_stripe_error', $e->getMessage() );
				return;
			}

			// If customer id doesn't exist, take the customer id from subscription.
			if ( empty( $customer_id ) ) {
				$customer_id = $stripe_subscription->customer;
			}

			try {

				$stripe_customer = \Stripe\Customer::retrieve( $customer_id );
			} catch ( Exception $e ) {

				give_set_error( 'give-recurring-stripe-customer-retrieval-error', $e->getMessage() );
				return;
			}

			// No errors in stripe, continue on through processing
			try {

				// Fetch payment method details.
				$stripe_payment_method = new Give_Stripe_Payment_Method();

				if ( $source_id ) {
					if ( give_stripe_is_source_type( $source_id, 'pm' ) ) {

						$payment_method = $stripe_payment_method->retrieve( $source_id );

						// Set Card ID as default payment method to customer and subscription.
						$payment_method->attach( array(
							'customer' => $stripe_customer->id,
						) );

						// Set default payment method for subscription.
						\Stripe\Subscription::update(
							$subscription->profile_id,
							array(
								'default_payment_method' => $source_id,
							)
						);
					} else {
						$card = $stripe_customer->sources->create( array( 'source' => $source_id ) );
						$stripe_customer->default_source = $card->id;

						// Set default source for subscription.
						\Stripe\Subscription::update(
							$subscription->profile_id,
							array(
								'default_source' => $source_id,
							)
						);
					}

				} elseif ( ! empty( $post_data['give_stripe_existing_card'] ) ) {
					if ( give_stripe_is_source_type( $post_data['give_stripe_existing_card'], 'pm' ) ) {

						$payment_method = $stripe_payment_method->retrieve( $post_data['give_stripe_existing_card'] );
						$payment_method->attach( array(
							'customer' => $stripe_customer->id,
						) );

						// Set default payment method for subscription.
						\Stripe\Subscription::update(
							$subscription->profile_id,
							array(
								'default_payment_method' => $post_data['give_stripe_existing_card'],
							)
						);
					} else {
						$stripe_customer->default_source     = $post_data['give_stripe_existing_card'];

						// Set default source for subscription.
						\Stripe\Subscription::update(
							$subscription->profile_id,
							array(
								'default_source' => $post_data['give_stripe_existing_card'],
							)
						);
					}
				}

				// Save the updated subscription details.
				$stripe_subscription->save();

				// Save the updated customer details.
				$stripe_customer->save();

			} catch ( \Stripe\Error\Card $e ) {

				$body = $e->getJsonBody();
				$err  = $body['error'];

				if ( isset( $err['message'] ) ) {
					give_set_error( 'payment_error', $err['message'] );
				} else {
					give_set_error( 'payment_error', __( 'There was an error processing your payment, please ensure you have entered your card number correctly.', 'give-recurring' ) );
				}

			} catch ( \Stripe\Error\ApiConnection $e ) {

				$body = $e->getJsonBody();
				$err  = $body['error'];

				if ( isset( $err['message'] ) ) {
					give_set_error( 'payment_error', $err['message'] );
				} else {
					give_set_error( 'payment_error', __( 'There was an error processing your payment (Stripe\'s API is down), please try again', 'give-recurring' ) );
				}

			} catch ( \Stripe\Error\InvalidRequest $e ) {

				$body = $e->getJsonBody();
				$err  = $body['error'];

				// Bad Request of some sort. Maybe Christoff was here ;)
				if ( isset( $err['message'] ) ) {
					give_set_error( 'request_error', $err['message'] );
				} else {
					give_set_error( 'request_error', __( 'The Stripe API request was invalid, please try again', 'give-recurring' ) );
				}

			} catch ( \Stripe\Error\Api $e ) {

				$body = $e->getJsonBody();
				$err  = $body['error'];

				if ( isset( $err['message'] ) ) {
					give_set_error( 'request_error', $err['message'] );
				} else {
					give_set_error( 'request_error', __( 'The Stripe API request was invalid, please try again', 'give-recurring' ) );
				}

			} catch ( \Stripe\Error\Authentication $e ) {

				$body = $e->getJsonBody();
				$err  = $body['error'];

				// Authentication error. Stripe keys in settings are bad.
				if ( isset( $err['message'] ) ) {
					give_set_error( 'request_error', $err['message'] );
				} else {
					give_set_error( 'api_error', __( 'The API keys entered in settings are incorrect', 'give-recurring' ) );
				}

			} catch ( Exception $e ) {
				give_set_error( 'update_error', __( 'There was an error with this payment method. Please try with another card.', 'give-recurring' ) );
			}

		}

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
	 * Can Cancel.
	 *
	 * @param bool $canCancel The value being filtered.
	 * @param $subscription
	 *
	 * @access public
	 *
	 * @since  1.9.4
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
	 * Can Sync.
	 *
	 * @param $ret
	 * @param $subscription
	 *
	 * @since  1.9.4
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
	 * Cancels a Stripe Subscription.
	 *
	 * @param  Give_Subscription $subscription
	 * @param  bool              $valid
	 *
	 * @since  1.9.4
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

				$subscription = \Stripe\Subscription::retrieve( $subscription->profile_id );
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
	 * Link the recurring profile in Stripe.
	 *
	 * @since  1.9.4
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
}

new Give_Recurring_Stripe_Checkout();
