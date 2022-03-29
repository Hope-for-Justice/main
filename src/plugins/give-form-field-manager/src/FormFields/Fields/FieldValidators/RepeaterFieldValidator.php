<?php

namespace GiveFormFieldManager\FormFields\Fields\FieldValidators;


use GiveFormFieldManager\FormFields\Fields\Contracts\FieldValidator;
use GiveFormFieldManager\FormFields\Fields\Repeater;

/**
 *
 */
class RepeaterFieldValidator implements FieldValidator
{
    /**
     * @var Repeater
     */
    private $field;
    /**
     * @var array
     */
    private $formInputValue;

    /**
     * @since 2.0.3
     *
     * @param Repeater $field
     * @param array $formInputValue
     */
    public function __construct(Repeater $field, array $formInputValue)
    {
        $this->field = $field;
        $this->formInputValue = $formInputValue;
    }

    /**
     * @since 2.0.3
     */
    public function __invoke()
    {
        // First of all, register error if data that’s not good.
        if ($this->field->isRequired() && empty($this->formInputValue)) {
            $this->registerEmptyFieldError($this->field->getName());

            return;
        }

        // These are the field columns.
        $columns = $this->field->getColumns();

        if ( ! $this->validateRepeaterFieldLimit()) {
            return;
        }

        $name = $this->field->getName();

        foreach ($this->formInputValue as $columnIndex => $columnValue) {
            // Single-column repeater field form input value is combination array of string.
            // Multi-column repeater field form input value is combination  two-dimensional array of string.

            // Next, we need to determine whether this is multi-column or single-column
            if (empty($columns)) {
                // single-column repeater field.
                $this->validateValue("{$name}[{$columnIndex}]", $columnValue);
            } else {
                // multi-column repeater field.
                // We loop through the actual column array value
                foreach ($columnValue as $rowIndex => $row) {
                    $this->validateValue("{$name}[{$columnIndex}][{$rowIndex}]", $row);
                }
            }
        }
    }

    /**
     * @since 2.0.3
     *
     * @param string $specifiedInputName
     * @param string $columnValue
     */
    private function validateValue($specifiedInputName, $columnValue)
    {
        $filteredValue = trim($columnValue);
        $allowedCharacterLimit = $this->field->getMaxLength();

        // Handle non-multi-column repeater: simple numeric array
        if ($this->field->isRequired() && empty($filteredValue)) {
            $this->registerEmptyFieldError($specifiedInputName);
        }

        // Ensure value does not exceed allowed character limit.
        if ($allowedCharacterLimit && strlen($filteredValue) > $allowedCharacterLimit) {
            $this->registerInvalidStringLengthFieldError($specifiedInputName);
        }
    }

    /**
     * @since 2.0.3
     */
    private function validateRepeaterFieldLimit()
    {
        $allowedMaximumFieldCount = $this->field->getMaxRepeatable();
        $fieldCount = empty($this->field->getColumns()) ?
            count($this->formInputValue) :
            count(current($this->formInputValue));

        if ($allowedMaximumFieldCount && $allowedMaximumFieldCount < $fieldCount) {
            $this->registerInvalidFieldCountError($this->field->getName());

            return false;
        }

        return true;
    }

    /**
     * @since 2.0.3
     */
    private function registerEmptyFieldError($specificInputName)
    {
        give_set_error(
            "give-{$specificInputName}-required-field-missing",
            $this->field->getRequiredError()['error_message']
        );
    }

    /**
     * @since 2.0.3
     */
    private function registerInvalidStringLengthFieldError($specificInputName)
    {
        give_set_error(
            "give-{$specificInputName}-required-field-exceed-allowed-character-limit",
            sprintf(
                esc_html__('%1$s field value exceed allowed character limit.', 'give-form-field-manager'),
                $this->field->getLabel()
            )
        );
    }

    /**
     * @since 2.0.3
     */
    private function registerInvalidFieldCountError($specificInputName)
    {
        give_set_error(
            "give-{$specificInputName}-required-field-exceed-allowed-repeater-field-limit",
            sprintf(
                esc_html__('%1$s fields count exceed allowed field limit.', 'give-form-field-manager'),
                $this->field->getName()
            )
        );
    }
}
