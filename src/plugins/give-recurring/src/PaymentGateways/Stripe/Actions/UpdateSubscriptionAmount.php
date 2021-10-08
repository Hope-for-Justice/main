<?php

namespace GiveRecurring\PaymentGateways\Stripe\Actions;

use Exception;
use Give\ValueObjects\Money;
use Give_Subscription;
use GiveRecurring\Infrastructure\Exceptions\PaymentGateways\Stripe\UnableToUpdateSubscriptionAmountOnStripe;
use GiveRecurring\PaymentGateways\DataTransferObjects\SubscriptionDto;
use Stripe\Subscription;
use function give_get_payment_currency_code;
use function give_get_price_id;

/**
 * Class StripeUpdateSubscriptionAmountService
 *
 * @package GiveRecurring\PaymentGateways\Stripe\Actions
 *
 * @since 1.12.6
 */
class UpdateSubscriptionAmount {
	/**
	 * @var RetrieveOrCreatePlan
	 */
	private $stripePlanCreatorAndRetrieverService;

	/**
	 * StripeUpdateSubscriptionAmountService constructor.
	 *
	 * @param RetrieveOrCreatePlan $stripePlanCreatorAndRetrieverService
	 *
	 * @since 1.12.6
	 */
	public function __construct( RetrieveOrCreatePlan $stripePlanCreatorAndRetrieverService ) {
		$this->stripePlanCreatorAndRetrieverService = $stripePlanCreatorAndRetrieverService;
	}

	/**
	 * Update Stripe Subscription plan.
	 *
	 * @param Give_Subscription $subscription
	 * @param string $renewalAmount
	 *
	 * @throws UnableToUpdateSubscriptionAmountOnStripe
	 * @since 1.12.6
	 */
	public function handle( $subscription, $renewalAmount ) {
		try{
			$newRecurringDonationAmount = Money::of(
				$renewalAmount,
				give_get_payment_currency_code( $subscription->parent_payment_id )
			);

			$stripePlan = $this->stripePlanCreatorAndRetrieverService->handle(
				SubscriptionDto::fromGiveSubscriptionObject(
					$subscription,
					[
						'recurringDonationAmount' => $newRecurringDonationAmount,
						'priceId' => give_get_price_id( $subscription->form_id, $newRecurringDonationAmount->getAmount() )
					]
				)
			);

			$stripeSubscription = Subscription::retrieve( $subscription->profile_id );

			$stripeSubscription->update(
				$subscription->profile_id,
				[
					'items'   => [
						[
							'id'   => $stripeSubscription->items->data[0]->id,
							'plan' => $stripePlan->id,
						],
					],
					'prorate' => false,
				]
			);

			$stripeSubscription->save();

		} catch ( Exception $e ) {
			throw new UnableToUpdateSubscriptionAmountOnStripe( $e->getMessage() );
		}
	}
}