<?php
/**
 * Template Name: Thank you
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main thankyou" role="main">

	<div class="grid">
		<h3 class="thankyou__subtitle">
			<?php the_field('subtitle'); ?>
		</h3>
		<h1 class="thankyou__title font-canela">
			<?php 

				$msg = 'Thank you';

				if (isset($_GET['Name'])) {
		    		$name = $_GET['Name'];
		    		$msg .= ' ' . $name . '!';
				} else { 
					$msg .= '!';
				}

				echo $msg;
			?>
		</h1>
		<div class="thankyou__text"><?php the_content(); ?></div>

		<ul class="thankyou__socials">
			<li class="">
				<a href="<?php echo the_field('linked_in_link', 'option'); ?>">
					<img src="<?php echo get_template_directory_uri().'/assets/img/li-red.svg'; ?>" alt="">
				</a>
			</li>
			<li class="">
				<a href="<?php echo the_field('instagram_link', 'option'); ?>">
					<img src="<?php echo get_template_directory_uri().'/assets/img/in-red.svg'; ?>" alt="">
				</a>
			</li>
			<li class="">
				<a href="<?php echo the_field('twitter_link', 'option'); ?>">
					<img src="<?php echo get_template_directory_uri().'/assets/img/tw-red.svg'; ?>" alt="">
				</a>
			</li>
			<li class="">
				<a href="<?php echo the_field('facebook_link', 'option'); ?>">
					<img src="<?php echo get_template_directory_uri().'/assets/img/fb-red.svg'; ?>" alt="">
				</a>
			</li>
		</ul>
	</div> <!-- /grid -->

</main>

<?php get_footer(); ?>