<?php

/**
 * Template Name: Block template
 * Template Post Type: post, page, events
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full"]);

?>






<main class="main site-main block-template">

    <?php while (have_posts()) : the_post();
        the_content();
    endwhile; ?>

</main>


<?php

//thank you scripts
if (get_field('thank_you_scripts')) {
    wp_enqueue_script('donate-thankyou');
}

get_footer();
?>