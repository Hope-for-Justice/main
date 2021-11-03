<?php
namespace GiveFormFieldManager\Helpers;

use Give_FFM_Render_Form;
use function give_get_payment_form_id as getDonationFormId;
use function give_get_meta as getDonationMeta;

/**
 * Class Form
 *
 * @package GiveFormFieldManager\Helpers
 * @since 1.4.5
 */
class Form {
	/**
	 * Get custom fields from donation meta.
	 *
	 * @param  int  $donationId
	 *
	 * @return array
	 * @since 1.4.5
	 */
	public static function getSavedCustomFields( $donationId ) {
		$fields = [];

		// List of field types that we can ignore when returning the receipt detail.
		$skipFieldList = [ 'section', 'html', 'action_hook' ];

		$formId           = getDonationFormId( $donationId );
		$customFormFields = self::get_input_fields( $formId );

		// Loop through form fields and match.
		foreach ( $customFormFields as $key => $value ) {
			if ( empty( $value ) ) {
				continue;
			}

			foreach ( $value as $field ) {
				// Double check this input type is set.
				if ( ! isset( $field['input_type'] ) ) {
					continue;
				}

				// Ignore section break and HTML input type.
				if ( in_array( $field['input_type'], $skipFieldList, true ) ) {
					continue;
				}

				// Whether to return a single value (complex repeaters return array).
				if ( isset( $field['columns'] ) && ! empty( $field['columns'][0] ) ) {
					$field_data = getDonationMeta( $donationId, $field['name'], false );
				} else {
					$field_data = getDonationMeta( $donationId, $field['name'], true );
				}

				// Only show fields with data.
				if ( empty( $field_data ) ) {
					continue;
				}

				// Handle various input types' output.
				switch ( $field['input_type'] ) {
					case 'textarea' :
						$field['value'] = nl2br( $field_data );
						break;

					case 'checkbox' :
					case 'radio' :
						$field['value'] = html_entity_decode( $field_data );
						break;

					default :
						$field['value'] = $field_data;
				}

				$fields[] = $field;
			}
		}

		return $fields;
	}

	/**
	 * Get input meta fields separated as post vars, taxonomy and meta vars.
	 *
	 * @param  int  $form_id  form id
	 *
	 * @return array
	 */
	public static function get_input_fields( $form_id ) {
		$form_vars = give_get_meta( $form_id, Give_FFM_Render_Form::$meta_key, true );

		$ignore_lists = array( 'section', 'html' );
		$post_vars    = $meta_vars = $taxonomy_vars = array();

		if ( $form_vars == null ) {
			return array( array(), array(), array() );
		}

		foreach ( $form_vars as $key => $value ) {
			// ignore section break and HTML input type
			if ( in_array( $value['input_type'], $ignore_lists ) ) {
				continue;
			}

			// separate the post and custom fields
			if ( isset( $value['is_meta'] ) && $value['is_meta'] == 'yes' ) {
				$meta_vars[] = $value;
				continue;
			}

			$post_vars[] = $value;
		}

		return array( $post_vars, $taxonomy_vars, $meta_vars );
	}

