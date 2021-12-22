<?php

namespace GiveFormFieldManager\FormFields\DataTransferObjects;

use Give\Framework\FieldsAPI\Types;
use GiveFormFieldManager\FormFields\ValueObjects\FieldType;
use ReflectionException;

use function give_ffm_allowed_extension;

/**
 * Class FormFieldData
 *
 * @since 2.0.1 Remove extensions property and setExtensionsProperty to prevent memory leaks.
 * @since 2.0.0
 */
class FormFieldData {
	/** @var array */
	private $data;
	/** @var FieldType */
	public $inputType;
	/** @var string */
	public $template;
	/** @var bool */
	public $required;
	/** @var string */
	public $label;
	/** @var string */
	public $name;
	/** @var bool */
	public $isMeta;
	/** @var string */
	public $fieldWidth;
	/** @var string */
	public $css;
	/** @var string */
	public $helpText;
	/** @var string */
	public $placeholder;
	/** @var string|array */
	public $defaultValue;
	/** @var int */
	public $maxLength;
	/** @var int */
	public $rows;
	/** @var int */
	public $cols;
	/** @var string */
	public $formatTime;
	/** @var bool */
	public $time;
	/** @var string */
	public $format;
	/** @var string */
	public $first;
	/** @var bool */
	public $hideField;
	/**
	 * @var int
	 *
	 * @note size is in bytes
	 */
	public $maxSize;
	/** @var int */
	public $count;
	/**
	 * @deprecated Admin can not create textarea of WYSIWYG type, so do not need this property.
	 *             We are setting editorType property for backward compatibility In the future, it will be removed.
	 *             https://github.com/impress-org/give-form-field-manager/pull/359
	 * @var mixed|string
	 */
	public $editorType;
	/** @var string[] */
	public $columns;
	/** @var int|null */
	public $maximumRepeat;
	/** @var array */
	public $options;
	/** @var bool */
	public $multiple;
	/** @var bool */
	public $hasVisibilityCondition;
	/** @var string */
	public $fieldVisibilityControllerFieldName;
	/** @var string */
	public $fieldVisibilityComparisonOperator;
	/** @var string */
	public $fieldVisibilityControllerFieldValue;

	/**
	 * FormFieldData constructor.
	 *
     * @unreleased Decode html entities in operator value.
     *
	 * @param array $data
	 *
	 * @throws ReflectionException
	 */
	public function __construct( array $data ) {
		$this->data                                = $data;
		$this->inputType                           = $this->fieldType( 'input_type' );
		$this->name                                = $this->string( 'name' );
		$this->template                            = $this->string( 'template' );
		$this->required                            = $this->boolean( 'required' );
		$this->isMeta                              = $this->boolean( 'is_meta' );
		$this->label                               = $this->string( 'label' );
		$this->fieldWidth                          = $this->string( 'field_width' );
		$this->css                                 = $this->string( 'css' );
		$this->helpText                            = $this->string( 'help' );
		$this->placeholder                         = $this->string( 'placeholder' ); // Only exist in text and textarea field
		$this->first                               = $this->string( 'first' ); // Only exist in select field
		$this->maxLength                           = (int) $this->string( 'maxlength' );
		$this->rows                                = (int) $this->string( 'rows' );
		$this->cols                                = (int) $this->string( 'cols' );
		$this->formatTime                          = $this->string( 'format_time' );
		$this->time                                = $this->boolean( 'time' );
		$this->format                              = $this->string( 'format' );
		$this->hideField                           = $this->boolean( 'hide_field', 'on' );
		$this->maxSize                             = (int) $this->string( 'max_size' ) * 1024; // Only exist in file upload field.
		$this->count                               = (int) $this->string( 'count' ); // Only exist in file upload field.
		$this->maximumRepeat                       = (int) $this->string( 'maximum_repeat' );
		$this->columns                             = $this->arrayValue( 'columns' );
		$this->multiple                            = $this->boolean( 'multiple', 'true' );
		$this->options                             = $this->arrayValue( 'options' );
		$this->fieldVisibilityControllerFieldName  = $this->string( 'controller_field_name' );
		$this->fieldVisibilityComparisonOperator   = html_entity_decode( $this->string( 'controller_field_operator' ) );
		$this->fieldVisibilityControllerFieldValue = $this->string( 'controller_field_value' );
		$this->hasVisibilityCondition              = $this->boolean( 'control_field_visibility', 'on' ) &&
		                                             $this->fieldVisibilityControllerFieldName &&
		                                             $this->fieldVisibilityComparisonOperator;

        $this->setDefaultValueProperty($data);
        $this->setEditorTypeProperty(); // Only exist in textarea field.
    }

