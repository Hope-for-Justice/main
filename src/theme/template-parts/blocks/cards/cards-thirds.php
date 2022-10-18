<?php

/**
 * card-thirds
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$block_margin_bottom_desktop = get_field('block_margin_bottom_desktop') ?: '80px';
$block_margin_bottom_mobile = get_field('block_margin_bottom_mobile') ?: '40px';
?>


<div class="better-grid card-thirds hfj-block" style="--margin-bottom-mobile:<?php echo $block_margin_bottom_mobile ?>; --margin-bottom-desktop: <?php echo $block_margin_bottom_desktop ?>;">


    <?php while (have_rows('third_cards')) : the_row(); ?>
        <?php
        $link_url = get_sub_field('link', ['url']) ?: "#";
        $link_target = get_sub_field('link', ['target']);
        $image = get_sub_field('image') ?: '309';
        $image_url = wp_get_attachment_url($image);
        ?>
        <a target="<?php echo $link_target ?>" href="<?php echo $link_url ?>" class="block-card">
            <div style="background-image: url('<?php echo $image_url ?>');" class="block-card__image-container">
                <div class="block-card__content">
                    <h4 class="block-title block-card__title"><b><?php echo (get_sub_field('title')) ?></b><span class="block-card__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span></h4>
                </div>
            </div>

        </a>

    <?php endwhile; ?>

</div>