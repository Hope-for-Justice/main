<?php
/**
 * The homepage template
 *
 * @package Hope_for_Justice_2020
 */

get_header();
?>

<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>		

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} ?>

	<!-- 
	-- 
	-- hero split
	-- 
	--> 
	
	<div class="hero-split">
		<div class="hero-split__img" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
		</div>
		<div class="hero-split__content">
			
		</div>
	</div>


	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>