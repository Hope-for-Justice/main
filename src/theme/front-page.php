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
	
	<div class="grid">
	<!-- 
	-- 
	-- hero split
	-- 
	--> 
	
	<div class="hero-split">
		<div class="hero-split__img" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
		</div>
		<div class="hero-split__content">
			<h3 class="hero-split__sub-heading">
				Our Mission
			</h3>
			<h1 class="hero-split__main-heading">
				End Slavery.<br>
				Change Lives.
			</h1>
			<p class="hero-split__desc">
				We exist to bring an end to modern slavery by preventing exploitation, rescuing victims, restoring lives and reforming society.
			</p>
			<div class="hero-spit__button">
				<div class="button button--green">
					<div class="button__inner">
						<img class="button__play-symbol" src="img/play.svg">
						<a class="button__link bold" href="#">Get our<br>email updates</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>