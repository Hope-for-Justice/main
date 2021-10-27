<?php 

function dropdown_function( $atts, $content = null ) {

	// set up default parameters
    extract(shortcode_atts(array(
     'title' => 'add title= to dropdown'
    ), $atts));
    

    return 
    '<div class="dropdown">
    	<h2 class="dropdown__title">' . $title . '<span> </span></h2>
    	<div class="dropdown__content">'. $content .'</div>
    </div>';

}

