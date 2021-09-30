<?php

/**
 * Class Give_Zapier_Customer
 *
 * Provides additional information for Zapier.
 *
 * @since 1.1
 */
class Give_Zapier_Customer extends Give_Donor {

	/**
	 * First name.
	 *
	 * @var string
	 */
	public $first_name;

	/**
	 * Last name.
	 *
	 * @var string
	 */
	public $last_name;

	/**
	 * Get First Name.
	 *
	 * @return string
	 */
	public function get_first_name() {

		$names = explode( ' ', $this->name );

		return ! empty( $names[0] ) ? $names[0] : '';

	}

	/**
	 * Get Last Name.
	 *
	 * @return string
	 */
	public function get_last_name() {

		$names     = explode( ' ', $this->name );
		$last_name = '';
		if ( ! empty( $names[1] ) ) {
			unset( $names[0] );
			$last_name = implode( ' ', $names );
		}

		return $last_name;

	}

}