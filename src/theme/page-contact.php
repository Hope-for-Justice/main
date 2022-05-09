<?php
/**
 * Template for /contact
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main contact" role="main">

		<?php while ( have_posts() ) : the_post(); ?>		

		<div class="grid">

			<div class="sub-grid contact__grid">
				<div class="contact__block">
					<div class="contact__block-content">
						<?php the_field('us_contact'); ?>
					</div>
				</div>

				<div class="contact__block">
					<div class="contact__block-content">
						<?php the_field('uk_contact'); ?>
					</div>
				</div>

				<div class="contact__block">
					<div class="contact__block-content">
						<?php the_field('norway_contact'); ?>
					</div>
				</div>

				<div class="contact__block contact__block">
					<div class="contact__block-content">
						<?php the_field('concern_contact'); ?>
					</div>
				</div>

				<div class="contact__block contact__block--press">
					<div class="contact__block-content">
						<?php the_field('press_contact'); ?>
					</div>
				</div>
			</div>


		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
