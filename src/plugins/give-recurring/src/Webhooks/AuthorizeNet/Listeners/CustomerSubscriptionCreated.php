<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use GiveRecurring\Infrastructure\Exceptions\InvalidSubscriptionIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasSubscriptionPayload;
use GiveRecurring\Webhooks\Contracts\EventListener;

/**
 * Class CustomerSubscriptionCreated
 * @package GiveRecurring\Webhooks\AuthorizeNet\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionCreated implements EventListener {
	use HasSubscriptionPayload;

	/**
     * @inheritDoc
     *
     * @since 1.13.0 Set donation status to "processing" if previous status is "pending"
     *
     * @return void
     * @throws InvalidSubscriptionIdInAuthorizeNetWebhookData
     */
	public function processEvent( $event )
    {
        $subscription = $this->getSubscriptionFromAuthorizeNetWebhookData($event);

        // Set subscription status to expired.
        $subscription->update([
            'status' => 'active',
        ]);

        if ( 'pending' === get_post_status($subscription->parent_payment_id) ) {
            give_update_payment_status($subscription->parent_payment_id, 'processing');
        }
    }
}
