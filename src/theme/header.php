<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hope_for_Justice_2020
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'hope-for-justice-2020' ); ?></a>

	<header id="site-header" class="header">
		<div class="header__inner">
			<svg class="header__logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 169.6 22.983">
				<g>
					<path d="M344.941,566.7v7.326H343.5V566.7h-3.22v17.762h3.22v-7.549h1.443v7.549h3.22V566.7Z" transform="translate(-293.078 -561.702)" fill="#212322"/><path d="M387.724,573.973c0-6.106,1.665-8.437,4.552-8.437s4.552,2.331,4.552,8.437V575.3c0,6.106-1.665,8.437-4.552,8.437s-4.552-2.331-4.552-8.437Zm3.664,5.861c0,.733.355,1.132.888,1.132s.888-.4.888-1.132v-10.5c0-.733-.355-1.133-.888-1.133s-.888.4-.888,1.133Z" transform="translate(-331.491 -560.758)" fill="#212322"/><path d="M444.869,566.7c2.709,0,5.04,1.776,5.04,5.55v.444c0,3.774-2.331,5.55-5,5.55v6.217h-3.331V566.7Zm.044,8.881h.222c.888,0,1.443-.511,1.443-1.776v-2.665c0-1.265-.555-1.776-1.443-1.776h-.222Z" transform="translate(-375.093 -561.7)" fill="#212322"/><path d="M495.612,566.7v2.886h-2.665v4.44h2.332v2.887h-2.332v4.662h2.665v2.886h-6V566.7Z" transform="translate(-413.982 -561.699)" fill="#212322"/><path d="M548.064,566.41h6V569.3h-2.665v4.44h2.221v2.887h-2.221v7.549h-3.331Z" transform="translate(-461.298 -561.463)" fill="#212322"/><path d="M581.524,573.681c0-6.106,1.665-8.437,4.552-8.437s4.552,2.331,4.552,8.437v1.332c0,6.106-1.665,8.437-4.552,8.437s-4.552-2.331-4.552-8.437Zm3.664,5.861c0,.733.355,1.132.888,1.132s.888-.4.888-1.132v-10.5c0-.733-.355-1.133-.888-1.133s-.888.4-.888,1.133Z" transform="translate(-488.388 -560.521)" fill="#212322"/><path d="M638.152,566.411c2.8,0,4.93,1.954,4.93,5.395a5.824,5.824,0,0,1-1.888,4.663l1.665,7.482v.222h-3.22l-1.266-6.75h-.333l.155,6.75h-3.331V566.411Zm.044,8.659h.111c.778,0,1.444-.6,1.444-1.776v-2.443c0-1.176-.666-1.776-1.444-1.776H638.2Z" transform="translate(-531.573 -561.466)" fill="#212322"/><path d="M707.936,566.41v14.1c0,2.22-1,3.775-3.331,3.775a16.254,16.254,0,0,1-2.665-.222l.222-2.775h1.643c.644,0,.911-.288.911-.91V569.3h-2.554V566.41Z" transform="translate(-585.875 -561.463)" fill="#212322"/><path d="M747.352,566.41v13.321c0,2.886-1.555,4.662-4.108,4.662s-4.108-1.776-4.108-4.662V566.41h3.33V580.6c0,.733.245,1.132.777,1.132s.777-.4.777-1.132V566.41Z" transform="translate(-615.988 -561.463)" fill="#212322"/><path d="M789.685,577.121a2.59,2.59,0,0,1,.133,1v1.643c0,.689.311,1.133.821,1.133.533,0,.844-.444.844-1.221,0-1.421-.933-2.731-1.91-4.018l-.644-.844c-1.509-1.976-2.132-3.286-2.132-5.24,0-2.553,1.532-4.329,4.041-4.329,2.554,0,3.953,1.776,3.953,4.6a4.329,4.329,0,0,0,.133,1.288v.222h-3a3.006,3.006,0,0,1-.133-1v-1.488c0-.711-.333-1.066-.8-1.066-.489,0-.866.355-.866,1.244,0,1.31.688,2.243,1.665,3.486l.666.844c1.532,1.931,2.354,3.463,2.354,5.639,0,2.709-1.532,4.44-3.952,4.44-2.709,0-4.086-1.754-4.086-4.862a3.944,3.944,0,0,0-.133-1.243v-.222Z" transform="translate(-654.45 -560.52)" fill="#212322"/><path d="M839.827,566.41V569.3h-2.221v14.876h-3.331V569.3h-2.22V566.41Z" transform="translate(-691.216 -561.463)" fill="#212322"/><rect width="3.331" height="17.762" transform="translate(149.58 4.945)" fill="#212322"/><path d="M905.286,565.244c2.665,0,4.086,2.109,4.086,5.439a5.463,5.463,0,0,0,.11,1.221v.222h-3.33a3.629,3.629,0,0,1-.111-1v-2.2c0-.621-.266-1.021-.8-1.021s-.865.4-.865,1.133v10.5c0,.733.333,1.132.865,1.132s.8-.4.8-1.021v-2.2a3.633,3.633,0,0,1,.111-1h3.33v.222a5.011,5.011,0,0,0-.11,1.332c0,3.33-1.422,5.439-4.086,5.439-2.887,0-4.574-2.331-4.574-8.437v-1.332c0-6.106,1.688-8.437,4.574-8.437" transform="translate(-746.799 -560.521)" fill="#212322"/><path d="M957.6,566.41V569.3h-2.665v4.44h2.332v2.887h-2.332v4.662H957.6v2.886h-6V566.41Z" transform="translate(-788 -561.463)" fill="#212322"/><path d="M529.437,416.2c-1.914,0-4.625-.858-7.892-4.164-.452-.455-.879-.875-1.378-1.377l-2.475-2.486c-2.621-2.62-5.178-3.523-9.225-3.523h-6.374l7.634,7.631a30.148,30.148,0,0,0,2.8,2.582l.286.248a14.473,14.473,0,0,0,8.833,3.578c.083,0,.165,0,.248,0s.165,0,.248,0A13.538,13.538,0,0,0,529.5,416.2l-.062,0" transform="translate(-502.094 -395.708)" fill="#d6001c"/><path d="M682.579,404.648c-4.28,0-6.7,1.094-9.118,3.515,0,0-2.98,3-3.261,3.276,5.177,5.3,8.741,3.139,9.109,2.85q1.049-.9,2.117-2.01l7.635-7.631Z" transform="translate(-649.45 -395.708)" fill="#d6001c"/><path d="M630.521,337.468a5.248,5.248,0,1,1-5.248-5.248,5.248,5.248,0,0,1,5.248,5.248" transform="translate(-605.467 -332.22)" fill="#d6001c"/>
				</g>
			</svg>
			<div class="header__navigation">
				<a class="button button--red button--nav bold" href="#">DONATE</a>
				<div class="header__burger">
					<div class="burger">
					<div id="burger-menu" class="burger">
					  <span></span>
					  <span></span>
					  <span></span>
					  <span></span>
					</div>
					</div>
				</div>
			</div>
		</div>
		<nav id="menu" class="menu">
			<div class="menu__inner">
			<?php wp_nav_menu( array( 'theme_location' => 'uk-primary', 'container' => false, 'menu_class' => 'menu__primary') ); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'uk-secondary', 'container' => false, 'menu_class' => 'menu__secondary') ); ?>
				<div class="menu__footer">
					<p><small>We use cookies to help make this website better. Here is how we use them. You can change the cookie settings on your browser. Otherwise, we’ll assume you’re OK to continue. Here is our Privacy Policy. Hope for Justice is a 501(c)(3) not for profit organization in the USA, a registered charity in England & Wales (no. 1126097) and in Scotland (no. SC045769), and a company limited by guarantee, registered in England and Wales, number 6563365. In Norway, Hope for Justice AS is registered under Organisasjonsnummer 915 520 995.</small></p>
				</div>
			</div>
		</nav>
	</header><!-- #masthead -->



	<div id="content" class="site-content">
