<?php
/**
 * Give Zapier Subscription Hooks.
 *
 * @package     Give
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Subscribe and Unsubscribe API endpoints for Zapier.
 *
 * @since  1.0
 *
 * @param  array $query_modes Valid API endpoints.
 *
 * @return array              Updated API endpoints.
 */
function give_zapier_query_modes( $query_modes = array() ) {
	$new_modes = array(
		'zapier-test',
		'zapier-subscribe',
		'zapier-unsubscribe',
	);

	return array_merge( $query_modes, $new_modes );
}

add_filter( 'give_api_valid_query_modes', 'give_zapier_query_modes' );

/**
 * Modify API output based on API endpoint.
 *
 * @since  1.0
 *
 * @param  mixed  $data       Output data.
 * @param  string $query_mode Current API endpoint.
 *
 * @return array              Response data.
 */
function give_zapier_output_data( $data = '', $query_mode = '' ) {

	switch ( $query_mode ) {
		case 'zapier-test' :
			break;
		case 'zapier-subscribe' :
			$data = array( 'id' => Give_Zapier_Subscription_Factory::maybe_add_subscription() );
			break;
		case 'zapier-unsubscribe' :
			$data = array( 'unsubscribed' => Give_Zapier_Subscription_Factory::delete_subscription() );
			break;
		default :
			break;
	}

	return $data;
}

add_filter( 'give_api_output_data', 'give_zapier_output_data', 10, 2 );

/**
 * Ping all Zapier subscriptions when payment status changes.
 *
 * @since 1.0
 * @since 1.3.0 update hook to capture donation status change efficiently
 * @since 1.3.2 update logic to handle donation status label because give_zapier_get_donation_data returns status label instead of id
 *
 * @param string  $new_status New payment status.
 * @param string  $old_status Previous payment status.
 * @param WP_Post $payment    Payment post object.
 *
 */
function give_zapier_update_payment_status( $new_status, $old_status, $payment ) {
	$donation_data    = give_zapier_get_donation_data( $payment->ID );

	// Bailout: exit if status update to something meanwhile.
	if( $new_status !== $donation_data['status_id'] ){
		return;
	}

	$whitelist = array_keys( give_get_payment_statuses() );
	if ( $new_status !== $old_status && in_array( $new_status, $whitelist, true ) ) {

		if ( 'publish' === $new_status ) {
			$new_status = 'new';
		}

		Give_Zapier_Connection::push_and_scrub( "give_{$new_status}_donation", $donation_data );
	}
}


/**
 * Schedule cron job to ping all Zapier subscriptions when payment status changes.
 *
 * @param  string  $new_status
 * @param  string  $old_status
 * @param  WP_Post  $payment
 *
 * @since 1.3.0
 *
 */
function give_zapier_update_payment_status_event( $new_status, $old_status, $payment ) {
	// Bailout.
	if ( 'give_payment' !== $payment->post_type || $new_status === $old_status ) {
		return;
	}

	// Delete status zapier hook lock to trigger again.
	if( give_zapier_is_editing_donation() ) {
		Give()->payment_meta->delete_meta($payment->ID, Give_Zapier_Integration::$background_process->get_donation_lock_key($new_status));
		Give()->payment_meta->delete_meta( $payment->ID, Give_Zapier_Integration::$background_process->get_donation_lock_key($old_status));
	}

	Give_Zapier_Connection::maybe_log_event(
		sprintf(
			'Add %1$s to zap batch',
			$payment->ID
		),
		[
			'Transition donation status' => "{$old_status} to {$new_status}",
			'Donation data'     => $payment,
		]
	);

	Give_Zapier_Integration::$background_process
		->set_donation_id( $payment->ID )
		->push_to_queue( array( $new_status, $old_status, $payment ) )
		->save();
}

add_action( 'transition_post_status', 'give_zapier_update_payment_status_event', 10, 3 );

// Keeping this for backward compatibility.
add_action( 'give_zapier_transition_post_status', 'give_zapier_update_payment_status', 10, 3 );

/**
 * Ping all Zapier subscriptions when a payment is deleted.
 *
 * @since  1.0
 *
 * @param  integer $payment_id Payment post ID.
 */
function give_zapier_payment_delete( $payment_id = 0 ) {
	$donation_data = give_zapier_get_donation_data( $payment_id );
	Give_Zapier_Connection::push_and_scrub( 'give_delete_donation', $donation_data );
}

add_action( 'give_payment_delete', 'give_zapier_payment_delete' );

/**
 * Ping all Zapier subscriptions with new donor data.
 *
 * @since  1.0
 *
 * @param  integer $donor_id Donor ID.
 * @param  array   $data     Donor data.
 */
function give_zapier_new_donor( $donor_id = 0, $data = array() ) {
	$donor_data = give_zapier_get_donor_data( $donor_id );
	Give_Zapier_Connection::push_and_scrub( 'give_new_donor', $donor_data );
}

add_action( 'give_post_insert_donor', 'give_zapier_new_donor', 10, 2 );


/**
 * Ping all Zapier subscriptions with updated donor data.
 *
 * @since  1.1
 *
 * @param  bool  $updated  If the donor has been updated.
 * @param  int   $donor_id Customer ID.
 * @param  array $args     Customer data.
 */
function give_zapier_updated_donor( $updated = false, $donor_id = 0, $args = array() ) {

	if ( ! $updated ) {
		return;
	}

	$donor_data = give_zapier_get_donor_data( $donor_id );
	Give_Zapier_Connection::push_and_scrub( 'give_updated_donor', $donor_data );
}

