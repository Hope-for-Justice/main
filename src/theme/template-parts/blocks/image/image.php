<?php
$image = get_field('image') ?: '309';
$indent = get_field('indent');
$caption = get_field('caption');
$video = get_field('video_source');
?>

<div class="better-grid image">
    <div <?php if ($video) { ?> data-toggle="modal" data-target="#video-modal" data-src="<?php echo $video ?>" <?php } ?> class="image__container <?php if ($video) echo 'video-trigger' ?> <?php if ($indent) echo 'image__container--indent' ?>"><?php echo wp_get_attachment_image($image, 'full') ?>
        <?php if ($caption) { ?>
            <div class="caption">
                <p class="small"><?php echo $caption ?></p>
            </div>
        <?php } ?>
    </div>
</div>