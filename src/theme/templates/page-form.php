<?php
/**
 * Template Name: Form page
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main" role="main">

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

			<!-- 
			-- 
			-- content
			--  
			-->
			<div class="color-block color-block--grey">
				<div class="sub-grid">
					<div class="form-page__content">
						<?php the_content(); ?>
					</div>
				</div>
			</div><!-- /content -->

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>
