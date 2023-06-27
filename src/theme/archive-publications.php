<?php

/**
 * The template for displaying publications archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<div id="primary" class="content-area archive-page">
    <main id="main" class="site-main">

        <?php if (have_posts()) : ?>



            <div style="height: clamp(40px, 8vw, 80px)"></div>
            <div class="better-grid">
                <header style="grid-column: span 12;" class="archive-header">
                    <h1 style="font-size: var(--wp--preset--font-size--huge); font-weight:bold;" class="">
                        <?php the_archive_title(); ?></h1>
                </header><!-- .page-header -->
            </div>
            <div style="height: clamp(24px, 5vw, 40px);"></div>



            <div class="better-grid post-block">
                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post(); ?>

                    <?php
                    //acf
                    $file = get_field('file', get_the_ID());
                    //$date_mod = date("M j", strtotime(get_the_date()));
                    $date = get_the_date();
                    $title = get_the_title();
                    $link = get_the_permalink();
                    // $tags = get_the_tags();
                    // $cat = get_the_category();
                    // $cat_info = $cat[0];

                    ?>
                    <div class="publication">
                        <a href="<?php echo $link ?>" class="publication__link"></a>

                        <div class="publication__title">
                            <div class="publication__svg"><img src="<?php echo get_template_directory_uri() . '/assets/img/file-solid.svg' ?>" alt="document symbol"></div><?php echo $title ?>
                        </div>
                        <div class="publication__date-download">
                            <div class="publication__date">
                                <div class="publication__clock">
                                    <img src="<?php echo get_template_directory_uri() . '/assets/img/clock.svg' ?>" alt="">
                                </div>
                                <div><?php echo $date ?></div>
                            </div>
                            <a href="<?php echo $file ?>" download class="publication__download"><img src="<?php echo get_template_directory_uri() . '/assets/img/download.svg' ?>" alt="download symbol"></a>
                        </div>

                    </div>





                <?php endwhile; ?>
            </div>

        <?php

        endif;
        ?>
        <div style="height: clamp(24px, 5vw, 40px);"></div>
        <div class="better-grid">
            <div style="grid-column: span 12;" class="archive-page__numbers">
                <?php the_posts_pagination(array(
                    'mid_size'  => 1,
                    'prev_next' => false,
                )); ?>
            </div>
        </div>
        <div style="height: clamp(24px, 5vw, 40px);"></div>

    </main><!-- #main -->
</div><!-- #primary -->


<?php
get_footer();
