<?php
/**
 * Template Name: Donation thank you
 *
 * @package Hope_for_Justice_2021
 */

get_header( '', array( 'page_class' => 'site--full') ); ?>

<main id="main" class="site-main donation-thankyou" role="main">

    <?php while ( have_posts() ) : the_post(); ?>       

    <?php $thumbnail = '';

    // Get the ID of the post_thumbnail (if it exists)
    $post_thumbnail_id = get_post_thumbnail_id($post->ID);

    // if it exists
    if ($post_thumbnail_id) {
        $thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
    } ?>

    <div class="full-grid">

        <h1 style="grid-column: main; text-align: center;" class="font-canela">Thank You</h1>

    </div><!-- /grid -->

    <?php endwhile; // end of the loop. ?>

</main><!-- #main -->

<?php get_footer(); ?>