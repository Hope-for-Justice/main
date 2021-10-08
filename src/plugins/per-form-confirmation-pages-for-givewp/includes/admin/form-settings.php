<?php
// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Example code to show how to add metabox tab to give form data settingd.
 *
 * @package     Give
 * @subpackage  Classes/PFCONFS4GiveWP_Form_Settings
 * @copyright   Copyright (c) 2020, Impress.org
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class PFCONFS4GiveWP_Form_Settings {
	/**
	 * Give_Metabox_Setting_Fields constructor.
	 */
	function __construct() {
		$this->id     = 'pfconfs4givewp-fields';
		$this->prefix = '_pfconfs4givewp_';
		add_filter( 'give_metabox_form_data_settings', array( $this, 'setup_setting' ), 999 );
	}
	function setup_setting( $settings ) {

		$screen = get_current_screen();
        
        // Custom metabox settings.
		$settings["{$this->id}_tab"] = array(
			'id'        => "{$this->id}_tab",
			'title'     => __( 'Confirmation', 'sss4givewp' ),
			'icon-html' => '<span class="dashicons dashicons-text-page"></span>',
			'fields'    => array(
				array(
					'id'	   => "{$this->id}_disabled",
					'name'	   => '',
					'type'     => 'disabled_for_non_legacy_templates_html',
					'callback' => array($this,'disabled_for_non_legacy_templates_html'),
				),
				array(
					'id'       => "{$this->id}_status",
					'name'     => __( 'Enable', 'pfconfs-4-givewp' ),
					'type'     => 'radio_inline',
					'desc'     => __( 'Enable Per Form Confirmations by setting this to "Customize", or inherit the Global Success Page setting.', 'pfconfs-4-givewp' ),
					'options' => array( 
                        'global' => __('Global', 'pfconfs-4-givewp'),
                        'customize' => __('Customize', 'pfconfs-4-givewp'),
					 ),
                     'default' => 'global',
				),
				array(
					'id'       => "{$this->id}_page_url",
					'name'     => __( 'Page', 'pfconfs-4-givewp' ),
					'type'     => 'give_custom_pages_output',
					'callback' => array($this, 'give_custom_pages_output'),
					'desc'     => __( 'Choose the Page your Confirmation message is on.', 'pfconfs-4-givewp' ),
				),
				array(
					'id'       => "{$this->id}_message_location",
					'name'     => __( 'Message Location', 'pfconfs-4-givewp' ),
					'type'     => 'radio_inline',
					'desc'     => __( 'Set the position of the custom messaging or disable it completely.', 'pfconfs-4-givewp' ),
					'options' => array( 
						'disabled' => __('Disabled', 'pfconfs-4-givewp'),
                        'above' => __('Above', 'pfconfs-4-givewp'),
                        'below' => __('Below', 'pfconfs-4-givewp'),
                     ),
                     'default' => 'disabled',
				),
				array(
					'id'       => "{$this->id}_confirmation_message",
					'name'     => __( 'Message', 'pfconfs-4-givewp' ),
					'type'     => 'wysiwyg',
				),
			),
		);
		return $settings;
	}

	public function give_custom_pages_output( $field ) {
		global $thepostid, $post, $wpdb; 

		// Get the Donation form id.
		$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;

		// Get the styles if passed with the field array.
		$field['style']         = isset( $field['style'] ) ? $field['style'] : '';
		$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';

		// Get the option value by field and donation form id.
		$field['value'] = give_get_field_value( $field, $thepostid );

		// Generate name for option field.
		$field['name'] = isset( $field['name'] ) ? $field['name'] : $field['id'];

		$pagesquery = $this->give_find_give_receipt_pages();

		?>
		<p class="give-field-wrap <?php echo esc_attr( $field['id'] ); ?>_field <?php echo esc_attr( $field['wrapper_class'] ); ?>">
		<label for="<?php echo esc_attr( give_get_field_name( $field ) ); ?>">
			<?php echo wp_kses_post( $field['name'] ); ?>
		</label>
		<?php //var_dump($field['value']); ?>
		<select
				class="give-select give-settings"
				name="<?php echo esc_attr( give_get_field_name( $field ) ); ?>"
				id="<?php echo esc_attr( $field['id'] ); ?>"
		>
			<?php
			foreach ( $pagesquery as $page ) { 
				$selected = ($field['value'] == $page->ID) ? 'selected' : '';
				?>
				<option <?php echo $selected; ?> value="<?php echo $page->ID; ?>">
					<?php echo $page->post_title;?>
				</option><?php } ?>
			?>
		</select>
		<?php echo give_get_field_description( $field ); ?>
		<br />
		<span class="pfconfs-notice give-notice notice warning notice-warning"><?php _e('<strong>NOTE:</strong> This select field is only populated by pages that already have the <code>[give_receipt]</code> shortcode on them. If you do not see the page that you want to target for this form, go to "Pages" and add the <code>[give_receipt]</code> shortcode to that page first.</span>', 'pfconfs-4-givewp'); ?>
	</p>

		<?php 
	}

	public function give_find_give_receipt_pages() { 

		$cache_key = 'pfconfs_pages_w_shortcode';
		
		if ( ! $results = get_transient( $cache_key ) ) {
			ob_start();
			
			$args = array(
				's' => '[give_receipt]',
				'post_type' => 'page',
				'post_status'            => 'publish',
				'posts_per_page'		 => apply_filters('pfc4g_receipt_page_query_number',30),
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'cache_results'          => false
			);
			
			$the_query = new WP_Query( $args );

			$results = $the_query->posts;

			set_transient( $cache_key, $results, 24 * HOUR_IN_SECONDS );
		}
		
		wp_reset_postdata();
		return $results;
		
	}

	public function disabled_for_non_legacy_templates_html() {
		ob_start(); ?>
			<p class="pfconfs-disabled"><?php _e('Per Form Confirmations is not relevant for non-Legacy Form Templates. If you want to use Per Form Confirmations, then change your Form Template to the "Legacy" option.', 'pfconfs-4-givewp'); ?></p>
		<?php 

		$html = ob_get_contents();

		return $html;
	}
}
new PFCONFS4GiveWP_Form_Settings();