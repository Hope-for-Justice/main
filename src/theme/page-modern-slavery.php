<?php
/**
 * Modern Slavery
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
		-- hero split --reverse
		-- 
		--> 
		<div class="hero-split hero-split--reverse">

			<div class="hero-split__img hero-split__img--bottom-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						Modern Slavery
					</h3>
					<h1 class="hero-split__main-heading">
						What is <br>Modern Slavery?
					</h1>
					<p class="hero-split__desc">
						Modern slavery is where one person controls another for profit by exploiting a vulnerability. Usually the victim is forced to work or is sexually exploited, and the trafficker keeps all or nearly all of the money. The control can be physical, financial or psychological.
					</p>
					<div>
						<a data-toggle="modal" data-target="#video-modal" data-src="https://player.vimeo.com/video/561295870" class="button button--green video-trigger">
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
		-- text-slider flexslider
		--  
		-->
		<div class="color-block color-block--grey">
			<div class="text-slider">
				<h3 class="text-slider__heading">
					Modern Slavery Facts
				</h3>
				<div class="text-slider__slider">
					<div class="flexslider-text">
						<ul class="slides">
							<li><p>$150 billion made each year from forced labour, that’s over $4,750&nbsp;a&nbsp;second <span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></p></li>
							<li><p>7 in every 10 victims worldwide are women&nbsp;and&nbsp;girls <span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></p></li>
							<li><p>There were 10,613 potential cases reported in the UK&nbsp;last&nbsp;year <span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></p></li>
						</ul>
					
					</div>
					<a class="text-slider__prev" href="prev"></a>
					<a class="text-slider__next" href="next"></a>
				</div>
				<div>
					<a href="#" class="button button--blue">
						<div class="button__inner">
							<div class="button__text bold">
								Resources and<br>
								Statistics
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- drag-cards
		--  
		-->
		<div class="drag-cards drag-cards--no-margin-top drag-cards--no-margin-bottom" id="dragCards">
			<h2 class="drag-cards__heading font-canela">Types of exploitation  <span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></h2>
			<div class="drag-cards__inner">
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">01</p>
					<h3 class="drag-cards__card-title font-fk">Sexual<br>Exploitation</h3>
					<p class="drag-cards__card-desc">Vulnerable people, overwhelmingly women and girls, are tricked or forced into the sex trade. It often begins with a promise of good work in hospitality or modelling, or a 'boyfriend' is responsible.</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">02</p>
					<h3 class="drag-cards__card-title font-fk">FORCED<br>LABOUR</h3>
					<p class="drag-cards__card-desc">This is when a person has no choice or control over their work, with the money they earn taken by someone else, who often also controls where they live and even who they can speak with.</p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">03</p>
					<h3 class="drag-cards__card-title font-fk">DOMESTIC<br>SERVITUDE</h3>
					<p class="drag-cards__card-desc">A less common type of modern slavery, when a person is forced to cook, clean or do childcare for little or no pay, often living in the home with the 'employer' and not allowed to live their own life.  </p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">04</p>
					<h3 class="drag-cards__card-title font-fk">CRIMINAL<br>EXPLOITATION</h3>
					<p class="drag-cards__card-desc">Victims are forced to grow or transport drugs, made to shoplift or pickpocket, are forced to beg on the streets, or used for fraud. The threat of being reported becomes another method of control. </p>
				</div>
				<div class="drag-cards__card">
					<p class="drag-cards__card-number font-canela">05</p>
					<h3 class="drag-cards__card-title font-fk">FORCED<br>MARRIAGE</h3>
					<p class="drag-cards__card-desc">More than 15 million people are thought to have been forced into a marriage without consent, nearly all of them women and girls, often to an older man in another region or country.</p>
				</div>
			</div>
			<div class="drag-cards__dots dots">
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
				<div class="dots__dot"></div>
			</div>
		</div>
		
		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text">
			<h2>How many people are in modern slavery?</h2>
			<p class="plain-text__thinner">The number of people living in modern slavery is estimated at <b>40.3 million</b>, made up of: 
				<span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span>
			</p>
		</div>

		<!-- 
		-- 
		-- number-stats
		--  
		-->
		<div class="number-stats">
			<div class="number-stats__stat">
				<div class="number-stats__heading">16.3m</div>
				<p>In some form of forced labour or criminal exploitation</p>
			</div>
			<div class="number-stats__stat">
				<div class="number-stats__heading">15.4m</div>
				<p>In forced marriage to which they had not consented</p>
			</div>
			<div class="number-stats__stat">
				<div class="number-stats__heading">16.3m</div>
				<p>In forced sexual exploitation (including 1 million children)</p>
			</div>
			<div class="number-stats__stat">
				<div class="number-stats__heading">3.8m</div>
				<p>In domestic servitude and private homes</p>
			</div>
		</div>

		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text plain-text--margin-bottom">
			<p class="plain-text__thinner">There are tens of thousands of victims in the UK. Some estimates suggest the number of people in modern slavery in the UK is up to 136,000.  
				<span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span>
			</p>
		</div>

		<!-- 
		-- 
		-- color block - plain-text
		--  
		-->
		<div class="color-block color-block--grey">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2>How do traffickers keep their victims under control?<span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></h2>
					<p>People are tricked or forced into exploitation and kept there through violence, fraud or coercion, and often end up living and working in abominable conditions. 
					<br><br>
					Some are beaten and abused; others have threats made against their families in their home countries. Many are forced into fraudulent ‘debt bondage’, with their wages kept by a trafficker to pay non-existent bills for their travel, accommodation or food. They are told they will be deported if they go to the authorities. 
					<br><br>
					Often, the trafficker takes control of a victim’s identity documents (e.g. passport). They accompany them to open a bank account, then take control of its associated bank card and correspondence (this functions both as a simple way for the trafficker to control the victim’s earnings, and a way for them to exert dominance and control by offering occasional small sums of money from what should be the victim’s own wages). 
					<br><br>
					Traffickers usually focus on those easiest to exploit, which tends to be people with fewer resources or existing vulnerabilities. </p>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- color block - plain-text
		--  
		-->
		<div class="color-block color-block--background-img" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2021/06/man-in-black-shirt-and-gray-denim-pants-sitting-on-gray-1134204.jpg');">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2>Risk factors for trafficking <span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></h2>
					<p>Anyone from any walk of life can be targeted and can end up as a victim of modern slavery. But people experiencing any of the following things can be at particular risk:
					<br><br>
					Homelessness
					<br>
					Alcohol or drug addiction
					<br>
					Mental health problems
					<br>
					Chaotic home environment or recent family breakdown
					<br>
					Long-term unemployment
					<br>
					Learning difficulties
					<br>
					Debts or criminal convictions
					<br>
					Fearful of deportation or being discovered by authorities
					<br>
					Physical injuries or disabilities
					</p>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- color block - plain-text
		--  
		-->
		<div class="color-block">
			<div class="sub-grid">
				<div class="plain-text plain-text--in-color-block">
					<h2>Why don’t victims run away?<span data-toggle="modal" data-target="#reference-modal" data-text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod." class="reference__symbol">i</span></h2>
					<p>The relationship between someone experiencing modern slavery and the person or group controlling them is complex. It is rare for the control to be based on physical confinement like locked doors or shackles. Instead, victims are exploited through manipulation, fear, dependency, threats or debt bondage. 
					<br><br>
					This means that during the time they are actually in exploitation, few people think of themselves as being a 'victim'. They often describe feeling hopeless or having no options, or even feel a sense of obligation towards those who trafficked them. They do not understand their situation as being one that they could run away from or escape from. 
					<br><br>
					For many, it is only once they get long-term help from a specialist organisation like Hope for Justice that they understand the extent of the exploitation and that a different life is possible, with the right support.</p>
				</div>
			</div>
		</div>

		<!-- 
		-- 
		-- hero split --reverse
		-- 
		--> 
		<div class="hero-split hero-split--reverse">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('https://hopeforjustice.org/wp-content/uploads/2021/06/men-smile.jpg');">
			</div>

			<div class="hero-split__content hero-split__content--grey">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						Help make a difference
					</h3>
					<h2 class="hero-split__smaller-main-heading">
						Together we can help more of those who are trapped and alone
					</h2>
					<div>
						<a class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									Make a Donation
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->


	</div> <!-- /grid -->

	<!-- 
	-- 
	-- reference modal
	-- 
	--> 
	<?php get_template_part(
	    'partials/content',
	    'modal',
	    array(
	        'type' => 'reference',
	        'id' => 'reference-modal'
	    )
	); ?>

	<!-- 
	-- 
	-- video modal
	-- 
	--> 
	<?php get_template_part(
	    'partials/content',
	    'modal',
	    array(
	        'type' => 'video',
	        'id' => 'video-modal'
	    )
	); ?>



	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>