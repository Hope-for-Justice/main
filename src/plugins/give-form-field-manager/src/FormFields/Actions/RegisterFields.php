<?php

namespace GiveFormFieldManager\FormFields\Actions;

use Give\Framework\FieldsAPI\Checkbox;
use Give\Framework\FieldsAPI\Contracts\Collection;
use Give\Framework\FieldsAPI\Contracts\Node;
use Give\Framework\FieldsAPI\Email;
use Give\Framework\FieldsAPI\Field;
use Give\Framework\FieldsAPI\File;
use Give\Framework\FieldsAPI\Hidden;
use Give\Framework\FieldsAPI\Html;
use Give\Framework\FieldsAPI\Option;
use Give\Framework\FieldsAPI\Phone;
use Give\Framework\FieldsAPI\Radio;
use Give\Framework\FieldsAPI\Select;
use Give\Framework\FieldsAPI\Text;
use Give\Framework\FieldsAPI\Textarea;
use Give\Framework\FieldsAPI\Types;
use Give\Framework\FieldsAPI\Url;
use GiveFormFieldManager\FormFields\DataTransferObjects\FormFieldData;
use GiveFormFieldManager\FormFields\Fields\Date;
use GiveFormFieldManager\FormFields\Fields\Repeater;
use GiveFormFieldManager\FormFields\Fields\WPEditor;
use GiveFormFieldManager\FormFields\Repositories\FormFieldsRepository;
use GiveFormFieldManager\FormFields\ValueObjects\FieldType;

/**
 * Class RegisterFields
 *
 * @since 2.0.0
 */
class RegisterFields {
	/**
	 * @var array $forms
	 */
	private $forms = [];

	/**
	 * @var FormFieldsRepository
	 */
	public $formFieldsRepository;

	/**
	 * RegisterFields constructor.
	 *
	 * @param FormFieldsRepository $formFieldsRepository
	 */
	public function __construct( FormFieldsRepository $formFieldsRepository ) {
		$this->formFieldsRepository = $formFieldsRepository;
	}

	/**
	 * @since 2.0.0
	 */
	public function init() {
		$this->forms = $this->formFieldsRepository->getAllFormsWithMetaData();

		$actions = $this->getActionsFromForms();

		foreach ( $actions as $action ) {
			add_action( $action, [ $this, 'register' ], 10, 2 );
		}
	}

