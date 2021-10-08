<?php

namespace GiveRecurring\Webhooks\Stripe\Listeners;

use Give\PaymentGateways\PayPalCommerce\Webhooks\Listeners\EventListener;
use Give_Subscription;

/**
 * Class CustomerSubscriptionCreated
 * @package GiveRecurring\Webhooks\Stripe\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionCreated implements EventListener {

	/**
	 * @inheritDoc
	 */
	public function processEvent( $event ) {
		$subscription = $event->data->object;

		$profile_id   = $subscription->id;
		$subscription = new Give_Subscription( $profile_id, true );

		// Sanity Check: Don't cancel already completed or cancelled subscriptions or empty subscription objects.
		if (
			! $subscription ||
			! $subscription->id ||
			in_array( $subscription->status, [ 'completed', 'cancelled' ] )
		) {
			return;
		}

		if( in_array( $subscription->status, [ 'active', 'cancelled', 'completed', 'expired' ] ) ) {
			return;
		}

		give_recurring_update_subscription_status( $subscription->id, 'active' );
		give_update_payment_status( $subscription->parent_payment_id, 'processing' );
	}
}