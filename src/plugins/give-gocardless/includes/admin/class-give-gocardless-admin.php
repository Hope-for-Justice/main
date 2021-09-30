<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://givewp.com
 * @since      1.0.0
 *
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/includes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Give_Gocardless
 * @subpackage Give_Gocardless/includes/admin
 * @author     GiveWP
 */
class Give_Gocardless_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 */
	public function __construct() {

		// Registering GoCardless gateway with give.
		add_filter( 'give_payment_gateways', array( $this, 'register_gateway' ) );

		// Enqueue script and styles in admin side.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Add GoCardless setting's page.
		add_action( 'give_get_settings_gateways', array( $this, 'add_settings' ) );
		add_action( 'give_get_sections_gateways', array( $this, 'add_section' ) );

		// Adding GoCardless auth button into Give WP setting API.
		add_action( 'give_admin_field_gocardless_auth_button', array(
			$this,
			'auth_button_gateway_setting_api',
		), 10, 2 );

		// Creating GoCardless payment link.
		add_filter(
			'give_payment_details_transaction_id-' . GIVE_GOCARDLESS_GATEWAY_SLUG, array(
			$this,
			'dynamic_donation_link',
		), 10, 2 );

		// Displays the available schemes from the customer's account
		add_action( 'give_admin_field_gocardless_schemes', array( $this, 'display_available_shemes' ), 10, 2 );

		// Add custom js on payment details page in admin.
		add_action( 'give_view_donation_details_before', array( $this, 'admin_payment_js' ), 100, 1 );

		// Append refund link on payment detail's page in admin.
		add_action(
			'give_view_donation_details_payment_meta_before', array(
			$this,
			'additional_donation_meta',
		), 10, 1
		);

		// Add custom js on subscription details page.
		add_action( 'give_subscription_card_top', array( $this, 'admin_subscription_payment_js' ), 100, 1 );

		// Registering new post status 'Processing'.
		add_action( 'wp_loaded', array( $this, 'register_post_statuses' ) );

		// Register 'processing' status to givewp.
		add_action( 'give_payment_statuses', array( $this, 'register_custom_statuses' ), 10, 1 );

		// View link to view 'processing' payment.
		add_action( 'give_payments_table_views', array( $this, 'add_custom_tableview' ), 10, 1 );

		// Add new action 'processing' in bulk action list.
		add_action( 'give_payments_table_bulk_actions', array( $this, 'custom_payment_bulk_actions' ), 10, 1 );

		// Handle 'processing' bulk action post request.
		add_action( 'give_payments_table_do_bulk_action', array( $this, 'process_custom_bulk_action' ), 10, 2 );

		// Show admin notice.
		add_action( 'admin_notices', array( $this, 'minimum_recurring_version_notice' ) );
	}

	/**
	 * Processes the bulk actions.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param $id
	 * @param $current_action
	 */
	public function process_custom_bulk_action( $id, $current_action ) {
		switch ( $current_action ) {
			case 'set-status-processing':
				give_update_payment_status( $id, 'processing' );
				break;
		}
	}

	/**
	 * Adds bulk options to select drop-down.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param array $actions
	 *
	 * @return array $actions
	 */
	public function custom_payment_bulk_actions( $actions ) {
		$actions['set-status-processing'] = __( 'Set To Processing', 'give-gocardless' );

		return $actions;
	}

	/**
	 * Register new post status 'Processing' for payments.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function register_post_statuses() {
		register_post_status( 'processing', array(
			'label'                     => __( 'Processing', 'give-gocardless' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Processing<span class="count">(%s)</span>', 'Processing <span class="count">(%s)</span>', 'give-gocardless' ),
		) );
	}

	/**
	 * Register Custom Statuses for Give to interpret.
	 * Tells Give about our new payment status.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param  array $status Array of payment status.
	 *
	 * @return array
	 */
	public function register_custom_statuses( $status ) {
		$status['processing'] = __( 'Processing', 'give-gocardless' );

		return $status;
	}

	/**
	 * Add filter options under to the Give donations table.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param $views
	 *
	 * @return mixed
	 */
	public function add_custom_tableview( $views ) {
		$current          = isset( $_GET['status'] ) ? $_GET['status'] : '';
		$payment_count    = wp_count_posts( 'give_payment' );
		$empty            = '&nbsp;<span class="count">(0)</span>';
		$processing_count = isset( $payment_count->processing ) ? '&nbsp;<span class="count">(' . $payment_count->processing . ')</span>' : $empty;

		$views['processing'] = sprintf( '<a href="%s"%s>%s</a>', esc_url( add_query_arg( array(
			'status' => 'processing',
			'paged'  => false,
		) ) ), $current === 'processing' ? ' class="current"' : '', __( 'Processing', 'give-gocardless' ) . $processing_count );

		return $views;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_styles() {
		if ( give_is_admin_page() ) {
			wp_register_style( 'gocardless-admin', GIVE_GOCARDLESS_PLUGIN_URL . 'assets/css/give-gocardless-admin.css', array(), GIVE_GOCARDLESS_VERSION, 'all' );
			wp_enqueue_style( 'gocardless-admin' );
		}

	}

	/**
	 * Add the input field when change the payment status drop-down on payment details page
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param int $payment_id
	 */
	public function admin_payment_js( $payment_id = 0 ) {

		if ( GIVE_GOCARDLESS_GATEWAY_SLUG !== give_get_payment_gateway( $payment_id ) ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( 'select[name=give-payment-status]' ).change( function() {
					$( '.give-gocardless-refund' ).remove();
					$( '#give_cancellation_in_gocardless' ).remove();
					if ( 'refunded' === $( this ).val() ) {
						$( this ).parent().parent().append( '<p class="give-gocardless-refund"><input type="checkbox" id="give_refund_in_gocardless" name="give_refund_in_gocardless" value="1"/><label for="give_refund_in_gocardless"><?php esc_html_e( 'Refund Charge in GoCardless?', 'give-gocardless' ); ?></label></p>' );
					} else if ( 'cancelled' === $( this ).val() ) {
						$( this ).parent().parent().append( '<input type="hidden" id="give_cancellation_in_gocardless" name="give_cancellation_in_gocardless" value="1"/>' );
					}
				} );
			} );
		</script>
		<?php
	}

	/**
	 * Adding the checkbox below cancel and expire on subscription page.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param Give_Subscription $subscription subscription data.
	 */
	public function admin_subscription_payment_js( $subscription ) {

		if ( GIVE_GOCARDLESS_GATEWAY_SLUG !== $subscription->gateway ) {
			return;
		}
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$( 'select#subscription_status' ).change( function() {
					$( 'p.give-gocardless-cancel' ).remove();
					if ( 'cancelled' === $( this ).val() || 'expired' === $( this ).val() ) {
						$( this ).closest( 'td' ).append( '<p class="give-gocardless-cancel"><input type="checkbox" id="cancel_in_gocardless" name="cancel_in_gocardless"/><label for="cancel_in_gocardless"><?php esc_html_e( ' Cancel in GoCardless?', 'give-gocardless' ); ?></label></p>' );
					}
				} );
			} );
		</script>
		<?php
	}


	/**
	 * Add setting section.
	 *
	 * @since 1.0.0
	 *
	 * @param array $sections Array of section.
	 *
	 * @return array
	 */
	public function add_section( $sections ) {
		$sections['gocardless'] = __( 'GoCardless', 'give-gocardless' );

		return $sections;
	}

	/**
	 * Register the gateway settings API.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $settings Gateway setting array.
	 *
	 * @return  array Get the settings fields of GoCardless settings.
	 */
	public function add_settings( $settings ) {
		$current_section = give_get_current_setting_section();

		if ( 'gocardless' !== $current_section ) {
			return $settings;
		}

		return array(
			array(
				'id'   => 'give_gocardless_admin_settings',
				'type' => 'title',
			),
			array(
				'name' => __( 'Connect / Disconnect', 'give-gocardless' ),
				'desc' => $this->sandbox_auth_desc(),
				'id'   => 'gocardless_collect_billing',
				'type' => 'gocardless_auth_button',
			),
			array(
				'name' => __( 'Webhook Secret', 'give-gocardless' ),
				'desc' => sprintf(
					'%1$s <code>%2$s?give-listener=gocardless</code> %3$s <a href="%4$s" target="_blank">%5$s</a> %6$s',
					__( 'Webhooks are required so that your website can communicate with GoCardless. To receive webhooks, add', 'give-gocardless' ),
					trailingslashit( site_url() ),
					__( 'as the webhook URL', 'give-gocardless' ),
					self::get_webhook_secret_url(),
					__( 'here', 'give-gocardless' ),
					__( 'and then copy the Webhook Secret into the field above.', 'give-gocardless' )
				),
				'id'   => 'gocardless_webhook_secret',
				'type' => 'text',
			),
			array(
				'id'      => 'direct_debit_scheme',
				'name'    => __( 'Direct Debit Scheme', 'give-gocardless' ),
				'desc'    => sprintf(
					'%1$s <a target="_blank" href="%2$s">%3$s</a> %4$s',
					__( 'The Direct Debit scheme of the mandate. See', 'give-gocardless' ),
					esc_url( 'https://developer.gocardless.com/api-reference/2015-07-06/#overview-supported-direct-debit-schemes' ),
					__( 'this page', 'give-gocardless' ),
					__( 'for  scheme and its supported countries. If Autogiro, Bacs, SEPA Core, or SEPA COR1 is specified, the payment pages will only allow the set-up of a mandate for the specified scheme. If auto detect is specified, failed validation may occur in case currency in the order is not supported by the scheme.', 'give-gocardless' )
				),
				'type'    => 'select',
				'default' => '',
				'options' => array(
					''          => __( 'Automatically detected from the customer\'s bank account', 'give-gocardless' ),
					'autogiro'  => __( 'Autogiro', 'give-gocardless' ),
					'bacs'      => __( 'Bacs', 'give-gocardless' ),
					'sepa_core' => __( 'SEPA Core', 'give-gocardless' ),
					'sepa_cor1' => __( 'SEPA COR1', 'give-gocardless' ),
				),
			),
			array(
				'name' => __( 'Available Schemes', 'give-gocardless' ),
				'desc' => __( 'The following Debit Schemes are enabled in your GoCardless account.', 'give-gocardless' ),
				'id'   => 'gocardless_available_schemes',
				'type' => 'gocardless_schemes',
			),
			array(
				'name'        => __( 'Collect Billing Details', 'give-gocardless' ),
				'id'          => 'gocardless_billing_details',
				'type'        => 'radio_inline',
				'options'     => array(
					'enabled'  => __( 'Enabled', 'give-gocardless' ),
					'disabled' => __( 'Disabled', 'give-gocardless' ),
				),
				'default'     => 'disabled',
				'description' => __( 'This option will enable the billing details section for GoCardless which requires the donor\'s address to complete the donation. These fields are not required by GoCardless to process the transaction, but you may have the need to collect the data.', 'give-gocardless' ),
			),
			array(
				'name'  => __( 'Give GoCardless Gateway Settings Docs Link', 'give-gocardless' ),
				'url'   => esc_url( 'https://givewp.com/documentation/add-ons/gocardless-gateway/' ),
				'title' => __( 'Give GoCardless Gateway Settings', 'give-gocardless' ),
				'type'  => 'give_docs_link',
			),
			array(
				'id'   => 'give_gocardless_admin_settings',
				'type' => 'sectionend',
			),
		);
	}

	/**
	 * Display Recurring Add-on Update Notice.
	 *
	 * @since 1.2.1
	 */
	public function minimum_recurring_version_notice() {

		if (
			defined( 'GIVE_RECURRING_PLUGIN_BASENAME' )
			&& is_plugin_active( GIVE_RECURRING_PLUGIN_BASENAME )
			&& version_compare( GIVE_RECURRING_VERSION, '1.7.2', '<' )
		) {

			Give()->notices->register_notice( array(
				'id'          => 'give-gocardless-require-minimum-recurring-version',
				'type'        => 'error',
				'dismissible' => false,
				'description' => sprintf( '%1$s <strong>%2$s</strong> %3$s',
					__( 'Please update the', 'give-gocardless' ),
					__( 'Give Recurring Donations', 'give-gocardless' ),
					__( 'add-on to version 1.7.2+ to be compatible with the latest version of the GoCardless payment gateway.', 'give-gocardless' )
				),
			) );

		}
	}

	/**
	 * Get the GoCardless Authentication description with link.
	 *
	 * @since   1.0.0
	 * @access  protected
	 *
	 * @return  string $sandbox_url   Get the authentication URL with description of GoCardless sandbox.
	 */
	protected function sandbox_auth_desc() {

		$sandbox_url = '';

		// Show message if it is not connected with GoCardless.
		if ( ! $this->is_connected() ) {
			$sandbox_url = sprintf( '<a href="%1$s">%2$s</a>', $this->generate_connection_url( true ), __( 'Not ready to accept live payments? Click here to connect using sandbox mode.', 'give-gocardless' ) );
		}

		// Get sandbox url with description.
		return $sandbox_url;
	}

	/**
	 * Get disconnect URL.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @return  string Disconnect authentication URL with GoCardless API.
	 */
	public function get_disconnect_url() {
		return add_query_arg(
			array(
				'give_gocardless_disconnect'       => 'true',
				'give_gocardless_disconnect_nonce' => wp_create_nonce( 'give_disconnect_gocardless' ),
			), $this->get_setting_url()
		);
	}

	/**
	 * Get setting URL.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @return  string GoCardless Gateway setting page url.
	 */
	public function get_setting_url() {

		// Return GoCardless gateway setting page url.
		return admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=' . GIVE_GOCARDLESS_GATEWAY_SLUG );
	}

	/**
	 * Generate oAuth Connection URL.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   bool $sandbox
	 *
	 * @return  string  authentication URL with GoCardless.
	 */
	public function generate_connection_url( $sandbox = true ) {
		return $this->get_connect_url(
			array(
				'sandbox' => $sandbox,
			)
		);
	}

	/**
	 * Generate Authentication with GoCardless dynamically.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $args query args list for authentication url.
	 *
	 * @return  string  return complete authentication url with urls.
	 */
	public function get_connect_url( $args = array() ) {

		// Create argument list.
		$args = wp_parse_args(
			$args, array(
				'base_url' => GIVE_BASE_AUTH_URL,
				'sandbox'  => 0,
				'redirect' => '',
			)
		);

		// Bind args with gateway setting url
		if ( empty( $args['redirect'] ) ) {
			$args['redirect'] = add_query_arg(
				array(
					'give_gocardless_nonce' => wp_create_nonce( 'give_gocardless_nonce' ),
					'sandbox'               => $args['sandbox'] ? '1' : '0',
				), $this->get_setting_url()
			);
		}

		// Store Redirect URL.
		$args['redirect'] = urlencode( $args['redirect'] );

		$base_url = $args['base_url'];
		unset( $args['base_url'] );

		// Return complete authentication url for GoCardless.
		return add_query_arg( $args, $base_url );
	}

	/**
	 * It register GoCardless auth button by using GiveWP Setting API.
	 * Setting API.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   $value              array Pass various value from Setting api array.
	 * @param   $option_value       string Option value for button.
	 */
	public function auth_button_gateway_setting_api( $value, $option_value ) {

		// Check if connected or not.
		$is_connected = $this->is_connected();

		// Get the connected data from the database.
		$get_connected_data = Give_GoCardless_Gateway::get_gocardless_auth_data();
		?>
		<tr valign="top" <?php echo ! empty( $value['wrapper_class'] ) ? 'class="' . $value['wrapper_class'] . '"' : ''; ?>>
			<th scope="row" class="titledesc">
				<label for=""><?php echo Give_Admin_Settings::get_field_title( $value ); ?></label>
			</th>
			<td class="gocardless-auth" colspan="2">
				<?php

				if ( $is_connected ) {
					$connection_label = __( 'Disconnect from GoCardless ', 'give-gocardless' );

					if ( '1' == $get_connected_data['sandbox'] ) {
						$connection_label .= __( 'Sandbox', 'give-gocardless' );
					} else {
						$connection_label .= __( 'Live', 'give-gocardless' );
					}
				} else {
					$connection_label = __( 'Authenticate with GoCardless', 'give-gocardless' );
				}
				?>
				<a class="button-primary"
				   href="<?php echo ( $is_connected ) ? $this->get_disconnect_url() : $this->get_connect_url(); ?>"><?php echo $connection_label; ?> </a>
				<?php echo Give_Admin_Settings::get_field_description( $value ); ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Displays the available schemes from the admins account if connected.
	 *
	 * @since   1.3.0
	 * @access  public
	 *
	 * @param   $value              array Pass various value from Setting api array.
	 * @param   $option_value       string Option value for button.
	 *
	 * @return  false               if not connected.
	 */
	public function display_available_shemes( $value, $option_value ) {

		// Check if connected or not.
		$is_connected = $this->is_connected();

		/* @var WP_Error|$subscription_data Get Subscription data from GoCardless, IF exists. */
		$creditors = Give_GoCardless_API::get_creditors();

		// Must be connected to view schemes.
		if ( ! $is_connected || is_wp_error( $creditors ) ) {
			return false;
		}
		?>
		<tr valign="top" <?php echo ! empty( $value['wrapper_class'] ) ? 'class="' . $value['wrapper_class'] . '"' : ''; ?>>
			<th scope="row" class="titledesc">
				<label for=""><?php echo Give_Admin_Settings::get_field_title( $value ); ?></label>
			</th>
			<td class="gocardless-auth" colspan="2">
				<?php

				/**
				 * List creditors with their available schemes.
				 */
				if ( is_array( $creditors['creditors'] ) ) :
					?>

					<ul style="margin-top:6px;">

						<?php foreach ( $creditors['creditors'] as $creditor ) : ?>

							<li><strong><?php echo $creditor['name']; ?></strong></li>

							<?php if ( is_array( $creditor['scheme_identifiers'] ) ) : ?>

								<ol>
									<?php foreach ( $creditor['scheme_identifiers'] as $scheme ) : ?>

										<li>
											<?php _e( 'Creditor Name:', 'give-gocardless' ); ?>
											<strong><?php echo $scheme['name']; ?></strong><br>
											<?php _e( 'Scheme Name:', 'give-gocardless' ); ?>
											<strong><?php echo $scheme['scheme']; ?></strong><br>
											<?php _e( 'Creditor Currency:', 'give-gocardless' ); ?>
											<strong><?php echo $scheme['currency']; ?></strong>
										</li>

									<?php endforeach; ?>
								</ol>

							<?php endif; ?>

						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php echo Give_Admin_Settings::get_field_description( $value ); ?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Show GoCardless transaction ID instead of showing the donation ID in donation meta box.
	 *Available Schemes
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   int $transaction_id Transaction ID.
	 * @param   int $payment_id     Payment ID.
	 *
	 * @return  string      $payment_url    GoCardless payment url.
	 */
	public function dynamic_donation_link( $transaction_id, $payment_id ) {

		/* @var Give_Payment $payment_data Get payment data by id. */
		$payment_data = give_get_payment_by( 'id', $payment_id );

		if ( $transaction_id === $payment_data->key ) {
			return $transaction_id;
		}

		// Generate GoCardless payment url.
		$payments_url = ( 'test' === $payment_data->mode ) ? 'https://manage-sandbox.gocardless.com/payments' : 'https://manage.gocardless.com/payments';

		// GoCardless payment's url.
		$payment_url = '<a href="' . $payments_url . '/' . $transaction_id . '" target="_blank" > ' . $transaction_id . ' </a>';

		return $payment_url;
	}

	/**
	 * Get the URL so the user can generate the webhook URL.
	 *
	 * @return string
	 */
	public function get_webhook_secret_url() {

		$get_connected_data = Give_GoCardless_Gateway::get_gocardless_auth_data();

		if ( isset( $get_connected_data['sandbox'] ) && '1' == $get_connected_data['sandbox'] ) {
			$connection_label = 'https://manage-sandbox.gocardless.com/developers/webhook-endpoints/create';
		} else {
			$connection_label = 'https://manage.gocardless.com/developers/webhook-endpoints/create';
		}

		return apply_filters( 'give_get_gocardless_webhook_secret_url', $connection_label );

	}

	/**
	 * Generate and show the subscription and refunded payment link on payment details page.
	 * After the order details payment meta section.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param string $payment_id Refunded payment id.
	 *
	 * @return bool if payment data is blank then return false or print the refund or subscription ID.
	 */
	public function additional_donation_meta( $payment_id ) {

		// Get payment data by id.
		$payment_data = give_get_payment_by( 'id', $payment_id );

		if ( ! isset( $payment_data ) ) {
			return false;
		}

		// Get sandbox refund list URL.
		$refund_url = ( 'test' === $payment_data->mode ) ? 'https://manage-sandbox.gocardless.com/refunds' : 'https://manage.gocardless.com/refunds';

		// Get sandbox refund list URL.
		$subscription_url = ( 'test' === $payment_data->mode ) ? 'https://manage-sandbox.gocardless.com/subscriptions' : 'https://manage.gocardless.com/subscriptions';

		// Check if Give Subscription plugin is installed or not.
		if ( class_exists( 'Give_Subscription' ) ) {

			// Get payment info.
			$payment = get_post( $payment_id );

			// Check if it is subscription payment or not.
			$is_sub = give_get_payment_meta( $payment_id, '_give_subscription_payment' );

			$transaction_gateway = give_get_payment_gateway( $payment_id );

			if ( ( $is_sub || ! empty( $payment->post_parent ) ) && GIVE_GOCARDLESS_GATEWAY_SLUG === $transaction_gateway ) {

				$subscription_payment_id = $payment_id;

				if ( $payment->post_parent ) {
					$subscription_payment_id = $payment->post_parent;
				}

				$subs_db = new Give_Subscriptions_DB();

				// Get subscription by payment id.
				$sub_id = $subs_db->get_column_by( 'id', 'parent_payment_id', $subscription_payment_id );

				$subscription_data = new Give_Subscription( $sub_id );
				?>
				<div class="give-subscription-id give-admin-box-inside">
					<p>
						<strong><?php esc_html_e( 'Subscription ID:', 'give-gocardless' ); ?></strong>&nbsp;
						<a href="<?php echo $subscription_url . '/' . $subscription_data->profile_id; ?>"
						   target="_blank"> <?php echo esc_html( $subscription_data->profile_id ); ?></a>
					</p>
				</div>
				<?php
			}
		}

		// Get GoCardless payment refunded id.
		$refund_id = Give_GoCardless_Gateway::get_payment_resource( $payment_id, 'refund', 'id' );

		if ( '' == $refund_id || ! isset( $refund_id ) ) {
			return false;
		}

		?>
		<div class="give-refunded-id give-admin-box-inside">
			<p>
				<strong><?php esc_html_e( 'Refund ID:', 'give-gocardless' ); ?></strong>&nbsp;
				<a href="<?php echo $refund_url . '/' . $refund_id; ?>"
				   target="_blank"> <?php echo esc_html( $refund_id ); ?></a>
			</p>
		</div>
		<?php return true;
	}

	/**
	 * Check whether we're connected with GoCardless app or not.
	 *
	 * @access  protected
	 * @since   1.0.0
	 *
	 * @return  bool|true     if access_token is available.
	 *          bool|false    if access_token is not available.
	 */
	protected function is_connected() {

		// Get the authentication setting of GoCardless.
		$auth_data = Give_GoCardless_Gateway::get_gocardless_auth_data();

		// Check whether there is action token is available or not.
		if ( isset( $auth_data['access_token'] ) && ! empty( $auth_data['access_token'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Register GoCardless gateway with Give WP.
	 *
	 * @since   1.0.0
	 * @access  public
	 *
	 * @param   array $gateways get the array of all registered gateways.
	 *
	 * @return  array $gateways return modified gateway array data.
	 */
	public function register_gateway( $gateways ) {

		// Check if GoCardless is authenticated or not.
		if ( $this->is_connected() ) {

			// Register the GoCardless Gateway values.
			$gateways['gocardless'] = array(
				'admin_label'    => __( 'GoCardless', 'give-gocardless' ),
				'checkout_label' => __( 'Direct Debit', 'give-gocardless' ),
			);
		}

		return $gateways;
	}

}
