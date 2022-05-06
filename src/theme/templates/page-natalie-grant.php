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
            $thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
        } ?>

        <div class="full-grid">
            <div class="natalie-grant__hero">
                <img src="">
            </div>
            <div>
                <h3>CO-FOUNDER AND GLOBAL AMBASSADOR</h3>
                <h1>Natalie Grant</h1>
                <p>
                    Natalie Grant, the co-founder of Hope for Justice and a Global Ambassador on behalf of our work and mission, is a nine-time GRAMMY® nominee and five-time GMA Dove Awards Female Vocalist of the Year.
                    <br><br>
                    As Global Ambassador, Natalie uses her platform to share our vision – to live in a world free from slavery – and to raise awareness and move people into action.  
                </p>
            </div>
        </div>


    </main>


<?php get_footer(); ?>