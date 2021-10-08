<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Traits;

use Give_Subscription;
use GiveRecurring\Infrastructure\Exceptions\InvalidSubscriptionIdInAuthorizeNetWebhookData;

/**
 * Class HasSubscriptionPayload
 * @package GiveRecurring\Webhooks\AuthorizeNet\Traits
 *
 * @since 1.12.6
 */
trait HasSubscriptionPayload {
	/**
	 * @since 1.12.6
	 *
	 * @param object $event
	 *
	 * @return null|Give_Subscription
	 * @throws InvalidSubscriptionIdInAuthorizeNetWebhookData
	 */
	protected function getSubscriptionFromAuthorizeNetWebhookData( $event ){
		$SubscriptionProfileId = isset( $event->payload->id ) ? $event->payload->id : '';

		// Must have subscription id to continue.
		if ( empty( $SubscriptionProfileId ) ) {
			throw new InvalidSubscriptionIdInAuthorizeNetWebhookData( 'Invalid subscription Id in Authorize.Net Webhook Data' );
		}

		$subscription = new Give_Subscription( $SubscriptionProfileId, true );

		return $subscription->id ? $subscription : null;
	}
}