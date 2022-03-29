<?php

namespace GiveFormFieldManager\FormFields\Fields\Contracts;

/**
 * @since 2.0.3
 */
interface HasFormInputValidator
{
    /**
     * @since 2.0.3
     * @return string FieldValidator class name.
     */
    public function getFormInputValidator();
}
