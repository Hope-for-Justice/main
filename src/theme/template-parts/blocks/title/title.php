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
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$title = get_field('title') ?: 'Add a title';
$font = get_field('font') ?: 'font-canela';
$margin_bottom = get_field('margin_bottom') ?: '24px';
$size = get_field('size') ?: 'h3';
$width = get_field('width') ?: 'block-title--full';
$weight = get_field('title_weight') ?: 'regular';
?>

<div class="better-grid">
    
    <<?php echo $size; ?> id="<?php echo esc_attr($id); ?>" style="margin-bottom: <?php echo $margin_bottom; ?>;"
    class="<?php echo $font; ?> block-title <?php echo $width; ?>">
    <?php if ($weight == 'bold') echo '<b>'?>
    <?php echo $title ?>
    <?php if ($weight == 'bold') echo '</b>'?>
    </<?php echo $size; ?>>
    
</div>

