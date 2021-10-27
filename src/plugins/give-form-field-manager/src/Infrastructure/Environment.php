<?php

namespace GiveFormFieldManager\Infrastructure;

/**
 * Helper class responsible for checking the add-on environment.
 *
 * @package     GiveFormFieldManager\Infrastructure
 * @since 2.0.0
 */
class Environment {
	/**
	 * Check environment.
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function checkEnvironment() {
		// Check is GiveWP active
		if ( ! static::isGiveActive() ) {
			add_action( 'admin_notices', [ Notices::class, 'giveInactive' ] );

			return false;
		}

		// Check min required version
		if ( ! static::giveMinRequiredVersionCheck() ) {
			add_action( 'admin_notices', [ Notices::class, 'giveVersionError' ] );

			return false;
		}

		return true;
	}

	/**
	 * Check min required version of GiveWP.
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function giveMinRequiredVersionCheck() {
		return defined( 'GIVE_VERSION' ) && version_compare( GIVE_VERSION, GIVE_FFM_MIN_GIVE_VERSION, '>=' );
	}

	/**
	 * Check if GiveWP is active.
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function isGiveActive() {
		return defined( 'GIVE_VERSION' );
	}
}
