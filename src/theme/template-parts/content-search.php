<?php

/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hope_for_Justice_2020
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="margin-bottom:0;">
    <header class="entry-header" style="margin-bottom: 0;">
        <h2 style="font-size: var(--wp--preset--font-size--default); font-weight:bold;"><a href="<?php echo esc_url(get_permalink()) ?>" rel="bookmark"><?php echo strip_tags(get_the_title()) ?></a></h2>
    </header><!-- .entry-header -->

    <div>
        <p>
            <?php if (aioseo()->meta->description->getPostDescription(get_the_ID())) {
                echo aioseo()->meta->description->getPostDescription(get_the_ID());
            } else {
                the_excerpt();
            } ?>
        </p>
    </div><!-- .entry-summary -->
</article><!-- #post-<?php the_ID(); ?> -->
<div style="height: clamp(24px, 5vw, 40px);"></div>