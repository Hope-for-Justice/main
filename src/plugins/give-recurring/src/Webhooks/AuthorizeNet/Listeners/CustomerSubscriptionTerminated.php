<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use GiveRecurring\Infrastructure\Exceptions\InvalidSubscriptionIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\Contracts\EventListener;
use Give_Subscription;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasSubscriptionPayload;

/**
 * Class CustomerSubscriptionTerminated
 * @package GiveRecurring\Webhooks\AuthorizeNet\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionTerminated implements EventListener {
	use HasSubscriptionPayload;

	/**
	 * @inheritDoc
	 *
	 * @return void
	 * @throws InvalidSubscriptionIdInAuthorizeNetWebhookData
	 */
	public function processEvent( $event ) {
		$subscription = $this->getSubscriptionFromAuthorizeNetWebhookData( $event );

		// Set subscription status to cancelled.
		$subscription->cancel();
	}
}