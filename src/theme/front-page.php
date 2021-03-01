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
	-- hero
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
	-- get-involved
	--  
	-->
	<div class="get-involved get-involved--home">
		<div class="grid">
			<div class="inner get-involved__inner">
				<h1 id="waypoint" class="font-fk get-involved__title">How <span>you</span> can get involved</h1>
				<p class="get-involved__body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
				</p>
			</div>
			<div class="get-involved__grid">
				<div class="get-involved__a get-involved__item" style="background-image: url(https://hopeforjustice.org/wp-content/uploads/2021/02/hope-news-optimised.jpg);">
					<div class="button button--blue button--left-align">
						<div class="button__inner">
							<svg class="button__mail-symbol" xmlns="http://www.w3.org/2000/svg" width="42.191" height="36.14" viewBox="0 0 42.191 36.14">
  								<path id="inbox" d="M1.49-.013A4.633,4.633,0,0,0,.645.233.668.668,0,0,0,.378.527.743.743,0,0,0,.259,1,2.631,2.631,0,0,0,.794,2.422c.089.14.234.4.326.589a1.235,1.235,0,0,0,.532.645c.194.12.218.124.954.174.416.027.9.07,1.083.094a18.852,18.852,0,0,0,2.5,0c.376-.025.841-.034,1.031-.026S8.3,3.943,9.2,3.973c2.886.1,3.755.133,4.931.191,3.553.173,4.584.219,6.972.327,3.67.161,6.2.288,9.68.482,1.411.081,4.284.272,4.486.3a2.032,2.032,0,0,1-.445.39c-1.376,1.041-2.061,1.6-3.247,2.637-.688.607-1.8,1.527-2.442,2.026-.267.209-.765.595-1.109.86a31.314,31.314,0,0,0-3.9,3.6c-.454.474-1.219,1.253-1.7,1.727S21.295,17.658,20.967,18l-.6.619-.23-.152a22.5,22.5,0,0,1-3.28-3.061c-.887-.945-2.489-2.521-3.288-3.237-.375-.34-.759-.684-.847-.764-.371-.332-3.85-3.352-4.52-3.924A26.769,26.769,0,0,0,5.033,5.048c-.19-.092-.19-.092-.5-.023-.263.057-.32.085-.348.165a.931.931,0,0,0,.132.557c.077.148.549.62,4.446,4.482a84.832,84.832,0,0,1,6.136,6.4,23.8,23.8,0,0,0,3.707,3.838c1.118.864,1.623,1.136,2.015,1.083.643-.085,1.185-.443,2.433-1.609.336-.313.972-.9,1.417-1.306s1.3-1.2,1.9-1.768A37.8,37.8,0,0,1,31.2,12.811c1.117-.816,1.822-1.375,2.733-2.175,2.393-2.094,2.851-2.5,3.2-2.849a5.683,5.683,0,0,0,.539-.6l.154-.221-.025.341c-.05.638-.126,8.428-.106,10.565.06,6.475.236,11.491.5,14.281l.024.253-.946,0c-1.039,0-2-.028-5.166-.17-2.684-.119-3.553-.149-7.114-.267-1.589-.053-3.589-.121-4.446-.152-2.118-.076-4.139-.124-6.973-.167s-3.686-.077-6.083-.233c-1.156-.078-2.308-.124-3.221-.138l-1.427-.021v-.585c.011-5.509-.02-16.515-.045-17.826-.074-3.424-.209-6.876-.28-7.337-.044-.249-.064-.289-.185-.369a.773.773,0,0,0-.691-.019c-.3.145-.324.309-.589,3.4-.4,4.656-.514,6.252-.774,11.208C.207,21.04.094,23.141.027,24.4s-.164,3.08-.21,4.05-.105,2.033-.126,2.366C-.434,32.6-.43,32.641.009,33.43a1.12,1.12,0,0,0,.113.18c.024.028.113.2.205.372a1.165,1.165,0,0,0,.508.62,3.306,3.306,0,0,1,.363.28l.165.144.744.047c.412.027,1.067.066,1.455.089s2.227.044,4.083.044c3.323.005,4.77.047,7.68.229.732.043,2.4.1,5.275.17,1.645.041,3.581.089,4.3.112,2.413.071,4.248.108,6.043.128,2.668.031,4.9.087,6.023.148.558.031,1.322.066,1.7.077s.853.03,1.059.038c.546.031.76-.078.947-.463.041-.076.134-.277.215-.442a1.452,1.452,0,0,0,.146-.437.332.332,0,0,1,.1-.241,2.549,2.549,0,0,0,.29-1.308c.013-.309.063-1.139.1-1.845s.092-1.464.1-1.684c.13-2.222.215-8.392.166-12.129-.056-4.35-.131-7.189-.263-10.224a38.418,38.418,0,0,0-.3-4.27.937.937,0,0,1-.048-.3c-.007-.389-.088-.485-.46-.536a.485.485,0,0,1-.3-.168l-.149-.148-2-.008c-3.428-.009-7.478-.178-16.653-.685-1.722-.1-4.313-.236-5.76-.309S12.415.723,11.413.661,9.149.521,8.6.486A15.043,15.043,0,0,1,5.961.195,3.82,3.82,0,0,0,5.27.136C4.914.121,4.279.086,3.855.055,2.986-.008,1.644-.045,1.49-.013Z" transform="translate(0.38 0.025)" fill="#fff"/>
							</svg>
							<a class="button__link bold" href="#">get our<br>email updates</a>
						</div>
					</div>
				</div>
    			<div id="getInvolved" class="get-involved__b get-involved__item"></div>
    			<div class="get-involved__c get-involved__item" style="background-image: url(https://hopeforjustice.org/wp-content/uploads/2021/02/spot-the-signs-optimised.jpg);">
    				<div class="button">
						<div class="button__inner">
							<a class="button__link bold" href="#">spot the signs of<br>modern slavery</a>
						</div>
					</div>
    			</div>
    			<div class="get-involved__d get-involved__item" style="background-image: url(https://hopeforjustice.org/wp-content/uploads/2021/02/guardian-optimised.jpg);">
    				<svg class="get-involved__guardian-logo" xmlns="http://www.w3.org/2000/svg"viewBox="0 0 119.474 45.23">
						  <g id="Group_6519" data-name="Group 6519" transform="translate(-984.884 -1527.305)">
						    <path id="_Path_" data-name="&lt;Path&gt;" d="M102.571,3.7a11.677,11.677,0,0,1,.067,4.706h-1.645c-.38-.9.034-1.923-.288-3.028-.731-.167-1.532-.372-2.342-.53C94.525,4.1,90.66,3.465,86.85,2.589a18.189,18.189,0,0,0-7.788.083c-4.03.8-8.064,1.584-12.094,2.382-.384.076-.761.205-1.259.344l-.136,2.992H63.816A14.013,14.013,0,0,1,63.824,3.7c.983-.216,2.029-.472,3.086-.675Q74.567,1.547,82.231.109A5.321,5.321,0,0,1,84.147.071C90.13,1.2,96.107,2.377,102.084,3.542a4.554,4.554,0,0,1,.487.16Z" transform="translate(961.604 1527.303)"/>
						    <path id="_Path_2" data-name="&lt;Path&gt;" d="M100.94,51.231A39.44,39.44,0,0,1,86.083,63.946c-5.562-2.315-12.612-8.459-14.915-12.674a8.116,8.116,0,0,1,2.208-.089,29.9,29.9,0,0,0,5.2,5.494c1.966,1.5,4.035,2.865,6.04,4.317a2.2,2.2,0,0,0,2.722.024A38.914,38.914,0,0,0,97.8,52.086c.217-.269.444-.529.719-.853Z" transform="translate(958.842 1508.589)"/>
						    <path id="Path_2872" data-name="Path 2872" d="M7.809,35.272a9.186,9.186,0,0,1-2.189.246,6.35,6.35,0,0,1-2.259-.391,5.219,5.219,0,0,1-1.775-1.1,5,5,0,0,1-1.166-1.7A6.009,6.009,0,0,1,.426,27.9a4.946,4.946,0,0,1,1.177-1.7,5.218,5.218,0,0,1,1.762-1.078,6.214,6.214,0,0,1,2.181-.375,6.705,6.705,0,0,1,2.254.368,4.666,4.666,0,0,1,1.691.992L7.931,27.89a2.7,2.7,0,0,0-.956-.686,3.234,3.234,0,0,0-1.34-.265,2.98,2.98,0,0,0-1.2.238,2.886,2.886,0,0,0-.951.665,3.011,3.011,0,0,0-.631,1.009,3.543,3.543,0,0,0-.224,1.278,4,4,0,0,0,.2,1.3,2.79,2.79,0,0,0,.6,1.018,2.723,2.723,0,0,0,.982.665,3.514,3.514,0,0,0,1.336.238,5.006,5.006,0,0,0,.824-.063,3.059,3.059,0,0,0,.722-.209V31.213H5.345V29.222H9.564v5.415a7.853,7.853,0,0,1-1.755.635Z" transform="translate(984.884 1518.245)"/>
						    <path id="Path_2873" data-name="Path 2873" d="M35.98,33.243a3.667,3.667,0,0,1-.888,1.3,4.1,4.1,0,0,1-1.395.845,5.59,5.59,0,0,1-3.633,0,3.947,3.947,0,0,1-1.373-.845,3.681,3.681,0,0,1-.867-1.3,4.5,4.5,0,0,1-.3-1.683V25.189h2.459v6.169a2.857,2.857,0,0,0,.108.795,2.029,2.029,0,0,0,.332.671,1.553,1.553,0,0,0,.592.469,2.363,2.363,0,0,0,1.775,0,1.615,1.615,0,0,0,.6-.469,1.868,1.868,0,0,0,.332-.672,3.055,3.055,0,0,0,.1-.794V25.189H36.3V31.56a4.4,4.4,0,0,1-.315,1.683Z" transform="translate(974.813 1518.086)"/>
						    <path id="Path_2874" data-name="Path 2874" d="M59.705,35.417l-.794-2.008H54.952L54.2,35.417H51.514L55.8,25.189h2.4l4.248,10.228Zm-2.747-7.5-1.3,3.511H58.23Z" transform="translate(966.033 1518.086)"/>
						    <path id="Path_2875" data-name="Path 2875" d="M84.989,35.417,82.77,31.359h-.843v4.058H79.514V25.189h3.9a6.784,6.784,0,0,1,1.437.152,3.741,3.741,0,0,1,1.257.513A2.683,2.683,0,0,1,87,26.8a2.98,2.98,0,0,1,.332,1.474,2.72,2.72,0,0,1-.564,1.748,3.073,3.073,0,0,1-1.56,1.011l2.673,4.375Zm-.1-7.093a1.021,1.021,0,0,0-.153-.585,1.045,1.045,0,0,0-.392-.347,1.722,1.722,0,0,0-.538-.166,4,4,0,0,0-.571-.043h-1.32v2.384H83.09a3.986,3.986,0,0,0,.624-.051,1.993,1.993,0,0,0,.581-.181,1.048,1.048,0,0,0,.6-1.011Z" transform="translate(955.789 1518.086)"/>
						    <path id="Path_2876" data-name="Path 2876" d="M113.579,30.274a5.041,5.041,0,0,1-.5,2.319,4.685,4.685,0,0,1-1.314,1.6,5.494,5.494,0,0,1-1.842.924,7.461,7.461,0,0,1-2.08.3H104.03V25.189h3.7a9.148,9.148,0,0,1,2.137.253,5.367,5.367,0,0,1,1.88.838,4.3,4.3,0,0,1,1.332,1.567A5.268,5.268,0,0,1,113.579,30.274Zm-2.571,0a3.242,3.242,0,0,0-.282-1.437,2.431,2.431,0,0,0-.751-.911,3.022,3.022,0,0,0-1.07-.484,5.268,5.268,0,0,0-1.235-.145h-1.228v5.981h1.171a5.326,5.326,0,0,0,1.279-.152,3.025,3.025,0,0,0,1.084-.5,2.473,2.473,0,0,0,.751-.924A3.25,3.25,0,0,0,111.008,30.274Z" transform="translate(946.817 1518.086)"/>
						    <path id="Path_2877" data-name="Path 2877" d="M131.073,35.417V25.189h2.485V35.417Z" transform="translate(936.921 1518.086)"/>
						    <path id="Path_2878" data-name="Path 2878" d="M153.938,35.417l-.795-2.008h-3.959l-.751,2.008h-2.687l4.291-10.228h2.4l4.248,10.228Zm-2.745-7.5-1.3,3.511h2.572Z" transform="translate(931.552 1518.086)"/>
						    <path id="Path_2879" data-name="Path 2879" d="M180.249,35.417l-4.117-6.689h-.043l.058,6.689h-2.4V25.189h2.817l4.1,6.674h.043l-.058-6.674h2.4V35.417Z" transform="translate(921.306 1518.086)"/>
						  </g>
					</svg>
    				 <div class="button button--green">
						<div class="button__inner">
							<a class="button__link bold" href="#">Become a<br>regular giver</a>
						</div>
					</div>
    			</div>
				<div class="button get-involved__more button--grey">
						<a class="button__link bold" href="#">More<br>options</a>
				</div>
			</div>
		</div>
	</div>
	<!-- 
	-- 
	-- Draggable cards
	-- 
	-->
	<h2 class="cards__title bold">Our approach <br>to ending slavery</h2>
	<p class="center cards__info">(Click and drag to see more)</p>
	<div class="cards" id="dragSpace">
	  <div class="cards__inner">
	    <div class="cards__card">
	    	<div class="cards__content">
	    		<h3 class="cards__card-title font-fk">Preventing Exploitation</h3>
	    		<p class="cards__body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
	    	</div>
		</div>
	    <div class="cards__card">
	    	<div class="cards__content">
	    		<h3 class="cards__card-title font-fk">rescuing victims</h3>
	    		<p class="cards__body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
	    	</div>
	    </div>
	    <div class="cards__card">
	    	<div class="cards__content">
	    		<h3 class="cards__card-title font-fk">restoring lives</h3>
	    		<p class="cards__body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
	    	</div>
	    </div>
	    <div class="cards__card">
	    	<div class="cards__content">
	    		<h3 class="cards__card-title font-fk">reforming society</h3>
	    		<p class="cards__body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
	    	</div>
	    </div>
	  </div>
	  <div class="cards__line"></div>
	</div>

	<div class="button--center">
		<div class="cards__button button button--yellow">
			<a class="button__link bold" href="#">learn more<br>about how we help</a>
		</div>
	</div>
	<!-- 
	-- 
	-- Freedom wall
	--
	-->
	<div class="freedom-wall">
		<div class="grid">
				<div class="freedom-wall__img" style="background-image: url(https://hopeforjustice.org/wp-content/uploads/2021/02/freedom-wall-optimised.jpg);">
					<div class="freedom-wall__content">
						<p>Every open lock on our Freedom Wall represents a real life changed.</p>
						<div class="button button--black">
							<a class="button__link bold" href="#">Read our latest<br>year in review</a>
						</div>
					</div>
				</div>
		</div>
	</div>
	<!-- 
	-- 
	-- modal (Splash screen)
	-- 
	
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
	</div>--> 



	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>