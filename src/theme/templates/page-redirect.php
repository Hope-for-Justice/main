<?php
/**
 * Template Name: Redirect
 *
 * @package Hope_for_Justice_2021
 */
get_header();
?>

<?php
    
    $url = 'https://' . $_SERVER['HTTP_HOST']; // Get the server
    if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['norway'])){ 
        $url .= get_field('norway_redirect');
    } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['usa'])){
        $url .= get_field('usa_redirect');
    } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['aus'])) {
        $url .= get_field('aus_redirect');
    } else if($GLOBALS['userInfo'] && in_array($GLOBALS['userInfo'], $GLOBALS['uk'])) {
        $url .= get_field('uk_redirect');
    } else {
        $url .= get_field('other_redirect');
    }
    wp_redirect($url);
    exit;
?>