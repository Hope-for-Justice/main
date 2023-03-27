<?php

if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$slides = get_field('slides');
$amount = count($slides);
$speed = get_field('speed') ?: 30

?>

<div class="carousel">
    <?php if ($slides) : ?>
        <div class="carousel__slides" style="--slides: <?php echo $amount ?>; --speed: <?php echo $speed ?>s;">
            <?php foreach ($slides as $slide) : ?>
                <div class="carousel__slide">
                    <img src="<?php echo esc_url($slide['url']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" />
                </div>
            <?php endforeach; ?>

            <?php foreach ($slides as $slide) : ?>
                <div class="carousel__slide">
                    <img src="<?php echo esc_url($slide['url']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" />
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : echo 'add slides';
    endif; ?>
</div>