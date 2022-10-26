<?php

//enque block scripts for save
if (is_page_template('templates/page-block-template.php') || is_tax('event_categories')) {
    wp_enqueue_script('block-scripts', get_template_directory_uri() . '/assets/js/block-scripts.js', array(), _S_VERSION, true);
}

function enqueue_editor_scripts()
{

    $blockPath = '/assets/js/block-scripts.js';

    wp_enqueue_script(
        'block-editor-scripts',
        get_template_directory_uri() . $blockPath,
        ['wp-blocks', 'wp-element', 'wp-i18n'], // required dependencies for blocks
        _S_VERSION,
        true
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_editor_scripts');
