<?php

namespace GiveRecurring\Webhooks;

use Give\Helpers\Hooks;
use GiveRecurring\Webhooks\Stripe\Listeners\CheckoutSessionCompleted;
use GiveRecurring\Webhooks\Stripe\Listeners\CustomerSubscriptionCreated as StripeCustomerSubscriptionCreated;
use GiveRecurring\Webhooks\Stripe\Listeners\CustomerSubscriptionDeleted;
use GiveRecurring\Webhooks\Stripe\Listeners\InvoicePaymentFailed;
use GiveRecurring\Webhooks\Stripe\Listeners\InvoicePaymentSucceeded;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\CustomerSubscriptionCancelled;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\CustomerSubscriptionCreated as AuthorizeCustomerSubscriptionCreated;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\CustomerSubscriptionExpiring;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\CustomerSubscriptionSuspended;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\CustomerSubscriptionTerminated;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\PaymentAuthCaptureCreated;
use GiveRecurring\Webhooks\AuthorizeNet\Listeners\PaymentFraudDeclined;

/**
 * Class ServiceProvider
 * @package GiveRecurring\Webhooks
 *
 * @since 1.12.6
 */
class ServiceProvider implements \Give\ServiceProviders\ServiceProvider {
	/**
	 * @var string[]
	 */
	private $stripeWebhookEventListeners = [
		'give_stripe_event_invoice.payment_succeeded'     => InvoicePaymentSucceeded::class,
		'give_stripe_event_invoice.payment_failed'        => InvoicePaymentFailed::class,
		'give_stripe_event_customer.subscription.deleted' => CustomerSubscriptionDeleted::class,
		'give_stripe_event_checkout.session.completed'    => CheckoutSessionCompleted::class,
		'give_stripe_event_customer.subscription.created' => StripeCustomerSubscriptionCreated::class
	];

	private $authorizeNetWebhookEventActionHooks = [
		'give_authorize_event_net.authorize.customer.subscription.created'    => AuthorizeCustomerSubscriptionCreated::class,
		'give_authorize_event_net.authorize.customer.subscription.cancelled'  => CustomerSubscriptionCancelled::class,
		'give_authorize_event_net.authorize.customer.subscription.suspended'  => CustomerSubscriptionSuspended::class,
		'give_authorize_event_net.authorize.customer.subscription.terminated' => CustomerSubscriptionTerminated::class,
		'give_authorize_event_net.authorize.customer.subscription.expiring'   => CustomerSubscriptionExpiring::class,
		// @todo: check if we can use net.authorize.customer.subscription.expired
		'give_authorize_event_net.authorize.payment.authcapture.created'      => PaymentAuthCaptureCreated::class,
		'give_authorize_event_net.authorize.payment.fraud.declined'           => PaymentFraudDeclined::class,
	];

	/**
	 * @inheritDoc
	 */
	public function register() {
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		add_action( 'give_init', [ $this, 'registerAuthorizeNetWebhookEvents' ], 99 );
		add_action( 'give_init', [ $this, 'registerStripeWebhookEvents' ], 99 );
	}

	/**
	 * @since 1.12.6
	 */
	public function registerAuthorizeNetWebhookEvents(){
		// Must be using latest Authorize with webhook support.
		if ( function_exists( 'Give_Authorize' ) && method_exists( Give_Authorize()->payments, 'setup_api_request' ) ) {
			foreach ( $this->authorizeNetWebhookEventActionHooks as $actionHook => $className ){
				Hooks::addAction( $actionHook, $className, 'processEvent' );
			}
		}
	}

	/**
	 * @since 1.12.6
	 */
	public function registerStripeWebhookEvents(){
		foreach ( $this->stripeWebhookEventListeners as $eventName => $eventListenerClassName ) {
			Hooks::addAction( $eventName, $eventListenerClassName, 'processEvent' );
		}
	}
}