<?php

namespace GiveFormFieldManager\FormFields\Repositories;

use Give\Framework\Database\DB;
use GiveFormFieldManager\FormFields\DataTransferObjects\FormFieldData;
use GiveFormFieldManager\FormFields\DataTransferObjects\FormMetaData;
use GiveFormFieldManager\FormFields\ValueObjects\MetaKey;

class FormFieldsRepository {
	/**
	 * Helper to get fields without excluded types
	 *
	 * @return array
	 */
	public function getMetaFields( array $fields ) {
		return array_filter(
			$fields,
			static function ( $field ) {
				return ( new FormFieldData( $field ) )->isMeta;
			}
		);
	}

	/**
	 * Get Form settings
	 *
	 * @since 2.0.0
	 *
	 * @param $formId
	 *
	 * @return bool|mixed
	 */
	public function getFormSettings( $formId ) {
		return give_get_meta( $formId, MetaKey::settings()->getValue(), true );
	}

	/**
	 * Get all forms meta as array of FormMetaData objects
	 *
	 * @since 2.0.0
	 *
	 * @return FormMetaData[]
	 */
	public function getAllFormsWithMetaData() {
		$allFormMeta = $this->queryAllFormWithPlacementAndActionMeta();

		return array_map(
			static function ( $formMeta ) {
				return new FormMetaData(
					[
						'formId' => $formMeta->form_id,
						'action' => $formMeta->placement,
						'fields' => unserialize( $formMeta->fields ),
					]
				);
			},
			$allFormMeta
		);
	}

	/**
	 * Query form meta for placement and actions
	 *
	 * @since 2.0.0
	 *
	 * @return array|object|null
	 */
	private function queryAllFormWithPlacementAndActionMeta() {
		global $wpdb;

		return DB::get_results(
			DB::prepare(
				"
				SELECT m1.form_id, m1.meta_value as fields, m2.meta_value as placement
				FROM $wpdb->formmeta AS m1
				INNER JOIN $wpdb->formmeta AS m2
					ON m1.form_id = m2.form_id
				INNER JOIN $wpdb->posts AS p
					ON p.ID = m2.form_id
				WHERE m1.meta_key = %s
					AND m1.meta_value > ''
					AND m2.meta_key = %s
					AND p.post_status='publish'
				ORDER BY m1.form_id
				",
				MetaKey::fields()->getValue(),
				MetaKey::placement()->getValue()
			)
		);
	}
}
