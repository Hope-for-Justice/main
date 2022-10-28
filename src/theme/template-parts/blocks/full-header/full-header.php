<?php

/**
 * full-header
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'full-header-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$title = get_field('title') ?: 'Add a title';
$title_size = get_field('title_size');
$title_font = get_field('title_font') ?: 'font-apercu';
$title_weight = get_field('title_weight') ?: 'regular';
$title_margin_bottom = get_field('title_margin_bottom') ?: '24px';
$description = get_field('description') ?: 'Add a short description';
$description_size = get_field('description_size') ?: 'regular';
$description_weight = get_field('description_weight') ?: 'regular';
$hasGradient = get_field('has_gradient');
$gradientColor = get_field('gradient_color');
$gradientColorB = get_field('gradient_color_b');
$text_color_desktop = get_field('text_color_desktop');
$text_color_mobile = get_field('text_color_mobile');
$image = get_field('image') ?: '309';
$split_on_mobile = get_field('split_on_mobile');

?>


<!-- grid -->
<div id="<?php echo esc_attr($id); ?>" class="full-header <?php echo $split_on_mobile ?> hfj-block">
    <div class="better-grid">

        <div class="full-header__image">
            <?php echo wp_get_attachment_image($image, 'full'); ?>
        </div>

        <?php if ($hasGradient) { ?>
            <div class="full-header__gradient" style="background: linear-gradient(0deg, <?php echo $gradientColor ?> 0%, <?php echo $gradientColorB ?> 100%);">
            </div>
        <?php } ?>

        <div class="full-header__content">
            <InnerBlocks />
        </div>

    </div>
</div>