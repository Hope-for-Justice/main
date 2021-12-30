<?php
/**
 * Get involved template
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main get-involved-page" role="main">

	<?php while ( have_posts() ) : the_post(); ?>		

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} 
	//acf groups
    $email_updates = get_field('email_updates');
    $grid = get_field('grid');
 	?>
	
	<div class="grid">
		<!-- 
		-- 
		-- hero full
		-- 
		--> 
		<div class="hero-full">

			<div class="hero-full__img" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="sub-grid hero-full__sub-grid">
				<div class="hero-full__content">
					<h3 class="hero-full__subtitle">
						<?php echo the_field('subtitle'); ?>
					</h3>
					<h1 class="font-fk hero-full__title">
						<?php the_title(); ?>
					</h1>
					<div class="hero-full__line"></div>
				</div>
			</div>
		</div><!-- /hero -->


		<!-- 
		-- 
		-- text block
		-- 
		--> 
		<div class="get-involved-page__text-block">
			<h2 class="font-canela">Take action today!</h2>
			<p><?php the_content(); ?></p>
		</div>


		<!-- 
		-- 
		-- get-involved
		--  
		-->

		<div class="sub-grid">
			<div class="get-involved">

				<div class="get-involved__grid">
					<div class="get-involved__item get-involved__item--a" style="background-image: url('<?php echo $grid['image_a'];?>');">
						<a href="<?php echo $grid['link_a'];?>" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold"><?php echo $grid['button_text_a'];?></div>
							</div>
						</a>
					</div>

	    			<div class="get-involved__item get-involved__item--b" style="background-image: url('<?php echo $grid['image_b'];?>');">
	    				<a href="<?php echo $grid['link_b'];?>" class="button button--white">
							<div class="button__inner">
								<div class="button__text bold"><?php echo $grid['button_text_b'];?></div>
							</div>
						</a>
	    			</div>

	    			<a href="<?php echo $grid['link_c'];?>" class="get-involved__item get-involved__item--c" style="background-image: url('<?php echo $grid['image_c'];?>');">
	    			</a>

	    			<div class="get-involved__item get-involved__item--d" style="background-image: url('<?php echo $grid['image_d'];?>');">
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
	    				<a href="<?php echo $grid['link_d'];?>" class="button button--green">
							<div class="button__inner">
								<div class="button__text bold"><?php echo $grid['button_text_d'];?></div>
							</div>
						</a>
	    			</div>

				</div>
			</div>
		</div> 


	</div> <!-- /grid -->



	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>