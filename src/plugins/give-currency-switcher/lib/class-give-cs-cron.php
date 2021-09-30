<?php
/**
 * Give Currency Cron Class.
 *
 * Update exchange rate automatically through wp cron.
 *
 * @package    Give_Currency_Switcher
 * @copyright  Copyright (c) 2016, GiveWP
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Give_CS_Cron
 *
 * @since 1.0
 */
class Give_CS_Cron {

	/**
	 * Cron Schedule intervals.
	 *
	 * @since 1.0
	 * @var array $schedule_intervals
	 */
	private $schedule_intervals;

	/**
	 * Give_CS_Cron constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
	}

	/**
	 * Register cron of the interval to fetch the exchange rate automatically.
	 *
	 * @since 1.2.2
	 *
	 * @param array $cron_args cron arguments
	 */
	public function register_schedule_hook( $cron_args ) {
		$interval      = array_key_exists( 'interval', $cron_args ) ? $cron_args['interval'] : 'daily';
		$schedule_hook = "cs_exchange_rate_{$interval}_task";

		// If the it was never scheduled before or expired.
		if ( ! wp_next_scheduled( $schedule_hook ) ) {
			wp_schedule_event( current_time( 'timestamp' ), $interval, $schedule_hook, (array) $interval );
		}
	}

	/**
	 * Update exchange rate automatically when CRON fires.
	 *
	 * @since 1.0
	 *
	 * @param integer $interval Interval
	 *
	 * @return bool
	 */
	public function auto_update_exchange_rate( $interval ) {
		// If it's not right schedule callback, go back.
		if ( ! array_key_exists( $interval, $this->get_schedules() ) ) {
			return false;
		}

		// Get the exchange rate interval.
		$cs_interval = give_cs_get_option( 'cs_exchange_rates_interval' );

		// Cron interval and exchange rate interval must be same.
		if ( $cs_interval !== $interval ) {
			return false;
		}

		$global_cs_status      = give_is_setting_enabled( give_cs_get_option( 'cs_status' ) );
		$global_exchange_rates = give_is_setting_enabled( give_cs_get_option( 'cs_exchange_rates_update' ) );

		// Update global exchange rate setting.
		if ( $global_cs_status && $global_exchange_rates && $interval === $cs_interval ) {

			// Get exchange rates from global setting.
			$saved_rates = give_cs_get_option( 'cs_exchange_rates', 0, array() );
			// Get the exchange rates.
			$new_exchange_rates = cs_fetch_exchange_rates_from_api( 0, give_get_currency() );

			// Go through the previously saved exchange rates.
			foreach ( $saved_rates as $currency_code => $exchange ) {
				if (
					isset( $new_exchange_rates['rates'][ $currency_code ] )
					&& $exchange['exchange_rate'] !== $new_exchange_rates['rates'][ $currency_code ]
					&& ! isset( $exchange['set_manually'] )
					&& false !== $new_exchange_rates['rates'][ $currency_code ]
					&& ! empty( $new_exchange_rates['rates'][ $currency_code ] )
				) {
					$saved_rates[ $currency_code ]['exchange_rate'] = $new_exchange_rates['rates'][ $currency_code ];
				}
			}

			// Update exchange rates globally.
			give_update_option( 'cs_exchange_rates', $saved_rates );
		}

		// Update exchange rate for all donation forms.
		// Get the donation forms.
		$donation_forms = get_posts( array(
			'post_type'   => array( 'give_forms' ),
			'post_status' => 'publish',
			'numberposts' => - 1,
		) );

		if ( ! empty( $donation_forms ) ) {
			// Check all of the donation forms.
			foreach ( $donation_forms as $form ) {
				// Get the donation Form ID.
				$form_id = $form->ID;

				// Get currency switcher status.
				$is_enable = give_get_meta( $form_id, 'cs_status', true );

				// Check if per form customizable.
				if ( give_cs_is_per_form_customized( $form_id ) && give_is_setting_enabled( $is_enable ) ) {
					// Get the exchange rates.
					$exchange_rate = cs_fetch_exchange_rates_from_api( $form_id, give_get_currency() );

					// If the option and the schedule interval both are same.
					if ( ! empty( $exchange_rate['rates'] ) ) {
						// Get old exchange rates.
						$saved_rates = give_cs_get_form_exchange_rates( $form_id );

						if ( ! empty( $saved_rates ) ) {

							// Go through the previously saved exchange rates.
							foreach ( $saved_rates as $currency_code => $exchange ) {
								if (
									isset( $exchange_rate['rates'][ $currency_code ] )
									&& $exchange['exchange_rate'] !== $exchange_rate['rates'][ $currency_code ]
									&& ! isset( $exchange['set_manually'] )
									&& false !== $exchange_rate['rates'][ $currency_code ]
									&& ! empty( $exchange_rate['rates'][ $currency_code ] )
								) {
									$saved_rates[ $currency_code ]['exchange_rate'] = $exchange_rate['rates'][ $currency_code ];
								}
							}
						}

						// Save updated exchange rates data.
						give_update_meta( $form_id, 'cs_exchange_rates', $saved_rates );
					}
				}
			}
		}
	}

	/**
	 * Get schedules.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function get_schedules() {
		$schedules = array(
			'hourly'     => __( 'Once Hourly', 'give-currency-switcher' ),
			'twicedaily' => __( 'Twice Daily', 'give-currency-switcher' ),
			'daily'      => __( 'Once Daily', 'give-currency-switcher' ),
			'weekly'     => __( 'Once Weekly', 'give-currency-switcher' ),
		);

		/**
		 * Filter the schedules
		 *
		 * @since 1.2.2
		 */
		return  apply_filters( 'give_cs_cron_schedules', $schedules );
	}
}

