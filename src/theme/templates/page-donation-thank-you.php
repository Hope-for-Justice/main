<?php
// require_once(get_template_directory() . '/exchangeapi.php');
// $exchange_key = EXCHANGE_RATE_API_KEY;

/**
 * Template Name: Donation thank you
 *
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" => "site--full"]); ?>

<?php while (have_posts()):
	the_post(); ?>

    <?php
    $campaign = $_COOKIE["wordpress_hfjcampaign"];
    $amount = $_GET["amount"];
    $type = $_GET["type"];
    $signup = $_GET["signup"];
    $name = $_GET["Name"];
    $tracked = $_GET["tracked"];
    $currency = $_GET["currency"];

    $guardianAmount = $_COOKIE["wordpress_guardian_amount"];
    $guardianName = $_COOKIE["wordpress_guardian_name"];
    $guardianSignup = $_COOKIE["wordpress_guardian_signup"];

    if ($guardianAmount) {
    	$type = "UK Guardian";
    	$signup = $guardianSignup;
    	$name = $guardianName;
    }

    if ($campaign == "StHelens") {
    	global $wpdb;
    	$table = $wpdb->prefix . "goats_milk";
    	$data = ["amount" => $amount];
    	$format = ["%f"];
    	$wpdb->insert($table, $data, $format);
    }

    //Adding tracked donations to db
    //only setup for USD, no exchange rate api stuff anymore
    if ($tracked !== "false" && $currency == "USD") {
    	// if ($currency == 'GBP') {
    	//     $from = 'GBP';
    	//     $to = 'USD';
    	// } elseif ($currency == 'USD') {
    	//     $from = 'USD';
    	//     $to = 'GBP';
    	// }

    	// $URL = 'http://api.exchangeratesapi.io/v1/convert' . '?access_key=' . $exchange_key . '&from=' . $from . '&to=' . $to . '&amount=' . $amount;

    	//     https://api.exchangeratesapi.io/v1/latest
    	// ? access_key = API_KEY
    	// & base = USD
    	// & symbols = GBP,JPY,EUR

    	//url-ify the data for the POST
    	// $fields_string = http_build_query($fields);

    	// $ch = curl_init();
    	// curl_setopt($ch, CURLOPT_URL, $URL);
    	// curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
    	// curl_setopt($ch, CURLOPT_POST, true);
    	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	// curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    	// curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    	//curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    	// $result = curl_exec($ch);
    	// $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
    	// curl_close($ch);

    	// $json = json_decode($result);
    	// $converted_amount = $json->result;
    	//echo $converted_amount;

    	// if ($currency == 'GBP') {
    	//     $amount_usd = $converted_amount;
    	//     $amount_gbp = $amount;
    	// } elseif ($currency == 'USD') {
    	//     $amount_usd = $amount;
    	//     $amount_gbp = $converted_amount;
    	// }

    	global $wpdb;
    	$table = $wpdb->prefix . $tracked;
    	$data = [
    		"amount_usd" => $amount,
    		// 'amount_gbp' => $amount_gbp
    	];
    	$format = ["%f"];
    	$wpdb->insert($table, $data, $format);
    }

    $thumbnail = "";

    // Get the ID of the post_thumbnail (if it exists)
    $post_thumbnail_id = get_post_thumbnail_id($post->ID); // if it exists if

    if ($post_thumbnail_id) {
    	$srcset = wp_get_attachment_image_srcset(
    		$post_thumbnail_id,
    		"",
    		false,
    		""
    	);
    	$src = wp_get_attachment_image_src($post_thumbnail_id);
    	$sizes = wp_get_attachment_image_sizes($post_thumbnail_id);
    }
    ?>

    <main id="main" class="site-main donation-thankyou" role="main">


        <div class="full-grid">

            <div class="donation-thankyou__photo">
                <img src="<?php echo get_the_post_thumbnail_url(
                	$post->ID
                ); ?>" srcset="<?php echo $srcset; ?>" />
            </div>

            <h1 class="donation-thankyou__title font-canela">Thank you <?php echo $name; ?>!</h1>

            <div class="donation-thankyou__text">

                <?php switch ($type) { case "UK one-off": ?>

                        <p>
                            Your donation of <b>£<?php echo $amount; ?></b>
                            will help end slavery and change lives. You will receive a receipt via email shortly.
                        </p>

                    <?php break;case "UK Guardian": ?>

                        <p>
                            Your donation of <b>£<?php echo $guardianAmount; ?></b> a month will help end slavery and change lives. You will receive a receipt via email shortly.
                        </p>

                    <?php break;case "USA one-off": ?>

                        <p>
                            Your donation of <b>$<?php echo $amount; ?></b> will help end slavery and change lives. You will receive a receipt via email shortly.
                        </p>

                    <?php break;case "USA Guardian": ?>

                        <p>
                            Your donation of <b>$<?php echo $amount; ?></b> a month will help end slavery and change lives. You will receive a receipt via email shortly.
                        </p>

                    <?php break;case "Norway one-off": ?>

                        <p>
                            Your donation of <b><?php echo $amount; ?> kr</b> will help end slavery and change lives. You will receive a receipt via email shortly.
                        </p>

                    <?php break;case "Norway Guardian": ?>

                        <p>
                            Your donation of <b><?php echo $amount; ?> kr</b> a month will help end slavery and change lives. You will receive a receipt via email shortly.
                        </p>

                    <?php break;default: ?>

                        <p>Your donation was successful</p>

                <?php } ?>

                <?php if ($signup == "false") { ?>

                    <div class="donation-thankyou__text--smaller">
                        <p>You have opted out of email communications. Press the button below to opt in and hear about how your money is helping our cause.</p>
                    </div>

                    <div class="donation-thankyou__button">
                        <div class="button" data-toggle="modal" data-target="#modal">
                            Join our mailing list
                        </div>
                    </div>

                <?php } else { ?>

                    <ul class="thankyou__socials">
                        <li class="">
                            <a href="<?php echo the_field(
                            	"linked_in_link",
                            	"option"
                            ); ?>">
                                <img src="<?php echo get_template_directory_uri() .
                                	"/assets/img/li-red.svg"; ?>" alt="">
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo the_field(
                            	"instagram_link",
                            	"option"
                            ); ?>">
                                <img src="<?php echo get_template_directory_uri() .
                                	"/assets/img/in-red.svg"; ?>" alt="">
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo the_field(
                            	"twitter_link",
                            	"option"
                            ); ?>">
                                <img src="<?php echo get_template_directory_uri() .
                                	"/assets/img/tw-red.svg"; ?>" alt="">
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo the_field(
                            	"facebook_link",
                            	"option"
                            ); ?>">
                                <img src="<?php echo get_template_directory_uri() .
                                	"/assets/img/fb-red.svg"; ?>" alt="">
                            </a>
                        </li>
                    </ul>

                <?php } ?>

            </div>


        </div><!-- /grid -->


        <!--
    --
    --  basic
    --
    -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal__dialog">
                <div class="modal__content">
                    <p class="modal__text">Click confirm if you wish Hope for Justice to send you emails to keep you informed of our ongoing activities, news, campaigns and appeals; and to invite you to events we think might interest you. You can unsubscribe at any time, or change your preferences, at: <a href="hopeforjustice.org/manage-your-preferences">hopeforjustice.org/manage-your-preferences</a>
                        <br><br>
                        We will always store your personal information securely. We will use it to provide the service(s) you have requested, and communicate with you in the way(s) you have agreed to. We will only allow your information to be used by third parties working on our behalf. We will share your information if required to do so by law. For details see our <a href="/privacy-policy">Privacy Policy</a>.<br><br>
                    </p>
                    <a id="signUpButton" class="button button--spinner">Confirm</a>
                    <a href="#" data-dismiss="modal" class="gi-close modal__close">&times;<span class="accessibility">Close</span></a>
                </div>
            </div>
        </div>

    </main><!-- #main -->

<?php
endwhile;
// end of the loop.
?>

<?php get_footer(); ?>