	/**
	 * Register form fields with field api
	 *
	 * @since 2.0.0
	 *
	 * @param Collection $collection
	 * @param int $formId
	 *
	 * @return void
	 */
	public function register( Collection $collection, $formId ) {
		$formId = absint( $formId );
		$form = $this->validateForm( $formId );

		if ( ! $form ) {
			return;
		}


		// Add support for `ffm_add_post_form_top` action hook
		// Todo: deprecate ffm_add_post_form_top action hook
		ob_start();
		do_action( 'ffm_add_post_form_top', $formId, '' );
		if ( $output = ob_get_clean() ) {
			$collection->append( Html::make( 'ffm_add_post_form_top' )->html( $output ) );
			add_filter(
				"give_form_{$formId}_field_classes_ffm_add_post_form_top",
				function ( $classes ) {
					$classes[] = 'ffm-field-container';

					return $classes;
				}
			);
		}

		/** @var FormFieldData $field */
		foreach ( $form->fields as $field ) {
			$ffmInputType = $field->inputType;

			if ( $field->hideField ) {
				continue;
			}

			$this->addClassHook( $formId, $field );

			switch ( $ffmInputType ) {
				case FieldType::action_hook():
					ob_start();
					do_action( $field->name, $formId, null, '' );
					if ( $output = ob_get_clean() ) {
						$node = Html::make( $field->name )->html( $output );

						$collection->append( $node );
					}
					break;
				case FieldType::section():
					$node = Html::make( $field->name )->html(
						"<div class=\"give-section-break\">{$field->label}</div>"
					);

					$this->applyFieldConditions($node, $field);

					$collection->append( $node );
					break;
				case FieldType::repeat():
					$node = Repeater::make( $field->name )
						->label( $field->label )
						->helpText( $field->helpText )
						->placeholder( $field->placeholder )
						->defaultValue( $field->defaultValue )
						->required( $field->required )
						->maxRepeatable( $field->maximumRepeat )
						->maxLength( $field->maxLength );

					if ( $field->multiple ) {
						$node->columns( ...$field->columns );
					}

					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;
				case FieldType::file():
					$node = File::make($field->name)
                                ->label($field->label)
                                ->helpText($field->helpText)
                                ->required($field->required)
                                ->allowedTypes($field->getAllowedExtensions())
						->maxSize( $field->maxSize )
						->allowMultiple( (bool) $field->count );

					$this->applyFieldConditions($node, $field);

					$collection->append( $node );
					break;
				case FieldType::hidden():
					$collection->append(
						Hidden::make( $field->name )->defaultValue( $field->defaultValue )
					);
					break;
				case FieldType::html():
					$node = Html::make( $field->name )->html( $field->defaultValue );
					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;
				case FieldType::checkbox():
					$options = array_map(
						static function ( $value, $key ) {
							return Option::make( $value, is_string( $key ) ? $key : null );
						},
						array_values( $options = $field->options ),
						array_keys( $options )
					);

					$node = Checkbox::make( $field->name )
					                ->label( $field->label )
					                ->helpText( $field->helpText )
					                ->placeholder( $field->placeholder )
					                ->defaultValue( $field->defaultValue )
					                ->options( ...$options )
					                ->required( $field->required );

					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;
				case FieldType::radio():
					$options = array_map(
						static function ( $value, $key ) {
							return Option::make( $value, is_string( $key ) ? $key : null );
						},
						array_values( $options = $field->options ),
						array_keys( $options )
					);

					$node = Radio::make( $field->name )
						->label( $field->label )
						->helpText( $field->helpText )
						->placeholder( $field->placeholder )
						->defaultValue( $field->defaultValue )
						->options( ...$options )
						->required( $field->required );

					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;
				case FieldType::multiselect():
				case FieldType::select():
					$options = array_map(
						static function ( $value, $key ) {
							return Option::make( $value, is_string( $key ) ? $key : null );
						},
						array_values( $options = $field->options ),
						array_keys( $options )
					);

					$node = Select::make( $field->name )
						->label( $field->label )
						->helpText( $field->helpText )
						->placeholder( $field->first )
						->defaultValue( $field->defaultValue )
						->options( ...$options )
						->allowMultiple( FieldType::multiselect()->equals( $ffmInputType ) )
						->required( $field->required);

				$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;
				case FieldType::textarea():
					$node = $field->editorType ?
						WPEditor::make( $field->name ):
						Textarea::make( $field->name );

					$node->label( $field->label )
						->helpText( $field->helpText )
						->defaultValue( $field->defaultValue )
						->required( $field->required );

					if ( $node instanceof WPEditor ) {
						$node->useSmallRichTextEditor()
						     ->editorConfig( [ 'textarea_rows' => $field->rows ] );

						if ( 'rich' === $field->editorType ) {
							$node->useRichTextEditor();
						}
					} elseif ( $node instanceof Textarea ) {
						$node->placeholder( $field->placeholder );
					}

					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;

				case FieldType::date():
					$node = Date::make( $field->name )
					            ->label( $field->label )
					            ->helpText( $field->helpText )
					            ->defaultValue( $field->defaultValue )
					            ->required( $field->required )
					            ->timeFormat( $field->time ? $field->formatTime : '' )
					            ->dateFormat( $field->format );

					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );

					break;

				default:
					$fieldApiClass = "Give\\Framework\\FieldsAPI\\" . [
						'text' => 'Text',
						'textarea' => 'Textarea',
						'phone' => 'Phone',
						'url' => 'Url',
						'email' => 'Email'
					][ $ffmInputType->getValue() ];

					/** @var Text|Textarea|Phone|Url|Email $fieldApiClass */
					$node = $fieldApiClass::make( $field->name )
						->label( $field->label )
						->helpText( $field->helpText )
						->placeholder( $field->placeholder )
						->defaultValue( $field->defaultValue )
						->required( $field->required );

					if( $field->maxLength ) {
						$node->maxLength( $field->maxLength );
					}

					$this->applyFieldConditions( $node, $field );

					$collection->append( $node );
					break;
			}
		}

