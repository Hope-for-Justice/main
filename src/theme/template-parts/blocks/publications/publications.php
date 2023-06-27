<?php

/**
 * publications block
 *
 */

$number = get_field('number');

$the_query = new WP_Query(array(
    'post_type' => 'publications',
    'posts_per_page'    => $number,
));

$show_by = get_field('show_by');

if ($show_by !== 'date') {
    $publications = get_field('selection');
}

?>

<div class="better-grid publications-block post-block">

    <?php if ($publications) :

        foreach ($publications as $post) :

            //acf
            $file = get_field('file', $post->ID);
            //$date_mod = date("M j", strtotime(get_the_date()));
            $date = get_the_date('', $post->ID);
            $title = get_the_title($post->ID);
            $link = get_the_permalink($post->ID);
            // $tags = get_the_tags();
            // $cat = get_the_category();
            // $cat_info = $cat[0];
    ?>
            <div class="publication">
                <a <?php if (!is_admin()) echo 'href="' . $link ?>" class="publication__link"></a>

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
        <?php endforeach; ?>


    <?php else : ?>

        <?php if ($the_query->have_posts()) :  ?>


            <?php while ($the_query->have_posts()) :
                $the_query->the_post();
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
                    <a <?php if (!is_admin()) echo 'href="' . $link ?>" class="publication__link"></a>

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



    <?php else : echo 'add publications';
        endif;
    endif; ?>

</div>


<?php wp_reset_postdata(); ?>