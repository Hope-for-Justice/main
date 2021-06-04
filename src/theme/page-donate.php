<?php
/**
 * The template for /donate
 *
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main">

	<div class="grid">
		<div class="color-block color-block--grey">
			<div class="sub-grid">
				<!-- 
				-- 
				-- donate
				-- 
				--> 
				<div class="donate">
					<div class="dots">
						<div class="dots__dot dots__dot--active"></div>
						<div class="dots__dot"></div>
						<div class="dots__dot"></div>
						<div class="dots__dot"></div>
					</div>
					<div class="form__text form__text--first">
						<h1 class="form__heading font-fk">Make a donation</h1>
						<p class="form__desc">
							Join us in ending slavery! Your donation will help prevent exploitation, rescue victims, restore lives and reform society. 
						</p>
						<div class="line"></div>
					</div>
					
					<div class="donate__widget">
						<div class="donate__toggle-and-currency">
							<div class="donate__toggle toggle toggle--black">
								<div class="toggle__option">Give once</div>
								<div class="toggle__option">Give monthly</div>
								<div class="toggle__slider">Giving </div>
							</div>
							<a class="donate__currency">Donation in British Pounds. Change currency?</a>
						</div>
						
						<div class="donate__buttons">
							<a 	data-valuemonthly="15"
								data-valuesingle="20"
								data-monthlymsg="monthly donation message for option one lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod." 
								data-singlemsg="single donation message for option one lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod."
								class="donate__button donate__button--monthly donate__button--uk">		
							</a>
							<a 	data-valuemonthly="30"
								data-valuesingle="50" 
								data-monthlymsg="monthly donation message for option two lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod."
								data-singlemsg="single donation message for option two lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod." 
								class="donate__button donate__button--monthly donate__button--uk donate__button--active">	
							</a>
							<a 	data-valuemonthly="50"
								data-valuesingle="80"
								data-monthlymsg="monthly donation message for option three lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod."
								data-singlemsg="single donation message for option three lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod." 
								class="donate__button donate__button--monthly donate__button--uk">
							</a>
							<a 	data-valuemonthly="100"
								data-valuesingle="200"
								data-monthlymsg="monthly donation message for option four lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod."
								data-singlemsg="single donation message for option four lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod." 
								class="donate__button donate__button--monthly donate__button--uk">
							</a>
							<div 
								data-monthlymsg="Monthly donation message for custom option lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod."
								data-singlemsg="Single donation message for custom option lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod." 
								class="donate__custom input--pre-pound">
									<input type="number" class="donate__custom-input" id="customAmount" name="customAmount">
							</div>
						</div>
					

						<p class="donate__message"><span class="donate__message-amount"></span> <span class="donate__message-text">a month could lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</span></p>


					</div><!--/ donate widget -->

					<div class="donate__widget-footer">
						<div class="line"></div>
						<a id="donateNext" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									Next
								</div>
							</div>
						</a>
					</div><!--/ donate widget footer-->
					<!-- 
					-- 
					-- Gravity Form
					-- 
					--> 
					<div class="donate__form form">
					<?php echo do_shortcode("[gravityform id=\"4\" title=\"false\" description=\"false\" ajax=\"true\"]"); ?>
					</div>

				</div><!-- /donate -->
			</div><!-- /sub grid -->

		</div><!-- /color block -->
	</div><!-- /grid -->
	

</main><!-- /#main -->

<?php get_footer(); ?>
