<?php

namespace GiveRecurring\PaymentGateways\AuthorizeNet\Views;

use Give_Subscription;

/**
 * @since 1.12.7
 */
class SubscriptionProfileIdView
{
    /**
     * @since 1.12.7
     *
     * @param string $transactionId AuthorizeNet subscription id.
     * @param Give_Subscription $subscription Subscription.
     *
     * @return string
     */
    public function render($transactionId, $subscription)
    {
        $subscriptionURL    = $this->isLivePayment($subscription->parent_payment_id) ?
            "https://account.authorize.net/UI/themes/anet/ARB/SubscriptionDetail.aspx?SubscrID=$transactionId" :
            "https://sandbox.authorize.net/ui/themes/sandbox/ARB/SubscriptionDetail.aspx?SubscrID=$transactionId";

        return sprintf(
            '<a href="%1$s" title="%3$s" target="_blank">%2$s</a>',
            $subscriptionURL,
            $transactionId,
            esc_html__('Authorize subscription link', 'give-recurring')
        );
    }

    /**
     * @since 1.12.7
     *
     * @param int $donationId
     *
     * @return bool
     */
    private function isLivePayment($donationId)
    {
        return Give()->payment_meta->get_meta($donationId, '_give_payment_mode', true) === 'live';
    }
}
