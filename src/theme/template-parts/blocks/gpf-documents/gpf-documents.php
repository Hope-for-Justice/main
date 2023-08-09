<?php

/**
 * gov pol fund block
 *
 */

$number = get_field('number');
$cat = get_field('cat');


$the_query = new WP_Query(array(
    'post_type' => 'gov_pol_fund',
    'posts_per_page'    => $number,
    'tax_query' => array(
        array(
            'taxonomy' => 'categories',
            'field' => 'term_id',
            'terms' => $cat,
        )
    ),
));

?>

<div class="better-grid publications-block post-block">

    <?php if ($the_query->have_posts()) :

        while ($the_query->have_posts()) :
            $the_query->the_post();

            //acf
            // $file = get_field('file', get_the_ID());
            $date = get_the_date('', get_the_ID());
            $title = get_the_title(get_the_ID());
            //$link = get_the_permalink(get_the_ID());
            if (get_field('choose_between_field', get_the_ID()) == 'updf') {
                $link = get_field('upload_pdf', get_the_ID());
                $download = true;
            } elseif (get_field('choose_between_field', get_the_ID()) == 'elink') {
                $link = get_field('external_link', get_the_ID());
                $download = false;
            }
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
                    <?php if ($download == true) { ?>
                        <a href="<?php echo $link ?>" download class="publication__download"><img src="<?php echo get_template_directory_uri() . '/assets/img/download.svg' ?>" alt="download symbol"></a>
                    <?php } ?>
                </div>

            </div>
        <?php endwhile; ?>



    <?php else : echo 'select category';
    endif; ?>

</div>


<?php wp_reset_postdata(); ?>