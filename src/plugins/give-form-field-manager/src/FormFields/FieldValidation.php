<?php

namespace GiveFormFieldManager\FormFields;

use Give\Framework\FieldsAPI\Field;
use GiveFormFieldManager\FormFields\Fields\Repeater;
use GiveFormFieldManager\FormFields\Fields\WPEditor;

/**
 * @since 2.0.0
 */
class FieldValidation
{
    /**
     * @since 2.0.0
     *
     * @param Field $field
     */
    public function __invoke($field)
    {
        switch ($field->getType()) {
            case WPEditor::TYPE:
                // WPEditor content is not available during AJAX, so it gets validated upon form submission
                if (isset($_POST['give_ajax'])) {
                    break;
                }
            case Repeater::TYPE:
                $this->validate($field);
        }
    }

    /**
     * @param WPEditor|Repeater $field
     */
    private function validate(Field $field)
    {
        $className = $field->getFormInputValidator();

        // This field gives back an array which we need to loop through to check if the values have been set.
        $validator = new $className(
            $field,
            empty($_POST[$field->getName()]) ? [] : $_POST[$field->getName()]
        );
        $validator();
    }
}

