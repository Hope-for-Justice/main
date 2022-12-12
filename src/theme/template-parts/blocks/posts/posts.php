<?php

/**
 * posts
 *
 */

use AIOSEO\Plugin\Pro\Schema\Graphs\Video;

// Load values and assign defaults.
$cat = get_field('cat');
$number = get_field('number_of_posts') ?: 7;
$cat_info = get_category($cat);
$enlarge = get_field('top_news');
?>

<?php
$the_query = new WP_Query(array(
    'posts_per_page'    => $number,
    'cat' => $cat
));
?>


<div class="better-grid post-block">
    <?php if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
            $the_query->the_post(); ?>


            <?php
            //acf
            $image = get_field('focus_point_image', get_the_ID());
            $news_icon = get_field('news_icon', get_the_ID());
            $news_icon_height = get_field('news_icon_height', get_the_ID());
            $iframe = get_field('upload_video', get_the_ID(), false);
            $vimeo = explode('/', $iframe);
            $vimeo_id = end($vimeo);

            if ($image) {
                $id = $image['id'];
                $image_src = wp_get_attachment_image_src($id, 'full');
                $image_src = $image_src[0];
            } else {
                $image_src = get_the_post_thumbnail_url();
            }

            $date_mod = date("M j", strtotime(get_the_date()));
            $title = get_the_title();
            $link = get_the_permalink();
            if ($cat_info->name == 'Hope for Justice in the headlines') {
                $link = get_field('external_news_link', get_the_ID());
            } else {
                $link = get_the_permalink();
            }
            $tags = get_the_tags();
            ?>
            <div class="post-block__post post-block__post--cat-<?php echo $cat_info->slug ?> <?php if ($enlarge) echo 'post-block__post--enlarge' ?>">
                <!-- image -->

                <?php if ($cat_info->name !== 'Hope for Justice in the headlines') { ?>
                    <div style="background-size:cover; background-image: url('<?php echo $image_src; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;" class="post-block__image">
                    </div>
                <?php } ?>

                <a class="post-block__link <?php if ($cat_info->name == 'Videos') echo 'video-trigger'; ?>" <?php if ($cat_info->name !== 'Videos') {
                                                                                                                echo 'href="' .  $link;
                                                                                                            } else {
                                                                                                                echo 'data-toggle="modal" data-target="#video-modal" data-src="https://player.vimeo.com/video/' . $vimeo_id;
                                                                                                            } ?>">
                </a>

                <div class=" post-block__content">
                    <div style="display: inline-block;">
                        <div class="post-block__date">
                            <svg id="Group_7762" data-name="Group 7762" xmlns="http://www.w3.org/2000/svg" width="11.819" height="11.82" viewBox="0 0 11.819 11.82">
                                <path id="Path_17202" data-name="Path 17202" d="M5.91,11.819a5.91,5.91,0,1,1,5.91-5.91,5.916,5.916,0,0,1-5.91,5.91M5.91.985A4.925,4.925,0,1,0,10.834,5.91,4.93,4.93,0,0,0,5.91.985" transform="translate(0 0)" fill="#212322" />
                                <path id="Path_17203" data-name="Path 17203" d="M7.04,7.109H6.969a.4.4,0,0,1-.4-.4V3.567a.4.4,0,0,1,.4-.4H7.04a.4.4,0,0,1,.4.4V6.711a.4.4,0,0,1-.4.4" transform="translate(-1.095 -0.528)" fill="#212322" />
                                <path id="Path_17204" data-name="Path 17204" d="M6.569,7.237l.089-.1a.367.367,0,0,1,.519-.021L8.949,8.754a.367.367,0,0,1,.021.518l-.091.1a.365.365,0,0,1-.517.021L6.589,7.755a.366.366,0,0,1-.02-.518" transform="translate(-1.078 -1.17)" fill="#212322" />
                            </svg>

                            <p><?php echo $date_mod ?></p>
                        </div>
                    </div>
                    <?php if ($cat_info->name == 'Hope for Justice in the headlines') { ?>
                        <div class="post-block__headline-source">
                            <div class="post-block__tag"><?php echo $title ?></div>
                        </div>
                        <?php if ($news_icon) { ?>
                            <div class="post-block__headline-image" style="height: <?php echo $news_icon_height ?>px;">
                                <img src="<?php echo $news_icon ?>" alt="external news logo">
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="post-block__title">
                        <?php if ($cat_info->name == 'Hope for Justice in the headlines') {
                            echo wp_strip_all_tags(get_the_content());
                        } else {
                            echo $title;
                        } ?><span style="white-space: pre;">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span>
                    </div>
                </div>
                <?php if ($tags && ($cat_info->name != 'Hope for Justice in the headlines')) { ?>
                    <div class="post-block__tags">
                        <?php $count = 0;
                        foreach ($tags as $tag) {
                            if ($count < 2) {
                                $tag_link = get_tag_link($tag->term_id); ?><a class="post-block__tag" href="<?php echo $tag_link ?>"><?php echo $tag->name ?></a>
                        <?php $count++;
                            }
                        } ?>
                    </div>
                <?php } ?>
            </div>






    <?php endwhile;
    else : if (is_admin()) echo '<p style="grid-column: span 12;">Select a post category</p>';
    endif;

    /* Restore original Post Data
* NB: Because we are using new WP_Query we aren't stomping on the
* original $wp_query and it does not need to be reset.
*/
    wp_reset_postdata(); ?>
</div>