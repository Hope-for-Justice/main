<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use GiveRecurring\Infrastructure\Exceptions\InvalidSubscriptionIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\Contracts\EventListener;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasSubscriptionPayload;

/**
 * Class CustomerSubscriptionExpiring
 * @package GiveRecurring\Webhooks\AuthorizeNet\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionExpiring implements EventListener {
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
			'status' => 'expired',
		) );
	}
}