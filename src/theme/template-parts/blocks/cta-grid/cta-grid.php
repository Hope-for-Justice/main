<?php

/**
 * cta-grid
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>


<div class="better-grid hfj-block cta-grid">

    <?php if (have_rows('cards')) { ?>

        <?php while (have_rows('cards')) : the_row();
            $image = get_sub_field('image');
            $title = get_sub_field('title');
            $link = get_sub_field('link');
            if ($link) {
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'];
            } else {
                $link_url = '#';
                $link_title = 'button-text';
                $link_target = '_self';
            }
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
            <a target="<?php echo $link_target; ?>" href="<?php echo $link_url; ?>" class="cta-grid__card" style="background-image: url('<?php echo $image_src[0]; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;">
                <div class="cta-grid__title"><?php echo $title ?><span style="white-space: pre;" class="cta-grid__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span>
                </div>
            </a>
        <?php endwhile; ?>
    <?php } else {
        echo '<p style="grid-column: 2/12;">CTA-Grid: Add some cards to this block</p>';
    } ?>


</div>