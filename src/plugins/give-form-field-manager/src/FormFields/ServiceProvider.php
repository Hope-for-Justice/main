<?php
namespace GiveFormFieldManager\FormFields;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider as GiveWPServiceProvider;
use GiveFormFieldManager\FormFields\Actions\RegisterFields;
use GiveFormFieldManager\FormFields\Fields\Date;
use GiveFormFieldManager\FormFields\Fields\Repeater;
use GiveFormFieldManager\FormFields\Fields\WPEditor;
use GiveFormFieldManager\FormFields\Repositories\FormFieldsRepository;
use function give;

/**
 * Class FormFieldsProvider
 *
 * @since 2.0.0
 */
class ServiceProvider implements GiveWPServiceProvider {
	/**
	 * @inheritdoc
	 */
	public function register() {
		give()->bind( FormFieldsRepository::class );
	}

	/**
	 * @inheritdoc
	 */
	public function boot() {
		give( RegisterFields::class )->init();
		$this->registerCustomFields();
	}

	/**
	 * @since 2.0.0
	 */
	private function registerCustomFields(){
		$customFields = [
			WPEditor::TYPE,
			Repeater::TYPE,
			Date::TYPE
		];

		foreach ( $customFields as $fieldType ) {
			Hooks::addAction(
				"give_fields_api_render_$fieldType",
				FieldView::class,
				'__invoke',
				10,
				2
			);
		}

		Hooks::addAction(
			'give_fields_legacy_consumer_validate_field',
			FieldValidation::class
		);

		Hooks::addAction(
			'give_fields_api_save_field',
			FieldPersistence::class,
			'__invoke',
			10,
			2
		);
	}
}
