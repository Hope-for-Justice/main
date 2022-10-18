<?php

/**
 * social
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Load values and assign defaults.
// $margin_bottom_mobile = get_field('margin_bottom_mobile') ?: '40px';
$background_color = get_field('background_color') ?: 'var(--black)';
$color = get_field('text_color') ?: 'white';
?>

<div class="better-grid social-block">
    <div class="social-block__inner" style=" <?php echo 'background-color:' . $background_color . '; color:' . $color ?>">
        <div class="social-block__content">
            <div class="social-block__text">
                <p>Follow us on social media:</p>
            </div>
            <ul class="social-block__icons">
                <li class="social-block__social-icon">
                    <a href="<?php echo the_field('linked_in_link', 'option'); ?>" target="_blank">
                        <img alt="linkedin link" src="<?php echo get_template_directory_uri() . '/assets/img/li-white.svg'; ?>">
                    </a>
                </li>
                <li class="social-block__social-icon">
                    <a href="<?php echo the_field('instagram_link', 'option'); ?>" target="_blank">
                        <img alt="instagram link" src="<?php echo get_template_directory_uri() . '/assets/img/in-white.svg'; ?>">
                    </a>
                </li>
                <li class="social-block__social-icon">
                    <a href="<?php echo the_field('twitter_link', 'option'); ?>" target="_blank">
                        <img alt="twitter link" src="<?php echo get_template_directory_uri() . '/assets/img/tw-white.svg'; ?>">
                    </a>
                </li>
                <li class="social-block__social-icon">
                    <a href="<?php echo the_field('facebook_link', 'option'); ?>" target="_blank">
                        <img alt="facebook link" src="<?php echo get_template_directory_uri() . '/assets/img/fb-white.svg'; ?>">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>