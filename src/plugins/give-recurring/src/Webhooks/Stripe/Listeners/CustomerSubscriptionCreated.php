<?php

namespace GiveRecurring\Webhooks\Stripe\Listeners;

use Give\PaymentGateways\PayPalCommerce\Webhooks\Listeners\EventListener;
use Give_Subscription;
use Give_Subscriptions_DB;
use Stripe\Event as StripeEvent;

/**
 * Class CustomerSubscriptionCreated
 * @package GiveRecurring\Webhooks\Stripe\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionCreated implements EventListener
{

    /**
     * @param StripeEvent $event
     *
     * @return void
     */
    public function processEvent($event)
    {
        $subscription = $this->getSubscription($event);

        if (!$this->isSubscriptionProcessable($subscription->id, $subscription->status)) {
            return;
        }

        give_recurring_update_subscription_status($subscription->id, 'active');

        if( 'pending' ===  get_post_status( $subscription->parent_payment_id ) ) {
            give_update_payment_status($subscription->parent_payment_id, 'processing');
        }
    }

    /**
     * @since 1.15.0
     *
     * @param StripeEvent $event
     *
     * @return Give_Subscription
     */
    private function getSubscription($event)
    {
        $subscription = new Give_Subscription(
            $event->data->object->id,
            true
        );

        if (!$subscription->id) {
            $donationMetaData = $event->data->object->metadata;
            $donationId = !empty($donationMetaData['Donation Post ID']) ? $donationMetaData['Donation Post ID'] : 0;
            $subscription = give_recurring_get_subscription_by( 'payment', $donationId );
        }

        return $subscription;
    }

    /**
     * @since 1.15.0
     *
     * @param int $subscriptionId
     * @param string $subscriptionStatus
     *
     * @return bool
     */
    private function isSubscriptionProcessable($subscriptionId, $subscriptionStatus)
    {
        return $subscriptionId && !in_array($subscriptionStatus, ['active', 'cancelled', 'completed', 'expired']);
    }
}
