<?php

namespace GiveRecurring\PaymentGateways\AuthorizeNet;

use Give\Helpers\Hooks;
use GiveRecurring\PaymentGateways\AuthorizeNet\Views\SubscriptionProfileIdView;

/**
 * @since 1.12.7
 */
class ServiceProvider implements \Give\ServiceProviders\ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register()
    {
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
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
