<?php
namespace GiveFormFieldManager\FormFields;

use Give\Form\LegacyConsumer\UniqueIdAttributeGenerator;
use Give\Framework\FieldsAPI\Field;
use GiveFormFieldManager\FormFields\Fields\Date;
use GiveFormFieldManager\FormFields\Fields\Repeater;
use GiveFormFieldManager\FormFields\Fields\WPEditor;
use GiveFormFieldManager\Infrastructure\View;

/**
 * @since 2.0.0
 */
class FieldView {
	/**
	 * @since 2.0.0
	 *
	 * @param Field|WPEditor $field
	 * @param int $formId
	 */
	public function __invoke( $field, $formId ) {
		$viewData = [
			'field'                => $field,
			'formId'               => $formId,
			'fieldIdAttribute'     => give( UniqueIdAttributeGenerator::class )->getId( $formId, $field->getName() ),
		];


		switch ( $field->getType() ) {
			case WPEditor::TYPE:
				View::render( 'field-templates/label.html', $viewData );
				View::render( 'field-templates/wp-editor.html', $viewData );

				break;

			case Date::TYPE:
				View::render( 'field-templates/label.html', $viewData );
				View::render( 'field-templates/date.html', $viewData );

				break;

			case Repeater::TYPE:
				View::render( 'field-templates/label.html', $viewData );
				View::render( 'field-templates/repeater.html', $viewData );

				break;
		}
	}
}
