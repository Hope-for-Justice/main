<?php
$title = get_field('title') ?: 'Dropdown title';
$text = get_field('text') ?: 'add some text';
$indent = get_field('indent');
?>

<div class="better-grid dropdown-block">
    <div class="dropdown-block__dropdown <?php if ($indent) echo 'dropdown-block__dropdown--indent' ?>">
        <div class="dropdown-block__header">
            <p class="block-title large"><b><?php echo $title ?></b></p>
            <img class="dropdown-block__arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>">
        </div>
        <div class="dropdown-block__content">
            <?php echo $text ?>
        </div>
    </div>
</div>