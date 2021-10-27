<?php

namespace GiveFormFieldManager\Infrastructure;

/**
 * Helper class responsible for loading add-on translations.
 *
 * @package     GiveFormFieldManager\Infrastructure
 * @since 2.0.0
 */
class Language {
	/**
	 * Loads the plugin language files.
	 *
	 * @since 2.0.0
	 *
	 * @uses   dirname()
	 * @uses   plugin_basename()
	 * @uses   apply_filters()
	 * @uses   load_textdomain()
	 * @uses   get_locale()
	 * @uses   load_plugin_textdomain()
	 */
	public static function load() {
		// Set filter for plugin's languages directory.
		$languageDirectory = apply_filters(
			'give_languages_directory',
			dirname( GIVE_FFM_BASENAME ) . '/languages/'
		);

		// Traditional WordPress plugin locale filter.
		$locale = apply_filters( 'plugin_locale', get_locale(), 'give-form-field-manager' );
		$moFile = sprintf( '%1$s-%2$s.mo', 'give-form-field-manager', $locale );

		// Setup paths to current locale file.
		$moLocalFilePath  = $languageDirectory . $moFile;
		$moGlobalFilePath = WP_LANG_DIR . '/give-form-field-manager/' . $moFile;

		if ( file_exists( $moGlobalFilePath ) ) {
			// Look in global /wp-content/languages/give-form-field-manager folder.
			load_textdomain( 'give-form-field-manager', $moGlobalFilePath );
		} elseif ( file_exists( $moLocalFilePath ) ) {
			// Look in local /wp-content/plugins/give-form-field-manager/languages/ folder.
			load_textdomain( 'give-form-field-manager', $moLocalFilePath );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'give-form-field-manager', false, $languageDirectory );
		}
	}
}
