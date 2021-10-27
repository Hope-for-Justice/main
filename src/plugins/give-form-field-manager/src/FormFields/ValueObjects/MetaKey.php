<?php

namespace GiveFormFieldManager\FormFields\ValueObjects;

use GiveFormFieldManager\Infrastructure\Enum;

/**
 * @method static self fields()
 * @method static self placement()
 * @method static self settings()
 */
class MetaKey extends Enum {
	const fields = 'give-form-fields';
	const placement = '_give_ffm_placement';
	const settings = 'give-form-fields_settings';
}
