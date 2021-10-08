<?php

namespace GiveRecurring\PaymentGateways\Stripe\Repositories;

use GiveRecurring\PaymentGateways\DataTransferObjects\SubscriptionDto;

/**
 * Class StripePlan
 * @package GiveRecurring\PaymentGateways\Stripe\Repositories
 *
 * @since 1.12.6
 */
class StripePlan {
	/**
	 * @since 1.12.6
	 *
	 * @param SubscriptionDto $subscriptionDto
	 *
	 * @return string
	 */
	public function getPlanId( SubscriptionDto $subscriptionDto ) {
		return sanitize_key(
			sprintf(
				'%1$s-%2$s-%3$s-%4$s',
				sanitize_title( $this->getProductName( $subscriptionDto ) ),
				$subscriptionDto->recurringDonationAmount->getAmount(),
				$subscriptionDto->period,
				$subscriptionDto->frequency
			)
		);
	}

	/**
	 * @since 1.12.6
	 *
	 * @param SubscriptionDto $subscriptionDto
	 *
	 * @return string
	 */
	public function getProductName( SubscriptionDto $subscriptionDto ) {
		return sprintf(
			'%1$s (%2$s)',
			give_recurring_generate_subscription_name(
				$subscriptionDto->formId,
				$subscriptionDto->priceId
			),
			$subscriptionDto->currencyCode
		);
	}
}