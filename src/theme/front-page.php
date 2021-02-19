<?php
/**
 * The homepage template
 *
 * @package Hope_for_Justice_2020
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

	<!-- 
	-- 
	-- Hero
	--  
	-->
	<div class="hero hero--home" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
		<div class="grid">
			<div class="hero__content">
				<div class="hero__inner">
					<h3 class="hero__sub-header bold">OUR MISSION</h3>
					<h1 class="hero__header font-fk">End<br>Slavery.<br>Change<br>Lives.
					</h1>
					<p class="hero__body-text">We exist to bring an end to modern slavery by preventing exploitation, rescuing victims, restoring lives and reforming society.</p>
					<div class="hero__button button button--green">
						<div class="button__inner">
							<svg class="button__play-symbol" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.537 19.013">
							  <path id="play" d="M10.019,7.565c-.077.022-.065-.02-.142.559-.087.651-.12,1.062-.209,2.577-.085,1.446-.134,2.093-.275,3.571a48.817,48.817,0,0,0-.22,6.1,24.731,24.731,0,0,0,.085,4.305,2.634,2.634,0,0,0,.321.939c.075.13.161.289.195.354a.812.812,0,0,0,.293.348,1.715,1.715,0,0,1,.181.14.3.3,0,0,0,.262.112,2.47,2.47,0,0,0,1.088-.447,17.447,17.447,0,0,1,3.246-1.4c1.092-.4,2.227-.862,3.119-1.261.679-.3.693-.311,1.731-.824.9-.447,1.318-.651,1.928-.941.506-.242,2.772-1.377,3.148-1.578.2-.108.47-.26.6-.336a7.812,7.812,0,0,0,1.8-1.48,1.9,1.9,0,0,0,.124-.236,1.989,1.989,0,0,1,.112-.216.86.86,0,0,0,.079-.187,1.006,1.006,0,0,1,.067-.187,2.079,2.079,0,0,0,.1-.331,1.338,1.338,0,0,0,.045-.443.668.668,0,0,0-.22-.521,8.172,8.172,0,0,0-1.32-.946c-.9-.6-1.458-.946-2.223-1.379-.514-.291-.933-.533-1.987-1.145-.476-.275-1.1-.632-1.377-.793l-.659-.374c-.5-.285-1.155-.635-2.164-1.161-.576-.3-1.281-.675-1.426-.758-.25-.144-1.257-.671-1.879-.982a6.762,6.762,0,0,0-1.663-.641,4.1,4.1,0,0,0-1.537-.2,2.038,2.038,0,0,0,.466.724,10.393,10.393,0,0,0,1.877,1.694c.242.165,2.107,1.222,2.873,1.627.108.057.26.136.334.177s.417.218.757.394c1.67.86,3.6,1.895,4.663,2.495.844.478,1.881,1.072,2.164,1.243.388.232,1.2.744,1.21.767a1.1,1.1,0,0,1-.242.173c-.655.407-1.041.624-2.011,1.129l-.492.258c-.3.153-1.928.97-2.1,1.047-.4.183-1.832.905-2.391,1.2-.7.374-1.792.927-2.312,1.175-.474.228-.85.405-1,.478-.39.183-1.129.529-1.336.628-.128.061-.234.11-.238.11s-.3.138-.663.307c-.653.3-1.21.584-1.617.813a2.241,2.241,0,0,1-.22.116,13.834,13.834,0,0,1-.1-1.428c-.045-1.275-.077-1.822-.187-3.211-.067-.842-.1-1.308-.148-2.135-.035-.58-.053-1.328-.069-2.8-.018-1.674-.028-1.944-.1-3.148-.022-.362-.055-.9-.073-1.2-.022-.366-.033-.9-.035-1.633,0-.6-.006-1.112-.008-1.135C10.247,7.588,10.123,7.535,10.019,7.565Z" transform="translate(-9.163 -7.556)" fill="#fff"/>
							</svg>
							<a class="button__link bold" href="#">New Here?<br>Watch this!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- 
	-- 
	-- Splash screen modal
	--  
	-->
	<div class="modal" id="splash-modal" tabindex="-1" role="dialog" aria-hidden="false">
		<div class="modal__dialog">
	        <div class="modal__content">
	        	
	        	<div class="modal__image" style="background-image: url(https://hopeforjustice.org/wp-content/uploads/2021/02/campaign-img-optimised.jpg);"></div>
	        	<div class="modal__info">
	        		<h2 class="font-fk modal__title">#keephopealive</h2>
	        		<p class="modal__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
	        		<div class="giving-widget">
	        			<div class="giving-widget__rangeslider">
	        				<input class="rangeslider" style="margin: 500px 0;" type="range" min="5" max="250" step="5" value="25">
	        			</div>
	        			<div id="custom-amount" class="button__link button__link--plain button__link--red">Use custom amount</div>
						<div class="input--pre-pound giving-widget__amount">
							<input id="preAmount" type="number" name="preAmount">
						</div>
						<p class="giving-widget__feedback"><b>£25</b> Could provide meals for a week for a child at one of our Lighthouses as they are protected from exploitation</p>
					</div>
					<div class="modal__buttons">
						<a class="modal__button button button__link button--one-line" href="#">Donate</a>
						<a class="modal__button button__link button__link--plain button__link--black" href="#">Learn more</a>
					</div>
	        	</div>
	        	<a id="splash-close" href="#" data-dismiss="splash-modal" class="gi-close modal__close"><span class="accessibility">Close</span></a>
	        </div>
    	</div>
	</div>

	<!-- 
	-- 
	-- Slider
	--  
	
	<input class="rangeslider" style="margin: 500px 0;" type="range" min="0" max="500" step="10" value="20">
	<input id="preAmount" type="number" name="preAmount">-->

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>