<?php
/**
 * Plugin Name: Per-Form Confirmation Pages for GiveWP
 * Plugin URI:  https://github.com/impress-org/givewp-per-form-confirmations
 * Description: Set a unique donation confirmation page per-form for GiveWP
 * Version:     1.1.1
 * Author:      GiveWP
 * Author URI:  https://givewp.com
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pfconfs-4-givewp
 *
 *
 * This add-on started as a combination of two popular GiveWP snippets:
 * https://github.com/impress-org/givewp-snippet-library/blob/master/form-customizations/conditional-successful-donation-redirect.php
 * https://github.com/impress-org/give-per-form-confirmation-message 
 * 
 * Free add-ons like this are a tribute to our thriving GiveWP community and their enthusiastic feedback of the GiveWP platform
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Per_Form_Confirmations_4_GIVEWP
 */
final class Per_Form_Confirmations_4_GIVEWP {
	/**
	 * Instance.
	 *
	 * @since
	 * @access private
	 * @var Per_Form_Confirmations_4_GIVEWP
	 */
	private static $instance;

	/**
	 * Singleton pattern.
	 *
	 * @since
	 * @access private
	 */
	private function __construct() {
	}


	/**
	 * Get instance.
	 *
	 * @return Per_Form_Confirmations_4_GIVEWP
	 * @since
	 * @access public
	 *
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Per_Form_Confirmations_4_GIVEWP ) ) {
			self::$instance = new Per_Form_Confirmations_4_GIVEWP();
			self::$instance->setup();
		}

		return self::$instance;
	}


	/**
	 * Setup
	 *
	 * @since
	 * @access private
	 */
	private function setup() {
		self::$instance->setup_constants();

		register_activation_hook( PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE, array( $this, 'install' ) );
		add_action( 'give_init', array( $this, 'init' ), 10, 1 );
		add_action( 'admin_init', array( $this, 'check_environment' ), 999 );
		add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );
		add_action( 'admin_enqueue_scripts', array($this, 'load_admin_styles') );
		add_action( 'admin_enqueue_scripts', array($this, 'load_admin_scripts') );
	}


	/**
	 * Setup constants
	 *
	 * Defines useful constants to use throughout the add-on.
	 *
	 * @since
	 * @access private
	 */
	private function setup_constants() {

		// Defines addon version number for easy reference.
		if ( ! defined( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_VERSION' ) ) {
			define( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_VERSION', '1.1.1' );
		}

		// Set it to latest.
		if ( ! defined( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_MIN_GIVE_VERSION' ) ) {
			define( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_MIN_GIVE_VERSION', '2.5' );
		}

		if ( ! defined( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE' ) ) {
			define( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE', __FILE__ );
		}

		if ( ! defined( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_DIR' ) ) {
			define( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_DIR', plugin_dir_path( PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE ) );
		}

		if ( ! defined( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_URL' ) ) {
			define( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_URL', plugin_dir_url( PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE ) );
		}

		if ( ! defined( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_BASENAME' ) ) {
			define( 'PER_FORM_CONFIRMATIONS_4_GIVEWP_BASENAME', plugin_basename( PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE ) );
		}
	}

	/**
	 * Notices (array)
	 *
	 * @var array
	 */
	public $notices = array();

	/**
	 * Plugin installation
	 *
	 * @since
	 * @access public
	 */
	public function install() {
		// Bailout.
		if ( ! self::$instance->check_environment() ) {
			return;
		}

		/**
		 * Set Trigger Date.
		 *
		 * @since  1.0.0
		 */
	
		// Number of days you want the notice delayed by.
		$delayindays = 15;

		// Create timestamp for when plugin was activated.
		$triggerdate = mktime( 0, 0, 0, date('m')  , date('d') + $delayindays, date('Y') );

		// If our option doesn't exist already, we'll create it with today's timestamp.
		if ( ! get_option( 'pfconfs_4_givewp_activation_date' ) ) {
			add_option( 'pfconfs_4_givewp_activation_date', $triggerdate, '', 'yes' );
		}
		
	}

	/**
	 * Plugin installation
	 *
	 * @param Give $give
	 *
	 * @return void
	 * @since
	 * @access public
	 *
	 */
	public function init( $give ) {

		// Don't hook anything else in the plugin if we're in an incompatible environment.
		if ( ! $this->get_environment_warning() ) {
			return;
		}

		self::$instance->load_files();

		// Set up localization.
		$this->load_textdomain();
	}

	/**
		 * Loads the plugin language files.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_textdomain() {

			// Set filter for Give's languages directory
			$give_lang_dir = dirname( plugin_basename( PER_FORM_CONFIRMATIONS_4_GIVEWP_FILE ) ) . '/languages/';
			$give_lang_dir = apply_filters( 'pfconfs4givewp_languages_directory', $give_lang_dir );

			// Traditional WordPress plugin locale filter.
			$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'pfconfs-4-givewp' );

			unload_textdomain( 'pfconfs-4-givewp' );
			load_textdomain( 'pfconfs-4-givewp', WP_LANG_DIR . '/givewp-per-form-confirmations/' . $locale . '.mo' );
			load_plugin_textdomain( 'pfconfs-4-givewp', false, $give_lang_dir );

		}


	/**
	 * Check plugin environment.
	 *
	 * @since  2.1.1
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

		/* Check to see if GiveWP is activated, if it isn't deactivate and show a banner. */

		$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

		if ( empty( $is_give_active ) ) {
			// Show admin notice.
			$this->add_admin_notice( 'prompt_give_activate', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">GiveWP</a> plugin installed and activated for Per-Form PayPal Standard for GiveWP to activate.', 'pfconfs-4-givewp' ), 'https://givewp.com' ) );

			// Deactivate plugin.
			deactivate_plugins( PER_FORM_CONFIRMATIONS_4_GIVEWP_BASENAME );
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$is_working = false;
		}
		return $is_working;
	}

	/**
	 * Check plugin for Give environment.
	 *
	 * @since  2.1.1
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
			&& version_compare( GIVE_VERSION, PER_FORM_CONFIRMATIONS_4_GIVEWP_MIN_GIVE_VERSION, '<' )
		) {
			/* Min. Give. plugin version. */
			// Show admin notice.
			$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">GiveWP</a> core version %s for the Per-Form PayPal Standard for GiveWP add-on to activate.', 'pfconfs-4-givewp' ), 'https://givewp.com', PER_FORM_CONFIRMATIONS_4_GIVEWP_MIN_GIVE_VERSION ) );
			$is_working = false;
		}

		return $is_working;
	}

	/**
	 * Allow this class and other classes to add notices.
	 *
	 * @param string $slug Notice Slug.
	 * @param string $class Notice Class.
	 * @param string $message Notice Message.
	 */
	public function add_admin_notice( $slug, $class, $message ) {
		$this->notices[ $slug ] = array(
			'class'   => $class,
			'message' => $message,
		);
	}

	/**
	 * Display admin notices.
	 */
	public function admin_notices() {
		$allowed_tags = array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'class' => array(),
				'id'    => array(),
			),
			'br'     => array(),
			'em'     => array(),
			'span'   => array(
				'class' => array(),
			),
			'strong' => array(),
		);
		foreach ( (array) $this->notices as $notice_key => $notice ) {
			echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
			echo wp_kses( $notice['message'], $allowed_tags );
			echo '</p></div>';
		}
	}

	/**
	 * Load plugin files.
	 *
	 * @since
	 * @access private
	 */
	private function load_files() {
		require_once PER_FORM_CONFIRMATIONS_4_GIVEWP_DIR . 'includes/main-functions.php';
		require_once PER_FORM_CONFIRMATIONS_4_GIVEWP_DIR . 'includes/admin/form-settings.php';
		require_once PER_FORM_CONFIRMATIONS_4_GIVEWP_DIR . 'includes/admin/notice.php';
	}


	/**
	 * Setup hooks
	 *
	 * @since
	 * @access private
	 */
	public function load_admin_styles() {
        wp_enqueue_style( 'pfconfs4givewp', PER_FORM_CONFIRMATIONS_4_GIVEWP_URL . '/assets/pfconfs4givewp-admin.css', array(), PER_FORM_CONFIRMATIONS_4_GIVEWP_VERSION, 'all' );
	}

	/**
	 * Setup hooks
	 *
	 * @since
	 * @access private
	 */
	public function load_admin_scripts( $hook_suffix ) {
		$cpt = 'give_forms';

    	if( in_array($hook_suffix, array('post.php', 'post-new.php') ) ){
        	$screen = get_current_screen();

        	if( is_object( $screen ) && $cpt == $screen->post_type ){

				wp_enqueue_script( 'pfconfs4givewp', PER_FORM_CONFIRMATIONS_4_GIVEWP_URL . 'assets/pfconfs4givewp.admin.js', array(), PER_FORM_CONFIRMATIONS_4_GIVEWP_VERSION, 'all' );
			}
		}
	}

}

/**
 * The main function responsible for returning the one true Per_Form_Confirmations_4_GIVEWP instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $recurring = Per_Form_Confirmations_4_GIVEWP(); ?>
 *
 * @return Per_Form_Confirmations_4_GIVEWP|bool
 * @since 1.0
 *
 */
function Per_Form_Confirmations_4_GIVEWP() {
	return Per_Form_Confirmations_4_GIVEWP::get_instance();
}

Per_Form_Confirmations_4_GIVEWP();
