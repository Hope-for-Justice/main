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
						Awareness can save lives
					</h3>
					<h1 class="font-canela">
						Spot the Signs<br> of Modern Slavery
					</h1>
					<p class="hero-split__desc">
						Modern slavery is happening in our communities - being able to spot the signs and know what to do could make a life-changing difference. You might walk past or speak to someone who needs help without you even realising it. Help spread the word about the signs to look out for.  
					</p>
					<div class="hero-spit__button">
						<a href="#" class="button button--red">
							<div class="button__inner">
								<div class="button__text bold">
									Downloadable<br>
									resources
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
			<div class="drop-card drop-card--open">
				<div class="drop-card__header">
					<h2 class="drop-card__title font-fk">General Indicators</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus cross-circle__plus--open">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Houses or flats with too many people, all picked up or dropped off at the same time 
						</li>
						<li class="drop-card__list-item">
							People who seem scared, confused or have untreated injuries 
						</li>
						<li class="drop-card__list-item">
							Few or no documents, or someone else in control of their documents / passport 
						</li>
						<li class="drop-card__list-item">
							No control over their own post/mail, no phone or phone held by someone else 
						</li>
						<li class="drop-card__list-item">
							Low or no pay 
						</li>
						<li class="drop-card__list-item">
							One person speaking on behalf of many others, who may avoid eye contact or conversation 
						</li>
						<li class="drop-card__list-item">
							Lights on at workplaces at strange times – are people living there? 
						</li>
						<li class="drop-card__list-item">
							Feel they are in debt to someone 
						</li>
						<li class="drop-card__list-item">
							Limited freedom of movement and dependency on others 
						</li>
						<li class="drop-card__list-item">
							Fear of police/authorities
						</li>
						<li class="drop-card__list-item">
							Fear of a trafficker, believing their life or families’ lives are at risk if they escape or complain 
						</li>
						<li class="drop-card__list-item">
							Anxious and unwilling to tell others about their situation 
						</li>
						<li class="drop-card__list-item">
							Poor health, malnutrition or untreated dental conditions  
						</li>
						<li class="drop-card__list-item">
							Bruising; signs of other physical or psychological trauma including anxiety, confusion, memory loss  
						</li>
						<li class="drop-card__list-item">
							Less often, someone believing they are being controlled through witchcraft 
						</li>
						<li class="drop-card__list-item">
							Note: Those affected are unlikely to self-identify as a ‘victim’ and may not realise or accept they are being controlled  
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
					<h2 class="drop-card__title font-fk">Forced Labour</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"><b>Where work is done under the menace of a penalty or the person has not offered himself or herself voluntarily and is now unable to leave. They may experience some or all of the above General Indicators as well as:</b></p>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Withholding of wages or reductions resulting in low or no pay 
						</li>
						<li class="drop-card__list-item">							
							Excessive hours, forced overtime, few or no breaks 
						</li>
						<li class="drop-card__list-item">						
							Poor or non-existent health and safety standards 
						</li>
						<li class="drop-card__list-item">						
							Workers made to pay for own tools or equipment  
						</li>
						<li class="drop-card__list-item">	
							Intimidation and threats, or physical violence 
						</li>
						<li class="drop-card__list-item">
							Threat of revealing irregular immigration status 
						</li>
						<li class="drop-card__list-item">					
							No access to labour contract or documentation 
						</li>
						<li class="drop-card__list-item">
							Abusive working and living conditions 
						</li>
						<li class="drop-card__list-item">
							Imposed place of accommodation (deductions made) 
						</li>
						<li class="drop-card__list-item">		
							Abuse of vulnerability 
						</li>
						<li class="drop-card__list-item">		
							Isolation, restriction of movement or confinement 
						</li>
						<li class="drop-card__list-item">
							Debt bondage with spurious deductions or interest added 
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
					<h2 class="drop-card__title font-fk">Forced Sexual Exploitation</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"><b>People trapped in situations of sexual exploitation may experience some or all of the above General Indicators as well as: </b></p>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Movement between brothels, sometimes different cities (temporary brothels can be set up in residential homes or hotels) 
						</li>
						<li class="drop-card__list-item">
							Sleeping on work premises 
						</li>
						<li class="drop-card__list-item">
							Limited amount of clothing and sexualised clothing  
						</li>
						<li class="drop-card__list-item">							
							Subjected to abduction, assault or rape  
						</li>
						<li class="drop-card__list-item">
							Movement is controlled, is picked up and dropped off at work location 
						</li>
						<li class="drop-card__list-item">
							Someone other than the person receives the money for the services  
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
					<h2 class="drop-card__title font-fk">Child Sexual Exploitation</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"><b>Modern slavery includes all forms of commercial sexual exploitation of children. This encompasses the use, procuring, or offering of children for prostitution or pornography. The below indicators relate specifically to grooming for sexual exploitation: </b></p>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							A child or teenager who is often truant or goes missing    
						</li>
						<li class="drop-card__list-item">
							Secretive behaviour or unexplained money/presents 
						</li>
						<li class="drop-card__list-item">
							Experimenting with drugs, alcohol 
						</li>
						<li class="drop-card__list-item">
							Unexplained association with older males or a significantly older boyfriend 
						</li>
						<li class="drop-card__list-item">
							Social activities without any plausible explanation 
						</li>
						<li class="drop-card__list-item">
							Low self-image/self-harm/eating disorder 
						</li>
						<li class="drop-card__list-item">
							Seen entering or leaving vehicles with unknown adults 
						</li>
						<li class="drop-card__list-item">
							Evidence of physical/sexual assault 
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
					<h2 class="drop-card__title font-fk">Domestic Servitude</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"><b>This is one of the most hidden forms of modern slavery as it happens within private homes. Some are exploited exclusively in domestic servitude, others have domestic duties imposed where they are forced to live while also working outside the home through forced labour or sexual exploitation. Signs include: </b></p>
					<ul class="drop-card__list">
						<li class="drop-card__list-item">
							Living and working for a family in a private home 
						</li>
						<li class="drop-card__list-item">
							Not eating with the rest of the family 
						</li>
						<li class="drop-card__list-item">
							No bedroom or proper sleeping place 
						</li>
						<li class="drop-card__list-item">
							No private space, documents or access to phone  
						</li>
						<li class="drop-card__list-item">
							Forced to work excessive hours, on-call 24 hours a day 
						</li>
						<li class="drop-card__list-item">
							May never leave the house without the employer 
						</li>
						<li class="drop-card__list-item">
							Employer reports as missing and/or accuses criminal activity if attempts to escape 
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
					<h2 class="drop-card__title font-fk">Criminal Activity</h2>
					<div class="drop-card__cross cross-circle"><span class="cross-circle__plus">&times;</span></div>
				</div>
				<div class="drop-card__content">
					<p class="drop-card__desc"><b>Criminal gangs use modern slavery to exploit victims both to profit from them and to use the threat of reporting the criminal behaviour as a means of control. Signs include all of the General Indictors above as well as</b></p>
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
			</div>
		</div>


	</div> <!-- /grid -->

	<?php endwhile; // end of the loop. ?>

</main>

<?php get_footer(); ?>