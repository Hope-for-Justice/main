<?php
/**
 * Template for resources and stats
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>

	<main id="main" class="site-main resources" role="main">

		<div class="grid">

			<div class="resources__content">	

				<h2 class="resources__title font-canela">
					<!-- Show the title -->
					<?php echo get_the_title(); ?>
				</h2>

				<div class="resources__content">
					<?php echo get_the_content(); ?>
				</div>

				<!-- cards container -->	
			    <div class="cards sub-grid">
					<?php while (have_rows('resources')) : the_row(); ?>
					
					<!-- card template -->	
					<a href="<?php get_sub_field('resource_link') ?>" class="cards__card cards__card--resource" >	
						<div class="cards__content cards__content--resource" >
							<img src="<?php get_sub_field('resource_image') ?>" class="cards__img cards__img--resource">

							<div class="cards__info cards__info--resource">
								<h3 class="cards__title cards__title--resource font-fk">
									<?php get_sub_field('resource_title') ?>
								</h3>
								<div class="button button--whites">
									<div class="button__inner">
										<div class="button__text bold">
											<?php get_sub_field('resource_button') ?>		
										</div>
									</div>
								</div>
							</div>
						</div>

					</a>

					<?php endwhile; ?>?>
				</div>

			</div>

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>