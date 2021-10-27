<?php

namespace GiveFormFieldManager\FormFields;

use Give\Framework\FieldsAPI\Field;
use GiveFormFieldManager\FormFields\Fields\Repeater;
use GiveFormFieldManager\FormFields\Fields\WPEditor;

/**
 * @since 2.0.0
 */
class FieldPersistence {
	/**
	 * @since 2.0.0
	 *
	 * @param Field|WPEditor $field
	 * @param int $donationId
	 */
	public function __invoke( $field, $donationId ) {
		switch ( $field->getType() ) {
			case WPEditor::TYPE:
				if ( isset( $_POST[ $field->getName() ] ) ) {
					$value = wp_kses_post( $_POST[ $field->getName() ] );
					$this->save( $field, $donationId, $value );
				}

				break;
			case Repeater::TYPE:
				/** @var Repeater $field */

				$name = $field->getName();

				if ( isset( $_POST[ $name ] ) ) {
					// These are the field columns.
					$columns = $field->getColumns();

					// These are the actual rows of data.
					$rows = (array) give_clean( $_POST[ $name ] );
					$rows = $this->filterRepeaterFieldValue( $field, $rows );

					if ( empty( $columns ) ) {
						$metaValue = implode( '| ', array_values( array_filter( $rows ) ) );
						$this->save( $field, $donationId, $metaValue );
					} else {
						// Handle multi-column repeater: two dimensional numeric array
						$rows = $this->reGroupRepeaterFieldMultiColumnValue( $field, $rows );
						foreach ( $rows as $row ) {
							$metaValue = implode( '| ', array_values( array_filter( $row ) ) );
							$this->save( $field, $donationId, $metaValue );
						}
					}
				}

				break;
		}
	}

	/**
	 * @since 2.0.0
	 *
	 * @param Field|Repeater|WPEditor $field
	 * @param $donationId
	 * @param $metaValue
	 */
	private function save( $field, $donationId, $metaValue ){
		if ( $field->shouldStoreAsDonorMeta() ) {
			$donorID = give_get_payment_meta( $donationId, '_give_payment_donor_id' );
			Give()->donor_meta->add_meta( $donorID, $field->getName(), $metaValue );
		} else {
			// Store as Donation Meta - default behavior.
			give()->payment_meta->add_meta( $donationId, $field->getName(), $metaValue );
		}
	}

	/**
	 * @since 2.0.0
	 *
	 * @param Repeater $field
	 * @param array $rows
	 *
	 * @return array
	 */
	private function reGroupRepeaterFieldMultiColumnValue( $field, $rows ){
		$value = [];

		foreach ( $rows as $columnIndex => $row ) {
			foreach ( $row as $index => $rowValue ) {
				$value[$index][$columnIndex] = $rowValue;
			}
		}

		return $value;
	}

	/**
	 * @since 2.0.0
	 *
	 * @param Repeater $field
	 * @param array $rows
	 *
	 * @return array
	 */
	private function filterRepeaterFieldValue( $field, &$rows ){
		$columnCount = count( $field->getColumns() );
		$rowCount = $field->getMaxRepeatable();

		if( $columnCount ) {
			// multi-column repeater field.
			$rows = array_splice( $rows, 0, $columnCount );

			array_walk( $rows, function( &$row ) use ( $rowCount ) {
				if( $rowCount ) {
					$row = array_slice( $row, 0, $rowCount );
				}
			});

		} else {
			// non-multi-column repeater field.
			$rows = array_splice( $rows, 0, $rowCount );
		}

		return  $rows;
	}
}
