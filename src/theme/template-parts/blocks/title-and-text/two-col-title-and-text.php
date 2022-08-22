<?php

/**
 * two-col-title-and-text
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'two-col-title-and-text-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$title_a = get_field('title_a') ?: 'Add a title (A)';
$title_a_font = get_field('title_a_font') ?: 'font-canela';
$margin_bottom_a = get_field('margin_bottom') ?: '24px';
$size_a = get_field('size_a') ?: 'h3';
$text_a = get_field('text_a') ?: 'Add some text (A)';

$title_b = get_field('title_b') ?: 'Add a title (B)';
$title_b_font = get_field('title_b_font') ?: 'font-canela';
$margin_bottom_b = get_field('margin_bottom') ?: '24px';
$size_b = get_field('size_b') ?: 'h3';
$text_b = get_field('text_b') ?: 'Add some text (B)';
?>

<div id="<?php echo esc_attr($id); ?>" class="better-grid two-col-title-and-text">
    <div class="two-col-title-and-text__col-a">
        <<?php echo $size_a; ?> style="margin-bottom: <?php echo $margin_bottom_a; ?>;"
        class="<?php echo $title_a_font; ?> block-title"><?php echo $title_a ?></<?php echo $size_a; ?>>
        <p class="block-text">
            <?php echo $text_a ?>
        </p>
    </div>
    <div class="two-col-title-and-text__col-b">
        <<?php echo $size_b; ?> style="margin-bottom: <?php echo $margin_bottom_b; ?>;"
        class="<?php echo $title_b_font; ?> block-title"><?php echo $title_b ?></<?php echo $size_b; ?>>
        <p class="block-text">
            <?php echo $text_b ?>
        </p>
    </div>
</div>

