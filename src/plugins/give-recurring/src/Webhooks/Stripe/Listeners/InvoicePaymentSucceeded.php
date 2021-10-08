<?php

namespace GiveRecurring\Webhooks\Stripe\Listeners;

use Give\PaymentGateways\PayPalCommerce\Webhooks\Listeners\EventListener;
use Give_Subscription;
use GiveRecurring\Infrastructure\Log;
use Stripe\Event as StripeEvent;

/**
 * Class InvoicePaymentSucceeded
 * @package GiveRecurring\Webhooks\Stripe\Listeners
 *
 * @since 1.12.6
 */
class InvoicePaymentSucceeded implements EventListener {

	/**
	 * Processes invoice.payment_succeeded event.
	 *
	 * @param StripeEvent $event Stripe Event received via webhooks.
	 *
	 * @since 1.12.6
	 * @return void
	 */
	public function processEvent( $event ) {
		$invoice = $event->data->object;

		$subscription_profile_id = $invoice->subscription;
		$subscription            = new Give_Subscription( $subscription_profile_id, true );

		/**
		 * Return false if no subscription ID can be found,
		 **/

		if ( ! $subscription || ! $subscription->id ) {
			return;
		}

		/**
		 * This action hook will be used to extend processing the invoice payment succeeded event.
		 *
		 * @since 1.9.4
		 */
		do_action( 'give_recurring_stripe_process_invoice_payment_succeeded', $event );

		$total_payments = (int) $subscription->get_total_payments();
		$bill_times     = (int) $subscription->bill_times;

		if ( give_recurring_stripe_can_cancel( false, $subscription ) ) {

			// If subscription is ongoing or bill_times is less than total payments.
			if ( 0 === $bill_times || $total_payments < $bill_times ) {

				// We have a new invoice payment for a subscription.
				$amount         = give_stripe_cents_to_dollars( $invoice->total );
				$transaction_id = $invoice->charge;

				// Look to see if we have set the transaction ID on the parent payment yet.
				if ( ! $subscription->get_transaction_id() ) {
					// This is the initial transaction payment aka first subscription payment.
					$subscription->set_transaction_id( $transaction_id );

					// Update Parent Donation to `Complete`, if the status is `Pending` or `Processing`.
					$payment_status = give_get_payment_status( $subscription->parent_payment_id );
					if ( in_array( $payment_status, [ 'pending', 'processing' ], true ) ) {
						give_update_payment_status( $subscription->parent_payment_id, 'publish' );
					}
				} else {

					$donation_id = give_get_purchase_id_by_transaction_id( $transaction_id );

					// Check if donation id empty that means renewal donation not made so please create it.
					if ( empty( $donation_id ) ) {

						$args = array(
							'amount'         => $amount,
							'transaction_id' => $transaction_id,
							'post_date'      => date_i18n( 'Y-m-d H:i:s', $invoice->created ),
						);
						// We have a renewal.
						$subscription->add_payment( $args );
						$subscription->renew();
					}

					// Update Total Payments as new renewal might have added.
					$total_payments = $subscription->get_total_payments();

					// Check if this subscription is complete.
					give_recurring_stripe_is_subscription_completed( $subscription, $total_payments, $bill_times );

				}
			} else {

				give_recurring_stripe_is_subscription_completed( $subscription, $total_payments, $bill_times );
			}

			return;

		}

		Log::error(
			'Stripe Subscription Can Cancel Error',
			[
				'Description'  => esc_html__( 'The Stripe Gateway returned an error while canceling the subscription.',
					'give-recurring' ),
				'Subscription' => $subscription,
				'Event Data'   => $event
			]
		);
	}
}