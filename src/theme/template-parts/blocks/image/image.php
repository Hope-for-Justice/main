<?php
$image = get_field('image') ?: '309';
$indent = get_field('indent');
?>

<div class="better-grid image">
    <div class="image__container <?php if ($indent) echo 'image__container--indent' ?>"><?php echo wp_get_attachment_image($image, 'full') ?></div>
</div>