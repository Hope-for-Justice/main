<?php

//Get Currency=value from the url
$currency = $_GET["Currency"];
$frequency = get_field("frequency_settings");
$frequency_start = get_field("frequency_start");
$image = get_field("image");
$margin_bottom_mobile = get_field("margin_bottom_mobile");
$margin_bottom_desktop = get_field("margin_bottom_desktop");
$extra_graphic = get_field("extra_graphic");
$thank_you = urlencode(get_field("custom_thankyou"));
$tracked = get_field("tracked") ?: "false";

$extra_text = get_field("extra_text") ?: false;
$background_color = get_field("background_color") ?: "#ffffff";
$overlay_color = get_field("overlay_color");

$title_img = get_field("title_img");
$form_image = get_field("form_img");

if (
	//if they are in the USA array or they want to give in $
	($GLOBALS["userInfo"] &&
		in_array($GLOBALS["userInfo"], $GLOBALS["usa"]) &&
		$currency != "NOK" &&
		$currency != "GBP" &&
		$currency != "AUD") ||
	$currency == "USD"
) {
	$currency = "USD";
	$settings = "usa_donate";
	$symbol = '$';
} elseif (
	// if they are in Norway or want to give in Kr
	($GLOBALS["userInfo"] &&
		in_array($GLOBALS["userInfo"], $GLOBALS["norway"]) &&
		$currency != "USD" &&
		$currency != "GBP" &&
		$currency != "AUD") ||
	$currency == "NOK"
) {
	$currency = "NOK";
	$settings = "no_donate";
	$symbol = "&nbsp;kr";
} elseif (
	// if they are in AU or want to give in AUD
	($GLOBALS["userInfo"] &&
		in_array($GLOBALS["userInfo"], $GLOBALS["au"]) &&
		$currency != "USD" &&
		$currency != "GBP" &&
		$currency != "NOK") ||
	$currency == "AUD"
) {
	$currency = "AUD";
	$settings = "au_donate";
	$symbol = '$';
} else {
	// fallback to UK
	$currency = "GBP";
	$settings = "uk_donate";
	$symbol = "£";
}
?>

<?php // preview countries in admin

if (is_admin()) {
	$preview = get_field("preview") ?: "uk_donate";
	$settings = $preview;
	if ($settings == "uk_donate") {
		$currency = "GBP";
		$symbol = "£";
	} elseif ($settings == "no_donate") {
		$currency = "NOK";
		$symbol = "Kr";
	} elseif ($settings == "au_donate") {
		$currency = "AUD";
		$symbol = '$';
	} else {
		$currency = "USD";
		$symbol = '$';
	}
} ?>




<!-- render the block -->
<?php
$set = get_field($settings);
//subfields
$once_title = $set["once_title"];
$monthly_title = $set["monthly_title"];
$once_text = $set["once_text"];
$monthly_text = $set["monthly_text"];
$widget_id_once = $set["widget_id_once"];
$widget_id_monthly = $set["widget_id_monthly"];
$email_event_once = $set["email_event_once"];
$email_event_monthly = $set["email_event_monthly"];
$target = $set["target"];
$offline_amount = $set["offline_amount"] ?: 0;
//option a
$amount_once_a = $set["amount_once_a"];
$amount_monthly_a = $set["amount_monthly_a"];
$reason_once_a = $set["reason_once_a"];
$reason_monthly_a = $set["reason_monthly_a"];
//option b
$amount_once_b = $set["amount_once_b"];
$amount_monthly_b = $set["amount_monthly_b"];
$reason_once_b = $set["reason_once_b"];
$reason_monthly_b = $set["reason_monthly_b"];
//option c
$amount_once_c = $set["amount_once_c"];
$amount_monthly_c = $set["amount_monthly_c"];
$reason_once_c = $set["reason_once_c"];
$reason_monthly_c = $set["reason_monthly_c"];
//option d
$amount_once_d = $set["amount_once_d"];
$amount_monthly_d = $set["amount_monthly_d"];
$reason_once_d = $set["reason_once_d"];
$reason_monthly_d = $set["reason_monthly_d"];
//option e
$amount_once_e = $set["amount_once_e"];
$amount_monthly_e = $set["amount_monthly_e"];
$reason_once_e = $set["reason_once_e"];
$reason_monthly_e = $set["reason_monthly_e"];
//option f
$reason_once_f = $set["reason_once_f"];
$reason_monthly_f = $set["reason_monthly_f"];
//norway link
//$link = $set['norway_link'];
//default level
$default_level = $set["default_level"] ?: "c";
//default level
$other_ways_link = $set["other_ways"];
?>

