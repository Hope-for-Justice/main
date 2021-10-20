<?php
/**
 * Template Name: Events
 */

get_header();
?>

<main id="main" class="site-main events">

	<div class="grid">

			<h2 class="events__title font-fk">
				<!-- Show the title -->
				<?php echo get_the_title(); ?>
			</h2>

			<div class="events__content">
				<p><?php echo get_the_content(); ?></p>
			</div>

			
			<?php while (have_rows('event_cards')) : the_row(); ?>

				<div class="events__card">
					<div class="events__card-img">
						<img src="<?php echo get_sub_field('image'); ?>">
					</div>
					<div class="events__card-content">
						<h3 class="events__card-date">
							<?php echo get_sub_field('date'); ?>
						</h3>
						<h2 class="events__card-title font-canela">
							<?php echo get_sub_field('title'); ?>
						</h2>
						<p>
							<?php echo get_sub_field('description'); ?>
						</p>
						<div class="events__card-button">
							<a href="<?php echo get_sub_field('button_link'); ?>" data-toggle="modal" class="button button--green">
								<div class="button__inner">
									<div class="button__text bold">
										<?php echo get_sub_field('button_text'); ?>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>

			<?php endwhile; ?>

		

	</div>
		
		
	



</main><!-- /#main -->

<?php get_footer(); ?>