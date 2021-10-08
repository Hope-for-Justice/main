<?php
/**
 * Plugin Name:       Give - GoCardless Gateway
 * Plugin URI:        https://givewp.com/addons/gocardless-gateway/
 * Description:       Adds the GoCardless payment gateway to the available Give payment methods.
 * Version:           1.3.8
 * Author:            GiveWP
 * Author URI:        https://givewp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       give-gocardless
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! class_exists( 'Give_Gocardless' ) ) :

	/**
	 * Give_Gocardless Class
	 *
	 * @package Give_Gocardless
	 * @since   1.1.0
	 */
	final class Give_Gocardless {

		/**
		 * Holds the instance
		 *
		 * Ensures that only one instance of Give_Gocardless exists in memory at any one
		 * time and it also prevents needing to define globals all over the place.
		 *
		 * TL;DR This is a static property property that holds the singleton instance.
		 *
		 * @var object
		 * @static
		 */
		private static $instance;

		/**
		 * Give GoCardless Admin Object.
		 *
		 * @since  1.1
		 * @access public
		 *
		 * @var Give_Gocardless_Admin object.
		 */
		public $plugin_admin;

		/**
		 * Give GoCardless Gateway Object.
		 *
		 * @since  1.1
		 * @access public
		 *
		 * @var Give_GoCardless_Gateway object.
		 */
		public $gocardless_gateway;

		/**
		 * Notices (array)
		 *
		 * @since 1.3
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * Get the instance and store the class inside it. This plugin utilises
		 * the PHP singleton design pattern.
		 *
		 * @since     1.1
		 * @static
		 * @staticvar array $instance
		 * @access    public
		 *
		 * @see       Give_Gocardless();
		 *
		 * @uses      Give_Gocardless::hooks() Setup hooks and actions.
		 * @uses      Give_Gocardless::includes() Loads all the classes.
		 * @uses      Give_Gocardless::licensing() Add Give - GoCardless License.
		 *
		 * @return object self::$instance Instance
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Give_Gocardless ) ) {
				self::$instance = new Give_Gocardless();
				self::$instance->setup();
			}

			return self::$instance;
		}

		/**
		 * Setup Give - GoCardless.
		 *
		 * @since  1.1
		 * @access private
		 */
		private function setup() {

			self::$instance->setup_constants();

			add_action( 'give_init', array( $this, 'init' ), 10 );
			add_action( 'admin_init', array( $this, 'check_environment' ), 999 );
			add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );
		}

		/**
		 * Init Give - GoCardless.
		 *
		 * Sets up hooks, licensing and includes files.
		 *
		 * @since  1.1
		 * @access public
		 *
		 * @return void
		 */
		public function init() {
			if ( ! self::$instance->get_environment_warning() ) {
				return;
			}

			self::$instance->hooks();
			self::$instance->licensing();
			self::$instance->includes();
		}

		/**
		 * Init the plugin after plugins_loaded so environment variables are set.
		 *
		 * @since 1.3
		 */
		public function get_environment_warning() {
			// Flag to check whether plugin file is loaded or not.
			$is_working = true;

			// Verify dependency cases.
			if (
				defined( 'GIVE_VERSION' )
				&& version_compare( GIVE_VERSION, GIVE_GOCARDLESS_MIN_GIVE_VER, '<' )
			) {

				/* Min. Give. plugin version. */
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> core version %s for the Give - GoCardless Gateway add-on to activate.', 'give-gocardless' ), 'https://givewp.com', GIVE_GOCARDLESS_MIN_GIVE_VER ) );

				$is_working = false;
			}

			return $is_working;
		}

		/**
		 * Check plugin environment.
		 *
		 * @since  1.1
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

			/* Check to see if Give is activated, if it isn't deactivate and show a banner. */
			// Check for if give plugin activate or not.
			$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

			if ( empty( $is_give_active ) ) {
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_activate', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> plugin installed and activated for Give - GoCardless Gateway to activate.', 'give-gocardless' ), 'https://givewp.com' ) );
				$is_working = false;
			}

			return $is_working;
		}

		/**
		 * Setup constants.
		 *
		 * @since   1.0.0
		 * @access  private
		 */
		private function setup_constants() {
			/**
			 * Define constants.
			 * Required minimum versions, paths, urls, etc.
			 *
			 * @since    1.0.0
			 */
			if ( ! defined( 'GIVE_GOCARDLESS_VERSION' ) ) {
				define( 'GIVE_GOCARDLESS_VERSION', '1.3.8' );
			}
			if ( ! defined( 'GIVE_GOCARDLESS_GATEWAY_SLUG' ) ) {
				define( 'GIVE_GOCARDLESS_GATEWAY_SLUG', 'gocardless' );
			}
			if ( ! defined( 'GIVE_GOCARDLESS_PLUGIN_FILE' ) ) {
				define( 'GIVE_GOCARDLESS_PLUGIN_FILE', __FILE__ );
			}
			if ( ! defined( 'GIVE_GOCARDLESS_PLUGIN_DIR' ) ) {
				define( 'GIVE_GOCARDLESS_PLUGIN_DIR', dirname( GIVE_GOCARDLESS_PLUGIN_FILE ) );
			}
			if ( ! defined( 'GIVE_GOCARDLESS_PLUGIN_URL' ) ) {
				define( 'GIVE_GOCARDLESS_PLUGIN_URL', plugin_dir_url( GIVE_GOCARDLESS_PLUGIN_FILE ) );
			}
			if ( ! defined( 'GIVE_GOCARDLESS_BASENAME' ) ) {
				define( 'GIVE_GOCARDLESS_BASENAME', plugin_basename( GIVE_GOCARDLESS_PLUGIN_FILE ) );
			}
			if ( ! defined( 'GIVE_GOCARDLESS_MIN_GIVE_VER' ) ) {
				define( 'GIVE_GOCARDLESS_MIN_GIVE_VER', '2.6.0' );
			}

			// Define authentication url.
			if ( ! defined( 'GIVE_BASE_AUTH_URL' ) ) {
				define( 'GIVE_BASE_AUTH_URL', 'https://connect.givewp.com/gocardless/' );
			}
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since  1.1
		 * @access protected
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'give-gocardless' ), '1.1' );
		}

		/**
		 * Disable Unserialize of the class.
		 *
		 * @since  1.1
		 * @access protected
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Unserialize instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'give-gocardless' ), '1.1' );
		}

		/**
		 * Constructor Function.
		 *
		 * @since  1.1
		 * @access protected
		 */
		public function __construct() {
			self::$instance = $this;
		}

		/**
		 * Reset the instance of the class
		 *
		 * @since  1.1
		 * @access public
		 */
		public static function reset() {
			self::$instance = null;
		}

		/**
		 * Includes.
		 *
		 * @since  1.1
		 * @access private
		 *
		 * - Give_Gocardless_Admin. Defines all hooks for the admin area.
		 * - Give_GoCardless_API. Define and manage the request toward GoCardless.
		 * - Give_GoCardless_Gateway. GoCardless Payment Gateway
		 */
		private function includes() {
			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once GIVE_GOCARDLESS_PLUGIN_DIR . '/includes/admin/class-give-gocardless-admin.php';

			/**
			 * This file is included for plugin upgrades.
			 */
			require_once GIVE_GOCARDLESS_PLUGIN_DIR . '/includes/admin/give-gocardless-upgrades.php';

			/**
			 * This file is included for GoCardless gateway helpers.
			 */
			require_once GIVE_GOCARDLESS_PLUGIN_DIR . '/includes/class-give-gocardless-api.php';

			/**
			 * The class responsible for gateway setting.
			 */
			require_once GIVE_GOCARDLESS_PLUGIN_DIR . '/includes/class-give-gocardless-gateway.php';

			/**
			 * The file is includes for GoCardless gateway helpers.
			 */
			require_once GIVE_GOCARDLESS_PLUGIN_DIR . '/includes/give-gocardless-helpers.php';

			self::$instance->plugin_admin       = new Give_Gocardless_Admin();
			self::$instance->gocardless_gateway = new Give_GoCardless_Gateway();

		}

		/**
		 * Hooks.
		 *
		 * @since  1.1
		 * @access public
		 */
		public function hooks() {
			add_action( 'init', array( $this, 'load_textdomain' ) );
			add_action( 'admin_init', array( $this, 'activation_banner' ) );
			add_filter( 'plugin_action_links_' . GIVE_GOCARDLESS_BASENAME, array( $this, 'action_links' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
			add_filter( 'give_recurring_available_gateways', array( $this, 'load_gocardless_recurring' ), 10, 1 );
		}

		/**
		 * Register Recurring class into GiveWP.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @param array $recurring_gateways Supported recurring gateways
		 *
		 * @return array $recurring_gateways Supported recurring gateways
		 */
		public function load_gocardless_recurring( $recurring_gateways ) {

			if ( class_exists( 'Give_Recurring_Gateway' ) ) {

				/**
				 * The file is includes for GoCardless gateway recurring.
				 */
				require_once GIVE_GOCARDLESS_PLUGIN_DIR . '/includes/class-give-gocardless-recurring.php';

				// Adding GoCardless recurring class.
				$recurring_gateways['gocardless'] = 'Give_GoCardless_Recurring';
			}

			return $recurring_gateways;
		}

		/**
		 * Implement Give Licensing for Give - GoCardless Gateway Add On.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function licensing() {
			if ( class_exists( 'Give_License' ) ) {
				new Give_License(
					GIVE_GOCARDLESS_PLUGIN_FILE,
					'GoCardless Gateway',
					GIVE_GOCARDLESS_VERSION,
					'WordImpress'
				);
			}
		}

		/**
		 * Load Plugin Text Domain
		 *
		 * Looks for the plugin translation files in certain directories and loads
		 * them to allow the plugin to be localised
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return bool True on success, false on failure.
		 */
		public function load_textdomain() {
			// Traditional WordPress plugin locale filter.
			$locale = apply_filters( 'plugin_locale', get_locale(), 'give-gocardless' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'give-gocardless', $locale );

			// Setup paths to current locale file.
			$mofile_local = trailingslashit( GIVE_GOCARDLESS_PLUGIN_DIR . 'languages' ) . $mofile;

			if ( file_exists( $mofile_local ) ) {
				// Look in the /wp-content/plugins/Give-GoCardless/languages/ folder.
				load_textdomain( 'give-gocardless', $mofile_local );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'give-gocardless', false, trailingslashit( GIVE_GOCARDLESS_PLUGIN_DIR . 'languages' ) );
			}

			return false;
		}

		/**
		 * Activation banner.
		 *
		 * Uses Give's core activation banners.
		 *
		 * @since 1.0.0
		 *
		 * @return bool
		 */
		public function activation_banner() {

			// Check for activation banner inclusion.
			if ( ! class_exists( 'Give_Addon_Activation_Banner' ) && file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' ) ) {
				include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
			}

			// Initialize activation welcome banner.
			if ( class_exists( 'Give_Addon_Activation_Banner' ) ) {

				// Only runs on admin.
				$args = array(
					'file'              => GIVE_GOCARDLESS_PLUGIN_FILE,
					'name'              => __( 'GoCardless Gateway', 'give-gocardless' ),
					'version'           => GIVE_GOCARDLESS_VERSION,
					'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=gocardless' ),
					'documentation_url' => 'https://givewp.com/documentation/add-ons/gocardless-gateway/',
					'support_url'       => 'https://givewp.com/support/',
					'testing'           => false,
				);
				new Give_Addon_Activation_Banner( $args );
			}

			return true;
		}

		/**
		 * Adding additional setting page link along plugin's action link.
		 *
		 * @since   1.0.0
		 * @access  public
		 *
		 * @param   array $actions get all actions.
		 *
		 * @return  array       return new action array
		 */
		function action_links( $actions ) {

			if ( ! class_exists( 'Give' ) ) {
				return $actions;
			}

			// Check min Give version.
			if ( defined( 'GIVE_GOCARDLESS_MIN_GIVE_VER' ) && version_compare( GIVE_VERSION, GIVE_GOCARDLESS_MIN_GIVE_VER, '<' ) ) {
				return $actions;
			}

			$new_actions = array(
				'settings' => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=gocardless' ), __( 'Settings', 'give-gocardless' ) ),
			);

			return array_merge( $new_actions, $actions );

		}

		/**
		 * Plugin row meta links.
		 *
		 * @since   1.0.0
		 * @access  public
		 *
		 * @param   array  $plugin_meta An array of the plugin's metadata.
		 * @param   string $plugin_file Path to the plugin file, relative to the plugins directory.
		 *
		 * @return  array  return meta links for plugin.
		 */
		function plugin_row_meta( $plugin_meta, $plugin_file ) {

			if ( ! class_exists( 'Give' ) ) {
				return $plugin_meta;
			}

			// Return if not Give GoCardless plugin.
			if ( $plugin_file !== GIVE_GOCARDLESS_BASENAME ) {
				return $plugin_meta;
			}

			$new_meta_links = array(
				sprintf(
					'<a href="%1$s" target="_blank">%2$s</a>', esc_url(
						add_query_arg(
							array(
								'utm_source'   => 'plugins-page',
								'utm_medium'   => 'plugin-row',
								'utm_campaign' => 'admin',
							), 'https://givewp.com/documentation/add-ons/gocardless-gateway'
						)
					), __( 'Documentation', 'give-gocardless' )
				),
				sprintf(
					'<a href="%1$s" target="_blank">%2$s</a>', esc_url(
						add_query_arg(
							array(
								'utm_source'   => 'plugins-page',
								'utm_medium'   => 'plugin-row',
								'utm_campaign' => 'admin',
							), 'https://givewp.com/addons/'
						)
					), __( 'Add-ons', 'give-gocardless' )
				),
			);

			return array_merge( $plugin_meta, $new_meta_links );

		}

		/**
		 * Allow this class and other classes to add notices.
		 *
		 * @since 1.3
		 *
		 * @param $slug
		 * @param $class
		 * @param $message
		 */
		public function add_admin_notice( $slug, $class, $message ) {
			$this->notices[ $slug ] = array(
				'class'   => $class,
				'message' => $message,
			);
		}

		/**
		 * Display admin notices.
		 *
		 * @since 1.3
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

	} //End Give_Gocardless Class.

endif;

/**
 * Loads a single instance of Give GoCardless.
 *
 * This follows the PHP singleton design pattern.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @example <?php $give_gocardless = Give_Gocardless(); ?>
 *
 * @since   1.0.0
 *
 * @see     Give_Gocardless::get_instance()
 *
 * @return object Give_Gocardless Returns an instance of the  class
 */
function Give_Gocardless() {
	return Give_Gocardless::get_instance();
}

Give_Gocardless();