<?php //get tracked campaign amount from wp database

if ($tracked && $target) {
	global $wpdb;
	$table = $wpdb->prefix . $tracked;

	if (!function_exists("get_amount")) {
		function get_amount($wpdb, $table, $currency)
		{
			$donations = $wpdb->get_results("SELECT * FROM $table");
			$amount = 0.0;
			if (!empty($donations)) {
				foreach ($donations as $donation) {
					if ($currency == "USD") {
						$amount += $donation->amount_usd;
					} else {
						$amount += $donation->amount_gbp;
					}
				}
			}
			return $amount;
		}
	}

	$amount = get_amount($wpdb, $table, $currency);

	$grand_total = $amount + $offline_amount;
	$amount_left = $target - $grand_total; // possibly need to parse a float here
	//$doubled = $amount * 2;
	$percentage = ($grand_total / $target) * 100;

	//$matchfunded = true;

	// if ($amount >= 10000) {
	//     $matchfunded = false;
	// }
} ?>

<!-- <div style="margin: 40px 0;">
    Tracking code: <?php echo $tracked; ?>
    <br>
    User Currency: <?php echo $currency; ?>
    <br>
    Online total: <?php echo $amount; ?>
    <br>
    Offline Amount: <?php echo $offline_amount; ?>
    <br>
    Grand Total: <?php echo $grand_total; ?>
    <br>
    Target: <?php echo $target; ?>
    <br>
    Percentage to total: <?php echo $percentage; ?>
</div> -->

