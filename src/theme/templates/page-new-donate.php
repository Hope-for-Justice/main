<?php
/**
 * Template Name: New donate
 *
 * @package hopeforjustice-2014
 */

get_header(); ?>


	<main id="main" class="site-main donate" role="main">


		<div class="grid">


			<a data-toggle="modal" data-target="#donateModal" class="button">Donate</a>

		</div><!-- /grid -->

		<!--
	    --
	    --  donate modal
	    --
	    --> 
	    <div class="donate-modal modal fade" id="donateModal" tabindex="-1" role="dialog" aria-hidden="false">
	          <div class="modal__dialog">
	                <div class="modal__content">
	                   	<?php echo do_shortcode( '[give_form id="1426"]' ); ?>
	                </div>
	         </div>
	    </div>

	</main><!-- #main -->



<?php get_footer(); ?>