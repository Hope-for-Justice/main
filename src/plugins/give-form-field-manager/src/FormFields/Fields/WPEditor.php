<?php

namespace GiveFormFieldManager\FormFields\Fields;

use Give\Framework\FieldsAPI\Concerns\HasEmailTag;
use Give\Framework\FieldsAPI\Concerns\HasHelpText;
use Give\Framework\FieldsAPI\Concerns\HasLabel;
use Give\Framework\FieldsAPI\Concerns\HasVisibilityConditions;
use Give\Framework\FieldsAPI\Concerns\ShowInReceipt;
use Give\Framework\FieldsAPI\Concerns\StoreAsMeta;
use Give\Framework\FieldsAPI\Field;
use GiveFormFieldManager\FormFields\Fields\Contracts\HasFormInputValidator;
use GiveFormFieldManager\FormFields\Fields\FieldValidators\WPEditorFieldValidator;

/**
 * @since 2.0.0
 */
class WPEditor extends Field implements HasFormInputValidator {
	use HasEmailTag;
	use HasHelpText;
	use HasLabel;
	use ShowInReceipt;
	use StoreAsMeta;
    use HasVisibilityConditions;

	/**
	 * @var string
	 */
	const TYPE = 'ffm-wp-editor';

	/**
	 * support: teeny, rich ( without media and quick tags )
	 *
	 * @var string
	 */
	protected $editorType = 'teeny';

	/**
	 * WP Editor default config.
	 * @var array
	 */
	private $defaultEditorConfig = [
		'quicktags'     => false,
		'media_buttons' => false,
		'teeny'         => true,
		'editor_class'  => ' rich-editor',
	];

	/**
	 * @see wp_editor settings: https://developer.wordpress.org/reference/classes/_wp_editors/parse_settings/
	 *
	 * @var array
	 */
	protected $editorConfig;

	/**
	 * @since 2.0.0
	 *
	 * @return self
	 */
	public function useRichTextEditor(){
		$this->defaultEditorConfig['teeny'] = false;

		return $this;
	}

	/**
	 * @since 2.0.0
	 *
	 * @return self
	 */
	public function useSmallRichTextEditor(){
		$this->defaultEditorConfig['teeny'] = true;

		return $this;
	}

	/**
	 * @since 2.0.0
	 *
	 * @param array $editorConfig
	 *
	 * @return $this
	 */
	public function editorConfig( $editorConfig ) {
		$this->editorConfig = $editorConfig;

		return $this;
	}

	/**
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function getEditorConfig() {
		return wp_parse_args(
			$this->editorConfig,
			$this->defaultEditorConfig
		);
	}

    /**
     * @unreleased
     * @inerhitDoc
     * @return string
     */
    public function getFormInputValidator()
    {
        return WPEditorFieldValidator::class;
    }
}
