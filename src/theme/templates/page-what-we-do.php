<?php
/**
 * The template for /how-we-change-lives
 * Template Name: What we do
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main how-we-change-lives">

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
	<div class="hero-split">

		<div class="hero-split__img hero-split__img--bottom-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
		</div>

		<div class="hero-split__content hero-split__content--dark">
			<div class="hero-split__content-inner">
				<h3>
					<?php the_field('subtitle'); ?>
				</h3>
				<h1 class="font-canela">
					<?php the_title(); ?>
				</h1>
				<div class="hero-split__desc">
					<?php the_content(); ?>
					<br><br>
					<div>
						<a data-toggle="modal" data-target="#video-modal" data-src="<?php the_field('video_source'); ?>" class="button button--green video-trigger">
							<div class="button__inner">
								<svg class="button__play-symbol" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.771 18.228">
									<g>
									  <path id="play" d="M9.984,7.564c-.074.021-.062-.019-.136.536-.083.624-.115,1.019-.2,2.471-.081,1.386-.128,2.007-.264,3.424a46.8,46.8,0,0,0-.211,5.848,23.71,23.71,0,0,0,.081,4.127,2.525,2.525,0,0,0,.307.9c.072.125.155.277.187.34a.779.779,0,0,0,.281.334,1.644,1.644,0,0,1,.174.134.286.286,0,0,0,.251.108,2.368,2.368,0,0,0,1.043-.428,16.726,16.726,0,0,1,3.112-1.339c1.047-.387,2.135-.826,2.99-1.209.651-.292.664-.3,1.66-.79.864-.428,1.264-.624,1.849-.9.485-.232,2.658-1.32,3.018-1.513.192-.1.451-.249.575-.323a7.489,7.489,0,0,0,1.728-1.419,1.822,1.822,0,0,0,.119-.226,1.908,1.908,0,0,1,.108-.207.824.824,0,0,0,.075-.179.964.964,0,0,1,.064-.179,1.993,1.993,0,0,0,.094-.317,1.283,1.283,0,0,0,.043-.424.641.641,0,0,0-.211-.5,7.834,7.834,0,0,0-1.266-.907c-.858-.573-1.4-.907-2.132-1.322-.492-.279-.894-.511-1.905-1.1-.457-.264-1.051-.606-1.32-.76l-.632-.358c-.479-.274-1.107-.609-2.075-1.113-.553-.287-1.228-.647-1.368-.726-.24-.138-1.205-.643-1.8-.941a6.483,6.483,0,0,0-1.594-.615A3.933,3.933,0,0,0,11.155,7.8a1.954,1.954,0,0,0,.447.694,9.963,9.963,0,0,0,1.8,1.624c.232.158,2.02,1.171,2.754,1.56.1.055.249.13.321.17s.4.209.726.377c1.6.824,3.456,1.817,4.471,2.392.809.458,1.8,1.028,2.075,1.192.372.223,1.147.713,1.16.736a1.059,1.059,0,0,1-.232.166c-.628.39-1,.6-1.928,1.083l-.472.247c-.283.147-1.849.93-2.009,1-.379.175-1.756.868-2.292,1.151-.672.358-1.718.888-2.216,1.126-.455.219-.815.389-.962.458-.373.175-1.083.507-1.281.6-.123.059-.224.106-.228.106s-.289.132-.636.294c-.626.292-1.16.56-1.551.779a2.149,2.149,0,0,1-.211.111A13.262,13.262,0,0,1,10.8,22.3c-.043-1.222-.074-1.747-.179-3.078-.064-.807-.094-1.254-.141-2.047-.034-.556-.051-1.273-.066-2.688-.017-1.605-.026-1.864-.094-3.018-.021-.347-.053-.866-.07-1.151-.021-.351-.032-.858-.034-1.566,0-.575-.006-1.066-.008-1.088C10.2,7.587,10.084,7.536,9.984,7.564Z" transform="translate(-9.163 -7.556)" fill="#fff"/>
									</g>
								</svg>
								<div class="button__text bold">
									<?php the_field('button_text'); ?>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /hero-split -->

	<!-- 
	-- 
	-- statement
	-- 
	-->
	<div class="statement">
		<h2><?php the_field('statement'); ?></h2>
	</div>

	<!-- 
	-- 
	-- hero split
	-- 
	--> 
	<div class="hero-split">

		<div class="hero-split__img hero-split__img--top-center" style="background-image: url('<?php echo the_field('second_split_image'); ?>');">
		</div>

		<div class="hero-split__content hero-split__content--grey">
			<div class="hero-split__content-inner">
				<h3>
					
					<?php echo the_field('second_split_subtitle'); ?>
				</h3>
				<h2 class="font-canela b-title--half-margin-bottom">
					
					<?php echo the_field('second_split_title'); ?>
				</h2>
				<div class="hero-split__desc">
					<p><?php echo the_field('second_split_text'); ?></p>
				</div>
			</div>
		</div>
	</div><!-- /hero-split -->

	<!-- 
	-- 
	-- drag-cards
	--  
	-->
	<div class="drag-cards drag-cards--no-margin-top drag-cards--no-margin-bottom drag-cards--no-padding-bottom" id="dragCards">
		<h2 class="drag-cards__heading font-canela">
			<?php the_field('drag_cards_title'); ?>
		</h2>
		<div class="drag-cards__inner">
			<div class="drag-cards__card">
				<p class="drag-cards__card-number font-canela">01</p>
				<h3 class="drag-cards__card-title font-fk">
					<?php the_field('card_1_title'); ?>
				</h3>
				<p class="drag-cards__card-desc">
					<?php the_field('card_1_text'); ?>
				</p>
			</div>
			<div class="drag-cards__card">
				<p class="drag-cards__card-number font-canela">02</p>
				<h3 class="drag-cards__card-title font-fk">
					<?php the_field('card_2_title'); ?>
				</h3>
				<p class="drag-cards__card-desc">
					<?php the_field('card_2_text'); ?>
				</p>
			</div>
			<div class="drag-cards__card">
				<p class="drag-cards__card-number font-canela">03</p>
				<h3 class="drag-cards__card-title font-fk">
					<?php the_field('card_3_title'); ?>
				</h3>
				<p class="drag-cards__card-desc">
					<?php the_field('card_3_text'); ?>
				</p>
			</div>
			<div class="drag-cards__card">
				<p class="drag-cards__card-number font-canela">04</p>
				<h3 class="drag-cards__card-title font-fk">
					<?php the_field('card_4_title'); ?>
				</h3>
				<p class="drag-cards__card-desc">
					<?php the_field('card_4_text'); ?>
				</p>
			</div>
		</div>
		<div class="drag-cards__dots dots">
			<img src="<?php echo get_template_directory_uri().'/assets/img/drag-above.svg'; ?>">
		</div>
	</div>

	<!-- 
	-- 
	-- drop-cards / country cards
	-- 
	-->
	<h2 class="drop-cards__title font-canela"><?php the_field('country_section_title'); ?></h2>
	<div class="drop-cards">

		<?php

		$i = 1;

		while (have_rows('countries')) : the_row(); ?>
		
			<div class="drop-card <?php if($i == 1) {echo 'drop-card--open';} ?>">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk">
						<?php echo (get_sub_field('country_title'));?>
					</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus <?php if($i == 1) {echo 'cross-circle__plus--open';} ?>">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc">
						<?php echo (get_sub_field('country_text'));?>
					</p>
				</div>
			</div>

		<?php $i++; 
		endwhile; ?> <!-- end card loop -->

	</div>

	<!-- 
	-- 
	-- Map
	--  
	-->
	<h2 class="map__title font-canela"><?php the_field('country_section_title'); ?></h2>
	<div class="map">
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1533.032" height="898.644" viewBox="0 0 1533.032 898.644">
		  <defs>
			    <filter id="Path_16929" x="361.94" y="366.167" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_17224" x="329.705" y="371.793" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-2"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-2"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_17225" x="342.829" y="408.645" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-3"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-3"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_16931" x="675.2" y="260.336" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-4"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-4"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_16930" x="696.889" y="275.024" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-5"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-5"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_16932" x="745.893" y="218.485" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-6"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-6"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_16933" x="833.95" y="551.708" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-7"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-7"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_16934" x="860.198" y="528.074" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-8"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-8"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_16936" x="1354.195" y="737.242" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-9"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-9"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_17226" x="1186.195" y="486.242" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-10"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-10"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_17128" x="235.234" y="342.072" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-11"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-11"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
			    <filter id="Path_17129" x="297.47" y="334.942" width="35.248" height="45.851" filterUnits="userSpaceOnUse">
			      <feOffset dx="-3" dy="-1" input="SourceAlpha"/>
			      <feGaussianBlur stdDeviation="1.5" result="blur-12"/>
			      <feFlood flood-opacity="0.161"/>
			      <feComposite operator="in" in2="blur-12"/>
			      <feComposite in="SourceGraphic"/>
			    </filter>
		  </defs>
		  <g id="Group_6927" data-name="Group 6927" transform="translate(-151.563 -4517.437)">
		    <g id="Group_6463" data-name="Group 6463" transform="translate(151.563 4517.437)" opacity="0.14">
		      <path id="Path_2470" data-name="Path 2470" d="M24.6,182.757,57.528,152.33V119.819L87.122,91.476,68.782,74.386V55.63H91.29L126.719,17.7H175.9l43.765,45.432H265.1l57.1,57.1,37.93.834L385.975,94.81v22.925l27.51-.834v29.177l-42.1,1.667.834,11.671L330.956,200.68l24.592,25.425h16.672l23.758,25.842-.417-44.6L421.4,184.841V161.083l17.089,18.34V230.69l19.59-20.007,25.009,25.425V267.37H439.327l-12.5,13.338h27.093l-.417,23.758H430.574l-65.023,63.355v28.76l-6.252,5-13.755-15.005H298.862L278.438,407l.834,27.926h40.848l.834,26.259,37.1,37.1,14.588-14.588h65.439L511.019,558.3H553.95v33.345l-23.341,22.925V663.34H505.183l-53.769,54.6.417,35.846-28.343,29.177L443.5,803.8v40.014l-57.937-57.937V721.277l18.34-15.839V619.575l-61.271-60.021,19.59-17.506V518.29l-23.341-.833-85.863-86.7h-37.93V407.835L156.312,349.9v-62.1l33.345-27.926-.417-71.691-41.264-42.1H105.461L82.12,168.169l-20.841-.834L36.688,193.594Z" transform="translate(11.663 54.825)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_402" data-name="Rectangle 402" width="29.177" height="7.503" transform="translate(0 246.335)" fill="#acacac"/>
		      <rect id="Rectangle_403" data-name="Rectangle 403" width="14.172" height="14.588" transform="translate(275.512 538.936)" fill="#acacac"/>
		      <rect id="Rectangle_404" data-name="Rectangle 404" width="12.504" height="14.588" transform="translate(480.167 854.045)" fill="#acacac"/>
		      <path id="Path_2471" data-name="Path 2471" d="M147.3,135.757,124.792,114.5H100.2v5.835h15.005l17.506,15.422Z" transform="translate(251.172 361.498)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_405" data-name="Rectangle 405" width="20.007" height="14.172" transform="translate(395.137 215.074)" fill="#acacac"/>
		      <path id="Path_2472" data-name="Path 2472" d="M164.217,135.72,142.96,113.629l10.42-9.17V73.616H137.958L114.2,49.024,134.207,28.6l10.42,9.17,15.422-1.25,24.175,23.758V97.791L203.4,114.463l-11.254,11.254-14.588-14.172V135.72Z" transform="translate(295.525 89.357)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2473" data-name="Path 2473" d="M122.557,66.315l16.672-15.839h13.338V30.469H135.894l-7.5-6.669L115.054,36.3H103.8V52.56Z" transform="translate(262.577 74.151)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2474" data-name="Path 2474" d="M139.6,59.662,112.507,85.087,92.5,66.331V37.154L101.67,25.9h22.925V42.989Z" transform="translate(226.777 80.804)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2475" data-name="Path 2475" d="M117.211,34.888h15.422V20.3H106.374L84.7,40.724,95.954,51.978Z" transform="translate(202.066 63.062)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2476" data-name="Path 2476" d="M108.437,20.352,97.6,29.105l13.755,16.256h30.01v-12.5l-9.587-7.086L134.7,14.1l-11.254,9.587v5.835H117.19V21.186Z" transform="translate(242.935 43.42)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2477" data-name="Path 2477" d="M102.686,35.225,95.6,28.556,116.441,9.8l10.42,10.837-9.17,9.587-5.419-5.419Z" transform="translate(236.599 29.797)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2478" data-name="Path 2478" d="M154.547,54.8l-8.336,9.587L134.957,54.8H123.7l-1.667-20.841L116.2,26.036V17.7h17.089V38.124Z" transform="translate(301.862 54.825)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2479" data-name="Path 2479" d="M130.957,28.4l-7.086,5.835v10h-10V36.324l-4.168-5V20.9l10.42-5Z" transform="translate(281.269 49.122)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2480" data-name="Path 2480" d="M127.357,17.72,116.52,30.641,106.1,20.221V13.552L114.436,7.3Z" transform="translate(269.864 21.877)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2481" data-name="Path 2481" d="M121.787,27.525,112.2,39.2l5,6.669h20.424l5-6.669V22.94L125.955,4.6,112.2,17.938Z" transform="translate(289.189 13.323)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2482" data-name="Path 2482" d="M126.619,37.278H121.2V50.616l5.419,3.334h12.088l7.919-10V24.774l6.252-4.168-7.086-6.669V3.1h-7.086L125.785,16.438Z" transform="translate(317.702 8.571)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2483" data-name="Path 2483" d="M141.69,102.835,178.37,65.322V50.734h17.506l16.672-17.089h15.839l15.005-15.422L225.469.3H185.455L178.37,7.8l-20.841.417V26.142L170.867,37.4H150.026V70.741H133.771L122.1,83.662Z" transform="translate(320.554 -0.3)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2484" data-name="Path 2484" d="M169.678,92.113V151.3l-14.588,15.422v51.685L183.016,245.5l21.257-20.841V200.484h31.261l37.513-38.347V141.714l23.341-22.925V64.6L320.563,42.93,311.81,32.51H291.8L264.711,5H242.62L225.947,21.256H194.686L168.427,47.932H138V70.022l20.424,22.091Z" transform="translate(370.927 14.59)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2485" data-name="Path 2485" d="M206.1,62.537,189.007,79.21H172.335V62.537L169,59.619l7.086-6.252,9.587,10.42L197.76,51.7Z" transform="translate(469.138 162.541)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2486" data-name="Path 2486" d="M201.491,82.053,189.4,94.974l-10-8.753L193.155,73.3Z" transform="translate(502.086 230.972)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2487" data-name="Path 2487" d="M213.094,118.6l14.172-12.921L208.092,86.507V74.836L198.505,66.5,183.5,79.838l18.756,19.173-10.837,12.921L196,116.517l-10,10,5.419,6.252,14.172-13.338Z" transform="translate(515.076 209.429)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2488" data-name="Path 2488" d="M244.242,303.068h19.173l25.426-28.343h46.683l30.427-31.261-16.673-17.923V194.28H336.357l-25.842,25.842,12.5,10.837L305.1,251.8l-15.005-13.755H273l1.667-29.177,66.273-65.022h45.849l25.842,27.51-16.256,16.256,11.254,11.254,37.513-37.93,47.1-.834V105.082h30.427l35.846-34.6V37.976L585.194,11.3h36.263l13.338,37.513h58.354l17.089,17.923,17.506-.417,27.51-25.009,37.93.834,11.671,12.5,6.252-7.5,24.175.417,25.842-24.592,82.112-.417L974.079,53.4V69.653L951.154,92.161l12.921,12.921-20.424,18.34v24.592l-23.758.834v20.424l13.755,12.921-.834,58.354H921.143l-13.338-12.5-.834-17.923-8.753-9.17.417-31.261L905.3,162.6l.417-19.173-9.587-10.837v13.755H881.963l-8.753,10.837V170.1l-14.171.417v6.252l-28.76.417.834,43.348,28.343,27.093-.833,52.518-31.678,29.594.417,27.51h-19.59L789.431,338.5l-9.587,10.42,27.51,28.76-.417,40.847L781.929,443.95h-34.6l.417,27.926L761.5,484.8l-.417,10-8.336,9.587H736.5L722.741,492.3l.417,21.674,21.257,20.841-8.753,10-12.921-10-.834-10.837-10.42-8.336-.417-27.093-11.254-12.087-9.17,7.5L661.47,454.787,632.71,484.38l1.25,25.009-14.588,15.005-32.511-31.678,1.25-29.594L560.6,435.613l-42.1.417,15.839,17.506-37.1,36.263-36.262,1.25-55.436-54.6V454.37l53.769,51.268,27.51.834v25.842l-42.932,43.765-.417,39.6L418.469,638.6v42.932l-49.6,47.933H326.354l-1.25-57.1-25.842-25.426.417-77.943-37.513-36.679-47.517-.834L171.3,487.3V435.2l50.017-49.184,82.112-.417,19.59,20.007,77.11-.834L420.136,385.6H373.87V365.172l11.671-9.587h32.094l21.674-20.007-67.94.834-.834,22.091L354.7,373.509l-46.683-45.849.834,11.254L329.688,361l-15.839,15.422-.417-21.257-21.257-21.257H270.5l-19.59,20.424-34.6,1.25-1.25-23.341Z" transform="translate(476.425 34.549)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_406" data-name="Rectangle 406" width="12.921" height="17.506" transform="translate(757.763 387.634)" fill="#acacac"/>
		      <rect id="Rectangle_407" data-name="Rectangle 407" width="11.254" height="20.841" transform="translate(1385.064 285.515)" fill="#acacac"/>
		      <path id="Path_2489" data-name="Path 2489" d="M391.487,83.285,383.151,91.2l4.168,4.168-8.753,9.17-5-5v12.088l4.168,2.5-.417,28.76,5.418,5.835-6.669,5.835H365.228v4.168H346.055l-3.751,3.751v20.007l-10-8.753V159.561l13.755-11.671h12.921l-.417-8.336,7.919-6.669.834-21.257-9.587-10,8.753-8.336-7.5-10,6.252-4.585,10.42,10,6.669-6.669Z" transform="translate(986.491 248.08)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_408" data-name="Rectangle 408" width="8.336" height="7.503" transform="translate(1310.455 433.9)" fill="#acacac"/>
		      <rect id="Rectangle_409" data-name="Rectangle 409" width="8.336" height="17.506" transform="translate(1289.614 441.403)" fill="#acacac"/>
		      <path id="Path_2490" data-name="Path 2490" d="M311.855,136.2l23.758,25.009v5.419h10v18.34h-7.5l-22.091-19.59V153.289L298.1,136.2Z" transform="translate(878.141 430.246)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2491" data-name="Path 2491" d="M313.8,161.926v9.17L329.639,186.1h14.588v-8.753l11.671-12.5-7.5-8.753,11.254-9.17L347.145,134,324.22,159.842Z" transform="translate(927.881 423.276)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2492" data-name="Path 2492" d="M347.013,157.853l-9.17-8.753H313.251l-3.751,4.168,7.919,4.585h21.674l5,7.086h11.254v-7.919Z" transform="translate(914.258 471.115)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2493" data-name="Path 2493" d="M324.8,173.878v-18.34L342.306,139.7l6.669,6.669-12.088,10.42,7.919,5.835v11.254Z" transform="translate(962.73 441.334)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_410" data-name="Rectangle 410" width="24.592" height="7.919" transform="translate(1282.112 628.134)" fill="#acacac"/>
		      <rect id="Rectangle_411" data-name="Rectangle 411" width="23.758" height="6.669" transform="translate(1318.374 602.708)" fill="#acacac"/>
		      <rect id="Rectangle_412" data-name="Rectangle 412" width="6.669" height="8.753" transform="translate(1314.623 636.053)" fill="#acacac"/>
		      <path id="Path_2494" data-name="Path 2494" d="M369.411,167.509l-7.086,5.835,10.837,10.837h16.256l10.837-10.837,14.172,17.089h12.5l-42.1-42.515H362.325l-6.669-5.419H339.4v5.419h13.755Z" transform="translate(1008.985 450.205)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_413" data-name="Rectangle 413" width="9.587" height="17.506" transform="translate(1432.58 602.708)" fill="#acacac"/>
		      <rect id="Rectangle_414" data-name="Rectangle 414" width="26.676" height="7.919" transform="translate(1457.172 623.966)" fill="#acacac"/>
		      <path id="Path_2495" data-name="Path 2495" d="M349.374,148.856v-12.5L346.04,130.1l-6.252,6.252-12.087-.417v7.5h10.837l1.25,5.419Z" transform="translate(971.918 410.92)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_415" data-name="Rectangle 415" width="9.17" height="8.336" transform="translate(1311.705 528.516)" fill="#acacac"/>
		      <path id="Path_2496" data-name="Path 2496" d="M343.973,145.109h-12.5l-6.669-7.5V120.1h12.088v10.42l-5.419,4.168Z" transform="translate(962.73 379.239)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_416" data-name="Rectangle 416" width="6.669" height="6.252" transform="translate(1299.618 531.017)" fill="#acacac"/>
		      <rect id="Rectangle_417" data-name="Rectangle 417" width="7.086" height="21.674" transform="translate(1284.196 528.516)" fill="#acacac"/>
		      <path id="Path_2497" data-name="Path 2497" d="M377.886,164.9l-7.086,6.252,17.089,17.923,7.086-6.252Z" transform="translate(1108.463 521.171)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2498" data-name="Path 2498" d="M385.319,189.4v23.758l-7.919,7.086,7.919,7.919v9.17l11.671-10V219.41h6.669v-7.919l-9.17-.834-.417-14.588Z" transform="translate(1129.373 598.789)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2499" data-name="Path 2499" d="M408.432,199.7l6.669,7.086v6.252l-11.254,10.837H395.51v9.17l-22.091,19.59-7.919-7.086v-12.5l12.921-11.254,9.17.417Z" transform="translate(1091.672 631.421)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2500" data-name="Path 2500" d="M366.057,197v11.254l-14.172,13.338L344.8,215.34V197Z" transform="translate(1026.092 622.867)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2501" data-name="Path 2501" d="M461.734,179.308V156.8l15.005,11.254v30.01L505.5,224.74V256l-24.175,22.091V292.68L467.57,305.6H434.642l-16.672-15.422v-10.42L396.3,256H380.039l-10.837,12.5H345.027l-14.588,15.839-14.172-15.839,7.5-8.753L314.6,251V212.236l19.59-17.923,19.59.417,34.179-33.762,9.17,8.753L412.134,156.8h28.343l-7.086,6.252,12.088,16.256Z" transform="translate(930.415 495.509)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2502" data-name="Path 2502" d="M288.719,134.6l-7.919,6.669,5.835,5.835,9.587-9.17Z" transform="translate(823.333 425.177)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2503" data-name="Path 2503" d="M285.95,155.8v15.422l-13.338,11.254v19.173l-21.674,21.674L237.6,209.569l12.088-11.254V177.891L270.111,155.8Z" transform="translate(686.471 492.341)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2504" data-name="Path 2504" d="M260.442,96.692,247.1,85.022V60.013L271.7,36.255V22.5L234.6,59.6V90.857l18.757,15.422Z" transform="translate(676.966 70.032)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_418" data-name="Rectangle 418" width="15.422" height="13.755" transform="translate(859.048 51.268)" fill="#acacac"/>
		      <rect id="Rectangle_419" data-name="Rectangle 419" width="11.671" height="11.671" transform="translate(894.894 58.354)" fill="#acacac"/>
		      <rect id="Rectangle_420" data-name="Rectangle 420" width="8.336" height="10.003" transform="translate(886.558 41.264)" fill="#acacac"/>
		      <path id="Path_2505" data-name="Path 2505" d="M225.657,24.186l-10,9.587L204.4,24.186V17.1h15.005Z" transform="translate(581.289 52.924)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2506" data-name="Path 2506" d="M226.743,31.188V55.363l-6.669,6.669L198.4,39.941v-12.5l7.919-8.336h7.919Z" transform="translate(562.281 59.26)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2507" data-name="Path 2507" d="M257.9,20.972l9.587,10h23.341V14.3H276.656l-7.086-7.5Z" transform="translate(750.783 20.293)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2508" data-name="Path 2508" d="M270.889,15.037l-8.336,9.17H253.8V10.035L262.553,4.2Z" transform="translate(737.794 12.056)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2509" data-name="Path 2509" d="M328.094,25.672H309.337L298.5,18.587V9h15.005Z" transform="translate(879.409 27.263)" fill="#acacac" fill-rule="evenodd"/>
		      <path id="Path_2510" data-name="Path 2510" d="M305.6,9v9.587h14.172L321.856,9Z" transform="translate(901.902 27.263)" fill="#acacac" fill-rule="evenodd"/>
		      <rect id="Rectangle_421" data-name="Rectangle 421" width="12.504" height="10.003" transform="translate(1203.334 64.189)" fill="#acacac"/>
		    </g>
		    <!-- usa -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('usa_text'); ?>" data-title="<?php the_field('usa_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16929)">
		      <path id="Path_16929-2" data-name="Path 16929" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(369.44 371.67)" fill="#d6001c"/>
		    </g>
		    <!-- usa -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('usa_text'); ?>" data-title="<?php the_field('usa_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_17224)">
		      <path id="Path_17224-2" data-name="Path 17224" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(337.21 377.29)" fill="#d6001c"/>
		    </g>
		    <!-- usa -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('usa_text'); ?>" data-title="<?php the_field('usa_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_17225)">
		      <path id="Path_17225-2" data-name="Path 17225" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(350.33 414.14)" fill="#d6001c"/>
		    </g>
		    <!-- uk -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('uk_text'); ?>" data-title="<?php the_field('uk_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16931)">
		      <path id="Path_16931-2" data-name="Path 16931" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(682.7 265.84)" fill="#d6001c"/>
		    </g>
		    <!-- uk-->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('uk_text'); ?>" data-title="<?php the_field('uk_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16930)">
		      <path id="Path_16930-2" data-name="Path 16930" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(704.39 280.52)" fill="#d6001c"/>
		    </g>
		    <!-- norway -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('norway_text'); ?>" data-title="<?php the_field('norway_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16932)">
		      <path id="Path_16932-2" data-name="Path 16932" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(753.39 223.98)" fill="#d6001c"/>
		    </g>
		    <!-- uganda -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('uganda_text'); ?>" data-title="<?php the_field('uganda_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16933)">
		      <path id="Path_16933-2" data-name="Path 16933" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(841.45 557.21)" fill="#d6001c"/>
		    </g>
		    <!-- ethiopia -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('ethiopia_text'); ?>" data-title="<?php the_field('ethiopia_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16934)">
		      <path id="Path_16934-2" data-name="Path 16934" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(867.7 533.57)" fill="#d6001c"/>
		    </g>
		    <!-- australia -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('australia_text'); ?>" data-title="<?php the_field('australia_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_16936)">
		      <path id="Path_16936-2" data-name="Path 16936" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(1361.69 742.74)" fill="#d6001c"/>
		    </g>
		    <!-- cambodia -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('cambodia_text'); ?>" data-title="<?php the_field('cambodia_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_17226)">
		      <path id="Path_17226-2" data-name="Path 17226" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(1193.69 491.74)" fill="#d6001c"/>
		    </g>
		    <!-- usa -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('usa_text'); ?>" data-title="<?php the_field('usa_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_17128)">
		      <path id="Path_17128-2" data-name="Path 17128" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(242.73 347.57)" fill="#d6001c"/>
		    </g>
		    <!-- usa -->
		    <g class="map__pin reference" data-toggle="modal" data-target="#country-modal" data-text="<?php the_field('usa_text'); ?>" data-title="<?php the_field('usa_title'); ?>" transform="matrix(1, 0, 0, 1, 151.56, 4517.44)" filter="url(#Path_17129)">
		      <path id="Path_17129-2" data-name="Path 17129" d="M13.124,0c7.248,0,13.124,5.62,13.124,12.553S13.516,37.445,13.124,36.836C13.008,36.9,0,19.486,0,12.553S5.876,0,13.124,0Z" transform="translate(304.97 340.44)" fill="#d6001c"/>
		    </g>
		  </g>
		</svg>
	</div>

	<!-- 
	-- 
	-- Picture quote
	--  
	-->
	<div class="picture-quote">
		<div class="picture-quote__picture" style="background-image: url('<?php echo the_field('picture_quote_image'); ?>');">
		</div>
		<h2 class="picture-quote__quote font-canela">
			<?php echo the_field('picture_quote_text'); ?>
		</h2>
		<h3 class="picture-quote__reference"><?php echo the_field('picture_quote_reference'); ?></h3>
	</div>

	<!-- 
	-- 
	-- hero split
	-- 
	--> 
	<div class="hero-split how-we-change-lives__hero-bottom">

		<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo the_field('bottom_section_image'); ?>');">
		</div>

		<div class="hero-split__content hero-split__content--grey">
			<div class="hero-split__content-inner">
				<h3>
					<?php echo the_field('bottom_section_subtitle'); ?>
				</h3>
				<h2 class="font-canela b-title--half-margin-bottom">				
					<?php echo the_field('bottom_section_title'); ?>
				</h2>
				<div>
					<a href="<?php echo the_field('bottom_button_link'); ?>" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								<?php echo the_field('bottom_button_text'); ?>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div><!-- /hero-split -->


	</div><!-- .grid -->

	<?php endwhile; // end of the loop. ?>


	<!-- 
	-- 
	-- reference modal
	-- 
	--> 
	<?php get_template_part(
	    'partials/content',
	    'modal',
	    array(
	        'type' => 'country',
	        'id' => 'country-modal'
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


</main><!-- #main -->

<?php
get_footer();