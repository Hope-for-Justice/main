<?php
/**
 * Who we are
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main who-we-are" role="main">

	<?php while ( have_posts() ) : the_post(); ?>		

	<?php $thumbnail = '';

	// Get the ID of the post_thumbnail (if it exists)
	$post_thumbnail_id = get_post_thumbnail_id($post->ID);

	// if it exists
	if ($post_thumbnail_id) {
		$thumbnail = wp_get_attachment_image_src($post_thumbnail_id, '', false, '');
	} ?>

	<?php
	//acf groups
    $top_section = get_field('top_section');
    $statement_text = get_field('statement_and_text');
    $image_text = get_field('image_and_text');
    $global_exec = get_field('global_exec');
    $country_leadership = get_field('country_leadership');
    $senior_leadership = get_field('senior_leadership');
    $trustees = get_field('trustees');
    $plain_text = get_field('plain_text');
 	?>
	
	<div class="grid">
		<!-- 
		-- 
		-- hero split
		-- 
		--> 
		<div class="hero-split">

			<div class="hero-split__img hero-split__img--top-center hero-split__img--cover hero-split__img--taller" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content hero-split__content--dark">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						 <?php echo $top_section['subtitle'];?>
					</h3>
					<h1 class="font-canela">
						<?php the_title(); ?>
					</h1>
					<div class="hero-split__desc">
						<?php the_content(); ?>
					</div>
					<div>
						<a data-toggle="modal" data-target="#video-modal" data-src="<?php echo $top_section['video'];?>" class="button button--green video-trigger">
							<div class="button__inner">
								<svg class="button__play-symbol" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.771 18.228">
									<g>
									  <path id="play" d="M9.984,7.564c-.074.021-.062-.019-.136.536-.083.624-.115,1.019-.2,2.471-.081,1.386-.128,2.007-.264,3.424a46.8,46.8,0,0,0-.211,5.848,23.71,23.71,0,0,0,.081,4.127,2.525,2.525,0,0,0,.307.9c.072.125.155.277.187.34a.779.779,0,0,0,.281.334,1.644,1.644,0,0,1,.174.134.286.286,0,0,0,.251.108,2.368,2.368,0,0,0,1.043-.428,16.726,16.726,0,0,1,3.112-1.339c1.047-.387,2.135-.826,2.99-1.209.651-.292.664-.3,1.66-.79.864-.428,1.264-.624,1.849-.9.485-.232,2.658-1.32,3.018-1.513.192-.1.451-.249.575-.323a7.489,7.489,0,0,0,1.728-1.419,1.822,1.822,0,0,0,.119-.226,1.908,1.908,0,0,1,.108-.207.824.824,0,0,0,.075-.179.964.964,0,0,1,.064-.179,1.993,1.993,0,0,0,.094-.317,1.283,1.283,0,0,0,.043-.424.641.641,0,0,0-.211-.5,7.834,7.834,0,0,0-1.266-.907c-.858-.573-1.4-.907-2.132-1.322-.492-.279-.894-.511-1.905-1.1-.457-.264-1.051-.606-1.32-.76l-.632-.358c-.479-.274-1.107-.609-2.075-1.113-.553-.287-1.228-.647-1.368-.726-.24-.138-1.205-.643-1.8-.941a6.483,6.483,0,0,0-1.594-.615A3.933,3.933,0,0,0,11.155,7.8a1.954,1.954,0,0,0,.447.694,9.963,9.963,0,0,0,1.8,1.624c.232.158,2.02,1.171,2.754,1.56.1.055.249.13.321.17s.4.209.726.377c1.6.824,3.456,1.817,4.471,2.392.809.458,1.8,1.028,2.075,1.192.372.223,1.147.713,1.16.736a1.059,1.059,0,0,1-.232.166c-.628.39-1,.6-1.928,1.083l-.472.247c-.283.147-1.849.93-2.009,1-.379.175-1.756.868-2.292,1.151-.672.358-1.718.888-2.216,1.126-.455.219-.815.389-.962.458-.373.175-1.083.507-1.281.6-.123.059-.224.106-.228.106s-.289.132-.636.294c-.626.292-1.16.56-1.551.779a2.149,2.149,0,0,1-.211.111A13.262,13.262,0,0,1,10.8,22.3c-.043-1.222-.074-1.747-.179-3.078-.064-.807-.094-1.254-.141-2.047-.034-.556-.051-1.273-.066-2.688-.017-1.605-.026-1.864-.094-3.018-.021-.347-.053-.866-.07-1.151-.021-.351-.032-.858-.034-1.566,0-.575-.006-1.066-.008-1.088C10.2,7.587,10.084,7.536,9.984,7.564Z" transform="translate(-9.163 -7.556)" fill="#fff"/>
									</g>
								</svg>
								<div class="button__text bold">
									<?php echo $top_section['button_text'];?>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- statement and text
		-- 
		--> 
		<div class="statement-and-text">
			<div class="statement-and-text__statement">
				<?php echo $statement_text['statement'];?>
				<div class="statement-and-text__line statement-and-text__line--bottom"></div>
			</div>
			<div class="statement-and-text__text">
				<p><?php echo $statement_text['text'];?></p>
			</div>
		</div>

		<div class="line line--full"></div>

		<!-- 
		-- 
		-- image and text
		-- 
		--> 
		<div class="image-and-text">
			<div class="image-and-text__image">
				<img src="<?php echo $image_text['image'];?>">
			</div>
			<div class="image-and-text__text">
				<p><?php echo $image_text['text'];?></p>
			</div>
		</div>

		<div class="line line--full"></div>

		<!-- 
		-- 
		-- people global exec
		-- 
		--> 
		<div class="people">
			<h2 class="people__title font-canela">
				<?php echo $global_exec['title']?>	
			</h2>
			<p class="people__subtitle">
				<?php echo $global_exec['subtitle']?>
			</p>
			<div class="people__grid">
				<?php 	

				while (have_rows('global_exec_members')) : the_row(); ?>

					<div class="people__person">
						<img src="<?php echo get_sub_field('image'); ?>">
						<?php if( get_sub_field('linked_in_link') ) { ?>
							<a href="<?php echo get_sub_field('linked_in_link'); ?>" class="people__linked-in">
								<img class="people__linked-in-img" src="<?php echo get_template_directory_uri().'/assets/img/li-blue.svg'; ?>">
							</a>
						<?php } ?>
						<p><?php echo get_sub_field('text'); ?></p>
					</div>

				<?php endwhile; ?>

			</div>
		</div>

		<div class="line line--full"></div>

		<!-- 
		-- 
		-- people country leadership
		-- 
		--> 
		<div class="people">
			<h2 class="people__title people__title--double-margin font-canela">
				<?php echo $country_leadership['title']?>	
			</h2>
			<div class="people__grid">
				<?php 	

				while (have_rows('country_leadership_members')) : the_row(); ?>

					<div class="people__person">
						<img src="<?php echo get_sub_field('image'); ?>">
						<p><?php echo get_sub_field('text'); ?></p>
					</div>

				<?php endwhile; ?>

			</div>
		</div>

		<div class="line line--full"></div>


		<!-- 
		-- 
		-- people senior leadership
		-- 
		--> 
		<div class="people">
			<h2 class="people__title people__title--double-margin font-canela">
				<?php echo $senior_leadership['title']?>	
			</h2>
			<div class="people__grid">
				<?php 	

				while (have_rows('senior_leadership_members')) : the_row(); ?>

					<div class="people__person">
						<img src="<?php echo get_sub_field('image'); ?>">
						<p><?php echo get_sub_field('text'); ?></p>
					</div>

				<?php endwhile; ?>

			</div>
		</div>

		<div class="line line--full"></div>

		<!-- 
		-- 
		-- people trustees
		-- 
		--> 
		<div class="people">
			<h2 class="people__title people__title--double-margin font-canela">
				<?php echo $trustees['title']?>	
			</h2>
			<div class="people__grid">
				<?php 	

				while (have_rows('trustee_members')) : the_row(); ?>

					<div class="people__person">
						<img src="<?php echo get_sub_field('image'); ?>">
						<p><?php echo get_sub_field('text'); ?></p>
					</div>

				<?php endwhile; ?>

			</div>
		</div>

		<div class="line line--full"></div>

		<!-- 
		-- 
		-- plain-text
		--  
		-->
		<div class="plain-text">
			<h2 class="font-canela"> <?php echo $plain_text['title']?> </h2>
			<p>
				<?php echo $plain_text['text']?>
			</p>
		</div>


	</div> <!-- /grid -->

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