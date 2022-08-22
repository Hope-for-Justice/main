<?php

/**
 * full-header-fk-screamer
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'full-header-fk-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Load values and assign defaults.
$title = get_field('title') ?: 'Add a title';
$description = get_field('description') ?: 'Add a short description';
$hasGradient = get_field('has_gradient');
$gradientColor = get_field('gradient_color');
$gradientColorB = get_field('gradient_color_b');
$text_color = get_field('text_color');
$image = get_field('image');
$style = "block-full-header-fk";

?>

<div id="<?php echo esc_attr($id); ?>"
    class="block-full-header-fk-screamer <?php echo esc_attr($className); ?>">

    <div class="block-full-header-fk-screamer__image">
        <?php echo wp_get_attachment_image( $image, 'full' ); ?>
    </div>


    <?php if ($hasGradient) { ?>
    <div class="block-full-header-fk-screamer__gradient"
        style="background: linear-gradient(0deg, <?php echo $gradientColor ?> 0%, <?php echo $gradientColorB ?> 100%);">
    </div>
    <?php } ?>

    <div class="better-grid block-full-header-fk-screamer__grid">
        <h1 style="color: <?php echo $text_color ?>" class="block-full-header-fk-screamer__title">
            <?php echo $title ?>
        </h1>
        <p style="color: <?php echo $text_color ?>" class="block-full-header-fk-screamer__description">
            <?php echo $description ?>
        </p>
    </div>
    
</div>
