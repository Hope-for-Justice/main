<?php

namespace GiveFormFieldManager\FormFields\Fields;

use Give\Framework\FieldsAPI\Concerns;
use Give\Framework\FieldsAPI\Field;
use GiveFormFieldManager\FormFields\Fields\Contracts\HasFormInputValidator;
use GiveFormFieldManager\FormFields\Fields\FieldValidators\RepeaterFieldValidator;

/**
 * @since 2.0.0
 */
class Repeater extends Field implements HasFormInputValidator{

	use Concerns\HasEmailTag;
	use Concerns\HasHelpText;
	use Concerns\HasLabel;
	use Concerns\HasMaxLength;
	use Concerns\HasPlaceholder;
	use Concerns\StoreAsMeta;
	use Concerns\ShowInReceipt;

	const TYPE = 'ffm-repeat';

	/** @var string[] */
	protected $columns = [];

	/**
	 * Add columns to the repeater
	 *
	 * @since 2.0.0
	 *
 	 * @param string[] $columns
 	 * @return $this
 	 */
	public function columns( ...$columns ) {
		$this->columns = $columns;

		return $this;
	}

	/**
	 * Get the columns.
	 *
	 * @since 2.0.0
	 *
 	 * @return string[]
 	 */
	public function getColumns() {
		return $this->columns;
	}

	/**
	 * Set the maximum times the field/row can repeat.
	 *
	 * @since 2.0.0
	 *
	 * @param int $maxRepeatable
	 *
	 * @return $this
	 */
	public function maxRepeatable( $maxRepeatable ) {
		$this->validationRules->rule( 'maxRepeatable', $maxRepeatable );

		return $this;
	}

	/**
	 * Get the maximum times the field/row can repeat.
	 *
	 * @since 2.0.0
	 *
	 * @return int|null
	 */
	public function getMaxRepeatable() {
		return $this->validationRules->getRule( 'maxRepeatable' );
	}

    /**
     * @since 2.0.3
     * @inerhitDoc
     * @return string
     */
    public function getFormInputValidator()
    {
        return RepeaterFieldValidator::class;
    }
}
