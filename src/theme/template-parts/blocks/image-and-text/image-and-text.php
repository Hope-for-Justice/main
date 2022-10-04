<?php

/**
 * image and text
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'image-text-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
// $margin_bottom_mobile = get_field('margin_bottom_mobile') ?: '40px';
$background_color = get_field('background_color');
$color = get_field('color');
$image = get_field('image') ?: '309';
$image_span = get_field('image_width') ?: 'span 7';
$text = get_field('text') ?: 'add some text';
$text_font = get_field('text_font') ?: 'font-apercu';
$text_size = get_field('text_size') ?: 'h4';
$title = get_field('title');
$title_font = get_field('title_font');
$title_size = get_field('title_size') ?: 'h3';
$small_text = get_field('small_text');
$video = get_field('video_source');
$caption = get_field('caption');

$link = get_field('link');

if ($link) {
    $link_url = $link['url'] ?: '#';
    $link_title = $link['title'] ?: 'Button text';
    $link_target = $link['target'] ? $link['target'] : '_self';
}

$button_text_color  = get_field('button_text_color') ?: '#ffffff';
$button_color = get_field('button_color') ?: '#D6001C';
?>


<div id="<?php esc_attr($id) ?>" class="image-text <?php if ($background_color) echo 'image-text--has-background' ?>" style=" <?php echo 'background-color:' . $background_color . '; color:' . $color ?>">
    <div class="better-grid">
        <div <?php if ($video) { ?> data-toggle="modal" data-target="#video-modal" data-src="<?php echo $video ?>" <?php } ?> class="image-text__image-container <?php if ($video) echo 'video-trigger' ?>" style="--span: <?php echo $image_span ?>">
            <?php echo wp_get_attachment_image($image, 'full'); ?>
            <?php if ($caption) { ?>
                <div class="caption">
                    <p class="small"><?php echo $caption ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="image-text__text" style="
        <?php if ($image_span == 'span 7') {
            echo '--text-span: 8 / 13';
        } else {
            echo '--text-span: 7 / 13';
        } ?>">
            <?php if ($title) { ?>
                <<?php echo $title_size; ?> class="<?php echo $title_font ?> block-title image-text__title">
                    <?php echo $title ?>
                </<?php echo $title_size; ?>>
            <?php } ?>

            <<?php echo $text_size; ?> class="<?php echo $text_font ?> block-title">
                <?php echo $text ?>
            </<?php echo $text_size; ?>>

            <?php if ($small_text) { ?>
                <p class="image-text__small-text">
                    <?php echo $small_text ?>
                </p>
            <?php } ?>

            <?php if ($link) { ?>
                <div class="image-text__button">
                    <a href="<?php echo $link_url ?>" target="<?php echo $link_target ?>" style="background-color: <?php echo $button_color ?>; color: <?php echo $button_text_color ?>" class="button button--tighter"><?php echo $link_title ?></a>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<?php if ($video) { ?>
    <!--
    --
    --  video
    --
    -->
    <div style="display: none;" class="modal modal--video fade" id="video-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal__dialog modal__dialog--video">
            <div class="modal__content modal__content--video video-container">
                <iframe class="video" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

                <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--video">&times;<span class="accessibility">Close</span></a>

            </div>
        </div>
    </div>
<?php } ?>