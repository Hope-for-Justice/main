<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use GiveRecurring\Infrastructure\Exceptions\InvalidSubscriptionIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\Contracts\EventListener;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasSubscriptionPayload;

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
	 * @return void
	 * @throws InvalidSubscriptionIdInAuthorizeNetWebhookData
	 */
	public function processEvent( $event ) {
		$subscription = $this->getSubscriptionFromAuthorizeNetWebhookData( $event );

		// Set subscription status to expired.
		$subscription->update( array(
			'status' => 'active',
		) );

		give_update_payment_status( $subscription->parent_payment_id, 'processing' );
	}
}