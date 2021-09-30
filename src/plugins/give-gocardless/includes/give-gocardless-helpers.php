<?php
/**
 * All functions related to gateway handler are here.
 *
 * @since  1.0.0
 * @author GiveWP
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register GoCardless it's own init hook.
 *
 * @since  1.0.0
 */
function give_gocardless_init_func() {

	/**
	 * Call GoCardless Init function.
	 *
	 * @since  1.0.0
	 */
	do_action( 'give_gocardless_init' );
}

add_action( 'init', 'give_gocardless_init_func', 10 );


/**
 * Get the values from backend settings.
 *
 * @param   string $option_key Pass give option key.
 * @param   bool   $default    default value
 *
 * @since   1.0.0
 *
 * @return string|array Gocardless setting data.
 */
function give_get_gocardless_setting( $option_key, $default = false ) {

	// Return value from give setting.
	return give_get_option( $option_key, $default );
}

/**
 * Manage fields on frontend.
 *
 * @since   1.0.0
 */
function give_gocardless_frontend_fields() {

	// GoCardless does not need a CC form, so remove it.
	add_action( 'give_' . GIVE_GOCARDLESS_GATEWAY_SLUG . '_cc_form', '__return_false' );

	$go_cardless_setting = give_get_gocardless_setting( 'gocardless_billing_details' );

	// Retrieve the value from 'gocardless_billing_details' option.
	$show_billing_details = give_is_setting_enabled( $go_cardless_setting );

	if ( $show_billing_details ) {

		// Add Billing address section after the Personal Info. section.
		add_action( 'give_' . GIVE_GOCARDLESS_GATEWAY_SLUG . '_cc_form', 'give_default_cc_address_fields' );
	}
}

// Bind the GoCardless front end fields.
add_action( 'give_gocardless_init', 'give_gocardless_frontend_fields' );

// Register GoCardless Payment handler hooks.
add_action( 'give_gateway_' . GIVE_GOCARDLESS_GATEWAY_SLUG, array( 'Give_GoCardless_Gateway', 'process_payment' ) );

/**
 * Get description to be send to GoCardless form order.
 *
 * @param int        $payment_id
 * @param string     $payment_type
 * @param null|array $subscription
 *
 * @return string|bool
 * @since 1.0.0
 *
 */
function gocardless_get_payment_description( $payment_id, $payment_type = 'single', $subscription = null ) {
	$description           = '';
	$price_id              = give_get_payment_meta( $payment_id, '_give_payment_price_id' );
	$form_id               = give_get_payment_form_id( $payment_id );

	switch ( $payment_type ) {
		case 'single':
			$form_title_with_level = get_the_title( $form_id );
			$description = sprintf( __( '%1$s One Time Donation', 'give-gocardless' ), give_donation_amount( $payment_id, true ) );

			// Check for multi-level.
			if (
				give_has_variable_prices( $form_id )
				&& is_numeric( $price_id )
				&& ( $price_level_title = give_get_price_option_name( $form_id, $price_id, $payment_id, false ) )
			) {
				$form_title_with_level .= " - {$price_level_title}";
			}

			$description = "{$form_title_with_level} - {$description}";

			break;
		case 'recurring':
			if ( ! isset( $subscription ) ) {
				return false;
			}

			// Description text for recurring payment.
			$description = give_recurring_generate_subscription_name( $form_id, $price_id );

			break;
	}

	/**
	 * Filter the description
	 *
	 * @since 1.3.3
	 */
	$description = apply_filters( 'gocardless_get_payment_description', $description, $payment_id, $payment_type, $subscription );

	// Truncate description due to 100 character GoCardless API limit.
	$description = strip_tags( $description );
	$description = html_entity_decode( trim( $description ), ENT_NOQUOTES, 'UTF-8' );
	$description = strlen( $description ) > 100 ? substr( $description, 0, 96 ) . '...' : $description;

	return $description;
}


/**
 * Get the currency sign by it's character.
 *
 * @since 1.0.0
 *
 * @param string $currency_char Pass the payment
 *
 * @return string|bool
 */
function gocardless_get_currency_sign( $currency_char ) {

	$currency_sign = '';

	if ( ! $currency_char ) {
		return false;
	}

	switch ( $currency_char ) {
		case 'EUR':
			$currency_sign = '€';
			break;
		case 'GBP':
			$currency_sign = '£';
			break;
		case 'SEK':
			$currency_sign = 'kr';
			break;
		case 'DKK':
			$currency_sign = 'kr';
			break;
		case 'AUD':
			$currency_sign = '$';
			break;
		case 'CAD':
			$currency_sign = '$';
			break;
	}

	return $currency_sign;
}


/**
 * Convert Gocardless Subscription interval unit into GiveWP format.
 *
 * @since 1.0.0
 *
 * @param string $unit Pass GoCardless interval unit.
 *
 * @return string  Get converted interval unit.
 */
function gocardless_convert_interval_unit( $unit = '' ) {

	$period = array(
		'weekly'  => 'week',
		'monthly' => 'month',
		'yearly'  => 'year',
		'week'    => 'weekly',
		'month'   => 'monthly',
		'year'    => 'yearly',
	);
	if ( ! isset( $period[ $unit ] ) ) {
		return false;
	}

	return $period[ $unit ];
}

/**
 * Set notice for GoCardless donation.
 *
 * @since 1.0.0
 *
 * @param string $notice      HTML markup for the default notice.
 * @param int    $id          Post ID where the notice is displayed.
 * @param string $status      Payment status.
 * @param int    $donation_id Donation ID.
 *
 * @return string Payment completion notice.
 */
function gocardless_receipt_status_notice( $notice, $id, $status, $donation_id ) {

	// Return default notice if not GoCardless.
	if (
		GIVE_GOCARDLESS_GATEWAY_SLUG !== give_get_payment_gateway( $donation_id )
		|| ! in_array( $status, array( 'processing', 'pending' ) )
	) {
		return $notice;
	}

	$message = Give()->notices->print_frontend_notice( __( 'Payment Processing: Direct debit payments typically will reach your account after 5 working days. Thank you for your donation!', 'give-gocardless' ), false, 'success' );

	return $message;
}

// Registering the payment notice when payment has been created successfully.
add_filter( 'give_receipt_status_notice', 'gocardless_receipt_status_notice', 10, 4 );

/**
 * GoCardless requires last name value.
 *
 * Set last name field required if payment gateway is GoCardless.
 *
 * @param array $required_fields All required fields.
 * @param int   $form_id         Donation form id.
 *
 * @return array
 */
function give_gocardless_required_lastname( $required_fields, $form_id ) {

	// Get the payment method details.
	$payment_mode = give_get_chosen_gateway( $form_id );

	// Make the last name required if payment gateway is gocardless.
	if ( 'gocardless' === $payment_mode ) {
		$required_fields['give_last'] = array(
			'error_id'      => 'invalid_last_name',
			'error_message' => __( 'Please enter your last name.', 'give-gocardless' ),
		);
	}

	return $required_fields;
}

add_filter( 'give_donation_form_required_fields', 'give_gocardless_required_lastname', 10, 2 );

/**
 * Append last name error message to givewp error.
 *
 * Adding the error message for the gocardless last name field.
 *
 * @since 1.0.0
 *
 * @param array $validation_messages
 *
 * @return array $validation_messages
 */
function give_gocardless_lastname_script_error( $validation_messages ) {
	$validation_messages['give_last'] = __( 'Please enter your last name.', 'give-gocardless' );

	return $validation_messages;
}

add_filter( 'give_form_translation_js', 'give_gocardless_lastname_script_error', 10 );
