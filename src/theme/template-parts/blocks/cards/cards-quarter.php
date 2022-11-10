<?php

/**
 * card-quarter
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
$has_video = false;

?>


<div class="better-grid cards-quarter hfj-block">


    <?php while (have_rows('quarter_cards')) : the_row(); ?>
        <?php
        $download = get_sub_field('download');
        $video = get_sub_field('video');
        $dropdown = get_sub_field('dropdown');
        $dropdown_content = get_sub_field('dropdown_content');
        if ($video) $has_video = true;
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
        <a <?php if ($video) { ?>data-toggle="modal" data-target="#video-modal-cards-quarters" data-src="<?php echo $video ?>" <?php } else if (!$dropdown) { ?><?php if ($target) echo 'target="' . $link_target . '"' ?> <?php if (!is_admin()) { ?>href="<?php echo $link_url ?>" <?php } ?> <?php } ?> class="<?php if ($dropdown) echo 'block-card--dropdown' ?> block-card <?php if ($video) echo 'video-trigger' ?>" <?php if ($download) echo 'download' ?>>
            <div style="background-image: url('<?php echo $image_src[0]; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;" class="block-card__image-container">
            </div>
            <div class="block-card__content">
                <h4 class="block-title block-card__title <?php echo $title_size; ?>"><b><?php echo (get_sub_field('title')) ?></b><span style="white-space: pre;" class="block-card__arrow">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span></h4>
                <?php if ($dropdown) { ?>
                    <div class="block-card__dropdown-content">
                        <p><?php echo $dropdown_content ?></p>
                    </div>
                <?php } ?>
            </div>
        </a>

    <?php endwhile; ?>

</div>

<?php if ($has_video) { ?>
    <!--
    --
    --  video
    --
    -->
    <div style="display: none;" class="modal modal--video fade" id="video-modal-cards-quarters" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal__dialog modal__dialog--video">
            <div class="modal__content modal__content--video video-container">
                <iframe class="video" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

                <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--video">&times;<span class="accessibility">Close</span></a>

            </div>
        </div>
    </div>
<?php } ?>