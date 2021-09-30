<?php
/**
 * Plugin Name: Give - Zapier
 * Plugin URI:  https://givewp.com/addons/zapier/
 * Description: Adds Zapier integration to Give. Trigger actions based on new donations and more.
 * Version:     1.4.0
 * Author:      GiveWP
 * Author URI:  https://givewp.com/
 * Text Domain: give-zapier
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
if ( ! defined( 'GIVE_ZAPIER_VERSION' ) ) {
	define( 'GIVE_ZAPIER_VERSION', '1.4.0' );
}

if ( ! defined( 'GIVE_ZAPIER_MIN_GIVE_VERSION' ) ) {
	define( 'GIVE_ZAPIER_MIN_GIVE_VERSION', '2.10.0' );
}

if ( ! defined( 'GIVE_ZAPIER_PATH' ) ) {
	define( 'GIVE_ZAPIER_PATH', dirname( __FILE__ ) );
}

if ( ! defined( 'GIVE_ZAPIER_URL' ) ) {
	define( 'GIVE_ZAPIER_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'GIVE_ZAPIER_DIR' ) ) {
	define( 'GIVE_ZAPIER_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'GIVE_ZAPIER_BASENAME' ) ) {
	define( 'GIVE_ZAPIER_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * Class Give_Zapier_Integration
 *
 * Main plugin instantiation class.
 *
 * @since 1.0
 */
class Give_Zapier_Integration {
	/**
	 * @since 1.3.0
	 * @var Give_Zapier_Background_Process
	 *
	 */
	static public $background_process;

	/**
	 * @since 1.2.2
	 * @var Give_Zapier_Integration The reference the singleton instance of this class.
	 *
	 */
	private static $instance;

	/**
	 * Notices (array)
	 *
	 * @since 1.2.2
	 *
	 * @var array
	 */
	public $notices = [];

	/**
	 * Returns the singleton instance of this class.
	 *
	 * @since 1.2.2
	 * @return Give_Zapier_Integration The singleton instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Setup Give Zapier Integration.
	 *
	 * @since  1.2.2
	 * @access private
	 */
	private function setup() {
		// Give init hook.
		add_action( 'give_init', [ $this, 'init' ], 10 );
		add_action( 'admin_init', [ $this, 'check_environment' ], 999 );
		add_action( 'admin_notices', [ $this, 'admin_notices' ], 15 );
		add_action( 'init', [ $this, 'register_cpt' ] );
		add_action( 'shutdown', [ $this, 'save_background_process' ] );
	}

	/**
	 * Dispatch background process if has batch and not already running
	 *
	 * @since 1.3.0
	 */
	public function save_background_process() {
		if (
			( ! ( self::$background_process instanceof Give_Zapier_Background_Process ) ) ||
			self::$background_process->is_process_running() ||
			self::$background_process->is_queue_empty()
		) {
			return;
		}

		self::$background_process->dispatch();
	}

	/**
	 * Give_Zapier_Integration constructor.
	 *
	 * Fire up the engines.
	 *
	 * @since  1.2.2
	 * @access public
	 */
	public function init() {
		$this->license();
		$this->textdomain();

		if ( ! $this->get_environment_warning() ) {
			return;
		}

		$this->activation_banner();
		$this->includes();
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}


	/**
	 * Register Give License
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function license() {
		if ( class_exists( 'Give_License' ) ) {
			new Give_License( __FILE__, 'Zapier', GIVE_ZAPIER_VERSION, 'WordImpress' );
		}
	}

	/**
	 * Give Admin Scripts
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @param $hook
	 *
	 * @return void
	 */
	public function admin_scripts( $hook ) {
		// if only on Zapier tab
		if ( 'give_forms_page_give-settings' === $hook ) {
			wp_register_style(
				'give-zapier-admin-css',
				plugin_dir_url( __FILE__ ) . '/assets/css/give-zapier-admin.css'
			);
			wp_enqueue_style( 'give-zapier-admin-css' );
		}
	}

