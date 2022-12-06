<?php
$image = get_field('image') ?: '309';
$indent = get_field('indent');
$caption = get_field('caption');
$video = get_field('video_source');
$link = get_field('link');
$max_width = get_field('max_width') ?: '960';
if (!empty($block['align'])) {
    $align = 'image--align-' . $block['align'];
}
?>

<?php if ($link && (!is_admin())) { ?>
    <a href="<?php echo $link ?>" class="better-grid image <?php echo $align ?> ">
    <?php } else { ?>
        <div class="better-grid image <?php echo $align ?> ">
        <?php } ?>
        <div style="max-width: <?php echo $max_width ?>px;" <?php if ($video) { ?> data-toggle="modal" data-target="#video-modal" data-src="<?php echo $video ?>" <?php } ?> class="image__container <?php if ($video) echo 'video-trigger' ?> <?php if ($indent) echo 'image__container--indent' ?>"><?php echo wp_get_attachment_image($image, 'full') ?>
            <?php if ($caption) { ?>
                <div class="caption">
                    <p class="small"><?php echo $caption ?></p>
                </div>
            <?php } ?>
        </div>
        <?php if ($link  && (!is_admin())) { ?>
    </a>
<?php } else { ?>
    </div>
<?php } ?>

<?php if ($video) { ?>
    <!--
    --
    --  video
    --
    -->
    <div style="display: none;" class="modal modal--video fade" id="video-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal__dialog modal__dialog--video">
            <div class="modal__content modal__content--video video-container">
                <iframe class="video" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>

                <a href="#" data-dismiss="modal" class="gi-close modal__close modal__close--video">&times;<span class="accessibility">Close</span></a>

            </div>
        </div>
    </div>
<?php } ?>