<?php

/**
 * geo-target
 *
 */

// Load values and assign defaults.
$selected_country = get_field('country');

if ($GLOBALS["userInfo"] && in_array($GLOBALS["userInfo"], $GLOBALS["usa"])) {
    $country = 'USA';
} else if ($GLOBALS["userInfo"] && in_array($GLOBALS["userInfo"], $GLOBALS["norway"])) {
    $country = 'NOK';
} else if ($GLOBALS["userInfo"] && in_array($GLOBALS["userInfo"], $GLOBALS["au"])) {
    $country = 'AUS';
} else {
    $country = 'UK';
}
?>

<?php if (($selected_country == "USA" && $country == "USA") || (is_admin() && $selected_country == "USA")) { ?>

    <div class="geo-target geo-target--usa">
        <?php if (is_admin()) echo '<p class="geo-target__admin-text geo-target__admin-text--usa">Geo target: USA</p>' ?>
        <InnerBlocks />
    </div>

<?php } else if (($selected_country == "UK" && $country == "UK") || (is_admin() && $selected_country == "UK")) { ?>
    <div class="geo-target geo-target--uk">
        <?php if (is_admin()) echo '<p class="geo-target__admin-text geo-target__admin-text--uk">Geo target: UK</p>' ?>
        <InnerBlocks />
    </div>
<?php } else if (($selected_country == "NOK" && $country == "NOK") || (is_admin() && $selected_country == "NOK")) { ?>
    <div class="geo-target geo-target--nok">
        <?php if (is_admin()) echo '<p class="geo-target__admin-text geo-target__admin-text--nok">Geo target: NOK</p>' ?>
        <InnerBlocks />
    </div>
<?php } else if (($selected_country == "AUS" && $country == "AUS") || (is_admin() && $selected_country == "AUS")) { ?>
    <div class="geo-target geo-target--au">
        <?php if (is_admin()) echo '<p class="geo-target__admin-text geo-target__admin-text--au">Geo target: AU</p>' ?>
        <InnerBlocks />
    </div>
<?php } ?>