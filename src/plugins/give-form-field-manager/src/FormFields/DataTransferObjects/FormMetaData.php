<?php

namespace GiveFormFieldManager\FormFields\DataTransferObjects;

use ReflectionException;

/**
 * Class FormMetaData
 *
 * @since 2.0.0
 */
class FormMetaData {
	/** @var array */
	private $data;
	/** @var int */
	public $formId;
	/** @var array */
	public $fields;
	/** @var string */
	public $action;

	/**
	 * FormMetaData constructor.
	 *
	 * @param array $data
	 *
	 * @throws ReflectionException
	 */
	public function __construct( array $data ) {
		$this->data   = $data;
		$this->formId = $this->integer( 'formId' );
		$this->action = $this->giveFieldsActionString( 'action' );
		$this->fields = $this->formFields( 'fields' );
	}

	/**
	 * @param $value
	 *
	 * @return int|null
	 */
	protected function integer( $value ) {
		return array_key_exists( $value, $this->data ) && $this->data[ $value ] ? (int) $this->data[ $value ] : null;
	}

	/**
	 * Internal helper for getting the give_fields_ hook
	 *
	 * @param $value
	 *
	 * @return string
	 */
	protected function giveFieldsActionString( $value ) {
		return array_key_exists( $value, $this->data ) ? str_replace( 'give_', 'give_fields_', $this->data[ $value ] ) : '';
	}

	/**
	 * @param $value
	 *
	 * @return array|FormFieldData[]
	 * @throws ReflectionException
	 */
	protected function formFields( $value ) {
		return array_key_exists( $value, $this->data ) ? array_map(
			static function ( $field ) {
				return new FormFieldData( $field );
			},
			$this->data[ $value ]
		) : [];
	}
}
