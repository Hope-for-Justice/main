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

			<!-- 
			-- 
			-- header
			--  
			-->
			<div class="color-block color-block--red">
				<div class="sub-grid">
					<header class="form-page__header">
						<h1 class="form__heading form__heading--no-margin font-fk"><?php the_title(); ?></h1>
					</header>
				</div>
			</div><!-- /header -->



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

			<div class="contact__block contact__block--press">
				<div class="contact__block-content">
					<?php the_field('press_contact'); ?>
				</div>
			</div>


		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
