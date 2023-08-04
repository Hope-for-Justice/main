<?php

/**
 * button
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Load values and assign defaults.
$indent = get_field('indent');

//a
$color_a = get_field('button_color') ?: '#D6001C';
$text_color_a = get_field('text_color') ?: '#ffffff';
$link_a = get_field('link');
$video_link_a = get_field('video_link');
$button_style_a = get_field('button_style_a');
$modal_name_a = get_field('modal_name');

if ($link_a) {
    $link_url_a = $link_a['url'];
    $link_title_a = $link_a['title'];
    $link_target_a = $link_a['target'];
} else {
    $link_url_a = '#';
    $link_title_a = 'button-text';
    $link_target_a = '_self';
}
$download_a = get_field('download');

//b

$color_b = get_field('button_color_b') ?: '#D6001C';
$text_color_b = get_field('text_color_b') ?: '#ffffff';
$link_b = get_field('link_b');
$video_link_b = get_field('video_link_b');
$button_style_b = get_field('button_style_b');
$modal_name_b = get_field('modal_name_b');

if ($link_b) {
    $link_url_b = $link_b['url'];
    $link_title_b = $link_b['title'];
    $link_target_b = $link_b['target'];
} else {
    $link_url_b = '#';
    $link_title_b = 'button-text';
    $link_target_b = '_self';
}
$download_b = get_field('download_b');

if (!empty($block['align'])) {
    $align = 'block-button--align-' . $block['align'];
}
?>


<div class="better-grid hfj-block block-button <?php echo $align ?>">

    <div class="block-button__inner <?php if ($indent) echo 'block-button__inner--indent' ?>">
        <a <?php if ($video_link_a || $modal_name_a) { ?> data-toggle="modal" data-target="<?php if ($modal_name_a) {
                                                                                                echo '#' . $modal_name_a;
                                                                                            } else {
                                                                                                echo '#video-modal';
                                                                                            } ?>" data-src="<?php echo $video_link_a ?>" <?php } ?> href="<?php echo $link_url_a ?>" target="<?php echo $link_target_a ?>" style="background-color: <?php echo $color_a ?>; color: <?php echo $text_color_a ?>" class="<?php if ($button_style_a !== 'plain') { ?>button button--tighter<?php } else { ?>button--plain<?php } ?> <?php if ($video_link_a) echo 'video-trigger' ?>  <?php echo $button_style_a ?>" <?php if ($download_a) echo 'download' ?>><span class="<?php if ($button_style_a == 'plain') { ?>button--plain__text<?php } ?>"><?php echo $link_title_a ?></span><?php if ($button_style_a == 'plain') { ?><span style="white-space: pre;" class="block-card__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span><?php } ?>
        </a>

        <?php if ($link_b) { ?>
            <a <?php if ($video_link_b || $modal_name_b) { ?> data-toggle="modal" data-target="<?php if ($modal_name_b) {
                                                                                                    echo '#' . $modal_name_b;
                                                                                                } else {
                                                                                                    echo '#video-modal';
                                                                                                } ?>" data-src="<?php echo $video_link_b ?>" <?php } ?>href="<?php echo $link_url_b ?>" target="<?php echo $link_target_b ?>" style="background-color: <?php echo $color_b ?>; color: <?php echo $text_color_b ?>" class="block-button__second-button <?php if ($button_style_b !== 'plain') { ?>button button--tighter<?php } else { ?>button--plain<?php } ?> <?php if ($video_link_b) echo 'video-trigger' ?>  <?php echo $button_style_b ?>" <?php if ($download_b) echo 'download' ?>><span class="<?php if ($button_style_b == 'plain') { ?>button--plain__text<?php } ?>"><?php echo $link_title_b ?></span><?php if ($button_style_b == 'plain') { ?><span style="white-space: pre;" class="block-card__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span><?php } ?>
            </a>
        <?php } ?>
    </div>


</div>