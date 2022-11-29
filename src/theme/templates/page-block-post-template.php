<?php

/**
 * Template Name: Block post template
 * Template Post Type: post, page, events
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full"]);

?>


<main class="main site-main block-template block-post">


    <?php while (have_posts()) : the_post(); ?>

        <!-- post header -->
        <div class="block-post__header">
            <div class="better-grid">
                <div class="block-post__header-content">
                    <!-- breadcrumbs -->
                    <div class="block-post__breadcrumbs">
                        <span class="aioseo-breadcrumb">
                            <a href="/news" title="Home">News</a>
                        </span>
                        <span class="aioseo-breadcrumb-separator">&nbsp;›&nbsp;</span>
                        <?php if (function_exists('aioseo_breadcrumbs')) aioseo_breadcrumbs(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php the_content(); ?>


    <?php endwhile; ?>


</main>


<?php
get_footer();
?>