<?php

namespace GiveRecurring\Webhooks\Stripe\Listeners;

use Give\PaymentGateways\PayPalCommerce\Webhooks\Listeners\EventListener;
use Give_Subscription;
use Stripe\Event as StripeEvent;

/**
 * Class CheckoutSessionCompleted
 * @package GiveRecurring\Webhooks\Stripe\Listeners
 *
 * @since 1.12.6
 */
class CheckoutSessionCompleted implements EventListener {

	/**
	 * Processes checkout.session.completed event.
	 *
	 * @param StripeEvent $event Stripe Event received via webhooks.
	 *
	 * @since 1.12.6
	 */
	public function processEvent( $event ) {
		$checkout_session = $event->data->object;

		$donation_id = (int) Give()->payment_meta->get_column_by(
			'donation_id',
			'meta_value',
			$checkout_session->id
		);

		if ( ! $donation_id ) {
			return;
		}

		// Update payment status to donation.
		give_update_payment_status( $donation_id, 'publish' );

		// Insert donation note to inform admin that charge succeeded.
		give_insert_payment_note( $donation_id, esc_html__( 'Charge succeeded in Stripe.', 'give-recurring' ) );

		$subscription = give_recurring_get_subscription_by( 'payment', $donation_id );

		if( ! $subscription || ! $subscription->id ) {
			return;
		}

		$subscription->update( array(
			'profile_id' => $checkout_session->subscription,
		) );

		give_recurring_update_subscription_status( $subscription->id, 'active' );
	}
}