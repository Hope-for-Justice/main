<?php

namespace GiveRecurring\PaymentGatewayModules\Modules;

use Give\Framework\PaymentGateways\Commands\SubscriptionComplete;
use Give\Framework\PaymentGateways\Contracts\SubscriptionModuleInterface;
use Give\PaymentGateways\DataTransferObjects\GatewayPaymentData;
use Give\PaymentGateways\DataTransferObjects\GatewaySubscriptionData;

/**
 * @since 1.14.0
 */
class TestGatewaySubscriptionModule implements SubscriptionModuleInterface
{
    /**
     * @since 1.14.0
     *
     * @inheritDoc
     */
    public function createSubscription(GatewayPaymentData $paymentData, GatewaySubscriptionData $subscriptionData)
    {
        $profileId = md5($paymentData->purchaseKey . $paymentData->donationId);
        $transactionId = md5(uniqid(mt_rand(), true));

        return new SubscriptionComplete($transactionId, $profileId);
    }
}
