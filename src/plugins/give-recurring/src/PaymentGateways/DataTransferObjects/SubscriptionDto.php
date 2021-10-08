<?php

namespace GiveRecurring\PaymentGateways\DataTransferObjects;

use Give\Framework\Exceptions\Primitives\InvalidArgumentException;
use Give\ValueObjects\Money;
use Give_Subscription;
use Exception;

/**
 * Class SubscriptionDto
 * @package GiveRecurring\PaymentGateways\DataTransferObjects
 *
 * Use this data transfer object for frontend subscription request.
 * This DTO does not provide access ot subscription id.
 *
 * @since 1.12.6
 *
 * @property string $formId
 * @property string $priceId
 * @property Money $recurringDonationAmount
 * @property string $period
 * @property string $frequency
 * @property string $currencyCode
 */
class SubscriptionDto {
	/**
	 * @since 1.12.6
	 *
	 * @param array $array
	 *
	 * @return static
	 */
	public static function fromArray( array $array ) {
		$self = new static();

		try {
			$self->formId = $array['formId'];
			$self->priceId = $array['priceId'];
			$self->recurringDonationAmount = $array['recurringDonationAmount'];
			$self->period = $array['period'];
			$self->frequency = $array['frequency'];
			$self->currencyCode = $array['currencyCode'];
		} catch ( Exception $e ) {
			throw new InvalidArgumentException(
				sprintf(
					'Add required argument to array to create %s object',
					__CLASS__
				)
			);
		}

		return $self;
	}

	/**
	 * @param Give_Subscription $subscription
	 * @param array $overwriteWith
	 *
	 * @return static
	 */
	public static function fromGiveSubscriptionObject( Give_Subscription $subscription, $overwriteWith = [] ){
		$currencyCode = give()->payment_meta->get_meta(
			$subscription->parent_payment_id,
			'_give_payment_currency',
			true
		);

		$priceId = give()->payment_meta->get_meta(
			$subscription->parent_payment_id,
			'_give_payment_price_id',
			true
		);

		$dataFromSubscription = wp_parse_args(
			$overwriteWith,
			[
				'formId' => $subscription->form_id,
				'priceId' => $priceId,
				'recurringDonationAmount' => Money::of( $subscription->recurring_amount, $currencyCode ),
				'period' => $subscription->period,
				'frequency' => $subscription->frequency,
				'currencyCode' => $currencyCode
			]
		);

		return self::fromArray( $dataFromSubscription );
	}

	/**
	 * @param string $name Property name
	 *
	 * @return mixed|void
	 */
	public function __get( $name ) {
		if( property_exists( $this, $name ) ) {
			return $this->{$name};
		}
	}
}