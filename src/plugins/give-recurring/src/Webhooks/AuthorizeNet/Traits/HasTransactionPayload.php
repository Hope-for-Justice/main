<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Traits;

use GiveRecurring\Infrastructure\Exceptions\InvalidDonationIdInAuthorizeNetWebhookData;

/**
 * Trait HasTransactionPayload
 * @package GiveRecurring\Webhooks\AuthorizeNet\Traits
 *
 * @since 1.12.6
 */
trait HasTransactionPayload {
	/**
	 * @since 1.12.6
	 *
	 * @param object $event
	 *
	 * @throws InvalidDonationIdInAuthorizeNetWebhookData
	 */
	public function getDonationIdFromAuthorizeNetWebhookData( $event ){
		$transactionId = isset( $event->payload->id ) ? $event->payload->id : '';

		// Must have the transaction id.
		if ( empty( $transactionId ) ) {
			throw new InvalidDonationIdInAuthorizeNetWebhookData( 'Invalid donation Id in Authorize.Net Webhook Data' );
		}

		$donationId = give_get_purchase_id_by_transaction_id( $transactionId );

		// Is this payment not recorded?
		if ( ! $donationId ) {
			return null;
		}

		return $donationId;
	}
}