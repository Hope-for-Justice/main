<?php
/**
 * Plugin Name:         Give - Form Field Manager
 * Plugin URI:          https://givewp.com/addons/form-field-manager/
 * Description:         Easily add and control additional donation form fields using an easy-to-use interface.
 * Version:             2.0.2
 * Requires at least:   4.9
 * Requires PHP:        5.6
 * Author:              GiveWP
 * Author URI:          https://givewp.com/
 * Text Domain:         give-form-field-manager
 * Domain Path:         /languages
 */

use GiveFormFieldManager\FormFields\ServiceProvider as FormFieldsServiceProvider;
use GiveFormFieldManager\Infrastructure\Environment;
use GiveFormFieldManager\Infrastructure\ServiceProvider as AddonServiceProvider;
use GiveFormFieldManager\Tracking\ServiceProvider as TrackingServiceProvider;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Give_Form_Fields_Manager
 */
final class Give_Form_Fields_Manager {

	/** Singleton *************************************************************/

	/**
	 * @since 1.0
	 * @var Give_Form_Fields_Manager The one true Give_Form_Fields_Manager
	 */
	private static $instance;

	/**
	 * @var string
	 */
	public $id = 'give-form-field-manager';

	/**
	 * The title of the FFM plugin.
	 *
	 * @var string
	 */
	public $title;

	/**
	 * @var Give_FFM_Render_Form
	 */
	public $render_form;

	/**
	 * @var Give_FFM_Setup
	 */
	public $setup;

	/**
	 * @var Give_FFM_Upload
	 */
	public $upload;

	/**
	 * @var Give_FFM_Admin_Form
	 */
	public $admin_form;

	/**
	 * @var Give_FFM_Admin_Posting
	 */
	public $admin_posting;

	/**
	 * Notices (array).
	 *
	 * @since 1.1.3
	 *
	 * @var array
	 */
	public $notices = [];

	/**
	 * @since 1.6.0
	 *
	 * @var string[]
	 */
	private $service_providers = [
		AddonServiceProvider::class,
		TrackingServiceProvider::class,
		FormFieldsServiceProvider::class,
	];

	/**
	 * Main Give_Form_Fields_Manager Instance.
	 *
	 * Insures that only one instance of Give_Form_Fields_Manager exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since     1.0
	 * @staticvar array $instance
	 * @return Give_Form_Fields_Manager|object - The one true FFM.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Setup FFM, loading scripts, styles and meta info.
	 *
	 * @since 1.0
	 * @return void
	 */
	private function setup() {

		self::$instance->define_globals();

		add_action( 'before_give_init', [ $this, 'includes_general' ] );
		add_action( 'before_give_init', [ $this, 'register_service_providers' ] );
		add_action( 'give_init', [ $this, 'init' ], 10 );
	}

	/**
	 * Setup Tribute.
	 *
	 * @since  1.4
	 *
	 * @access private
	 */
	public function init() {

		if ( ! Environment::checkEnvironment() ) {
			return;
		}

		do_action( 'give_ffm_setup_actions' );

		self::$instance->includes_admin();
		self::$instance->setup();

		// Setup Instances
		self::$instance->setup  = new Give_FFM_Setup;
		self::$instance->upload = new Give_FFM_Upload;

		if ( is_admin() ) {
			self::$instance->admin_form    = new Give_FFM_Admin_Form;
			self::$instance->admin_posting = new Give_FFM_Admin_Posting;
		}
	}

	/**
	 * Defines all the globally used constants
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function define_globals() {

		$this->title = __( 'Form Field Manager', 'give-form-field-manager' );

		// Plugin Name.
		if ( ! defined( 'GIVE_FFM_PRODUCT_NAME' ) ) {
			define( 'GIVE_FFM_PRODUCT_NAME', 'Form Field Manager' );
		}

		// Plugin Version.
		if ( ! defined( 'GIVE_FFM_VERSION' ) ) {
			define( 'GIVE_FFM_VERSION', '2.0.2' );
		}

		// Min Give Version.
		if ( ! defined( 'GIVE_FFM_MIN_GIVE_VERSION' ) ) {
			define( 'GIVE_FFM_MIN_GIVE_VERSION', '2.16.0' );
		}

		// Plugin Root File.
		if ( ! defined( 'GIVE_FFM_PLUGIN_FILE' ) ) {
			define( 'GIVE_FFM_PLUGIN_FILE', __FILE__ );
		}

		// Plugin Folder Path.
		if ( ! defined( 'GIVE_FFM_PLUGIN_DIR' ) ) {
			define( 'GIVE_FFM_PLUGIN_DIR', trailingslashit( plugin_dir_path(GIVE_FFM_PLUGIN_FILE) ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'GIVE_FFM_PLUGIN_URL' ) ) {
			define( 'GIVE_FFM_PLUGIN_URL', plugin_dir_url( GIVE_FFM_PLUGIN_FILE ) );
		}

		// Plugin basename.
		if ( ! defined( 'GIVE_FFM_BASENAME' ) ) {
			define( 'GIVE_FFM_BASENAME', apply_filters( 'give_ffm_plugin_basename', plugin_basename( GIVE_FFM_PLUGIN_FILE ) ) );
		}

		if ( class_exists( 'Give_License' ) ) {
			new Give_License( GIVE_FFM_PLUGIN_FILE, GIVE_FFM_PRODUCT_NAME, GIVE_FFM_VERSION, 'WordImpress' );
		}
	}

	/**
	 * Include all files.
	 *
	 * @since 1.0.0
	 * @unreleased use $this to class methods
	 */
	private function includes() {
		$this->includes_general();
		$this->includes_admin();
	}

	/**
	 * Load general files.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function includes_general() {
		$files = [
			'class-setup.php',
			'class-render-form.php',
			'class-upload.php',
			'class-emails.php',
			'functions.php',
		];

		foreach ( $files as $file ) {
			require( sprintf( '%s/includes/%s', untrailingslashit( GIVE_FFM_PLUGIN_DIR ), $file ) );
		}
	}

	/**
	 * Load admin files.
	 *
	 * @since 1.0
	 * @return void
	 */
	private function includes_admin() {
		if ( is_admin() ) {
			$files = [
				'admin-activation.php',
				'admin-settings.php',
				'admin-form.php',
				'admin-posting.php',
				'admin-template.php',
				'export-donations.php',
			];

			foreach ( $files as $file ) {
				require( sprintf( '%s/includes/admin/%s', untrailingslashit( GIVE_FFM_PLUGIN_DIR ), $file ) );
			}
		}
	}

	/**
	 * @unreleased
	 */
	public function register_service_providers() {
		if ( ! Environment::giveMinRequiredVersionCheck() ) {
			return;
		}

		foreach ( $this->service_providers as $service_provider ) {
			give()->registerServiceProvider( $service_provider );
		}
	}
}

require_once __DIR__ . '/vendor/autoload.php';


/**
 * The main function responsible for returning the one true Give_Form_Fields_Manager
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $give_ffm = give_ffm(); ?>
 *
 * @since 1.0
 * @unreleased Rename function in small letters
 * @return Give_Form_Fields_Manager The one true Give_Form_Fields_Manager instance.
 */

function give_ffm() {
	return Give_Form_Fields_Manager::instance();
}

/**
 * Calling instance of Give FFM.
 *
 * @see     give_ffm()
 * @since  1.4
 */
give_ffm();
