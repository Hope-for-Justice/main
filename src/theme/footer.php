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
		<!-- #newsTicker -->
		<div class="newsticker">
			<div id="newsTicker"><a href="#" class="newsticker__item">40.3 Million victims of modern slavery rescued by Hope for Justice</a></div>
		</div>

		<!-- 
		-- 
		-- payment modal once
		-- 
		--> 
		<?php get_template_part(
		    'partials/content',
		    'modal',
		    array(
		        'type' => 'payment-once',
		        'id' => 'payment-modal-once'
		    )
		); ?>

		<!-- 
		-- 
		-- payment modal regular
		-- 
		--> 
		<?php get_template_part(
		    'partials/content',
		    'modal',
		    array(
		        'type' => 'payment-regular',
		        'id' => 'payment-modal-regular'
		    )
		); ?>

	</div><!-- #content -->

	<footer class="footer">
		<div class="grid">
			<div class="footer__content">
				
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>


</body>
</html>
