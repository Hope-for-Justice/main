<?php

add_action('wp_enqueue_scripts', 'register_custom_core_block_styles');
add_action('admin_enqueue_scripts', 'register_custom_core_block_styles');

function register_custom_core_block_styles()
{
    if (has_block('core/paragraph') || is_admin()) {
        wp_enqueue_style('core_paragraph_styles', get_template_directory_uri() . '/template-parts/blocks/paragraph.css', array(), _S_VERSION);
    }
    if (has_block('core/heading') || is_admin()) {
        wp_enqueue_style('core_heading_styles', get_template_directory_uri() . '/template-parts/blocks/heading.css', array(), _S_VERSION);
    }
    if (has_block('core/spacer') || is_admin()) {
        wp_enqueue_style('core_spacer_styles', get_template_directory_uri() . '/template-parts/blocks/core-spacer.css', array(), _S_VERSION);
    }
    if (has_block('core/pullquote') || is_admin()) {
        wp_enqueue_style('core_pullquote_styles', get_template_directory_uri() . '/template-parts/blocks/pull-quote.css', array(), _S_VERSION);
    }
    if (has_block('core/list') || is_admin()) {
        wp_enqueue_style('core_list_styles', get_template_directory_uri() . '/template-parts/blocks/list.css', array(), _S_VERSION);
    }
}