	/**
	 * Load localization.
	 *
	 * @since  1.0
	 * @access public
	 */
	public function textdomain() {
		// Set filter for language directory.
		$lang_dir = GIVE_ZAPIER_DIR . '/languages/';
		$lang_dir = apply_filters( 'give_zapier_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter.
		$locale = apply_filters( 'plugin_locale', get_locale(), 'give-zapier' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'give-zapier', $locale );

		// Setup paths to current locale file.
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/give-zapier/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/give-zapier/ folder.
			load_textdomain( 'give-zapier', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/give-zapier/languages/ folder.
			load_textdomain( 'give-zapier', $mofile_local );
		} else {
			// Load the default language files.
			load_plugin_textdomain( 'give-zapier', false, $lang_dir );
		}
	}

	/**
	 * Register Give Zapier Subscription post type.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_cpt() {
		register_post_type(
			'give-zapier-sub',
			[
				'description' => esc_html__( 'Used for storing Give Zapier subscriptions', 'give-zapier' ),
				'public'      => false,
				'rewrite'     => false,
				'query_var'   => false,
			]
		);
	}

	/**
	 * Include file dependencies.
	 *
	 * @since  1.0
	 * @access public
	 */
	public function includes() {
		require_once GIVE_ZAPIER_DIR . '/includes/give-zapier-helpers.php';
		require_once GIVE_ZAPIER_DIR . '/includes/class-give-zapier-background-process.php';

		self::$background_process = new Give_Zapier_Background_Process();

		if ( is_admin() ) {
			// Register settings.
			add_filter( 'give-settings_get_settings_pages', [ $this, 'register_settings' ] );
			require_once GIVE_ZAPIER_DIR . '/includes/admin/plugins-list.php';
		}

		require_once GIVE_ZAPIER_DIR . '/includes/class.Give_Zapier_Subscription_Factory.php';
		require_once GIVE_ZAPIER_DIR . '/includes/class.Give_Zapier_Connection.php';
		require_once GIVE_ZAPIER_DIR . '/includes/class.Give_Zapier_Customer.php';
		require_once GIVE_ZAPIER_DIR . '/includes/give-zapier-api-hooks.php';

		require_once GIVE_ZAPIER_DIR . '/includes/give-zapier-recurring.php';
	}

	/**
	 * Register Zapier Setting
	 *
	 * @since 2.0
	 *
	 * @param $settings
	 *
	 * @return array
	 */
	public function register_settings( $settings ) {
		$settings[] = include GIVE_ZAPIER_DIR . '/includes/admin/settings.php';

		return $settings;
	}

	/**
	 * Check plugin environment.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return bool
	 */
	public function check_environment() {
		// Flag to check whether plugin file is loaded or not.
		$is_working = true;

		// Load plugin helper functions.
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		/*
		 Check to see if Give is activated, if it isn't deactivate and show a banner. */
		// Check for if give plugin activate or not.
		$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

		if ( empty( $is_give_active ) ) {
			// Show admin notice.
			$this->add_admin_notice(
				'prompt_give_activate',
				'error',
				sprintf(
					__(
						'<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> plugin installed and activated for Give - Zapier to activate.',
						'give-zapier'
					),
					'https://givewp.com'
				)
			);
			$is_working = false;
		}

		return $is_working;
	}

	/**
	 * Check plugin for Give environment.
	 *
	 * @since  1.1.2
	 * @access public
	 *
	 * @return bool
	 */
	public function get_environment_warning() {
		// Flag to check whether plugin file is loaded or not.
		$is_working = true;

		// Verify dependency cases.
		if (
			defined( 'GIVE_VERSION' )
			&& version_compare( GIVE_VERSION, GIVE_ZAPIER_MIN_GIVE_VERSION, '<' )
		) {
			/*
			 Min. Give. plugin version. */
			// Show admin notice.
			$this->add_admin_notice(
				'prompt_give_incompatible',
				'error',
				sprintf(
					__(
						'<strong>Activation Error:</strong> You must have the <a href="%1$s" target="_blank">Give</a> core version %2$s for the Give - Zapier add-on to activate.',
						'give-zapier'
					),
					'https://givewp.com',
					GIVE_ZAPIER_MIN_GIVE_VERSION
				)
			);

			$is_working = false;
		}

		return $is_working;
	}

	/**
	 * Allow this class and other classes to add notices.
	 *
	 * @since 1.0
	 *
	 * @param $class
	 * @param $message
	 *
	 * @param $slug
	 */
	public function add_admin_notice( $slug, $class, $message ) {
		$this->notices[ $slug ] = [
			'class'   => $class,
			'message' => $message,
		];
	}

	/**
	 * Display admin notices.
	 *
	 * @since 1.0
	 */
	public function admin_notices() {
		$allowed_tags = [
			'a'      => [
				'href'  => [],
				'title' => [],
				'class' => [],
				'id'    => [],
			],
			'br'     => [],
			'em'     => [],
			'span'   => [
				'class' => [],
			],
			'strong' => [],
		];

		foreach ( (array) $this->notices as $notice_key => $notice ) {
			echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
			echo wp_kses( $notice['message'], $allowed_tags );
			echo '</p></div>';
		}
	}

	/**
	 * Show activation banner for this add-on.
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function activation_banner() {
		// Check for activation banner inclusion.
		if (
			! class_exists( 'Give_Addon_Activation_Banner' )
			&& file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' )
		) {
			include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
		}

		// Initialize activation welcome banner.
		if ( class_exists( 'Give_Addon_Activation_Banner' ) ) {
			// Only runs on admin
			$args = [
				'file'              => __FILE__,
				'name'              => 'Zapier',
				'version'           => GIVE_ZAPIER_VERSION,
				'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=zapier' ),
				'documentation_url' => 'http://docs.givewp.com/addon-zapier',
				'support_url'       => 'https://givewp.com/support/',
				'testing'           => false,
			];
			new Give_Addon_Activation_Banner( $args );
		}

		return true;
	}
}

$GLOBALS['give_zapier_integration'] = Give_Zapier_Integration::get_instance();
