<?php

namespace GiveFormFieldManager\FormFields\DataTransferObjects;

/**
 * Class DonationData
 *
 * @since 2.0.0
 */
class DonationData {
	/** @var int */
	public $formId;

	/**
	 * DonationData constructor.
	 *
	 * @param  array  $data
	 */
	public function __construct( array $data ) {
		$this->formId = $data['give_form_id'];
	}
}
