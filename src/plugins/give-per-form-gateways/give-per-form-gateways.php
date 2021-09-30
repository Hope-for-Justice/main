<?php
/**
 * Plugin Name:     Give - Per Form Gateways
 * Plugin URI:      https://givewp.com/addons/per-form-gateways/
 * Description:     Choose on a per-form basis which payment gateways you would like enabled for donors.
 * Version:         1.0.2
 * Author:          GiveWP
 * Author URI:      https://givewp.com
 * Text Domain:     give-per-form-gateways
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Give_Per_Form_Gateways' ) ) {

	/**
	 * Class Give_Per_Form_Gateways
	 *
	 * @since 1.0
	 */
	class Give_Per_Form_Gateways {


		/**
		 * @var         Give_Per_Form_Gateways $instance The one true Give_Per_Form_Gateways
		 * @since       1.0
		 */
		private static $instance;

		/**
		 * Notices (array)
		 *
		 * @since 1.0.2
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * Get active instance.
		 *
		 * @access      public
		 * @since       1.0
		 * @return      self::$instance The one true Give_Per_Form_Gateways
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
				self::$instance->setup();
			}

			return self::$instance;
		}

		/**
		 * Setup Give_Per_Form_Gateways.
		 *
		 * @since  1.0.2
		 * @access private
		 */
		private function setup() {

			// Setup constants.
			$this->setup_constants();

			// Give init hook.
			add_action( 'give_init', array( $this, 'init' ), 10 );
			add_action( 'admin_init', array( $this, 'check_environment' ), 999 );
			add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );
		}


		/**
		 * Setup plugin constants.
		 *
		 * @access      public
		 * @since       1.0
		 * @return      void
		 */
		private function setup_constants() {

			// Plugin version.
			if ( ! defined( 'GIVE_PER_FORM_GATEWAYS_VERSION' ) ) {
				define( 'GIVE_PER_FORM_GATEWAYS_VERSION', '1.0.2' );
			}

			// Min Give Core version.
			if ( ! defined( 'GIVE_PER_FORM_GATEWAYS_MIN_GIVE_VERSION' ) ) {
				define( 'GIVE_PER_FORM_GATEWAYS_MIN_GIVE_VERSION', '2.2.0' );
			}

			// Plugin path.
			if ( ! defined( 'GIVE_PER_FORM_GATEWAYS_DIR' ) ) {
				define( 'GIVE_PER_FORM_GATEWAYS_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin URL.
			if ( ! defined( 'GIVE_PER_FORM_GATEWAYS_URL' ) ) {
				define( 'GIVE_PER_FORM_GATEWAYS_URL', plugin_dir_url( __FILE__ ) );
			}

			// Basename.
			if ( ! defined( 'GIVE_PER_FORM_GATEWAYS_BASENAME' ) ) {
				define( 'GIVE_PER_FORM_GATEWAYS_BASENAME', plugin_basename( __FILE__ ) );
			}

		}

		/**
		 * Include necessary files.
		 *
		 * @access      private
		 * @since       1.0.2
		 * @return      void
		 */
		public function init() {

			$this->load_textdomain();
			$this->licensing();

			if ( ! $this->get_environment_warning() ) {
				return;
			}

			$this->activation_banner();

			require_once GIVE_PER_FORM_GATEWAYS_DIR . 'includes/give-per-form-gateways-core.php';

			if ( is_admin() ) {
				require_once GIVE_PER_FORM_GATEWAYS_DIR . 'includes/admin/plugins-list.php';
				require_once GIVE_PER_FORM_GATEWAYS_DIR . 'includes/admin/meta-boxes.php';
			}

		}


		/**
		 * Run action and filter hooks
		 *
		 * @access      private
		 * @since       1.0
		 * @return      void
		 */
		private function licensing() {
			// Handle licensing.
			if ( class_exists( 'Give_License' ) ) {
				new Give_License( __FILE__, 'Per Form Gateways', GIVE_PER_FORM_GATEWAYS_VERSION, 'WordImpress' );
			}
		}

		/**
		 * Check plugin environment.
		 *
		 * @since  1.0.2
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
				$this->add_admin_notice( 'prompt_give_activate', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> plugin installed and activated for Give - Per Form Gateways to activate.', 'give-per-form-gateways' ), 'https://givewp.com' ) );
				$is_working = false;
			}

			return $is_working;
		}

		/**
		 * Check plugin for Give environment.
		 *
		 * @since  1.0.2
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
				&& version_compare( GIVE_VERSION, GIVE_PER_FORM_GATEWAYS_MIN_GIVE_VERSION, '<' )
			) {

				/* Min. Give. plugin version. */
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> core version %s for the Give - Per Form Gateways add-on to activate.', 'give-per-form-gateways' ), 'https://givewp.com', GIVE_PER_FORM_GATEWAYS_MIN_GIVE_VERSION ) );

				$is_working = false;
			}

			return $is_working;
		}


		/**
		 * Show activation banner for this add-on.
		 *
		 * @since 1.0.2
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

				//Only runs on admin
				$args = array(
					'file'              => __FILE__,
					'name'              => esc_html__( 'Per Form Gateways', 'give-per-form-gateways' ),
					'version'           => GIVE_PER_FORM_GATEWAYS_VERSION,
					'documentation_url' => 'http://docs.givewp.com/addon-per-form-gateways',
					'support_url'       => 'https://givewp.com/priority-support/',
					'testing'           => false //Never leave as TRUE!
				);
				new Give_Addon_Activation_Banner( $args );
			}

			return true;
		}

		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'give_per_form_gateways_language_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), '' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'give-per-form-gateways', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/give-per-form-gateways/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/give-per-form-gateways/ folder
				load_textdomain( 'give-per-form-gateways', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/give-per-form-gateways/ folder
				load_textdomain( 'give-per-form-gateways', $mofile_local );
			} else {
				// Load the traditional language files
				load_plugin_textdomain( 'give-per-form-gateways', false, $lang_dir );
			}
		}


		/**
		 * Allow this class and other classes to add notices.
		 *
		 * @since 1.0.2
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
		 * @since 1.0.2
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
	}
}


/**
 * The main function responsible for returning the Give_Per_Form_Gateways instance.
 *
 * @since       1.0
 * @return      Give_Per_Form_Gateways The one true Give_Per_Form_Gateways
 */
function give_per_form_gateways() {
	return Give_Per_Form_Gateways::instance();
}

give_per_form_gateways();