	/**
	 * Prepare Meta Fields.
	 *
	 * @param $meta_vars
	 *
	 * @return array
	 */
	public static function prepare_meta_fields( $meta_vars ) {
		// Loop through custom fields skip files, put in a key => value paired array for later execution process repeatable fields separately if the input is array type, implode with separator in a field.
		$files          = array();
		$meta_key_value = array();
		$multi_repeated = array(); // multi repeated fields will in store duplicated meta key.

		foreach ( $meta_vars as $key => $value ) {
			// Check is field hide?
			$is_field_hide = ( isset( $value['hide_field'] ) && 'on' === $value['hide_field'] ) ? true : false;

			// put files in a separate array, we'll process it later.
			if ( ( $value['input_type'] == 'file_upload' ) || ( $value['input_type'] == 'image_upload' ) ) {
				$files[] = array(
					'name'  => $value['name'],
					'value' => isset( $_POST['ffm_files'][ $value['name'] ] ) ? $_POST['ffm_files'][ $value['name'] ] : array(),
				);
				// process repeatable fields
			} elseif (
				'repeat' === $value['input_type']
				&& ! $is_field_hide
			) {
				// if it is a multi column repeat field
				if ( isset( $value['multiple'] ) ) {
					// if there's any items in the array, process it
					if ( $_POST[ $value['name'] ] ) {
						$ref_arr = array();
						$cols    = count( $value['columns'] );
						$ar_vals = array_values( $_POST[ $value['name'] ] );
						$first   = array_shift( $ar_vals ); // first element
						$rows    = count( $first );

						// loop through columns
						for ( $i = 0; $i < $rows; $i ++ ) {
							// loop through the rows and store in a temp array
							$temp = array();
							for ( $j = 0; $j < $cols; $j ++ ) {
								$temp[] = $_POST[ $value['name'] ][ $j ][ $i ];
							}

							// store all fields in a row with self::$separator separated
							$ref_arr[] = implode( Give_FFM_Render_Form::$separator, $temp );
						}

						// now, if we found anything in $ref_arr, store to $multi_repeated
						if ( $ref_arr ) {
							$multi_repeated[ $value['name'] ] = array_slice( $ref_arr, 0, $rows );
						}
					}
				} else {
					$meta_key_value[ $value['name'] ] = implode( Give_FFM_Render_Form::$separator,
					                                             $_POST[ $value['name'] ] );
				}
			} elseif ( ! empty( $_POST[ $value['name'] ] ) ) {
				// if it's an array, implode with this->separator
				if ( is_array( $_POST[ $value['name'] ] ) ) {
					$meta_key_value[ $value['name'] ] = implode( Give_FFM_Render_Form::$separator,
					                                             $_POST[ $value['name'] ] );
				} else {
					$meta_key_value[ $value['name'] ] = trim( $_POST[ $value['name'] ] );
				}
			}// End if().
		} // End foreach().

		return array( $meta_key_value, $multi_repeated, $files );
	}

	/**
	 * Validates if required fields are filled.
	 *
	 * @return void
	 * @since 1.2.9
	 * @since 2.0.0 Validation radio and checkbox field if required
	 *
	 */
	public function validate_required_fields() {
		$posted_data = is_array( $_POST ) ? give_clean( $_POST ) : array();

		$form_id         = ! empty( $posted_data['give-form-id'] ) ? $posted_data['give-form-id'] : '';
		$form_vars       = self::get_input_fields( $form_id );
		$required_fields = give_get_meta( $form_id, 'give-form-required-fields', true );
		$required_flag   = false;

		list( $post_vars, $tax_vars, $meta_vars ) = $form_vars;

		// Ensure that required fields are not empty.
		if ( empty( $required_fields ) || empty( $meta_vars ) ) {
			return;
		}

		/**
		 * The following loop takes care of fields such
		 * as text, textarea, email, phone and url.
		 */
		foreach ( $meta_vars as $key => $value ) {
			$valid_data[ $value['name'] ] = ! empty( $posted_data[ $value['name'] ] ) ? $posted_data[ $value['name'] ] : '';

			// Set required false if field is hide.
			if ( isset( $value['hide_field'] ) && 'on' === $value['hide_field'] ) {
				$required_flag = false;
				break;
			}

			if ( ! empty( $value['required'] ) && 'yes' === $value['required'] ) {
				switch ( $value['input_type'] ) {
					case 'text':
					case 'textarea':
					case 'email':
					case 'phone':
					case 'url':
					case 'date':
					case 'checkbox':
					case 'radio':
						if ( empty( $valid_data[ $value['name'] ] ) ) {
							$required_flag = true;
						}
						break;

					case 'select':
					case 'multiselect':
						if ( empty( $valid_data[ $value['name'] ][0] ) ) {
							$required_flag = true;
						}

						break;

					case 'repeat':
						$repeat_fields = $valid_data[ $value['name'] ];

						foreach ( $repeat_fields as $data ) {
							if ( empty( $data ) ) {
								$required_flag = true;
							}
						}

						break;

					default:
						break;
				}
			} // End if().
		} // End foreach().

		if ( $required_flag ) {
			give_set_error( 'incomplete-required-fields',
			                sprintf( __( 'Please complete all required fields', 'give-form-field-manager' ) ) );
		}

		/**
		 * Hook that fires after validating all the
		 * FFM required fields.
		 *
		 * @since 1.2.9
		 */
		do_action( 'give_ffm_fields_validated' );
	}


