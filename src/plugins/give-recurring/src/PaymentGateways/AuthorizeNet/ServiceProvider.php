<?php

namespace GiveRecurring\PaymentGateways\AuthorizeNet;

use Give\Helpers\Hooks;
use GiveAuthorizeNet\AuthorizeNet\PaymentProcessors\CreditCardProcessor;
use GiveRecurring\PaymentGateways\AuthorizeNet\Actions\EditSubscriptionTransactionRequestArgs;
use GiveRecurring\PaymentGateways\AuthorizeNet\Actions\ProcessOneTimeDonation;
use GiveRecurring\PaymentGateways\AuthorizeNet\Views\SubscriptionProfileIdView;

/**
 * @since 1.12.7
 */
class ServiceProvider implements \Give\ServiceProviders\ServiceProvider
{
    /**
     * @inerhitDoc
     */
    public function register()
    {
    }

    /**
     * @inerhitDoc
     * @unreleased Process one-time payment before subscription creates on payment gateway.
     */
    public function boot()
    {
        if (class_exists(CreditCardProcessor::class)) {
            Hooks::addAction('give_recurring_pre_create_payment_profiles', ProcessOneTimeDonation::class);

            Hooks::addFilter(
                'give_recurring_authorize_create_subscription_request_args',
                EditSubscriptionTransactionRequestArgs::class
            );
            Hooks::addFilter(
                'give_recurring_authorize_echeck_create_subscription_request_args',
                EditSubscriptionTransactionRequestArgs::class
            );
            Hooks::addFilter(
                'give_subscription_profile_link_authorize',
                SubscriptionProfileIdView::class,
                'render', 10, 2
            );
            Hooks::addFilter(
                'give_subscription_profile_link_authorize_echeck',
                SubscriptionProfileIdView::class,
                'render', 10, 2
            );
        }
    }
}
