<?php
/**
 * The homepage template
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main" role="main">

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
		-- hero split ---reverse
		-- 
		--> 
		<div class="hero-split hero-split--reverse">

			<div class="hero-split__img" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						Modern Slavery
					</h3>
					<h1 class="hero-split__main-heading">
						What is<br>Modern Slavery?
					</h1>
					<p class="hero-split__desc">
						Modern slavery is where one person controls another for profit by exploiting a vulnerability. Usually the victim is forced to work or is sexually exploited, and the trafficker keeps all or nearly all of the money. The control can be physical, financial or psychological.
					</p>
					<div class="hero-spit__button">
						<a href="#" class="button button--green">
							<div class="button__inner">
								<svg class="button__play-symbol" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.771 18.228">
									<g>
									  <path id="play" d="M9.984,7.564c-.074.021-.062-.019-.136.536-.083.624-.115,1.019-.2,2.471-.081,1.386-.128,2.007-.264,3.424a46.8,46.8,0,0,0-.211,5.848,23.71,23.71,0,0,0,.081,4.127,2.525,2.525,0,0,0,.307.9c.072.125.155.277.187.34a.779.779,0,0,0,.281.334,1.644,1.644,0,0,1,.174.134.286.286,0,0,0,.251.108,2.368,2.368,0,0,0,1.043-.428,16.726,16.726,0,0,1,3.112-1.339c1.047-.387,2.135-.826,2.99-1.209.651-.292.664-.3,1.66-.79.864-.428,1.264-.624,1.849-.9.485-.232,2.658-1.32,3.018-1.513.192-.1.451-.249.575-.323a7.489,7.489,0,0,0,1.728-1.419,1.822,1.822,0,0,0,.119-.226,1.908,1.908,0,0,1,.108-.207.824.824,0,0,0,.075-.179.964.964,0,0,1,.064-.179,1.993,1.993,0,0,0,.094-.317,1.283,1.283,0,0,0,.043-.424.641.641,0,0,0-.211-.5,7.834,7.834,0,0,0-1.266-.907c-.858-.573-1.4-.907-2.132-1.322-.492-.279-.894-.511-1.905-1.1-.457-.264-1.051-.606-1.32-.76l-.632-.358c-.479-.274-1.107-.609-2.075-1.113-.553-.287-1.228-.647-1.368-.726-.24-.138-1.205-.643-1.8-.941a6.483,6.483,0,0,0-1.594-.615A3.933,3.933,0,0,0,11.155,7.8a1.954,1.954,0,0,0,.447.694,9.963,9.963,0,0,0,1.8,1.624c.232.158,2.02,1.171,2.754,1.56.1.055.249.13.321.17s.4.209.726.377c1.6.824,3.456,1.817,4.471,2.392.809.458,1.8,1.028,2.075,1.192.372.223,1.147.713,1.16.736a1.059,1.059,0,0,1-.232.166c-.628.39-1,.6-1.928,1.083l-.472.247c-.283.147-1.849.93-2.009,1-.379.175-1.756.868-2.292,1.151-.672.358-1.718.888-2.216,1.126-.455.219-.815.389-.962.458-.373.175-1.083.507-1.281.6-.123.059-.224.106-.228.106s-.289.132-.636.294c-.626.292-1.16.56-1.551.779a2.149,2.149,0,0,1-.211.111A13.262,13.262,0,0,1,10.8,22.3c-.043-1.222-.074-1.747-.179-3.078-.064-.807-.094-1.254-.141-2.047-.034-.556-.051-1.273-.066-2.688-.017-1.605-.026-1.864-.094-3.018-.021-.347-.053-.866-.07-1.151-.021-.351-.032-.858-.034-1.566,0-.575-.006-1.066-.008-1.088C10.2,7.587,10.084,7.536,9.984,7.564Z" transform="translate(-9.163 -7.556)" fill="#fff"/>
									</g>
								</svg>
								<div class="button__text bold">
									Watch our<br>
									Explanation
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- fact-slider
		--  
		-->
		<div class="color-block color-block--grey">
			<div></div>
		</div>

		<!-- 
		-- 
		-- drag-cards
		--  
		-->
		<div class="drag-cards" id="dragCards">
			<h2 class="drag-cards__heading font-canela">Types of exploitation</h2>
			<div class="drag-cards__inner">
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">01</p>
					<h3 class="drag-cards__card-title font-fk">Preventing<br>Exploitation</h3>
					<p class="drag-cards__card-desc">Through education and community empowerment, we help families and vulnerable people protect themselves against traffickers and the deceptive methods they use to control others.</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">02</p>
					<h3 class="drag-cards__card-title font-fk">Rescuing<br>Victims</h3>
					<p class="drag-cards__card-desc">Our investigators and outreach teams work with police and other agencies to identify victims of modern slavery, build bridges of trust with them and get them safely out of exploitation.</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">03</p>
					<h3 class="drag-cards__card-title font-fk">Restoring<br>Lives</h3>
					<p class="drag-cards__card-desc">We provide world-class survivor aftercare, both residential and non-residential. Our legal advocacy and support ensures needs are met and gives the best chance for justice to be done.</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">04</p>
					<h3 class="drag-cards__card-title font-fk">Reforming<br>Society</h3>
					<p class="drag-cards__card-desc">We train others on the front line – police, NHS, charities and many more – to spot the signs of modern slavery and to respond effectively. We work with governments and businesses to make change happen.</p>
				</div>
			</div>
			<div class="drag-cards__dots dots">
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
			</div>

			<div class="drag-cards__button">
			    <a href="#" class="button button--green">
					<div class="button__inner">
						<div class="button__text bold">Learn more about<br>how we help</div>
					</div>
				</a>
			</div>
		</div>

		<!-- 
		-- 
		-- freedom-wall
		--  
		-->
		<div class="freedom-wall">
			<h2 class="freedom-wall__heading font-canela">Every lock on our Freedom Wall<br> represents a real life changed</h2>
			<div class="freedom-wall__button">
			    <a href="#" class="button button--black">
					<div class="button__inner">
						<div class="button__text bold">See how we <br>change lives</div>
					</div>
				</a>
			</div>
			<div class="freedom-wall__image"></div>
		</div>



	</div> <!-- /grid -->

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>