<?php

/**
 * Template Name: Location test
 *
 * @package Hope_for_Justice_2022
 */
get_header('', array('page_class' => 'site--full'));
/** Loads the WordPress Environment and Template */
$test_geoip_country_Code = do_shortcode('[geoip-country]');
$test_geoip_region = do_shortcode('[geoip-region]');
$test_geoip_city = do_shortcode('[geoip-city]');
$test_geoip_postalcode = do_shortcode('[geoip-postalcode]');
$test_geoip_location = do_shortcode('[geoip-location]');
echo "Country: " . $test_geoip_country . "<br/>";
echo "Region: " . $test_geoip_region . "<br/>";
echo "City: " . $test_geoip_city . "<br/>";
echo "Postal Code:" . $test_geoip_postalcode . "<br/>";
echo "Location: " . $test_geoip_location . "<br/>";

get_footer();
