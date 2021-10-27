<?php

namespace GiveFormFieldManager\Infrastructure;

use Give\Framework\Exceptions\Primitives\InvalidArgumentException;

/**
 * Helper class responsible for loading add-on views.
 *
 * @package     GiveFormFieldManager\Infrastructure
 * @since 2.0.0
 */
class View {
	/**
	 * Load template.
	 *
	 * @since 2.0.0
	 *
	 * @param  array  $vars
	 * @param  bool  $echo
	 *
	 * @param  string  $view
	 *
	 * @return false|string
	 * @throws InvalidArgumentException if template file not exist
	 */
	public static function load( $view, $vars = [], $echo = false ) {
		$template = GIVE_FFM_PLUGIN_DIR . 'src/resources/views/' . $view . '.php';

		if ( ! file_exists( $template ) ) {
			throw new InvalidArgumentException( "View template file $template not exist" );
		}

		ob_start();
		// phpcs:ignore
		extract( $vars );
		include $template;
		$content = ob_get_clean();

		if ( ! $echo ) {
			return $content;
		}

		echo $content;
	}

	/**
	 * Render template.
	 *
	 * @since 2.0.0
	 *
	 * @param  string  $view
	 * @param  array  $vars
	 *
	 * @void
	 */
	public static function render( $view, $vars = [] ) {
		static::load( $view, $vars, true );
	}
}
