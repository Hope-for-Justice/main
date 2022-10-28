<?php

/**
 * Plugin Name:       Guten-edits
 * Description:       Editing Gutenberg for HfJ
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            James Holt
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       guten-edits
 */

function guten_enqueue()
{
    wp_enqueue_script(
        'guten-script',
        plugins_url('/build/index.js', __FILE__),
        ['wp-blocks', 'wp-element', 'wp-i18n'], // required dependencies for blocks
        _S_VERSION,
        true
    );
}
add_action('enqueue_block_editor_assets', 'guten_enqueue');