	/**
	 * Submit Post.
	 *
	 * @param  int  $payment  Payment ID.
	 * @param  array  $payment_data  Payment Data.
	 */
	public function submit_post( $payment, $payment_data ) {
		$form_id       = $payment_data['give_form_id'];
		$form_vars     = self::get_input_fields( $form_id );
		$form_settings = give_get_meta( $form_id, 'give-form-fields_settings', true );

		list( $post_vars, $tax_vars, $meta_vars ) = $form_vars;

		$post_id = $payment;

		self::update_post_meta( $meta_vars, $post_id, $form_vars );

		// Set the post form_id for later usage.
		update_post_meta( $post_id, Give_FFM_Render_Form::$config_id, $form_id );
	}

	/**
	 * Update Post Meta.
	 *
	 * Updates individual meta fields and _give_payment_meta as
	 * an array of all meta fields combined.
	 *
	 * @param $meta_vars
	 * @param $post_id
	 * @param $form_vars
	 */
	public static function update_post_meta( $meta_vars, $post_id, $form_vars ) {
		// Prepare the meta vars.
		list( $meta_key_value, $multi_repeated, $files ) = self::prepare_meta_fields( $meta_vars );
		$textarea_fields = array();

		// Get default payment meta so we can add to it below.
		$default_meta = (array) give_get_meta( $post_id, '_give_payment_meta', true );

		// Array of file fields formatted as key-value pairs.
		$files_key_value = array();

		// Save custom fields.
		foreach ( $form_vars[2] as $key => $value ) {
			if ( isset( $_POST[ $value['name'] ] ) ) {
				if ( 'textarea' === $value['input_type'] ) {
					$textarea_fields[ $value['name'] ] = $value['rich'];
				}

				update_post_meta( $post_id, $value['name'], $_POST[ $value['name'] ] );
			}
		}

		// Save all custom fields.
		foreach ( $meta_key_value as $meta_key => $meta_value ) {
			// Process textarea value differently.
			if (
				! empty( $textarea_fields )
				&& array_key_exists( $meta_key, $textarea_fields )
			) {
				$meta_value = wp_kses_post( $meta_value );

				$meta_value = 'no' === $textarea_fields[ $meta_key ]
					? wp_strip_all_tags( $meta_value )
					: $meta_value;

				update_post_meta( $post_id, $meta_key, $meta_value );

				continue;
			}

			$values     = array_values( array_filter( give_clean( explode( '|', $meta_value ) ) ) );
			$meta_value = implode( ' | ', $values );
			update_post_meta( $post_id, $meta_key, $meta_value );
		}

		// Save any multi column repeatable fields.
		foreach ( $multi_repeated as $repeat_key => $repeat_value ) {
			// First, delete any previous repeatable fields.
			delete_post_meta( $post_id, $repeat_key );
			// Now add them.
			foreach ( $repeat_value as $repeat_field ) {
				// Filter out the empty value for repeater fields.
				if ( '|' !== give_clean( $repeat_field ) ) {
					add_post_meta( $post_id, $repeat_key, $repeat_field );
				}
			}
		}

		// Save any files attached.
		foreach ( $files as $file_input ) {
			// Delete any previous value.
			delete_post_meta( $post_id, $file_input['name'] );
			foreach ( $file_input['value'] as $attachment_id ) {
				give_ffm_associate_attachment( $attachment_id, $post_id );
				add_post_meta( $post_id, $file_input['name'], $attachment_id );
				$files_key_value[ $file_input['name'] ] = $file_input['value'];
			}
		}

		// Combine all meta fields.
		$all_meta = array_merge(
			$default_meta, // meta associated with all Give donations (user_info, email, date, etc.).
			$meta_key_value, // singular custom fields added via FFM.
			$multi_repeated, // multi-column repeatable custom fields added via FFM.
			$files_key_value // file fields added via FFM.
		);

		// update one meta field with array of all meta fields combined.
		update_post_meta( $post_id, '_give_payment_meta', $all_meta );
	}
}
