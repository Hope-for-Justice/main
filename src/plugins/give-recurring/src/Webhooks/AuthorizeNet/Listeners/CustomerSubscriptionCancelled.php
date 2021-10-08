<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use GiveRecurring\Infrastructure\Exceptions\InvalidSubscriptionIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\Contracts\EventListener;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasSubscriptionPayload;

/**
 * Class CustomerSubscriptionCancelled
 * @package GiveRecurring\Webhooks\AuthorizeNet\Listeners
 *
 * @since 1.12.6
 */
class CustomerSubscriptionCancelled implements EventListener {
	use HasSubscriptionPayload;

	/**
	 * @since 1.12.6
	 *
	 * @param object $event
	 *
	 * @return void
	 * @throws InvalidSubscriptionIdInAuthorizeNetWebhookData
	 */
	public function processEvent( $event ) {
		$subscription = $this->getSubscriptionFromAuthorizeNetWebhookData( $event );

		$timesBilled = $subscription->get_total_payments();

		// Is the subscription completed? Complete subscription if applicable.
		if ( $subscription->bill_times > 0 && $timesBilled >= $subscription->bill_times ) {
			return;
		}

		$subscription->cancel();
	}
}