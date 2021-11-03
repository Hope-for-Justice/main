<?php
/**
 * Form Field Manager Setup and script loading
 *
 * @package     Give_FFM
 * @copyright   Copyright (c) 2015, GiveWP
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Give_FFM_Setup
 */
class Give_FFM_Setup {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_enqueue_scripts' ], 1 );
	}

	/**
	 * Frontend Styles
	 *
	 * @since 1.2
	 */
	public function frontend_enqueue_styles() {
		wp_register_style(
			'give_ffm_frontend_styles',
			GIVE_FFM_PLUGIN_URL . 'assets/dist/css/give-ffm-frontend.css',
			[],
			GIVE_FFM_VERSION
		);
		wp_enqueue_style( 'give_ffm_frontend_styles' );

		$this->datepicker_enqueue_styles();
	}


	/**
	 * Conditionally output datepicker styles.
	 */
	private function datepicker_enqueue_styles() {
		// Datepicker CSS.
		$datepicker_css = give_get_option( 'ffm_datepicker_css' );

		if ( empty( $datepicker_css ) || $datepicker_css !== 'disabled' ) {
			wp_register_style(
				'give_ffm_datepicker_styles',
				GIVE_FFM_PLUGIN_URL . 'assets/dist/css/give-ffm-datepicker.css',
				[],
				GIVE_FFM_VERSION
			);
			wp_enqueue_style( 'give_ffm_datepicker_styles' );
		}
	}

	/**
	 * Frontend Scripts
	 */
	public function frontend_enqueue_scripts() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'plupload-handlers' );

		wp_register_script(
			'give_ffm_frontend',
			GIVE_FFM_PLUGIN_URL . 'assets/dist/js/give-ffm-frontend.js',
			[
				'jquery',
				'jquery-ui-datepicker',
				'jquery-ui-slider',
				'plupload-handlers',
			],
			GIVE_FFM_VERSION
		);
		wp_enqueue_script( 'give_ffm_frontend' );

		wp_localize_script(
			'give_ffm_frontend',
			'give_ffm_frontend',
			[
				'ajaxurl'                   => admin_url( 'admin-ajax.php' ),
				'error_message'             => __( 'Please complete all required fields', 'give-form-field-manager' ),
				'submit_button_text'        => __( 'Donate Now', 'give-form-field-manager' ),
				'nonce'                     => wp_create_nonce( 'ffm_nonce' ),
				'confirmMsg'                => __( 'Are you sure?', 'give-form-field-manager' ),
				'i18n'                      => [
					'timepicker' => $this->get_timepocker_translations(),
					'repeater'   => [
						'max_rows' => __( 'You have added the maximum number of fields allowed.', 'give-form-field-manager' ),
					],
				],
				'plupload'                  => [
					'url'              => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'ffm_featured_img' ),
					'flash_swf_url'    => includes_url( 'js/plupload/plupload.flash.swf' ),
					'filters'          => [
						[
							'title'      => __( 'Allowed Files', 'give-form-field-manager' ),
							'extensions' => '*',
						],
					],
					'multipart'        => true,
					'urlstream_upload' => true,
				]
			]
		);

	}

	/**
	 * Admin Scripts
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {

		$current_screen = get_current_screen();

		// Only enqueue where necessary - Give Forms single CPT
		if ( $current_screen->post_type !== 'give_forms' ) {
			return;
		}

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'suggest' );
		wp_enqueue_script( 'jquery-ui-slider' );

		// This one file contains all the goodies from above
		wp_register_script(
			'give_ffm_formbuilder',
			GIVE_FFM_PLUGIN_URL . 'assets/dist/js/give-ffm-admin.js',
			[
				'jquery',
				'jquery-ui-datepicker',
				'jquery-ui-sortable',
				'jquery-ui-autocomplete',
				'suggest',
				'jquery-ui-slider',
			],
			GIVE_FFM_VERSION
		);
		wp_enqueue_script( 'give_ffm_formbuilder' );

		// AJAX vars
		wp_localize_script(
			'give_ffm_formbuilder',
			'give_ffm_formbuilder',
			[
				'ajaxurl'              => admin_url( 'admin-ajax.php' ),
				'error_message'        => __( 'Please fill out this required field', 'give-form-field-manager' ),
				'nonce'                => wp_create_nonce( 'give_ffm_nonce' ),
				'hidden_field_enable'  => __( 'This field is disabled. Click to enable it.', 'give-form-field-manager' ),
				'hidden_field_disable' => __( 'Click to disable this field.', 'give-form-field-manager' ),
				'error_address_key'    => __( 'The word "address" is reserved and cannot be used as the meta key of a custom field. Please enter a different meta key.', 'give-form-field-manager' ),
				'i18n'                 => [
					'timepicker'            => $this->get_timepocker_translations(),
					'emptyMetaKey'          => [
						'title' => esc_html__( 'Empty meta key detected!', 'give-form-field-manager' ),
						'desc'  => esc_html__( 'Empty meta key detected. Please make sure you enter a unique meta key for each custom field.', 'give-form-field-manager' ),
					],
					'editMetaKeyModal'      => [
						'title' => esc_html__( 'Do you want to edit field meta key?', 'give-form-field-manager' ),
						'desc'  => esc_html__( 'Changing the meta key value will affect the visibility of existing donation data. Would you like to proceed?', 'give-form-field-manager' ),
					],
					'duplicateMetaKeyModal' => [
						'title' => esc_html__( 'Duplicate meta key detected!', 'give-form-field-manager' ),
						'desc'  => esc_html__( 'Duplicate meta keys found. Please make this meta key unique.', 'give-form-field-manager' ),
					],
					'removeFieldModal'      => [
						'title' => esc_html__( 'Remove form field?', 'give-form-field-manager' ),
						'desc'  => esc_html__( 'Are you sure you want to remove this form field?', 'give-form-field-manager' )
					],
					'donationAmount'        => esc_html__( 'Donation Amount', 'give-form-field-manager' )
				],
			]
		);

		wp_localize_script(
			'give_ffm_formbuilder',
			'give_ffm_frontend',
			[
				'confirmMsg' => __( 'Are you sure?', 'give-form-field-manager' ),
				'nonce'      => wp_create_nonce( 'ffm_nonce' ),
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'plupload'   => [
					'url'              => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'ffm_featured_img' ),
					'flash_swf_url'    => includes_url( 'js/plupload/plupload.flash.swf' ),
					'filters'          => [
						[
							'title'      => __( 'Allowed Files' ),
							'extensions' => '*',
						],
					],
					'multipart'        => true,
					'urlstream_upload' => true,
				],
			]
		);
	}

	/**
	 * Admin Enqueue Styles
	 *
	 * @return void
	 */
	public function admin_enqueue_styles() {
		$current_screen = get_current_screen();

		if ( $current_screen->post_type !== 'give_forms' ) {
			return;
		}

		wp_register_style(
			'give_ffm_form_builder',
			GIVE_FFM_PLUGIN_URL . 'assets/dist/css/give-ffm-admin.css'
		);
		wp_enqueue_style( 'give_ffm_form_builder' );

		$this->datepicker_enqueue_styles();

	}

	/**
	 * Get timepicker translations
	 *
	 * @return array
	 */
	private function get_timepocker_translations() {
		return [
			'choose_time' => __( 'Choose Time', 'give-form-field-manager' ),
			'time'        => __( 'Time', 'give-form-field-manager' ),
			'hour'        => __( 'Hour', 'give-form-field-manager' ),
			'minute'      => __( 'Minute', 'give-form-field-manager' ),
			'second'      => __( 'Second', 'give-form-field-manager' ),
			'done'        => __( 'Done', 'give-form-field-manager' ),
			'now'         => __( 'Now', 'give-form-field-manager' ),
		];
	}
}
