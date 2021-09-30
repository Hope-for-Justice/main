<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://givewp.com
 * @since      1.0.0
 * @author     GiveWP
 *
 * @package    Give_Gocardless
 */

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Get Give core settings.
$give_settings = give_get_settings();

// List of plugin settings.
$plugin_settings = array(
	'give_title_gocardless',
	'gocardless_collect_billing',
	'gocardless_webhook_secret',
	'direct_debit_scheme',
	'gocardless_billing_details',
);

// Unset all plugin settings.
foreach ( $plugin_settings as $setting ) {
	if ( isset( $give_settings[ $setting ] ) ) {
		unset( $give_settings[ $setting ] );
	}
}

// Remove gocardless from active gateway list.
if ( isset( $give_settings['gateways']['gocardless'] ) ) {
	unset( $give_settings['gateways']['gocardless'] );
}

// Delete gocardless auth's related details.
delete_option( 'give_gocardless_settings' );

// Update settings.
update_option( 'give_settings', $give_settings );