add_action( 'give_donor_post_update', 'give_zapier_updated_donor', 10, 3 );

/**
 * Get Donor Data for API.
 *
 * Takes the customer object and matches the Give API JSON object array.
 *
 * @param int $donor_id
 *
 * @return array $donor_data
 */
function give_zapier_get_donor_data( $donor_id ) {

	$donor     = new Give_Zapier_Customer( $donor_id );
	$user_data = get_userdata( $donor->user_id );

	$donor->purchase_value = intval( $donor->purchase_value );
	$total_spent           = ! empty( $donor->purchase_value ) ? $donor->purchase_value : ( isset( $_POST['give-amount'] ) ? $_POST['give-amount'] : '' );
	$donation_count        = ! empty( $donor->purchase_count ) ? $donor->purchase_count : 1;

	$donor_data = array(
		'info'  => array(
			'user_id'      => $donor->user_id,
			'customer_id'  => $donor->id,
			'username'     => ! empty( $user_data->user_login ) ? $user_data->user_login : '',
			'display_name' => ! empty( $user_data->display_name ) ? $user_data->display_name : '',
			'first_name'   => $donor->get_first_name(),
			'last_name'    => $donor->get_last_name(),
			'email'        => $donor->email,
		),
		'stats' => array(
			'total_spent'     => $total_spent,
			'total_donations' => $donation_count,
		),
	);

	return $donor_data;

}

/**
 * Get relevant data for a given completed donation.
 *
 * @since 1.0
 * @since 1.3.2 Set donation status value to status label instead of id
 *
 * @param  integer $payment_id Payment post ID.
 *
 * @return array               Order data.
 */
function give_zapier_get_donation_data( $payment_id = 0 ) {

	$donation_data = array();
	$payment       = new Give_Payment( $payment_id );
	$payment_meta  = $payment->get_meta();
	$user_info     = $payment->user_info;
	$first_name    = isset( $user_info['first_name'] ) ? $user_info['first_name'] : '';
	$last_name     = isset( $user_info['last_name'] ) ? $user_info['last_name'] : '';

	$empty_address = array(
		'line1'   => '',
		'line2'   => '',
		'city'    => '',
		'country' => '',
		'state'   => '',
		'zip'     => '',
	);

	$donation_data['ID']             = $payment_id;
	$donation_data['transaction_id'] = $payment->transaction_id;
	$donation_data['key']            = $payment->key;
	$donation_data['total']          = ! empty( $payment->total ) ? give_maybe_sanitize_amount( $payment->total ) : give_donation_amount( $payment_id );
	$donation_data['status_id']      = $payment->status;
	$donation_data['status']         = give_get_payment_status( $payment->ID, true );
	$donation_data['gateway']        = $payment->gateway;
	$donation_data['name']           = $first_name . ' ' . $last_name;
	$donation_data['fname']          = $first_name;
	$donation_data['lname']          = $last_name;
	$donation_data['email']          = $payment->email;
	$donation_data['date']           = get_the_time( 'Y-m-d H:i:s', $payment_id );
	$donation_data['payment_meta']   = give_zapier_get_donation_metadata( false, $payment_meta );

	$form_id    = isset( $payment->form_id ) ? $payment->form_id : $payment_meta;
	$price      = isset( $payment->form_id ) ? give_get_form_price( $payment->form_id ) : false;
	$price_id   = isset( $payment->price_id ) ? $payment->price_id : null;
	$price_name = '';

	$donation_data['form']['id']    = $payment->form_id;
	$donation_data['form']['name']  = $payment->form_title;
	$donation_data['form']['price'] = $price;

	if ( give_has_variable_prices( $payment->form_id ) ) {
		$price_name                     = give_get_price_option_name( $form_id, $price_id, $payment->ID );
		$donation_data['form']['price'] = give_get_price_option_amount( $form_id, $price_id );
	}

	$donation_data['form']['price_id']   = $price_id;
	$donation_data['form']['price_name'] = $price_name;

	$donation_data['billing_address'] = ! empty( $user_info['address'] ) ? $user_info['address'] : $empty_address;

	/**
	 * Filter to update Donation data that is being sent via Zapier API.
	 *
	 * @since 1.0
	 *
	 * @param array $donation_data Donation Data
	 *
	 * @return array $donation_data Donation Data
	 */
	return (array) apply_filters( 'give_zapier_donation_data', $donation_data );
}

/**
 * Retrieve an array of all custom metadata on a payment.
 *
 * @since  1.1
 *
 * @param  integer|bool $payment_id Payment post ID.
 * @param  array $meta_data Meta Data related to Donations.
 *
 * @return array               Metadata
 */
function give_zapier_get_donation_metadata( $payment_id = false, $meta_data = array() ) {
	$meta = array();

	if ( ! empty( $payment_id ) ) {
		$payment   = new Give_Payment( $payment_id );
		$meta_data = $payment->get_meta();
	}

	// Add custom meta to API
	foreach ( $meta_data as $meta_key => $meta_value ) {

		$exceptions = array(
			'form_title',
			'form_id',
			'price_id',
			'user_info',
			'key',
			'email',
			'date',
		);

		// Don't clutter up results with dupes.
		if ( in_array( $meta_key, $exceptions ) ) {
			continue;
		}
		$meta[ $meta_key ] = $meta_value;
	}

	return $meta;
}
