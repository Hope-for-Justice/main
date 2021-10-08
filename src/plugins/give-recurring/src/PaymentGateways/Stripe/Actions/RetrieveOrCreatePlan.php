<?php

namespace GiveRecurring\PaymentGateways\Stripe\Actions;

use Exception;
use GiveRecurring\Infrastructure\Exceptions\PaymentGateways\Stripe\UnableToCreateStripePlan;
use GiveRecurring\PaymentGateways\DataTransferObjects\SubscriptionDto;
use GiveRecurring\PaymentGateways\Stripe\Plan;
use Stripe\Plan as StripePlan;
use Stripe\Product as StripeProduct;
use GiveRecurring\PaymentGateways\Stripe\Repositories\StripePlan as StripePlanRepository;
use function give;
use function give_stripe_get_statement_descriptor;

/**
 * Class StripePlanCreatorAndRetrieverService
 * @package GiveRecurring\PaymentGateways\Stripe\Actions
 *
 * @since 1.12.6
 */
class RetrieveOrCreatePlan {
	/**
	 * @var StripePlanRepository
	 */
	private $stripePlanRepository;

	/**
	 * StripePlanCreatorAndRetrieverService constructor.
	 *
	 * @param StripePlanRepository $stripePlanRepository
	 *
	 * @since 1.12.6
	 */
	public function __construct( StripePlanRepository $stripePlanRepository ) {
		$this->stripePlanRepository  = $stripePlanRepository;
	}

	/**
	 * @since 1.12.6
	 *
	 * @param SubscriptionDto $subscriptionDto
	 *
	 * @return StripePlan
	 * @throws UnableToCreateStripePlan
	 */
	public function handle( SubscriptionDto $subscriptionDto ) {
		$stripeProductName = $this->stripePlanRepository->getProductName( $subscriptionDto );
		$stripePlanId = $this->stripePlanRepository->getPlanId( $subscriptionDto );

		try {
			return give( Plan::class )->retrieve( $stripePlanId );
		} catch ( Exception $e ) {
			return $this->createNewStripePlan( $subscriptionDto, $stripePlanId, $stripeProductName );
		}
	}

	/**
	 * Creates a Stripe Plan using the API.
	 *
	 * @since 1.12.6
	 *
	 * @param SubscriptionDto $subscriptionDto
	 * @param string $stripePlanId
	 * @param string $stripeProductName
	 *
	 * @return StripePlan
	 * @throws UnableToCreateStripePlan
	 */
	private function createNewStripePlan( SubscriptionDto $subscriptionDto, $stripePlanId, $stripeProductName ) {
		$args           = array(
			'amount'         => $subscriptionDto->recurringDonationAmount->getMinorAmount(),
			'interval'       => $subscriptionDto->period,
			'interval_count' => $subscriptionDto->frequency,
			'currency'       => $subscriptionDto->currencyCode,
			'id'             => $stripePlanId,
		);

		try {
			$args['product'] = $this->createStripeProduct( $stripeProductName );
			return give( Plan::class )->create( $args );

		} catch ( Exception $e ) {
			throw new UnableToCreateStripePlan( $e->getMessage() );
		}
	}

	/**
	 * @since 1.12.6
	 *
	 * @param string $stripeProductName
	 *
	 * @return StripeProduct
	 */
	private function createStripeProduct( $stripeProductName ){
		return StripeProduct::create( array(
			'name'                 => $stripeProductName,
			'statement_descriptor' => give_stripe_get_statement_descriptor(),
			'type'                 => 'service',
		) );
	}
}