<?php
/**
 * Template Name: Natalie Grant
 *
 * @package Hope_for_Justice_2021
 */

get_header( '', array( 'page_class' => 'site--full') ); ?>


    <main id="main" class="site-main natalie-grant" role="main">

        <?php while ( have_posts() ) : the_post(); ?>       

        <?php $thumbnail = '';

        // Get the ID of the post_thumbnail (if it exists)
        $post_thumbnail_id = get_post_thumbnail_id($post->ID);

        // if it exists
        if ($post_thumbnail_id) {
            $srcset = wp_get_attachment_image_srcset($post_thumbnail_id, '', false, '');
            $src = wp_get_attachment_image_src($post_thumbnail_id);
            $sizes = wp_get_attachment_image_sizes($post_thumbnail_id);
        } ?>


        <div class="full-grid">
            <div class="natalie-grant__hero">
                <div class="natalie-grant__hero-img">
                    <img
                    src="<?php echo $src[0]; ?>" 
                    srcset="<?php echo $srcset; ?>" 
                    >
                </div>
            </div>
            <div class="natalie-grant__top-content">
                <div class="grid">
                    <div class="natalie-grant__top-text">
                        <h3><?php the_field('subtitle'); ?></h3>
                        <h1 class="font-canela"><?php the_title(); ?></h1>
                        
                        <?php the_content(); ?>

                    </div>
                </div>
            </div>

            <div class="natalie-grant__content">
                <div class="grid">
                    
                    <div class="natalie-grant__portrait">
                        <img src="<?php the_field('profile_image'); ?>">
                    </div>

                    <div class="natalie-grant__portrait-text">
                        <h2 class="font-canela"><?php the_field('second_title'); ?></h2>
                        <p>
                            <?php the_field('about_content'); ?>
                        </p>
                    </div>

                    <div class="natalie-grant__pull-quote">
                        <div class="natalie-grant__line"></div>
                        <p class="natalie-grant__pull-quote-text">
                        <?php the_field('pull_quote'); ?>
                        </p>
                    </div>

                    <div class="natalie-grant__video">
                        <img class="video-trigger" data-toggle="modal" data-target="#video-modal" data-src="<?php the_field('video_source'); ?>" src="<?php the_field('video_image'); ?>">
                    </div>

                    <div class="natalie-grant__video-text">
                        <h2 class="font-canela">
                            <?php the_field('video_title'); ?>
                        </h2> 
                        <p>
                            <?php the_field('video_text'); ?>
                            
                        </p>
                    </div>

                </div>
            </div>




        </div>

        <?php endwhile; // end of the loop. ?>

    <!-- 
    -- 
    -- video modal
    -- 
    --> 
    <?php get_template_part(
        'partials/content',
        'modal',
        array(
            'type' => 'video',
            'id' => 'video-modal'
        )
    ); ?>


    </main>


<?php get_footer(); ?>