<?php

/**
 * Template Name: Block post template
 * Template Post Type: post, page, events
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full block-post"]);

?>





<?php while (have_posts()) : the_post(); ?>

    <main class="main site-main block-template">
        <!-- post header -->
        <div class="block-post__header">
            <div class="better-grid">
                <div class="block-post__header-content">
                    <!-- tags -->
                    <div class="block-post__tags">
                        <?php
                        $posttags = get_the_tags();
                        $count = 0;
                        if ($posttags) {
                            foreach ($posttags as $tag) {
                                if ($count < 3) { ?>
                                    <a href="<?php echo get_tag_link($tag) ?>" class="block-post__tags-tag">
                                        <?php echo $tag->name ?>
                                    </a>
                                    <?php $count++ ?>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                    <!-- breadcrumbs -->
                    <div class="block-post__breadcrumbs">
                        <?php $category = get_the_category($post->ID);
                        if ($category[0]->name !== 'Case Studies') {
                        ?>

                            <span class="aioseo-breadcrumb">
                                <a href="/news" title="Home">News</a>
                            </span>
                            <span class="aioseo-breadcrumb-separator">&nbsp;›&nbsp;</span>

                        <?php } ?>

                        <?php if (function_exists('aioseo_breadcrumbs')) aioseo_breadcrumbs(); ?>
                    </div>
                    <!-- title -->
                    <header class="block-post__title">
                        <h1 class="has-massive-font-size"><b><?php the_title() ?></b></h1>
                        <div class="block-post__date">
                            <svg id="Group_7762" data-name="Group 7762" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11.819 11.82">
                                <path id="Path_17202" data-name="Path 17202" d="M5.91,11.819a5.91,5.91,0,1,1,5.91-5.91,5.916,5.916,0,0,1-5.91,5.91M5.91.985A4.925,4.925,0,1,0,10.834,5.91,4.93,4.93,0,0,0,5.91.985" transform="translate(0 0)" fill="#d6001c" />
                                <path id="Path_17203" data-name="Path 17203" d="M7.04,7.109H6.969a.4.4,0,0,1-.4-.4V3.567a.4.4,0,0,1,.4-.4H7.04a.4.4,0,0,1,.4.4V6.711a.4.4,0,0,1-.4.4" transform="translate(-1.095 -0.528)" fill="#d6001c" />
                                <path id="Path_17204" data-name="Path 17204" d="M6.569,7.237l.089-.1a.367.367,0,0,1,.519-.021L8.949,8.754a.367.367,0,0,1,.021.518l-.091.1a.365.365,0,0,1-.517.021L6.589,7.755a.366.366,0,0,1-.02-.518" transform="translate(-1.078 -1.17)" fill="#d6001c" />
                            </svg>
                            <p><?php echo get_the_date(); ?></p>
                        </div>
                    </header>
                </div>
            </div>
        </div>

        <!-- author and share -->
        <div class="block-post__author-share">
            <div class="better-grid">
                <div class="block-post__author-share-content">
                    <?php if ($category[0]->name !== 'Case Studies') { ?>
                        <div class="block-post__author">
                            <?php
                            // Get the author ID
                            $author_id = get_post_field('post_author', $post->ID);
                            $acf_author_img = get_field('author_image');
                            $acf_author = get_field('author_name');
                            if ($acf_author_img) {
                                $author_image = $acf_author_img;
                            } else {
                                $author_image = get_avatar_url($author_id);
                            }
                            ?>
                            <div class="block-post__author-img" style="background-image: url('<?php echo $author_image ?>');">

                            </div>
                            <p>By <b><?php if ($acf_author) {
                                            echo $acf_author;
                                        } else {
                                            echo get_the_author();
                                        } ?></b></p>
                        </div>
                    <?php } ?>
                    <div class="block-post__share <?php if ($category[0]->name == 'Case Studies') echo 'block-post__share--left' ?>">
                        <p>Share:</p>
                        <!-- social icons -->
                        <ul class="block-post__share-icons">
                            <li class="block-post__share-icon">
                                <a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>:%20<?php the_permalink(); ?>%20@hopeforjustice">
                                    <img class="" src="<?php echo get_template_directory_uri() . '/assets/img/twitter-seeklogo.com.svg'; ?>" alt="share on twitter">
                                </a>
                            </li>
                            <li class="block-post__share-icon">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
                                    <img class="" src="<?php echo get_template_directory_uri() . '/assets/img/fb.svg'; ?>" alt="share on facebook">
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>



        <div class="better-grid">
            <!-- article -->
            <div class="block-post__content">
                <article>
                    <?php the_content(); ?>
                </article>
            </div>

            <!-- aside -->
            <aside class="block-post__aside">
                <?php
                // $category = get_the_category($post->ID); //moved higher
                $categoryID = $category[0]->cat_ID;
                $catLink = get_category_link($categoryID);
                $posts = get_posts(array('numberposts' => 5, 'offset' => 0, 'category__in' => array($categoryID), 'post__not_in' => array($post->ID))); ?>
                <div class="has-large-font-size block-post__aside-title"><b>More <?php echo $category[0]->name; ?></b></div>

                <ul>
                    <?php foreach ($posts as $post) : setup_postdata($post); ?>

                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo $catLink ?>" class="button button--tighter">See all</a>
            </aside>
        </div>




    </main>


<?php endwhile; ?>





<?php
get_footer();
?>