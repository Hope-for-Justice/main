<?php

namespace GiveFormFieldManager\FormFields\Fields\FieldValidators;

use GiveFormFieldManager\FormFields\Fields\Contracts\FieldValidator;
use GiveFormFieldManager\FormFields\Fields\WPEditor;

/**
 * @since 2.0.3
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
     * @since 2.0.3
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
