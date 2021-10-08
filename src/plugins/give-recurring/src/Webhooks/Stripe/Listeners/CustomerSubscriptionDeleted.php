<?php

namespace GiveRecurring\Webhooks\Stripe\Listeners;

use Give\PaymentGateways\PayPalCommerce\Webhooks\Listeners\EventListener;
use Give_Subscription;
use Stripe\Event as StripeEvent;

/**
 * Class CustomerSubscriptionDeleted
 * @package GiveRecurring\Webhooks\Stripe\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionDeleted implements EventListener {

	/**
	 * Processes customer.subscription.deleted event.
	 *
	 * @param StripeEvent $event Stripe Event received via webhooks.
	 *
	 * @since 1.12.6
	 * @return void
	 */
	public function processEvent( $event ) {
		$subscription = $event->data->object;

		/**
		 * This action hook will be used to extend processing the customer subscription deleted event.
		 *
		 * @since 1.9.4
		 */
		do_action( 'give_recurring_stripe_process_customer_subscription_deleted', $event );

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

		$subscription->cancel();
	}
}