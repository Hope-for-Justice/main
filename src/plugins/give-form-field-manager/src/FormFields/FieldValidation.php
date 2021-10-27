<?php

namespace GiveFormFieldManager\FormFields;

use Give\Framework\FieldsAPI\Field;
use GiveFormFieldManager\FormFields\Fields\Repeater;
use GiveFormFieldManager\FormFields\Fields\WPEditor;

/**
 * @since 2.0.0
 */
class FieldValidation {
	/**
	 * @since 2.0.0
	 *
	 * @param Field $field
	 */
	public function __invoke( $field ) {
		switch ( $field->getType() ) {
			case WPEditor::TYPE:
				// WPEditor content is not available during AJAX, so it gets validated upon form submission
				if ( ! isset( $_POST['give_ajax'] ) && $field->isRequired() && empty( $_POST[ $field->getName() ] ) ) {
					give_set_error(
						"give-{$field->getName()}-required-field-missing",
						$field->getRequiredError()['error_message']
					);
				}
				break;

			case Repeater::TYPE:
				/** @var Repeater $field */
				// This field gives back an array which we need to loop through to check if the values have been set.
				$name = $field->getName();

				/**
				 * For re-using the same error for the different conditions.
				 *
				 * @void
				 */
				$emptyFieldError               = function ( $specificInputName ) use ( $field ) {
					give_set_error(
						"give-{$specificInputName}-required-field-missing",
						$field->getRequiredError()['error_message']
					);
				};
				$InvalidStringLengthFieldError = function ( $specificInputName ) use ( $field ) {
					give_set_error(
						"give-{$specificInputName}-required-field-missing",
						sprintf(
							esc_html__( '%1$s field value exceed allowed character limit.', 'give-form-field-manager' ),
							$field->getName()
						)
					);
				};

				// First of all, if the top-level key is not in the POST
				// data that’s not good.
				if ( empty( $_POST[ $name ] ) ) {
					$emptyFieldError( $name );
					break;
				}

				// These are the field columns.
				$columns       = $field->getColumns();
				$columnIndices = array_keys( $columns );

				// These are the actual rows of data.
				$rows = $_POST[ $name ];

				foreach ( $rows as $rowIndex => $row ) {
					// Next, we need to determine whether this is multi-column
					// or not since the data structure will be different.
					if ( empty( $columns ) ) {
						// Handle non-multi-column repeater: simple numeric array
						if ( $field->isRequired() && empty( trim( $row ) ) ) {
							$emptyFieldError( "{$name}[{$rowIndex}]" );
						}

						// Ensure value does not exceed allowed character limit.
						if ( strlen( trim( $row ) ) > $field->getMaxLength() ) {
							$InvalidStringLengthFieldError( "{$name}[{$rowIndex}]" );
						}
					} else {
						// We loop through the actual columns since we don’t
						// want more than what’s defined in the schema for
						// the field.
						foreach ( $columnIndices as $columnIndex ) {
							if( $field->isRequired() ) {
								// Ensure the column is present.
								if ( ! isset( $row[ $columnIndex ] ) ) {
									$emptyFieldError( "{$name}[{$columnIndex}][{$rowIndex}]" );
									continue;
								}

								// Ensure the value is set.
								if ( empty( trim( $row[ $columnIndex ] ) ) ) {
									$emptyFieldError( "{$name}[{$columnIndex}][{$rowIndex}]" );
								}
							}

							// Ensure value does not exceed allowed character limit.
							if ( strlen( trim( $row ) ) > $field->getMaxLength() ) {
								$InvalidStringLengthFieldError( "{$name}[{$columnIndex}][{$rowIndex}]" );
							}
						}
					}
				}
				break;
		}
	}
}

