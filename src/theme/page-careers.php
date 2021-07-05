<?php
/**
 * The template for /careers
 *
 *
 * @package Hope_for_Justice_2021
 */

get_header();
?>

<main id="main" class="site-main">

	<div class="container">
		<div class="row">
			<?php
				$get_records =  wp_remote_get( 'https://cezanneondemand.intervieweb.it/annunci.php?lang=en&LAC=hopeforjustice&d=hopeforjustice.org&k=1408e0edd8768dfa3e838b0059df4899&CodP=&nbsp;&format=json_en&utype=0');
				foreach(json_decode($get_records['body']) as $body) { ?>
					
					<div class="col-md-6">
						<a href="<?php echo $body->url; ?>" class="career_card_links">
						<div class="drag-cards career_drag-cards" id="dragCards">
							<div class=" drag-cards__inner_career" >
								<div class="drag-cards__card drag-cards__card_career">

									<h3 class="drag-cards__card-title font-fk"><?php echo $body->title; ?></h3>
									<div class="img-icons"><img src="<?php echo get_template_directory_uri().'/assets/img/arrow.svg'; ?>" /></div>
									<p class="drag-cards__card-desc align-items-center"><span class="img-icon">
										<img src="<?php echo get_template_directory_uri().'/assets/img/balloon.svg'; ?>" /></span>
										<span class="card-location"> <?php echo $body->location; ?>,&nbsp;<?php echo $body->nation; ?></span></p>
								</div>
							</div>
						</div>
						</a>

					</div>
				<?php } ?>
		</div>
	</div>



</main><!-- /#main -->

<?php get_footer(); ?>