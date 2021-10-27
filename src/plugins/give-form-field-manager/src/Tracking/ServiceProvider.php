<?php
namespace GiveFormFieldManager\Tracking;

use Give\ServiceProviders\ServiceProvider as GiveWPServiceProvider;
use GiveFormFieldManager\FormFields\ValueObjects\MetaKey;

/**
 * Class TrackingServiceProvider
 * @package GiveFormFieldManager\Tracking
 *
 * @since 2.0.0
 */
class ServiceProvider implements GiveWPServiceProvider {
	/**
	 * @inheritdoc
	 */
	public function register() {
	}

	/**
	 * @inheritdoc
	 */
	public function boot() {
		add_filter(
			'give_telemetry_form_uses_addon_form_field_manager',
			static function( $result, $formId ) {
				return ! empty( give()->form_meta->get_meta( $formId, MetaKey::fields()->getValue(), true ) );
			},
			10,
			2
		);
	}
}
