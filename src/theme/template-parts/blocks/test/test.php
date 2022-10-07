<?php
$image = get_field('image');
$image_src = wp_get_attachment_image_src($image['id'], 'full'); ?>

<style>
    #my-image {
        background-image: url('<?php echo $image_src[0]; ?>');
        background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;
        background-size: cover;
        height: 400px;
        width: 80vw;
    }
</style>

<div style="" id="my-image"></div>