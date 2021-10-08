<?php
/**
 * Give Recurring - Stripe Plan API
 *
 * Note: this class is only for inter use and can be modify in future.
 */

namespace GiveRecurring\PaymentGateways\Stripe;

use Exception;
use GiveRecurring\Infrastructure\Exceptions\PaymentGateways\Stripe\UnableToCreateStripePlan;
use GiveRecurring\Infrastructure\Exceptions\PaymentGateways\Stripe\UnableToRetrieveStripePlan;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plan
 * @package GiveRecurring\Gateways\Stripe
 * @since 1.10.3
 */
class Plan {

	/**
	 * This function will be used to create subscription plan.
	 *
	 * @param array $args List of Plan Arguments.
	 *
	 * @return \Stripe\Plan
	 * @throws UnableToCreateStripePlan
	 *
	 * @since  1.10.3
	 * @since 1.12.6 throw exception
	 */
	public function create( $args ) {

		try {
			return \Stripe\Plan::create( $args );

		} catch ( Exception $e ) {
			throw new UnableToCreateStripePlan(
				sprintf(
				/* translators: %s Exception Message Body */
					esc_html__( 'The Stripe Gateway returned an error while creating a subscription plan. Details: %s',
						'give-recurring' ),
					$e->getMessage()
				)
			);
		}
	}

	/**
	 * This function will be used to retrieve subscription plan.
	 *
	 * @param string $id Plan ID.
	 *
	 * @return \Stripe\Plan
	 * @throws UnableToRetrieveStripePlan
	 *
	 * @since  1.10.3
	 * @since 1.12.6 throw exception
	 *
	 */
	public function retrieve( $id ) {

		try {
			return \Stripe\Plan::retrieve( $id );

		} catch ( Exception $e ) {
			throw new UnableToRetrieveStripePlan(
				sprintf(
				/* translators: %s Exception Message Body */
					esc_html__( 'The Stripe Gateway returned an error while retrieving the subscription plan. Details: %s',
						'give-recurring' ),
					$e->getMessage()
				)
			);
		}
	}
}
