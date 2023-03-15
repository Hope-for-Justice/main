<?php

/**
 * Featured Stories
 *
 */

// Load values and assign defaults.
$featured_stories = get_field('featured_stories');
?>

<div class="better-grid featured-stories">

    <?php

    if ($featured_stories) : ?>
        <?php while (have_rows('featured_stories')) : the_row(); ?>
            <?php
            $post = get_sub_field('post');
            $alt_title = get_sub_field('overwrite_title');
            $image = get_field('focus_point_image', $post->ID);
            $tags = get_the_tags($post->ID);

            if ($image) {
                $id = $image['id'];
                $image_src = wp_get_attachment_image_src($id, 'full');
                $image_src = $image_src[0];
            } else {
                $image_src = get_the_post_thumbnail_url($post->ID);
            }
            $link = get_field('link', $post->ID) ?: get_permalink($post->ID);
            $title = get_the_title($post->ID);

            ?>

            <div class="featured-stories__story">

                <a <?php if (!is_admin()) echo 'href="' . $link . '"' ?> class="featured-stories__link"></a>
                <div class="featured-stories__img" style="background-image: url('<?php echo $image_src ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;"></div>

                <div class="featured-stories__gradient"></div>

                <div class="featured-stories__content">

                    <?php if ($tags) { ?>
                        <div class="featured-stories__tags">
                            <?php $count = 0;
                            foreach ($tags as $tag) {
                                if ($count < 2) {
                                    $tag_link = get_tag_link($tag->term_id); ?><a class="featured-stories__tag" href="<?php echo $tag_link ?>"><?php echo $tag->name ?></a>
                            <?php $count++;
                                }
                            } ?>
                        </div>
                    <?php } ?>

                    <div class="featured-stories__title">
                        <b><?php echo ($alt_title) ? $alt_title : $title;  ?><span style="white-space: pre;">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span>
                        </b>
                    </div>
                </div>

            </div>

        <?php endwhile; ?>



    <?php else : echo 'add posts';
    endif; ?>

</div>


<?php wp_reset_postdata(); ?>