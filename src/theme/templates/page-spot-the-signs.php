<?php
/**
 * Template Name: Spot the signs
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
		-- hero split
		-- 
		--> 
		<div class="hero-split hero-split">

			<div class="hero-split__img hero-split__img--center-center" style="background-image: url('<?php echo $thumbnail[0]; ?>');">
			</div>

			<div class="hero-split__content hero-split__content--grey">
				<div class="hero-split__content-inner">
					<h3 class="hero-split__sub-heading">
						<!--  -->
						<?php the_field('subtitle'); ?>
					</h3>
					<h1 class="font-canela">
						<!--  -->
						<?php the_title(); ?>
					</h1>
					<div class="hero-split__desc">
						<!--  -->
						<?php the_content(); ?>
					</div>
					<div class="hero-spit__button">
						<a href="<?php the_field('hero_button_link'); ?>" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									<?php the_field('hero_button_text'); ?>
									<!--  -->
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /hero-split -->

		<!-- 
		-- 
		-- drop-cards
		-- 
		-->
		<div class="drop-cards">
			

			<?php

			$i = 1;

			while (have_rows('drop_cards')) : the_row(); ?>
			
				<div class="drop-card <?php if($i == 1) {echo 'drop-card--open';} ?>">
					<div class="drop-card__header">
						<h2 class="drop-card__title font-fk">
							<?php echo (get_sub_field('drop_card_title'))?>
						</h2>
						<div class="drop-card__cross cross-circle"><span class="cross-circle__plus <?php if($i == 1) {echo 'cross-circle__plus--open';} ?>">&times;</span></div>
					</div>
					<div class="drop-card__content">
						<!-- If has description -->
						<?php if( get_sub_field('description') ){ ?>
							<p class="drop-card__desc">
								<?php echo (get_sub_field('description'))?>
							</p>
						<?php } ?>
						
						<?php while (have_rows('lists')) : the_row(); ?>

							<!-- If has title -->
							<?php if( get_sub_field('list_title') ){ ?>
								<h3 class="drop-card__sub-title">
									<?php echo (get_sub_field('list_title'))?>		
								</h3>
							<?php } ?>

							<ul class="drop-card__list">
								<?php while (have_rows('list_items')) : the_row(); ?>
									<li class="drop-card__list-item">
										<?php echo (get_sub_field('list_item'))?>
									</li>
								<?php endwhile; ?> <!--/list items-->							
							</ul>
						<?php endwhile; ?> <!--/lists-->	
						<a href="<?php echo (get_sub_field('drop_card_button_link'))?>" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									<!-- Report<br>
									a concern -->
									<?php echo (get_sub_field('drop_card_button_text'))?>
								</div>
							</div>
						</a>
					</div>
				</div>

			<?php $i++; 
			endwhile; ?> <!-- end card loop -->

<!-- 			<div class="drop-card">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk"></h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							 
						</li>
						<li class="drop-card__list-item">							
							
						</li>
						<li class="drop-card__list-item">						
							 
						</li>
						<li class="drop-card__list-item">						
							
						</li>
						<li class="drop-card__list-item">	
							
						</li>
						<li class="drop-card__list-item">
							
						</li>
						<li class="drop-card__list-item">					
							
						</li>
						<li class="drop-card__list-item">
							
						</li>
						<li class="drop-card__list-item">
							
						</li>
						<li class="drop-card__list-item">		
							
						</li>
						<li class="drop-card__list-item">		
							 
						</li>
						<li class="drop-card__list-item">
							
						</li>
					</ul>
					<a href="#" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="drop-card">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk"></h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"></p>
					<ul class="drop-card__list">

					</ul>
					<a href="#" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								Report<br>
								a concern
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="drop-card">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk">Child Sexual Exploitation</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"></p>
					<ul class="drop-card__list">

					</ul>
					<a href="#" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								Report<br>
								a concern
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="drop-card">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk"></h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"></p>
					<ul class="drop-card__list">
						
					</ul>
					<a href="#" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								Report<br>
								a concern
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="drop-card">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk"></h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"></p>
					<h3 class="drop-card__sub-title">Cannabis Cultivation:</h3>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Windows permanently covered from the inside  
						</li>
						<li class="drop-card__list-item">
							Visits at unusual times 
						</li>
						<li class="drop-card__list-item">
							Unusual noises coming from the property, such as machinery 
						</li>
						<li class="drop-card__list-item">
							Pungent smells  
						</li>
						<li class="drop-card__list-item">
							Strange or permanent lighting  
						</li>
						<li class="drop-card__list-item">
							Excessive condensation and temperature – attracts birds and causes roof snow to melt quickly
						</li>
					</ul>
					<h3 class="drop-card__sub-title">Sham Marriage:</h3>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Lack of ‘courtship’ of bride and groom  
						</li>
						<li class="drop-card__list-item">
							Someone with little or no knowledge of partner’s family 
						</li>
						<li class="drop-card__list-item">
							Bride has no family at wedding 
						</li>
						<li class="drop-card__list-item">							
							No wedding ring, photographs, reception or honeymoon 
						</li>
						<li class="drop-card__list-item">
							Uncertainty over marital home
						</li>
					</ul>
					<h3 class="drop-card__sub-title">Pickpocketing/Forced Begging: </h3>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Young, elderly or disabled people begging in public or on public transport, especially foreign nationals  
						</li>
						<li class="drop-card__list-item">
							One adult acting as guardian of a large group of children; 
						</li>
						<li class="drop-card__list-item">
							Group of adult and/or child beggars moved daily to different locations, returning to same location every night;    
						</li>
						<li class="drop-card__list-item">							
							Group moving together on public transport, eg walking up and down length of bus or train. 
						</li>
					</ul>
					<h3 class="drop-card__sub-title">Benefit Fraud:</h3>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Relationship between adult and child or children is unclear   
						</li>
						<li class="drop-card__list-item">
							Shared addresses for registering for benefits, school etc 
						</li>
						<li class="drop-card__list-item">
							Single adult registers large number of children (possibly at single address)      
						</li>
						<li class="drop-card__list-item">							
							Suspicious ‘family’ members, ‘friends’ or ‘interpreters’  
						</li>
						<li class="drop-card__list-item">
							References to someone ‘helping’ with benefits forms or applications, but no access to the money or correspondence
						</li>
					</ul>
					<h3 class="drop-card__sub-title">Child Criminal Exploitation, such as in County Lines drug trafficking: </h3>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Persistently going missing from school or home, or being found out-of-area   
						</li>
						<li class="drop-card__list-item">
							Unexplained money, clothes, phones 
						</li>
						<li class="drop-card__list-item">
							Receiving excessive texts or phone calls, having multiple phones      
						</li>
						<li class="drop-card__list-item">							
							Relationships with older individuals or groups  
						</li>
						<li class="drop-card__list-item">
							Leaving home or care without explanation 
						</li>
						<li class="drop-card__list-item">
							Strange injuries  
						</li>
						<li class="drop-card__list-item">
							Carrying weapons 
						</li>
						<li class="drop-card__list-item">
							Significant decline in school performance       
						</li>
						<li class="drop-card__list-item">							
							Gang association or isolation from former friends 
						</li>
						<li class="drop-card__list-item">
							Self-harm or significant changes in emotional well-being  
						</li>
 
					</ul>
					<a href="#" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								Report<br>
								a concern
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="drop-card">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk">Forced Marriage</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"><b>This form of modern slavery primarily affects women and girls who are living in a forced marriage to which they had not consented. The institution of marriage is then used by the partner or family to impose other forms of exploitation, such as domestic servitude, forced labour (such as in a family business) and sexual exploitation. Forced marriage is different to arranged marriage, where those involved can still make the choice not to go through with it. There are no religious nor cultural grounds that justify forced marriage.  
					<br><br>
					Signs include the General Indicators above as well as:  </b></p>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Unable to leave family home, or can only leave with partner or chaperone 
						</li>
						<li class="drop-card__list-item">
							Surveillance of behaviour  
						</li>
						<li class="drop-card__list-item">
							Not being allowed to speak to others (or having others claim they have to interpret) 
						</li>
						<li class="drop-card__list-item">
							Removed from school or sudden absence from workplace 
						</li>
						<li class="drop-card__list-item">
							Decline in physical and mental health  
						</li>
						<li class="drop-card__list-item">
							Always accompanied on doctor or hospital visits  
						</li>
						<li class="drop-card__list-item">
							Under age 16 when married  
						</li>
						<li class="drop-card__list-item">
							No access to phone or computer, prevented from seeking help or communicating with others
						</li>
					</ul>
					<a href="#" class="button button--red">
						<div class="button__inner">
							<div class="button__text bold">
								Report<br>
								a concern
							</div>
						</div>
					</a>
				</div>
			</div> -->
		</div>


	</div> <!-- /grid -->

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>