<?php
/**
 * Template Name: Spot the signs
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main spot-the-signs" role="main">

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
		<div class="hero-split hero-split">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content hero-split__content--grey">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						<!--  -->
						<?php the_field('subtitle'); ?>
					</h3>
					<h1 class="font-canela">
						<!--  -->
						<?php the_title(); ?>
					</h1>
					<div class="hero-split__desc">
						<!--  -->
						<?php the_content(); ?>
					</div>
					<div class="hero-spit__button">
						<a href="<?php the_field('hero_button_link'); ?>" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									<?php the_field('hero_button_text'); ?>
									<!--  -->
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- drop-cards
		-- 
		-->
		<div class="drop-cards">
			

			<?php

			$i = 1;

			while (have_rows('drop_cards')) : the_row(); ?>
			
				<div class="drop-card <?php if($i == 1) {echo 'drop-card--open';} ?>">
					<div class="drop-card__header">
						<h2 class="drop-card__title font-fk">
							<?php echo (get_sub_field('drop_card_title'))?>
						</h2>
						<div class="drop-card__cross cross-circle"><span class="cross-circle__plus <?php if($i == 1) {echo 'cross-circle__plus--open';} ?>">&times;</span></div>
					</div>
					<div class="drop-card__content">
						<!-- If has description -->
						<?php if( get_sub_field('description') ){ ?>
							<p class="drop-card__desc">
								<?php echo (get_sub_field('description'))?>
							</p>
						<?php } ?>
						
						<?php while (have_rows('lists')) : the_row(); ?>

							<!-- If has title -->
							<?php if( get_sub_field('list_title') ){ ?>
								<h3 class="drop-card__sub-title">
									<?php echo (get_sub_field('list_title'))?>		
								</h3>
							<?php } ?>

							<ul class="drop-card__list">
								<?php while (have_rows('list_items')) : the_row(); ?>
									<li class="drop-card__list-item">
										<?php echo (get_sub_field('list_item'))?>
									</li>
								<?php endwhile; ?> <!--/list items-->							
							</ul>
						<?php endwhile; ?> <!--/lists-->	
						<a href="<?php echo (get_sub_field('drop_card_button_link'))?>" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									<!-- Report<br>
									a concern -->
									<?php echo (get_sub_field('drop_card_button_text'))?>
								</div>
							</div>
						</a>
					</div>
				</div>

			<?php $i++; 
			endwhile; ?> <!-- end card loop -->

		</div>


	</div> <!-- /grid -->

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>