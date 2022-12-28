/* global _SEARCHWP */

( function($) {

    'use strict';

    const app = {

        /**
         * Init.
         *
         * @since 1.7.3
         */
        init: () => {

            $( app.ready );
        },

        /**
         * Document ready
         *
         * @since 1.7.3
         */
        ready: () => {

            app.events();
        },

        /**
         * Extension page events.
         *
         * @since 1.7.3
         */
        events: () => {

            const $notificationsPanel = $( '.searchwp-notifications-panel-wrapper' );

            if ( window.location.hash === '#notifications' ) {
                $notificationsPanel.show();
            }

            $( window ).on(
                'hashchange',
                () => {
                    if ( window.location.hash === '#notifications' ) {
                        $notificationsPanel.show();
                    }
                }
            );

            $( '.searchwp-admin-menu-notification-indicator' ).parent().click(
                () => {
                    if ( window.location.hash === '#notifications' ) {
                        $notificationsPanel.show();
                    }
                }
            );

            $( '.searchwp-branding-bar__actions-button' ).click(
                () => $notificationsPanel.show()
            );

            $( '.searchwp-notifications-panel__close' ).click(
                () => $notificationsPanel.hide()
            );

            $( '.searchwp-notifications-backdrop' ).click(
                () => $notificationsPanel.hide()
            );

            $( '.searchwp-notification-dismiss' ).click( app.dismiss );
        },

        /**
         * Dismiss notification.
         *
         * @since 1.7.3
         */
        dismiss: ( event ) => {

            const $el = $( event.target );

            // AJAX call - update option.
            const data = {
                _ajax_nonce: _SEARCHWP.nonce,
                action: _SEARCHWP.prefix + 'notification_dismiss',
                id: $el.data( 'id' ),
            };

            const $notification = $el.closest( '.searchwp-notifications-notification' );

            const handleResponse = ( res ) => {
                if ( res.success ) {
                    $notification.fadeOut(
                        100,
                        () => {
                            $notification.remove();
                            app.updateNotificationCount();
                        }
                    );
                }
            };

            $.post( ajaxurl, data, handleResponse );
        },

        /**
         * Update notification count in various places or reload the page if no notifications left.
         *
         * @since 1.7.3
         */
        updateNotificationCount: () => {

            const notificationsCount = $( '.searchwp-notifications-panel__notifications' ).children().length;

            $( '.searchwp-branding-bar__actions-button-count' ).text( notificationsCount );
            $( '.searchwp-notifications-panel__header span span' ).text( notificationsCount );

            if ( notificationsCount !== 0 ) {
                return;
            }

            if ( window.location.hash ) {
                window.location.hash = '';
            }

            location.reload();
        }
    };

    app.init();

    window.searchwp = window.searchwp || {};

    window.searchwp.LiveSearchAdminNotifications = app;

}( jQuery ) );
