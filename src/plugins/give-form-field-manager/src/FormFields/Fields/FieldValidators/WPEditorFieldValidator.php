<?php

namespace GiveFormFieldManager\FormFields\Fields\FieldValidators;

use GiveFormFieldManager\FormFields\Fields\Contracts\FieldValidator;
use GiveFormFieldManager\FormFields\Fields\WPEditor;

/**
 * @unreleased
 */
class WPEditorFieldValidator implements FieldValidator
{
    /**
     * @var WPEditor
     */
    private $field;

    /**
     * @var string
     */
    private $formInputValue;

    public function __construct( WPEditor $field, $formInputValue )
    {
        $this->field = $field;
        $this->formInputValue = $formInputValue;
    }

    /**
     * @unreleased
     */
    public function __invoke()
    {
        if ( $this->field->isRequired() && empty($this->formInputValue)) {
            give_set_error(
                "give-{$this->field->getName()}-required-field-missing",
                $this->field->getRequiredError()['error_message']
            );
        }
    }

}
