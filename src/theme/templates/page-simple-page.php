<?php
/**
 * Template Name: Simple Page
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main simple-page" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

		<?php $thumbnail = '';

		// Get the ID of the post_thumbnail (if it exists)
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);

		// if it exists
		if ($post_thumbnail_id) {
			$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
		} ?>

		<div class="grid">

			<div class="simple-page__hero">
				<div class="simple-page__image-con">
					<div class="simple-page__image" style="background-image: url('<?php echo $thumbnail[0]; ?>');"></div>
				</div>
				<div class="simple-page__hero-content-con">
					<h1 class="simple-page__title font-fk font-fk--normal-case"><?php the_title(); ?></h1>

					<div class="simple-page__hero-content">
						<?php the_field('hero_content'); ?>
					</div>
				</div>

			</div>

			<div class="simple-page__line"></div>
		
			<div class="simple-page__content">
				<?php the_content(); ?>
			</div>


		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

	<!-- modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="false">
	      <div class="modal__dialog">
	            <div class="modal__content">
	            	<?php the_field('modal_content'); ?>
	                <a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a>
	            </div>
	     </div>
	</div>


<?php get_footer(); ?>