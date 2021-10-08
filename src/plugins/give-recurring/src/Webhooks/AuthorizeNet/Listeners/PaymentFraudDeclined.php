<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use GiveRecurring\Infrastructure\Exceptions\InvalidDonationIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\Contracts\EventListener;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasTransactionPayload;

/**
 * Class PaymentFraudDeclined
 * @package GiveRecurring\Webhooks\AuthorizeNet\Listeners
 *
 * @since 1.12.6
 */
class PaymentFraudDeclined implements EventListener {
	use HasTransactionPayload;

	/**
	 * @inheritDoc
	 *
	 * @return void
	 * @throws InvalidDonationIdInAuthorizeNetWebhookData
	 */
	public function processEvent( $event ) {
		$donationId = $this->getDonationIdFromAuthorizeNetWebhookData( $event );

		// Donation is already set to failed?
		if( 'failed' === get_post_status( $donationId ) ) {
			return;
		}

		give_update_payment_status( $donationId, 'failed' );
	}
}