<div class="donate-block__container donate-block__container--<?php echo $currency; ?>" data-image="<?php if (
	$form_image
) {
	echo $image;
} ?>" style="--margin-bottom-mobile:<?php echo $margin_bottom_mobile; ?>; --margin-bottom-desktop: <?php echo $margin_bottom_desktop; ?>; --overlay-color: <?php echo $overlay_color; ?>; --background-color: <?php echo $background_color; ?>;">

    <div class="donate-block__img <?php if ($extra_text) {
    	echo "donate-block__img--bottom";
    } ?>" style="background-image: url('<?php echo $image; ?>');">

    </div>

    <!-- <div class="donate-block__video">
        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/892188383?badge=0&amp;autopause=0&amp;quality_selector=1&amp;player_id=0&amp;app_id=58479&amp;autoplay=1&amp;loop=1&amp;muted=1&amp;background=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Megan's Story Loop"></iframe></div>
        <script src="https://player.vimeo.com/api/player.js"></script>
    </div> -->

    <?php if ($extra_graphic) { ?>
        <div class="donate-block__extra-graphic">
            <?php echo wp_get_attachment_image($extra_graphic, "full"); ?>
        </div>
    <?php } ?>

    <div class="better-grid donate-block__grid">
        <!-- text area -->
        <?php if ($extra_text) { ?>

            <div class="donate-block__extra-text">
                <InnerBlocks />
            </div>
        <?php } ?>

        <!-- donate widget -->
        <div data-tracked="<?php echo $tracked; ?>" data-thankyou="<?php echo $thank_you; ?>" data-emaileventonce="<?php echo $email_event_once; ?>" data-emaileventmonthly="<?php echo $email_event_monthly; ?>" data-currency="<?php echo $currency; ?>" class="donate-block" <?php if (
	$widget_id_once
) { ?> data-widgetidonce="<?php echo $widget_id_once; ?>" <?php } ?> <?php if (
 	$widget_id_monthly
 ) { ?> data-widgetidmonthly="<?php echo $widget_id_monthly; ?>" <?php } ?>>


            <div style="<?php if ($frequency == "once") {
            	echo "display:none;";
            } ?>" class="donate-block__freq">
                <div class="donate-block__freq-option <?php if (
                	$frequency == "once" ||
                	$frequency_start == "once"
                ) {
                	echo "donate-block__freq-option--active";
                } ?>" data-freq="once">
                    <?php if ($currency == "NOK") { ?>
                        Gi en enkeltgave
                    <?php } else { ?>
                        &nbsp;Once
                    <?php } ?>
                </div>
                <div class="donate-block__freq-option <?php if (
                	$frequency != "once" &&
                	$frequency_start == "monthly"
                ) {
                	echo "donate-block__freq-option--active";
                } ?>" data-freq="monthly">
                    <?php if ($currency == "NOK") { ?>
                        Gi månedlig
                    <?php } else { ?>
                        &nbsp;Monthly
                    <?php } ?>
                </div>
            </div>



            <?php if ($title_img) { ?>
                <div class="donate-block__title-img">
                    <?php echo wp_get_attachment_image($title_img, "full"); ?>
                </div>
            <?php } else { ?>
                <h2 class="font-fk donate-block__title">
                    <?php echo $monthly_title; ?>
                </h2>

                <h2 class="font-fk donate-block__title donate-block__title--once">
                    <?php echo $once_title; ?>
                </h2>
            <?php } ?>
            <p class="donate-block__text donate-block__top-text">
                <?php echo $monthly_text; ?>
            </p>

            <p class="donate-block__text donate-block__top-text--once">
                <?php echo $once_text; ?>
            </p>

            <?php if (
            	$tracked !== "false" &&
            	($currency == "USD" || $currency == "GBP")
            ) { ?>

                <div class="donate-block__tracker">
                    <div class="donate-block__tracker-bar">
                        <div class="donate-block__tracker-bar-inner" style="--total-percentage: <?php echo $percentage; ?>%">
                        </div>
                    </div>
                    <div class="donate-block__tracker-bar-info">
                        <div class="donate-block__tracker-bar-info-total">
                            <span style="color: var(--red)"><?php echo $symbol; ?><span class="donate-block__tracker-bar-info-total-amount"><?php echo number_format(
	$grand_total,
	2
); ?></span></span>
                            Raised so far
                        </div>
                        <div class="donate-block__tracker-bar-info-target">
                            Target: <?php echo $symbol; ?><span class="donate-block__tracker-bar-info-target-amount"><?php echo number_format(
	$target,
	0
); ?></span>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <div class="donate-block__options">
                <div class="donate-block__options-option <?php if (
                	$default_level == "a"
                ) {
                	echo "donate-block__options-option--active";
                } ?>" data-amount="<?php echo $amount_once_a; ?>" data-amountmonthly="<?php echo $amount_monthly_a; ?>" data-reason="<?php echo $reason_once_a; ?>" data-monthly="<?php echo $reason_monthly_a; ?>">
                    <span class="currency"><?php echo $symbol; ?></span>
                    <span class="donate-block__options-amount">
                        <?php echo $amount_monthly_a; ?>
                    </span>
                </div>

                <div class="donate-block__options-option <?php if (
                	$default_level == "b"
                ) {
                	echo "donate-block__options-option--active";
                } ?>" data-amount="<?php echo $amount_once_b; ?>" data-amountmonthly="<?php echo $amount_monthly_b; ?>" data-reason="<?php echo $reason_once_b; ?>" data-monthly="<?php echo $reason_monthly_b; ?>">
                    <span class="currency"><?php echo $symbol; ?></span>
                    <span class="donate-block__options-amount">
                        <?php echo $amount_monthly_b; ?>
                    </span>
                </div>

                <div class="donate-block__options-option <?php if (
                	$default_level == "c"
                ) {
                	echo "donate-block__options-option--active";
                } ?>" data-amount="<?php echo $amount_once_c; ?>" data-amountmonthly="<?php echo $amount_monthly_c; ?>" data-reason="<?php echo $reason_once_c; ?>" data-monthly="<?php echo $reason_monthly_c; ?>">
                    <span class="currency"><?php echo $symbol; ?></span>
                    <span class="donate-block__options-amount">
                        <?php echo $amount_monthly_c; ?>
                    </span>
                </div>

                <div class="donate-block__options-option <?php if (
                	$default_level == "d"
                ) {
                	echo "donate-block__options-option--active";
                } ?>" data-amount="<?php echo $amount_once_d; ?>" data-amountmonthly="<?php echo $amount_monthly_d; ?>" data-reason="<?php echo $reason_once_d; ?>" data-monthly="<?php echo $reason_monthly_d; ?>">
                    <span class="currency"><?php echo $symbol; ?></span>
                    <span class="donate-block__options-amount">
                        <?php echo $amount_monthly_d; ?>
                    </span>
                </div>

                <div class="donate-block__options-option <?php if (
                	$default_level == "e"
                ) {
                	echo "donate-block__options-option--active";
                } ?>" data-amount="<?php echo $amount_once_e; ?>" data-amountmonthly="<?php echo $amount_monthly_e; ?>" data-reason="<?php echo $reason_once_e; ?>" data-monthly="<?php echo $reason_monthly_e; ?>">
                    <span class="currency"><?php echo $symbol; ?></span>
                    <span class="donate-block__options-amount">
                        <?php echo $amount_monthly_e; ?>
                    </span>
                </div>

                <div class="donate-block__options-option donate-block__options-option--custom" data-amount="custom" data-reason="<?php echo $reason_once_f; ?>" data-monthly="<?php echo $reason_monthly_f; ?>">
                    <span class="text">
                        <?php if ($currency == "NOK") { ?>
                            Valgfritt<br />beløp
                        <?php } else { ?>
                            Custom<br />Amount
                        <?php } ?>
                    </span>
                    <span class="currency"><?php echo $symbol; ?></span>
                    <input id="customAmount" style="display: none" type="number" name="customAmount" />
                </div>
            </div>

            <p class="donate-block__text">
                <span class="color-red">
                    <b><span class="donate-block__text-currency"><?php
                    if ($currency !== "NOK") {
                    	echo $currency . " ";
                    }
                    echo $symbol;
                    ?></span><span class="donate-block__text-amount"></span></b>
                </span>
                <span class="donate-block__text-freq">
                    <?php if ($currency == "NOK") { ?>
                        månedlig
                    <?php } else { ?>
                        monthly
                    <?php } ?>
                </span>
                <span id="reason"></span>
            </p>

            <div class="donate-block__other-ways">
                <a href="<?php echo $other_ways_link; ?>">
                    <?php if ($currency == "NOK") { ?>
                        Andre måter å gi
                    <?php } else { ?>
                        Other ways to give
                    <?php } ?>
                </a>
                <div class="donate-block__other-ways-divider">|</div>
                <a data-toggle="modal" data-target="#currencyModal" id="changeCurrency">
                    <?php if ($currency == "NOK") { ?>
                        Endre valuta
                    <?php } else { ?>
                        Change currency
                    <?php } ?>
                </a>
            </div>

            <div class="donate-block__button">
                <?php if ($currency == "NOK") { ?>
                    Gi
                <?php } else { ?>
                    Donate
                <?php } ?>
                <span class="donate-block__button-currency currency"><?php
                if ($currency !== "NOK") {
                	echo $currency . " ";
                }
                echo $symbol;
                ?></span><span class="donate-block__button-amount"></span>
                <span class="donate-block__button-freq"></span>
            </div>
        </div>

    </div>
</div>
<?php  ?>


<!-- 
-- 
-- currency modal
-- 
-->
<?php if (!is_admin()) {
	get_template_part("partials/content", "modal", [
		"type" => "currency-select",
		"id" => "currencyModal",
	]);
}
?>
