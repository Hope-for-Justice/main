<?php
/**
 * The template used for /donate 
 * Redirects to homepage with url parameters
 *
 * @package hopeforjustice-2014
 */
?>
<?php

	$url = 'http://' . $_SERVER['HTTP_HOST']; // Get the server
	$url .= '?donate=true';

	wp_redirect($url);
	exit;
?>