    /**
     * @since 2.0.0
     *
     * @param array $data
     */
    private function setDefaultValueProperty($data)
    {
        if (in_array($this->inputType->getFieldsApiType(), [Types::SELECT, Types::CHECKBOX, Types::RADIO])) {
            $this->defaultValue = isset($data['selected']) ? $data['selected'] : [];
        } elseif ('html' === $data['input_type']) {
            $this->defaultValue = $this->string('html');
        } else {
            $this->defaultValue = $this->maxLength ?
                substr($this->string('default'), 0, $this->maxLength) :
                $this->string('default');
        }
    }

    /**
     * @since 2.0.1
     *
     * @return array
     *
     * Note: Use this function to get allowed fields extension list.
     *       There is not any limitation of use but this function work better for "File Upload" field type.
     */
    public function getAllowedExtensions()
    {
        $defaultAllowedExtensionsInFFM = give_ffm_allowed_extension();
        $selectedExtensionIds          = ! empty($this->data['extension']) ? $this->data['extension'] : [];
        $allowedExtensions             = [];
        $allowedMimeTypesInWP          = get_allowed_mime_types();
        $extensions                    = [];

        if (empty($selectedExtensionIds)) {
            $extensions = $allowedMimeTypesInWP;
        }

        foreach ($selectedExtensionIds as $extensionId) {
            if ( ! array_key_exists($extensionId, $defaultAllowedExtensionsInFFM)) {
                continue;
            }

            $allowedExtensions = array_merge(
                $allowedExtensions,
                array_map('trim', explode(',', $defaultAllowedExtensionsInFFM[$extensionId]['ext']))
            );
        }

        foreach ($allowedExtensions as $extension) {
            foreach ($allowedMimeTypesInWP as $ext => $mimeType) {
                if (false === strpos($ext, '|')) {
                    if ($ext !== $extension) {
                        continue;
                    }
                } elseif ( ! in_array($extension, explode('|', $ext))) {
                    continue;
                }

                $extensions[$ext] = $mimeType;
                break;
            }
        }

        return $extensions;
    }

    /**
     * @since 2.0.0
     */
    private function setEditorTypeProperty()
    {
        $editorType       = $this->string('rich'); // Only for textarea
        $this->editorType = '';

        if ('yes' === $editorType) {
            $this->editorType = 'rich';
        } elseif ('teeny' === $editorType) {
            $this->editorType = 'teeny';
        }
    }

    /**
     * Boolean cast helper
     *
     * @param string $value
     *
     * @return bool
     */
    private function boolean($value, $expected = 'yes')
    {
        return array_key_exists($value, $this->data) && $this->data[$value] === $expected;
    }

    /**
     * String cast helper
     *
     * @param string $value
     *
     * @return mixed|string
     */
    private function string($value)
    {
        return isset($this->data[$value]) ? $this->data[$value] : '';
    }

    /**
     * Array cast helper
     *
     * @param string $value
     *
     * @return array
     */
    private function arrayValue($value)
    {
        return $this->useDataOrFallback($value, []);
    }

    /**
     * FieldType cast helper
     *
     * @param $value
     *
     * @return FieldType
     * @throws ReflectionException
     */
    private function fieldType($value)
    {
        return new FieldType($this->data[$value]);
    }

    /**
     * Use the data provided if it exists or the fallback.
     *
     * @since 2.0.0
     *
     * @param string $value
     * @param mixed $fallback
     *
     * @return mixed
     */
    private function useDataOrFallback($value, $fallback)
    {
        return array_key_exists($value, $this->data) && ! empty($this->data[$value])
            ? $this->data[$value]
            : $fallback;
    }
}
