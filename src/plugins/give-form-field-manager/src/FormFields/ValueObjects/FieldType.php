<?php

namespace GiveFormFieldManager\FormFields\ValueObjects;

use Give\Framework\FieldsAPI\Types;
use GiveFormFieldManager\Infrastructure\Enum;

/**
 * @method static self action_hook()
 * @method static self checkbox()
 * @method static self date()
 * @method static self email()
 * @method static self file()
 * @method static self hidden()
 * @method static self html()
 * @method static self multiselect()
 * @method static self phone()
 * @method static self radio()
 * @method static self repeat()
 * @method static self section()
 * @method static self select()
 * @method static self text()
 * @method static self textarea()
 * @method static self url()
 */
class FieldType extends Enum {
	const action_hook = 'action_hook';
	const checkbox    = 'checkbox';
	const date        = 'date';
	const email       = 'email';
	const file        = 'file_upload';
	const hidden      = 'hidden';
	const html        = 'html';
	const multiselect = 'multiselect';
	const phone       = 'phone';
	const radio       = 'radio';
	const repeat      = 'repeat';
	const section     = 'section';
	const select      = 'select';
	const text        = 'text';
	const textarea    = 'textarea';
	const url         = 'url';

	/**
	 * Map the FFM field type to corresponding Fields API
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function getFieldsApiType() {
		return [
			static::action_hook => null,
			static::checkbox    => Types::CHECKBOX,
			static::date        => Types::DATE,
			static::email       => Types::EMAIL,
			static::file        => Types::FILE,
			static::hidden      => Types::HIDDEN,
			static::html        => Types::HTML,
			static::multiselect => Types::SELECT,
			static::phone       => Types::PHONE,
			static::radio       => Types::RADIO,
			static::repeat      => Types::HTML,
			static::section     => Types::HTML,
			static::select      => Types::SELECT,
			static::text        => Types::TEXT,
			static::textarea    => Types::TEXTAREA,
			static::url         => Types::URL,
		][ $this->getValue() ];
	}
}
