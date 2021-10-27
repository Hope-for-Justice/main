<?php

namespace GiveFormFieldManager\Infrastructure;

/**
 * Helper class responsible for showing add-on notices.
 *
 * @package     GiveFormFieldManager\Infrastructure
 * @since 2.0.0
 */
class Notices {

	/**
	 * Add notice
	 *
	 * @since 2.0.0
	 * @param  string  $type
	 * @param  string  $description
	 * @param  bool  $show
	 */
	public static function add( $type, $description, $show = true ) {
		Give()->notices->register_notice(
			[
				'id'          => sprintf( 'give-ffm-notice-%s', $type ),
				'type'        => $type,
				'description' => $description,
				'show'        => $show,
			]
		);
	}

	/**
	 * GiveWP min required version notice.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public static function giveVersionError() {
		self::add( 'error', View::load( 'admin/notices/give-version-error' ) );
	}

	/**
	 * GiveWP inactive notice.
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public static function giveInactive() {
		self::add( 'error', View::load( 'admin/notices/give-inactive' ) );
	}
}
