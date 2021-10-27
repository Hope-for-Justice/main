<?php

namespace GiveFormFieldManager\Infrastructure;

/**
 * Class Log
 *
 * @package GiveFormFieldManager\Infrastructure
 * @since 2.0.0
 */
class Log extends \Give\Log\Log {
	/**
	 * @inheritDoc
	 * @since 2.0.0
	 *
	 * @param  string  $name
	 * @param  array  $arguments
	 */
	public static function __callStatic( $name, $arguments ) {
		$arguments[1]['source'] = 'Form Field Manager';

		parent::__callStatic( $name, $arguments );
	}
}
