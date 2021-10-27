<?php
namespace GiveFormFieldManager\Infrastructure;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider as GiveWPServiceProvider;

/**
 * Class FormFieldManagerServiceProvider
 *
 * @package GiveFormFieldManager
 * @since 2.0.0
 */
class ServiceProvider implements GiveWPServiceProvider {
	/**
	 * @inheritDoc
	 * @since 2.0.0
	 */
	public function register() {
	}

	/**
	 * @inheritDoc
	 * @since 2.0.0
	 */
	public function boot() {
		Hooks::addAction( 'init', Language::class, 'load' );
	}
}
