<?php

/**
 * button
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'button-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$color = get_field('button_color') ?: '#D6001C';
$text_color = get_field('text_color') ?: '#ffffff';
$link = get_field('link');

$link_url = $link['url'] ?: '#';
$link_title = $link['title'] ?: 'Button text';
$link_target = $link['target'] ? $link['target'] : '_self';

$margin_bottom_mobile = get_field('margin_bottom_mobile') ?: '40px';
$margin_bottom_desktop = get_field('margin_bottom_desktop') ?: '80px';
$indent = get_field('indent');
$download = get_field('download');

if (!empty($block['align'])) {
    $align = 'block-button--align-' . $block['align'];
}
?>


<div id="<?php esc_attr($id) ?>" class="better-grid hfj-block block-button <?php echo $align ?>" style="--margin-bottom-mobile:<?php echo $margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $margin_bottom_desktop ?>;">
    <div class="block-button__inner <?php if ($indent) echo 'block-button_inner--indent' ?>"><a href="<?php echo $link_url ?>" target="<?php echo $link_target ?>" style="background-color: <?php echo $color ?>; color: <?php echo $text_color ?>" class="button button--tighter" <?php if ($download) echo 'download' ?>><?php echo $link_title ?></a></div>
</div>