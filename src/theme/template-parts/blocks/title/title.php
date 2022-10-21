<?php

/**
 * title
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'title-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

if (!empty($block['align'])) {
    $align = 'block-title-parent--align-' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('title') ?: 'Add a title';
$font = get_field('font') ?: 'font-canela';
$margin_bottom = get_field('margin_bottom') ?: '24px';
$size = get_field('size') ?: 'h3';
$width = get_field('width') ?: 'block-title--full';
$weight = get_field('title_weight') ?: 'regular';
$margin_bottom_mobile = get_field('margin_bottom_mobile') ?: '24px';
$margin_bottom_desktop = get_field('margin_bottom_desktop') ?: '24px';
$indent = get_field('indent');
?>

<div class="better-grid hfj-block block-title-parent <?php echo $align; ?>" style="--margin-bottom-mobile:<?php echo $margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $margin_bottom_desktop ?>;">

    <<?php echo $size; ?> id="<?php echo esc_attr($id); ?>" class="<?php echo $font; ?> block-title <?php echo $width; ?> <?php if ($indent) echo 'block-title--indent' ?>">
        <?php if ($weight == 'bold') echo '<b>' ?>
        <?php echo $title ?>
        <?php if ($weight == 'bold') echo '</b>' ?>
    </<?php echo $size; ?>>

</div>