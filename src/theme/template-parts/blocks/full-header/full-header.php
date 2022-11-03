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

if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$hasGradient = get_field('has_gradient');
$gradientColor = get_field('gradient_color');
$gradientColorB = get_field('gradient_color_b');
$split_on_mobile = get_field('split_on_mobile');
$align_content = get_field('align_content');
$max_width = get_field('content_max_width');

$image = get_field('image');
if ($image) {
    $top = $image['top'];
    $left = $image['left'];
    $id = $image['id'];
} else {
    $top = 0;
    $left = 0;
    $id = '309';
}
$image_src = wp_get_attachment_image_src($id, 'full');

?>


<!-- grid -->
<div id="<?php echo esc_attr($id); ?>" class="full-header <?php echo $split_on_mobile . ' ' . $class_name ?> hfj-block">
    <div class="better-grid">

        <div style="background-image: url('<?php echo $image_src[0]; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;" class="full-header__image">
        </div>

        <?php if ($hasGradient) { ?>
            <div class="full-header__gradient full-header__gradient--left" style="--gradient-a:<?php echo $gradientColor ?>; --gradient-b: <?php echo $gradientColorB ?>;">
            </div>
        <?php } ?>

        <div class="full-header__content <?php if ($align_content === 'center') echo 'full-header__content--no-padding' ?>" style="--align-content: <?php echo $align_content; ?>; --max-width: <?php echo $max_width; ?>px;">
            <InnerBlocks />
        </div>

    </div>
</div>