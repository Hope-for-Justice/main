<?php
/**
 * Template Name: Anti-slavery day
 *
 * @package Hope_for_Justice_2021
 */

get_header("",["page_class" =>
"site--full"]); 

?>

<?php while (have_posts()):
    the_post(); ?>

<?php
$thumbnail = "";

// Get the ID of the post_thumbnail (if it exists)
$post_thumbnail_id = get_post_thumbnail_id($post->ID); // if it exists if

if ($post_thumbnail_id) { 

$srcset = wp_get_attachment_image_srcset($post_thumbnail_id, "", false, ""); 
$src = wp_get_attachment_image_src($post_thumbnail_id); 
$sizes = wp_get_attachment_image_sizes($post_thumbnail_id); 

} ?>


<main class="main site-main church-partnerships">

    <?php get_template_part(
	    'partials/content',
	    'full-header',
	   array(
	        'class' => 'full-header--fk',
	        'srcset' => $srcset,
            'src' => $src,
            'title' => 'Anti-Slavery Day',
            'description' => 'Anti-Slavery Day is marked every year on October 18th.',
            'has-gradient' => true
	    )
	); ?>


    <div class="better-grid">

        <!-- content for wyswig?-->

        <h3 class="font-canela full-width mb-24 h4-to-mob-l">What is Anti-Slavery Day?</h3>

        <p class="full-width space-bottom">Anti-Slavery Day is an opportunity to raise awareness of the fact over 40
            million people in the world today, and an estimated 136,000 people in the UK, are trapped in conditions of
            modern slavery. But it doesn’t have to be this way.
            <br><br>Anti-Slavery Day is a time to encourage governments, businesses, friends, family and colleagues to
            do what they can to prevent human trafficking and protect victims of modern-day slavery.
        </p>

        <div class="half">
            <h3 class="font-canela full-width mb-24 h4-to-mob-l">When is Anti-Slavery Day?</h3>
            <p class="space-bottom">Anti-Slavery Day takes place every year on the 18th October. At Hope for Justice, we
                will be hosting a whole week of events and campaigns (17th – 23rd October) which individuals and
                organisations can take part in.</p>
        </div>

        <div class="half">
            <h3 class="font-canela full-width mb-24 h4-to-mob-l">Get involved in Anti-Slavery Day!
            </h3>
            <p class="space-bottom">Whether you’re new to the issue of modern slavery or a seasoned activist, we have
                planned plenty of ways for organisations and individuals to get involved in Anti-Slavery Day.</p>
        </div>

        <div class="cta-card">

        </div>

        <!-- end content -->
    </div>



</main>



<?php
endwhile;
// end of the loop.
?>

<!-- 
	-- 
	-- video modal
	-- 
	-->
<?php //get_template_part(
	    //'partials/content',
	   // 'modal',
	   // array(
	        //'type' => 'video',
	        //'id' => 'video-modal'
	   // )
	//); ?>

<?php get_footer(); ?>