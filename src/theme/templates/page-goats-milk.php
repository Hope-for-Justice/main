<?php
/**
 * Template Name: Goats Milk
 *
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full campaign-page", "donate-link" => "#"]); 

$currency = $_GET["Currency"]; 

?>

<?php while (have_posts()):
    the_post(); ?>

<?php
$thumbnail = "";

// Get the ID of the post_thumbnail (if it exists)
$post_thumbnail_id = get_post_thumbnail_id($post->ID); // if it exists if

if ($post_thumbnail_id) { 

$srcset = wp_get_attachment_image_srcset($post_thumbnail_id, "", false, ""); 
$src = wp_get_attachment_image_src($post_thumbnail_id); 
$sizes = wp_get_attachment_image_sizes($post_thumbnail_id); 

} ?>


<?php 

global $wpdb;
$table = $wpdb->prefix .'goats_milk';
// $data = array('amount' => 12.85);
// $format = array('%f');
// $wpdb->insert($table,$data,$format);
// $my_id = $wpdb->insert_id;


function get_amount($wpdb, $table) {

  $donations = $wpdb->get_results( "SELECT * FROM $table" );
  $amount = 0.00;
  if(!empty($donations)) {
    foreach ($donations as $donation) {
      $amount += $donation->amount;
    }
   }
   return $amount;
}

$offline_amount = 0;
$amount = get_amount($wpdb, $table) + $offline_amount;
$amount_left = 10000.00 - $amount;
$doubled = $amount * 2;
$percentage = ($amount / 10000) * 100;

$matchfunded = true;

if ($amount >= 10000) {
    $matchfunded = false;
}

?>
<main class="main site-main donate-new goats-milk">
    <div class="full-grid">
        <div class="donate-new__hero-image donate-new__hero-image--main">
            <img src="<?php echo $src[0]; ?>" srcset="<?php echo $srcset; ?>" alt="" />
        </div>

        <!-- giving widget -->

        <!-- (else) UK + others -->
        <div data-currency="GBP" class="donate-new__giving-widget giving-widget">
            <div class="goats-milk__logo">
                <a href="https://sthelensfarm.co.uk/" target="_blank"><img src="https://hopeforjustice.org/wp-content/uploads/2022/07/SH-logo-2017-01.png" alt=""></a>
            </div>

            <div style="display:none;" class="giving-widget__freq">
                <div class="giving-widget__freq-option giving-widget__freq-option--active" data-freq="once">
                    &nbsp;Once
                </div>
                <div class="giving-widget__freq-option giving-widget__freq-option" data-freq="monthly">
                    &nbsp;Monthly
                </div>
            </div>

            <h2 class="font-fk giving-widget__title">
                <?php the_field('uk_widget_guardian_title')?>
            </h2>

            <h2 class="font-fk giving-widget__title giving-widget__title--once">
                <?php the_field('uk_widget_once_title')?>
            </h2>

            <div class="giving-widget__totaliser">
                <div class="giving-widget__totaliser-bar">
                    <div style="width: <?php echo number_format($percentage); ?>%;" class="giving-widget__totaliser-bar-inner"></div>
                </div>
            </div>

            <p class="giving-widget__totaliser-info">
                <?php if ($matchfunded) { ?>
                    <b>£<?php echo number_format($amount, 2); ?></b> doubled to <b>£<?php echo number_format($doubled, 2); ?></b> so far!
                <?php } else {?>
                    <b>£<?php echo number_format($amount, 2); ?></b> raised so far!
                <?php }?>
                
            </p>

            <p class="giving-widget__text giving-widget__top-text">
                <?php the_field('uk_widget_guardian_text')?>
            </p>

            <p class="giving-widget__text giving-widget__top-text--once">
                <?php the_field('uk_widget_once_text')?>
            </p>

            <div class="giving-widget__options">
                <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_1_amount')?>"
                    data-amountmonthly="<?php the_field('uk_widget_option_1_amount_monthly')?>"
                    data-reason="<?php 
                    if ($matchfunded) {
                        the_field('uk_widget_option_1_reason_match');
                    } else {
                        the_field('uk_widget_option_1_reason');
                    }
                    ?>"
                    >
                    <span class="currency">£</span><span class="giving-widget__options-amount">
                        <?php the_field('uk_widget_option_1_amount')?>
                    </span>
                </div>

                <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_2_amount')?>"
                    data-amountmonthly="<?php the_field('uk_widget_option_2_amount_monthly')?>"
                    data-reason="<?php 
                    if ($matchfunded) {
                        the_field('uk_widget_option_2_reason_match');
                    } else {
                        the_field('uk_widget_option_2_reason');
                    }
                    ?>"
                    >
                    <span class="currency">£</span><span class="giving-widget__options-amount">
                        <?php the_field('uk_widget_option_2_amount')?>
                    </span>
                </div>

                <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_3_amount')?>"
                    data-amountmonthly="<?php the_field('uk_widget_option_3_amount_monthly')?>"
                    data-reason="<?php 
                    if ($matchfunded) {
                        the_field('uk_widget_option_3_reason_match');
                    } else {
                        the_field('uk_widget_option_3_reason');
                    }
                    ?>">
                    <span class="currency">£</span><span class="giving-widget__options-amount">
                        <?php the_field('uk_widget_option_3_amount')?>
                    </span>
                </div>

                <div class="giving-widget__options-option giving-widget__options-option--active"
                    data-amount="<?php the_field('uk_widget_option_4_amount')?>"
                    data-amountmonthly="<?php the_field('uk_widget_option_4_amount_monthly')?>"
                    data-reason="<?php 
                    if ($matchfunded) {
                        the_field('uk_widget_option_4_reason_match');
                    } else {
                        the_field('uk_widget_option_4_reason');
                    }
                    ?>">
                    <span class="currency">£</span><span class="giving-widget__options-amount">
                        <?php the_field('uk_widget_option_4_amount')?>
                    </span>
                </div>

                <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_5_amount')?>"
                    data-amountmonthly="<?php the_field('uk_widget_option_5_amount_monthly')?>"
                    data-reason="<?php 
                    if ($matchfunded) {
                        the_field('uk_widget_option_5_reason_match');
                    } else {
                        the_field('uk_widget_option_5_reason');
                    }
                    ?>">
                    <span class="currency">£</span><span class="giving-widget__options-amount">
                        <?php the_field('uk_widget_option_5_amount')?>
                    </span>
                </div>

                <div class="giving-widget__options-option giving-widget__options-option--custom" data-amount="custom"
                    data-reason="<?php the_field('uk_widget_option_6_reason')?>"
                    data-monthly="<?php the_field('uk_widget_option_6_reason_monthly')?>">
                    <span class="text">Custom<br />Amount</span>
                    <span class="currency">£</span>
                    <input id="customAmount" style="display: none" type="number" name="customAmount" />
                </div>
            </div>

            <p class="giving-widget__text">
                <span class="color-red"><b><span class="giving-widget__text-currency">£</span><span
                            class="giving-widget__text-amount"></span></b></span>
                <!-- <span class="giving-widget__text-freq">monthly</span> -->
                <span id="reason"></span>
            </p>

            <div class="giving-widget__other-ways">
                <a href="<?php the_field('uk_widget_other_ways_link')?>">Other ways to give</a>
                <!-- <div class="giving-widget__other-ways-divider">|</div>
                <a data-toggle="modal" data-target="#modal" id="changeCurrency">Change currency</a> -->
            </div>

            <div class="giving-widget__button">
                Donate
                <span class="giving-widget__button-currency currency">£</span><span
                    class="giving-widget__button-amount"></span>
                <span class="giving-widget__button-freq"></span>
            </div>
        </div>

        <div class="goats-milk__content">
            <div class="grid">
                <div class="goats-milk__content-inner"><?php the_content(); ?></div>
            </div>
        </div>

    </div>
</main>

<!-- 
-- 
-- currency modal
-- 
-->
<?php get_template_part(
    'partials/content',
    'modal',
    array(
        'type' => 'currency-select',
        'id' => 'modal'
    )
); ?>


<?php
endwhile;
// end of the loop.
?>

<?php get_footer(); ?>