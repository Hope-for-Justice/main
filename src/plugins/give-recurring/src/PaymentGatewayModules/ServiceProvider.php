<?php

namespace GiveRecurring\PaymentGatewayModules;

use Give\Helpers\Hooks;
use Give\PaymentGateways\Gateways\TestGateway\TestGateway;
use Give\ServiceProviders\ServiceProvider as ServiceProviderInterface;
use GiveRecurring\PaymentGatewayModules\Actions\AddPaymentGatewayModulesToLegacyList;
use GiveRecurring\PaymentGatewayModules\Modules\TestGatewaySubscriptionModule;

class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @since 1.14.0
     *
     * @inheritDoc
     */
    public function register()
    {
    }

    /**
     * @since 1.14.0
     *
     * @inheritDoc
     */
    public function boot()
    {
        $testGatewayId = TestGateway::id();
        add_filter("give_gateway_{$testGatewayId}_subscription_module", function () {
            return TestGatewaySubscriptionModule::class;
        });

        Hooks::addFilter('give_recurring_available_gateways', AddPaymentGatewayModulesToLegacyList::class);
    }
}
