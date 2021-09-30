<?php
/**
 * Give Zapier Settings
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

if ( ! class_exists( 'Give_Settings_Zapier' ) ) {

	/**
	 * Give_Settings_Zapier.
	 *
	 * @since       2.0
	 */
	class Give_Settings_Zapier extends Give_Settings_Page {

		/**
		 * Flag to check if enable saving option for setting page or not
		 *
		 * @since       2.0
		 *
		 * @var bool
		 */
		protected $enable_save = true;

		/**
		 * Give_Settings_Zapier constructor.
		 *
		 * @since       2.0
		 */
		public function __construct() {

			$this->id          = 'zapier';
			$this->label       = __( 'Zapier', 'give-zapier' );
			$this->default_tab = 'zapier';

			add_action( 'give_admin_field_give_zapier_headline', array(
				$this,
				'give_render_give_zapier_heading',
			), 10 );

			add_action( 'give_admin_field_give_zapier_button', array(
				$this,
				'give_render_give_zapier_button',
			), 10 );

			parent::__construct();
		}

		/**
		 * Default setting tab.
		 *
		 * @param  $setting_tab
		 *
		 * @return string
		 * @since       2.0
		 *
		 */
		function set_default_setting_tab( $setting_tab ) {
			return 'zapier';
		}

		/**
		 * Get sections.
		 *
		 * @return array
		 * @since       2.0
		 *
		 */
		public function get_sections() {
			/**
			 * Filter the sections.
			 *
			 * @param  array sections setting
			 * @param  Give_Settings_Zapier instances of Give_Settings_Zapier.
			 *
			 * @return array sections setting
			 * @since       2.0
			 *
			 */
			return (array) apply_filters( 'give_zapier_get_sections', array(), $this );
		}

		/**
		 * Get settings array.
		 *
		 * @return array
		 * @since       2.0
		 *
		 */
		public function get_settings() {
			$settings = array();

			switch ( give_get_current_setting_section() ) {
				case 'zapier':

					$settings = array(
						// Section 1: Tribute Settings.
						array(
							'type' => 'title',
							'id'   => 'give_zapier_settings',
						),
						array(
							'name'          => esc_html__( 'Zapier Settings', 'give-zapier' ),
							'id'            => 'give_zapier_settings',
							'wrapper_class' => 'give-zapier-headline',
							'type'          => 'give_zapier_headline',
						),
						array(
							'ids'  => array(
								'give_new_donor'         => esc_html__( 'New Donor', 'give-zapier' ),
								'give_updated_donor'     => esc_html__( 'Updated Donor', 'give-zapier' ),
								'give_new_donation'      => esc_html__( 'New Donation', 'give-zapier' ),
								'give_delete_donation'   => esc_html__( 'Deleted Donation', 'give-zapier' ),
								'give_revoked_donation'  => esc_html__( 'Revoked Donation', 'give-zapier' ),
								'give_refunded_donation' => esc_html__( 'Refunded Donation', 'give-zapier' ),
								'give_failed_donation'   => esc_html__( 'Failed Donation', 'give-zapier' ),
								'give_pending_donation'  => esc_html__( 'Pending Donation', 'give-zapier' ),
							),
							'type' => 'give_zapier_button',
						),
						array(
							'name'    => __( 'Zapier Logging', 'give-zapier' ),
							'desc'    => __( 'Activate logging to help debug intermittent Zapier issues.',
								'give-zapier' ),
							'id'      => 'zapier_logging',
							'type'    => 'radio_inline',
							'default' => 'disabled',
							'options' => array(
								'enabled'  => __( 'Yes, Activate Logging', 'give-zapier' ),
								'disabled' => __( 'No, Deactivate Logging', 'give-zapier' ),
							),
						),
						array(
							'type' => 'sectionend',
							'id'   => 'give_zapier_settings',
						),
					);

			}// End switch().

			/**
			 * Filter the settings.
			 *
			 * @param  array  $settings
			 *
			 * @since       2.0
			 *
			 */
			$settings = apply_filters( 'give_settings_zapier', $settings );

			// Output.
			return $settings;
		}

		/**
		 * Render Zapier Buttons
		 *
		 * @param $value
		 *
		 * @since       2.0
		 *
		 */
		function give_render_give_zapier_button( $value ) {
			?>

			<tr valign="top" <?php echo ! empty( $value['wrapper_class'] ) ? 'class="' . $value['wrapper_class'] . '"' : '' ?>>
				<td class="give-zapier-triggers-td" colspan="2">
					<hr>
					<div class="give-zapier-triggers">
						<h3><?php esc_html_e( 'Testing Triggers:', 'give-zapier' ); ?></h3>
						<p><?php esc_html_e( 'Once you have setup triggers in Zapier you can use the buttons below to test their functionality. Click the buttons that corresponds with your triggers below to test:',
								'give-zapier' ); ?></p>

						<div class="give-zapier-trigger-btn-wrap">
							<?php
							echo '<ul>';

							// Output trigger buttons.
							foreach ( $value['ids'] as $key => $button_text ) {
								printf(
									'<li><a href="%1$s" class="button-secondary give-zapier-trigger-btn">%2$s</a></li>',
									wp_nonce_url( add_query_arg( array(
										'give_zapier' => $key,
									) ), 'give-zapier-test' ),
									$button_text
								);
							}

							echo '</ul>';
							?>
						</div>
						<p class="description"><?php esc_html_e( 'Note: testing will not work on localhost without a local tunnel configured. As well, if you are using Zapier\'s filters it may prevent tests from going through. In that case, test the functionality through test donations and donor updates.', 'give-zapier' ); ?></p>
                    </div>
				</td>
			</tr>
			<?php
		}


		/**
		 * Render Zapier Heading
		 *
		 * @param  array  $value  Pass various value from Setting api array.
		 *
		 * @since       2.0
		 *
		 */
		function give_render_give_zapier_heading( $value ) {

			$value['style']         = isset( $value['style'] ) ? $value['style'] : '';
			$value['wrapper_class'] = isset( $value['wrapper_class'] ) ? $value['wrapper_class'] : '';
			$value['type']          = isset( $value['type'] ) ? $value['type'] : 'text';
			$value['after_field']   = '';

			?>
			<tr valign="top" <?php echo ! empty( $value['wrapper_class'] ) ? 'class="' . $value['wrapper_class'] . '"' : '' ?>>
				<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_attr( $value['name'] ); ?></label>
				</th>
				<td class="give-zapier-intro-td" colspan="2">

					<div id="zapier-intro">
						<img src="<?php echo GIVE_ZAPIER_URL . 'assets/img/zapier-logo.png'; ?>"
							 class="give-zapier-logo">

						<div class="give-zapier-content">
							<p class="give-zapier-intro-p"><?php esc_html_e( 'Welcome to the Zapier Add-on for Give. This powerful Add-on lets you connect Give to more than 1,000+ third-party web services.', 'give-zapier' ); ?></p>
						</div>

						<div class="give-zapier-step-wrap">
							<div class="give-zapier-col give-zapier-left">
								<p class="give-zapier-title">Getting Started:</p>
								<ol class="give-zapier-steps">
									<li><a href="<?php echo give_zapier_get_api_url(); ?>"
										   target="_blank"><?php esc_html_e( 'Create a Give API Key', 'give-zapier' ); ?></a>
										-
										<em><?php esc_html_e( 'this allows Give to communicate with Zapier.', 'give-zapier' ); ?></em>
									</li>
									<li>
										<a href="https://zapier.com/developer/invite/24997/b6076987c71af5d4495daa2574ab6797/"
										   target="_blank"><?php esc_html_e( 'Connect to the Zapier Give App', 'give-zapier' ); ?></a>
										-
										<em><?php esc_html_e( 'this connects Zapier to your Website', 'give-zapier' ); ?></em>
									</li>
									<li><?php esc_html_e( 'Done - ', 'give-zapier' ); ?>
										<em><?php esc_html_e( 'It\'s time to create some Zaps!', 'give-zapier' ); ?></em>
									</li>
								</ol>
							</div>
							<div class="give-zapier-col give-zapier-right">
								<p class="give-zapier-title"><?php esc_html_e( 'Help and Support:',
										'give-zapier' ); ?></p>
								<ul class="give-zapier-bullets">
									<li><a href="https://givewp.com/documentation/add-ons/zapier/"
										   target="_blank"><?php esc_html_e( 'Give Zapier Add-on Documentation', 'give-zapier' ); ?></a>
									</li>
									<li><a href="https://givewp.com/documentation/developers/give-api-reference/"
										   target="_blank"><?php esc_html_e( 'Give API Documentation', 'give-zapier' ); ?></a>
									</li>
									<li><a href="https://givewp.com/support/"
										   target="_blank"><?php esc_html_e( 'Zapier Add-on Support', 'give-zapier' ); ?></a>
									</li>
								</ul>
							</div>
						</div>

					</div>
				</td>
			</tr>
			<?php
		}
	}

	return new Give_Settings_Zapier();
}
