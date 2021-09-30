<?php
/**
 * Give Zapier Helpers functions
 *
 * @package     Give
 * @copyright   Copyright (c) 2018, GiveWP
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Maybe Send Sample Data
 */
function give_zapier_maybe_send_sample_data() {

	if ( ! isset( $_GET['give_zapier'] ) || ! isset( $_GET['_wpnonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'give-zapier-test' ) ) {
		return;
	}

	Give_Zapier_Connection::sample_data_push( $_GET['give_zapier'] );

}

add_action( 'admin_init', 'give_zapier_maybe_send_sample_data' );


/**
 * Get Give API URL
 *
 * The API url changes in 1.8 - this helps prevent the link from breaking.
 *
 * @return string
 */
function give_zapier_get_api_url() {
	return admin_url( 'edit.php?post_type=give_forms&page=give-tools&tab=api' );
}

/**
 * Zapier payment testing data that is being send when donation button is click.
 *
 * @since 2.1
 *
 * @return array $data Dummy Donation details.
 */
function give_zapier_testing_data_for_payment() {

	return array(
		'ID'             => 2345,
		'transaction_id' => 'test12345',
		'key'            => 'ca2aaaa2a9e9e5369b8280403431b6fd',
		'total'          => '23.5',
		'status'         => 'Complete',
		'gateway'        => 'manual',
		'name'           => 'John Doe',
		'fname'          => 'John',
		'lname'          => 'Doe',
		'email'          => 'johndoe123@test.com',
		'date'           => date( 'Y-m-d h:i:s' ),
		'payment_meta'   => array(
			'_give_payment_currency'         => 'USD',
			'_give_donor_billing_first_name' => 'John',
			'_give_donor_billing_last_name'  => 'Doe',
			'_give_donor_billing_address1'   => '123 Elm Street',
			'_give_donor_billing_address2'   => 'Unit 201',
			'_give_donor_billing_city'       => 'San Diego',
			'_give_donor_billing_state'      => 'CA',
			'_give_donor_billing_zip'        => '92101',
			'_give_donor_billing_country'    => 'US',
			'_give_payment_gateway'          => 'manual',
			'_give_payment_form_title'       => 'Name of Donation Form',
			'_give_payment_form_id'          => '8',
			'_give_payment_price_id'         => '0',
			'_give_payment_donor_email'      => 'johndoe123@test.com',
			'_give_payment_donor_ip'         => '49.33.254.126',
			'_give_payment_purchase_key'     => 'ca2aaaa2a9e9e5369b8280403431b6fd',
			'_give_payment_mode'             => 'test',
			'_give_payment_donor_id'         => '14',
			'_give_payment_total'            => '23.5',
			'_give_current_url'              => 'http=>\/\/givewp.com',
			'_give_current_page_id'          => '65',
			'give_last_paypal_ipn_received'  => '1522275985',
			'_give_payment_transaction_id'   => 'test12345',
			'_give_completed_date'           => date( 'Y-m-d h:i:s' ),
		),
		'form'           => array(
			'id'         => 8,
			'name'       => 'Name of Donation Form',
			'price'      => '50.00',
			'price_name' => 'Name of Donation Level',
			'price_id'   => '0',
		),

		'billing_address' => array(
			'line1'   => '123 Elm Street',
			'line2'   => 'Unit 201',
			'city'    => 'San Diego',
			'country' => 'US',
			'state'   => 'CA',
			'zip'     => '92101',
		),
		'metadata'        => array(
			'field_id'   => 'Field value',
			'field_id_2' => 'Second field value',
		),
	);
}


/**
 * Check if anyone editting donation history
 *
 * @return bool
 * @since 1.3.0
 */
function give_zapier_is_editing_donation() {
	return doing_action( 'give_update_payment_details' );
}
