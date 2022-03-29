<?php
/**
 * Template Name: Freedom Run
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>

	<main id="main" class="site-main freedom-run" role="main">

    <?php while ( have_posts() ) : the_post(); ?>       

    <?php $thumbnail = '';

    // Get the ID of the post_thumbnail (if it exists)
    $post_thumbnail_id = get_post_thumbnail_id($post->ID);

    // if it exists
    if ($post_thumbnail_id) {
        $thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
    } ?>

        <div class="grid">

    	   <div class="freedom-run-video"><iframe value="<?php the_field('video');?>" style="display:none;" id="video" width="100%" height="100%" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>

            <img src="<?php the_field('logo');?>" class="freedom-run__logo">
            <img src="<?php the_field('plus');?>" class="freedom-run__plus">

            <div class="freedom-run-hero">
                <img src="<?php the_field('slant');?>" class="freedom-run-hero__slant">
                <img src="<?php echo $thumbnail[0]; ?>" class="freedom-run-hero__img">
                <img src="<?php the_field('lines');?>" class="freedom-run-hero__lines">
                <img src="<?php the_field('date');?>" class="freedom-run-hero__date">
            </div>

            <div class="freedom-run-description">
                <img src="<?php the_field('logo');?>" class="freedom-run-description__logo">
                <h1 class="freedom-run-description__title font-canela"><?php the_field('title');?></h1>
                    <p>
                    <?php the_field('description');?>
                    </p>
                    <div><a href="<?php the_field('button_link');?>" class="button button--red"><?php the_field('button_text');?></a></div>
            </div>

            <div class="freedom-run-second">
                <img src="<?php the_field('plus');?>" class="freedom-run-second__plus">
                <img class="freedom-run-second__place" src="<?php the_field('place');?>">
                <img class="freedom-run-second__img" src="
                <?php the_field('second_img');?>">

            </div>

            <div class="freedom-run-second-description">
                <img src="<?php the_field('date');?>" class="freedom-run-second-description__date">
                <p>
                    <?php the_field('second_description');?>
                </p>
                <div><a href="<?php the_field('button_link');?>" class="button button--red"><?php the_field('button_text');?></a></div>
            </div>


        <div class="grid">

        <?php endwhile; // end of the loop. ?>

	</main>

<?php get_footer(); ?>