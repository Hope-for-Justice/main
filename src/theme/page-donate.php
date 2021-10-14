<?php
/**
 * The template used for /donate 
 *
 * @package hopeforjustice-2014
 */

get_header(); ?>


	<main id="main" class="site-main donate" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

		<?php $thumbnail = '';

		// Get the ID of the post_thumbnail (if it exists)
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);

		// if it exists
		if ($post_thumbnail_id) {
			$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
		} ?>

		<img class="donate__img" src="<?php echo $thumbnail[0]; ?>" alt="reintegration of a young girl back to her family">
		<div class="grid">

			<!-- 
			-- 
			-- Description
			--  
			-->
			<div class="donate__info donate__info--monthly">	
				<h2 class="donate__title font-fk">
					<?php the_field('donate_title_monthly');?>		
				</h2>
				<p>
					<?php the_field('donate_description_monthly');?>	
				</p>
			</div>

			<div class="donate__info donate__info--once">	
				<h2 class="donate__title font-fk">
					<?php the_field('donate_title_once');?>		
				</h2>
				<p>
					<?php the_field('donate_description_once');?>	
				</p>
			</div>


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
				<div class="donate__toggle-container">
					<div class="donate__toggle toggle toggle--black">
						<div class="toggle__option">Give once</div>
						<div class="toggle__option">Give monthly</div>
						<div class="toggle__slider">Giving </div>
					</div>
				</div>
				<div class="donate__form donate__form--monthly">
					<?php 
						if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['us'])){
							//US
							echo do_shortcode( get_field('us_donate_form_monthly') );
						} 
						else if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { 
							//Norway
							echo do_shortcode( get_field('norway_donate_form_monthly') );
						}
						else {
							//UK fallback
							echo do_shortcode( get_field('uk_donate_form_monthly') );
						} ?>
				</div>
				<div class="donate__form donate__form--once">
					<?php 
						if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['us'])){
							//US
							echo do_shortcode( get_field('us_donate_form_once') );
						} 
						else if($GLOBALS['userInfo'] 
						&& in_array($GLOBALS['userInfo'], $GLOBALS['norway'])) { 
							//Norway
							echo do_shortcode( get_field('norway_donate_form_once') );
						}
						else {
							//UK fallback
							echo do_shortcode( get_field('uk_donate_form_once') );
						} ?>
				</div>
			</div>


		</div><!-- /grid -->

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer(); ?>