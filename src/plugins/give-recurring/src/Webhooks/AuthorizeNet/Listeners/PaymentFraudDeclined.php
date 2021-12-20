<?php

namespace GiveRecurring\Webhooks\AuthorizeNet\Listeners;

use Give_Subscription;
use GiveRecurring\Infrastructure\Exceptions\InvalidDonationIdInAuthorizeNetWebhookData;
use GiveRecurring\Webhooks\AuthorizeNet\Traits\HasTransactionPayload;
use GiveRecurring\Webhooks\Contracts\EventListener;

/**
 * Class PaymentFraudDeclined
 * @package GiveRecurring\Webhooks\AuthorizeNet\Listeners
 *
 * @since 1.12.6
 */
class PaymentFraudDeclined implements EventListener
{
    use HasTransactionPayload;

    /**
     * @inheritDoc
     *
     * @since 1.13.0 Set subscription to "cancelled" and Cancel on authorizeNet when initial payment decline.
     *
     * @return void
     * @throws InvalidDonationIdInAuthorizeNetWebhookData
     */
    public function processEvent($event)
    {
        $donationId = (int)$this->getDonationIdFromAuthorizeNetWebhookData($event);

        $subscription = new Give_Subscription(give_get_payment_transaction_id($donationId));

        if ( ! $subscription->id ) {
            return;
        }

        // Is not initial payment of subscription?
        if ( $donationId !== $subscription->parent_payment_id ) {
            return;
        }

        give_update_payment_status($donationId, 'failed');
        $subscription->cancel();

        // Fire action hook to cancel subscription on Authorize.net.
        do_action('give_recurring_cancel_authorize_subscription', $subscription, true);
    }
}
