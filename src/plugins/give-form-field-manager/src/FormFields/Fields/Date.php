<?php

namespace GiveFormFieldManager\FormFields\Fields;

use Give\Framework\FieldsAPI\Concerns\HasEmailTag;
use Give\Framework\FieldsAPI\Concerns\HasHelpText;
use Give\Framework\FieldsAPI\Concerns\HasLabel;
use Give\Framework\FieldsAPI\Concerns\ShowInReceipt;
use Give\Framework\FieldsAPI\Concerns\StoreAsMeta;
use Give\Framework\FieldsAPI\Field;

/**
 * @since 2.12.0
 */
class Date extends Field {

	use HasEmailTag;
	use HasHelpText;
	use HasLabel;
	use ShowInReceipt;
	use StoreAsMeta;

	/**
	 * @var string
	 */
	const TYPE = 'ffm-date';

	/**
	 * @var string
	 */
	protected $dateFormat = 'mm/dd/yy';

	/**
	 * @var string
	 */
	protected $timeFormat = '';

	/**
	 * @since 2.0.0
	 * @see https://api.jqueryui.com/datepicker/#utility-formatDate
	 *
	 * @param string $dateFormat
	 */
	public function dateFormat( $dateFormat ){
		$this->dateFormat = $dateFormat;

		return $this;
	}

	/**
	 * @since 2.0.0
	 */
	public function getDateFormat(){
		return $this->dateFormat;
	}

	/**
	 * @since 2.0.0
	 * @see https://api.jqueryui.com/datepicker/#utility-formatDate
	 *
	 * @param string $timeFormat
	 */
	public function timeFormat( $timeFormat ){
		$this->timeFormat = $timeFormat;

		return $this;
	}

	/**
	 * @since 2.0.0
	 */
	public function getTimeFormat(){
		return $this->timeFormat;
	}
}
