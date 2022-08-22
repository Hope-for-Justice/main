<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Hope_for_Justice_2021
 */

?>

<!-- if no cookie exists show notice -->

<!-- cookie notice  -->
<div id="cookieNotice" class="cookie-notice">
    <p>
        <?php echo the_field('cookie_text', 'option'); ?>
    </p>
    <div id="cookieAccept" class="button button--yellow">
        <?php echo the_field('cookie_button_text', 'option'); ?>
    </div>
</div>




<?php // show or hide ticker
	if( ! get_field('no_news') ) { ?>

<?php if ( is_page() ) { ?>
<!-- #newsTicker -->
<div class="newsticker">
    <div id="newsTicker">
        <?php while (have_rows('news_ticker','option')) : the_row(); ?>
        <a href="<?php echo get_sub_field('link'); ?>" class="newsticker__item">
            <?php echo get_sub_field('text'); ?>
        </a>
        <?php endwhile; ?>
    </div>
</div>
<?php } ?>

<?php } ?>

<?php if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['help'])){
 
	// show or hide get help
	if( ! get_field('no_get_help') ) { ?>

<?php if ( is_page() ) { ?>
<!-- get help -->
<div class="get-help">
    <a data-toggle="modal" data-target="#get-help-modal" class="get-help__help-button">
        Get&nbsp;Help
    </a>
    <a href="http://google.com" class="get-help__quick-exit"><span>Quick&nbsp;Exit</span></a>
</div>

<!-- 
			-- 
			-- get help modal
			-- 
			-->
<?php get_template_part(
				'partials/content',
				'modal',
				array(
					'type' => 'get-help',
					'id' => 'get-help-modal'
				)
			); ?>

<?php } ?>


<?php } 
	}?>

</div><!-- #content -->
</div><!-- #page -->

<?php // show or hide ticker
	if( ! get_field('no_email_push') ) { 
	if( ! is_page_template('templates/page-block-template.php') ) { ?>
<div class="email-push">
    <div class="email-push__image">
        <img src="<?php the_field('email_footer_image', 'option'); ?>">
    </div>
    <div class="grid">
        <div class="email-push__content">
            <h2 class="email-push__title font-canela"><?php the_field('email_footer_title', 'option'); ?></h2>
            <p class="email-push__text">
                <?php the_field('email_footer_text', 'option'); ?>
            </p>
            <?php echo do_shortcode( get_field('email_footer_form', 'option') ); ?>
        </div>
    </div>
</div>

<?php } }?>

<footer id="footer" class="footer">
    <div class="grid">
        <div class="footer__social-email">
            <ul class="footer__social-icons">
                <li class="footer__social-icon">
                    <a href="<?php echo the_field('linked_in_link', 'option'); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri().'/assets/img/li-white.svg'; ?>" alt="">
                    </a>
                </li>
                <li class="footer__social-icon">
                    <a href="<?php echo the_field('instagram_link', 'option'); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri().'/assets/img/in-white.svg'; ?>" alt="">
                    </a>
                </li>
                <li class="footer__social-icon">
                    <a href="<?php echo the_field('twitter_link', 'option'); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri().'/assets/img/tw-white.svg'; ?>" alt="">
                    </a>
                </li>
                <li class="footer__social-icon">
                    <a href="<?php echo the_field('facebook_link', 'option'); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri().'/assets/img/fb-white.svg'; ?>" alt="">
                    </a>
                </li>
            </ul>
            <div class="footer__button">
                <a href="/signup" class="button button--white">
                    <div class="button__inner">
                        <div class="button__text bold">
                            Get our <br>email updates
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="line footer__line"></div>
        <div class="sub-grid footer__sub-grid">
            <div class="footer__section footer__section--a">
                <h3 class="footer__section-title">About Us</h3>
                <?php wp_nav_menu( array( 'theme_location' => 'uk-footer-a', 'container' => false, 'menu_class' => 'footer__menu footer__menu-a') ); ?>
            </div>
            <div class="footer__section footer__section--b">
                <h3 class="footer__section-title">Information</h3>
                <?php wp_nav_menu( array( 'theme_location' => 'uk-footer-b', 'container' => false, 'menu_class' => 'footer__menu footer__menu-b') ); ?>
            </div>
            <div class="footer__section footer__section--c">
                <h3 class="footer__section-title">Get Involved</h3>
                <?php wp_nav_menu( array( 'theme_location' => 'uk-footer-c', 'container' => false, 'menu_class' => 'footer__menu footer__menu-c') ); ?>
            </div>
            <div class="footer__section footer__section--d">
                <h3 class="footer__section-title">Work with us</h3>
                <?php wp_nav_menu( array( 'theme_location' => 'uk-footer-d', 'container' => false, 'menu_class' => 'footer__menu footer__menu-d') ); ?>
            </div>
        </div>
        <p class="footer__small">
            <?php echo the_field('footer_text', 'option'); ?>
        </p>
        <div class="footer__logos">
            <img class="fr-reg" src="<?php echo get_template_directory_uri().'/assets/img/fr-reg@2x.png'; ?>">
            <img class="guidestar" src="<?php echo get_template_directory_uri().'/assets/img/guidestar@2x.png'; ?>">
        </div>
        <div class="footer__branding">
            <img class="footer__branding-logo"
                src="<?php echo get_template_directory_uri().'/assets/img/logo-white-stack.svg'; ?>">
        </div>
    </div>
</footer><!-- #colophon -->


<?php wp_footer(); ?>


</body>

</html>