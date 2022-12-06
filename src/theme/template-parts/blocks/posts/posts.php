<?php

/**
 * posts
 *
 */

// Load values and assign defaults.
$cat = get_field('cat');
$number = 7;
$cat_info = get_category($cat)
?>

<?php
$the_query = new WP_Query(array(
    'posts_per_page'    => $number,
    'cat' => $cat
));
?>


<div class="better-grid posts-block">
    <?php if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
            $the_query->the_post(); ?>


            <?php
            $image = get_field('focus_point_image', get_the_ID());
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
            $tags = get_the_tags();
            ?>
            <div class="post-block__post post-block__post--cat-<?php echo $cat_info->slug ?>">
                <!-- image -->
                <div style="background-size:cover; background-image: url('<?php echo $image_src; ?>'); background-position: <?php echo $image['left'] . '% ' . $image['top']; ?>%;" class="post-block__image">

                </div>

                <div class="post-block__content">
                    <div></div>
                </div>
                Title: <?php echo $title ?><br><br>
                Link: <?php echo $link ?><br><br>
                Cat: <?php echo $cat_info->name ?>, <?php echo $cat_info->slug ?><br><br>
                Date: <?php echo $date_mod ?><br><br>
                Tags: <?php foreach ($tags as $tag) {
                            $tag_link = get_tag_link($tag->term_id); ?>
                    <a href="<?php echo $tag_link ?>"><?php echo $tag->name ?></a>,
                <?php } ?>
                <!-- $tags = get_tags();
                $html = '<div class="post_tags">';
                foreach ( $tags as $tag ) {
                    $tag_link = get_tag_link( $tag->term_id );
                            
                    $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
                    $html .= "{$tag->name}</a>";
                }
                $html .= '</div>';
                echo $html; -->
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