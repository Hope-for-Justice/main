<?php

namespace GiveStripe\Infrastructure;

/**
 * Class Log
 *
 * @package GiveStripe\Infrastructure
 * @since 2.3.0
 */
class Log extends \Give\Log\Log {
	/**
	 * @inheritDoc
	 *
	 * @param string  $name
	 * @param array $arguments
	 *
	 *@since 2.3.0
	 *
	 */
	public static function __callStatic( $name, $arguments ) {
		$arguments[1]['source'] = 'Give Stripe';

		parent::__callStatic( $name, $arguments );
	}

}
