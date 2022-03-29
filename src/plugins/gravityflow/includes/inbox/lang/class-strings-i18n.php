<?php

namespace Gravity_Flow\Gravity_Flow\Inbox\Lang;

/**
 * Simple class to store i18n strings and their translations.
 *
 * @since 2.8
 */
class Strings_I18n {

	/**
	 * The strings to be translated.
	 *
	 * @since 2.8
	 *
	 * @return array
	 */
	public function strings() {
		return array(
			'actions_menu_heading'        => esc_html__( 'Note:', 'gravityflow' ),
			'browser_notifications_error' => esc_html__( 'Your browser does not support notifications.', 'gravityflow' ),
			'cancel'                      => esc_html__( 'Cancel', 'gravityflow' ),
			'disabled'                    => esc_html__( 'Disabled', 'gravityflow' ),
			'enabled'                     => esc_html__( 'Enabled', 'gravityflow' ),
			'inbox_notification_title'    => esc_html__( 'Workflow Inbox', 'gravityflow' ),
			'inbox_settings'              => esc_html__( 'Inbox Settings', 'gravityflow' ),
			'loading'                     => esc_html__( 'Loading...', 'gravityflow' ),
			'new_inbox_items'             => esc_html__( 'You have a new item in your workflow inbox.', 'gravityflow' ),
			'no_entries'                  => esc_html__( 'No Pending Tasks', 'gravityflow' ),
			'options_for_grid_not_found'  => esc_html__( 'Can\'t find inbox options for grid id:', 'gravityflow' ),
			''                            => esc_html__( '', 'gravityflow' ),
			'search_inbox'                => esc_html__( 'Search Inbox', 'gravityflow' ),
			'settings_push_title'         => esc_html__( 'Enable Push Notifications', 'gravityflow' ),
			'settings_push_desc'          => esc_html__( 'You will have to allow push notifications for this domain and browser to enable this feature. If you haven\'t already,
		your browser will ask you to enable them one time.', 'gravityflow' ),
			'submit'                      => esc_html__( 'Submit', 'gravityflow' ),
			'toggle_fullscreen_title'     => esc_html__( 'Toggle fullscreen for this table', 'gravityflow' ),
			'toggle_settings_title'       => esc_html__( 'Toggle settings for this table', 'gravityflow' ),
			'toggle_clear_filters_title'  => esc_html__( 'Clear active filters for this table', 'gravityflow' ),
			'view_entry'                  => esc_html__( 'View', 'gravityflow' ),
			'view_quick_actions'          => esc_html__( 'View quick actions', 'gravityflow' ),
		);
	}

}
