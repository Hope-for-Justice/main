<?php
/**
 * Template Name: Anti-slavery day
 *
 * @package Hope_for_Justice_2021
 */

get_header(); 

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