		// Add support for `ffm_add_post_form_bottom` action hook
		// Todo: deprecate ffm_add_post_form_bottom action hook
		ob_start();
		do_action( 'ffm_add_post_form_bottom', $formId, '' );
		if ( $output = ob_get_clean() ) {
			$collection->append( Html::make( 'ffm_add_post_form_bottom' )->html( $output ) );
			add_filter(
				"give_form_{$formId}_field_classes_ffm_add_post_form_bottom",
				function ( $classes ) {
					$classes[] = 'ffm-field-container';

					return $classes;
				}
			);
		}
	}

	/**
	 * Get actions from forms
	 *
	 * @return array
	 */
	private function getActionsFromForms() {
		return array_unique( wp_list_pluck( $this->forms, 'action' ) );
	}

	/**
	 * Get form from memory by formId
	 *
	 * @param $formId
	 *
	 * @return false|mixed
	 */
	private function getFormById( $formId ) {
		return current(
			array_filter(
				$this->forms,
				static function ( $form ) use ( $formId ) {
					return $form->formId === $formId;
				}
			)
		);
	}

	/**
	 * Return form if validation passes
	 *
	 * @param $formId
	 *
	 * @return false|mixed|void
	 */
	private function validateForm( $formId ) {
		// make sure the formId is in our list of forms
		if ( ! in_array( $formId, wp_list_pluck( $this->forms, 'formId' ), true ) ) {
			return;
		}

		// get form from memory
		$form = $this->getFormById( $formId );

		// make sure the current action matches the form in context's action value
		if ( current_action() !== $form->action ) {
			return;
		}

		return $form;
	}

	/**
	 * @since 2.0.0
	 *
	 * @param int $formId
	 * @param FormFieldData $field
	 */
	private function addClassHook( $formId, $field ){
		add_filter(
			"give_form_{$formId}_field_classes_{$field->name}",
			function ( $classes ) use ( $field ) {
				return $this->addClassNames( $classes, $field );
			}
		);
	}

	/**
	 * @since 2.0.0
     * @unreleased Insert custom class as string to array instead of array
	 *
	 * @param array $classList
	 * @param FormFieldData $field
	 *
	 * @return array
	 */
	private function addClassNames( $classList, $field ){
		$classList[] = 'ffm-field-container';

		// Handle field width
		if ( $field->fieldWidth !== 'full' ) {
			// Specifically remove the full-width class from the list since we are using other widths
			$classList = array_filter(
				$classList,
				static function ( $className ) {
					return $className !== 'form-row-wide';
				}
			);

			// This is banking on $field->fieldWidth always being one of these keys (otherwise this will break).
			$classList[] = $this->getWidthClassName( $field->fieldWidth );
		}

		// Phone field related class.
		if ( Types::PHONE === $field->inputType->getValue() ) {
			$classList[] = "js-phone-$field->format";
		}

		// Handle custom class names
		if ( ! empty( $field->css ) ) {
			$classList = array_merge( $classList, array_map( 'trim', explode( ' ', $field->css ) ) );
		}

		return array_filter( $classList );
	}

	/**
	 * @since 2.0.0
	 *
	 * @param string $width Only support "half", "one-third", and "two-third"
	 *
	 * @return string
	 */
	private function getWidthClassName( $width ) {
		$classes = [
			'half'      => 'give-ffm-form-row-half',
			'one-third' => 'give-ffm-form-row-third',
			'two-third' => 'give-ffm-form-row-thirds',
		];

		if ( array_key_exists( $width, $classes ) ) {
			return $classes[ $width ];
		}

		return '';
	}

	/**
	 * Add visibility conditions to node.
	 *
	 * @since 2.0.0
	 *
	 * @param Field $node
	 * @param FormFieldData $field
	 */
	private function applyFieldConditions( Node $node, FormFieldData $field ) {
		if ( $field->hasVisibilityCondition ) {
			$node->showIf(
				$field->fieldVisibilityControllerFieldName,
				$field->fieldVisibilityComparisonOperator,
				$field->fieldVisibilityControllerFieldValue
			);
		}
	}
}
