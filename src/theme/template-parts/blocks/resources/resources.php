<?php

/**
 * Resources block
 *
 */

// Load values and assign defaults.
$resources = get_field('resources');
?>

<div class="better-grid resources-block post-block">

    <?php

    if ($resources) : ?>
        <?php foreach ($resources as $post) : ?>
            <?php
            // $post = get_sub_field('resources');
            //$image = get_field('focus_point_image', $post->ID);
            $image_src = get_the_post_thumbnail_url($post->ID);
            //$link = get_field('link', $post->ID) ?: get_permalink($post->ID); //need to change for downloads
            $title = get_the_title($post->ID);

            if (get_field('choose_between', $post->ID) == 'pdf') {
                $link = get_field('upload_pdf', $post->ID);
            } elseif (get_field('choose_between', $post->ID) == 'link') {
                $link = get_field('link', $post->ID);
            }

            ?>

            <div class="resources-block__resource post-block__post">

                <a <?php if (!is_admin()) echo 'href="' . $link . '"' ?> class="resources-block__link post-block__link" download></a>
                <div class="resources-block__img post-block__image" style="background-size:cover; background-image: url('<?php echo $image_src ?>'); background-position: center">
                    <?php if (!get_field('no_download', $rpost->ID)) { ?>
                        <img class="resources__download resources-block__download" src="<?php echo get_template_directory_uri() . '/assets/img/download.svg'; ?>" alt="">
                    <?php } ?>
                </div>

                <div class="resources-block__content post-block__content">


                    <div class="resources-block__title">
                        <b><?php echo get_the_excerpt($post->ID); ?><span style="white-space: pre;">&nbsp;<img alt="arrow" src="<?php echo get_template_directory_uri() . '/assets/img/link-arrow.svg'; ?>"></span>
                        </b>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>



    <?php else : echo 'add posts';
    endif; ?>

</div>


<?php wp_reset_postdata(); ?>