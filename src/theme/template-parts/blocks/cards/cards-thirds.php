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
        $link = get_sub_field('link');
        if ($link) {
            $link_url = $link['url'];
            $link_target = $link['target'];
        } else {
            $link_url = '#';
            $link_target = '_self';
        }
        $image = get_sub_field('img');
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
        $title_size = get_sub_field('title_size');
        ?>
        <a target="<?php echo $link_target ?>" <?php if (!is_admin()) { ?>href="<?php echo $link_url ?>" <?php } ?> class="block-card">
            <div style="background-image: url('<?php echo $image_src[0]; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;" class="block-card__image-container">
                <div class="block-card__content">
                    <h4 class="block-title block-card__title <?php echo $title_size; ?>"><b><?php echo (get_sub_field('title')) ?></b><span style="white-space: pre;" class="block-card__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span></h4>
                </div>
            </div>

        </a>

    <?php endwhile; ?>

</div>