<?php
/**
 * Template Name: Basic Campaign
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


	<main id="main" class="site-main campaign" role="main">

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
			-- Hero
			--  
			-->
			<div class="hero">
				<div class="hero__img">
					<img src="<?php echo $thumbnail[0]; ?>">
				</div>
				<div class="sub-grid">
					<div class="hero__info">
						<h1 class="font-fk hero__title">
							<?php the_title(); ?>
						</h1>
						<div class="line line--white line--title"></div>
						<div class="hero__description">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>

		
			<!-- 
			-- 
			-- Inline Giving
			--  
			-->
			<div class="inline-giving">
				
				<!-- 
				-- 
				-- Giving
				--  
				-->
				<div class="donate__giving">
					<!-- 
					-- 
					-- Toggle
					--  
					-->				
					<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) {?> 

					<a href="<?php echo the_field('norway_donate_form_monthly')?>">
						<div class="donate__toggle-container">
							<div class="donate__toggle toggle toggle--black">
								<div class="toggle__option">Give once</div>
								<div class="toggle__option">Give monthly</div>
								<div class="toggle__slider">Giving </div>
							</div>
						</div>
					</a>

					<?php } else { ?>

					<div class="donate__toggle-container">
						<div class="donate__toggle toggle toggle--black">
							<div class="toggle__option">Give once</div>
							<div class="toggle__option">Give monthly</div>
							<div class="toggle__slider">Giving </div>
						</div>
					</div>

					<?php } ?>

					<div class="donate__form donate__form--monthly">
						<?php 
							if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
								<!-- US -->
								<div id="usaFormMonthly">
									<?php echo do_shortcode( get_field('us_donate_form_monthly') ); ?>
								</div>
							<?php } 
							else if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { ?>
								<!-- Norway 
									one off default for norway
								-->
								<div id="norwayForm">
									<?php echo do_shortcode( get_field('norway_donate_form_once') ); ?>
								</div>
							<?php } else { ?>
								<!-- UK fallback -->
								<div id="ukFormMonthly">
									<?php echo do_shortcode( get_field('uk_donate_form_monthly') ); ?>
								</div>
							<?php } ?>
					</div>
					<div class="donate__form donate__form--once">
						<?php 
							if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){ ?>
								<!-- US -->
								<div id="usaForm">
									<?php echo do_shortcode( get_field('us_donate_form_once') );?>
								</div>
							<?php } 
							else if($GLOBALS['userInfo'] 
							&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { ?>
								<!-- Norway -->
								<div id="norwayForm">
									<?php echo do_shortcode( get_field('norway_donate_form_once') ); ?>
								</div>
							<?php } 
							else { ?>
								<!-- UK fallback -->
								<div id="ukForm">
									<?php echo do_shortcode( get_field('uk_donate_form_once') ); ?>
								</div>
							<?php } ?>
					</div>
				</div><!-- / giving -->

			</div>

			<div class="inline-giving__info">	
				<h2 class="inline-giving__title font-fk">	
					<?php the_field('form_description_title');?>		
				</h2>
				<div class="inline-giving__description">
					<p>
					<?php the_field('form_description_text');?>
					</p>
				</div>
			</div>

		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

	<?php if($GLOBALS['userInfo'] 
	&& in_array($GLOBALS['userInfo'], $GLOBALS['norway']) || get_field('start_with_one_off')) { ?>
		<input id="initialDonationType" type="hidden" name="geo" value="once">
	<?php } ?>


<?php get_footer(); ?>