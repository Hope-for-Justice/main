<?php
/**
 * Template Name: Donate new
 *
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full"]); $currency = $_GET["Currency"]; ?>

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

<div class="main site-main donate-new">
    <div class="full-grid">
        <div class="donate-new__hero-image">
            <img src="<?php echo $src[0]; ?>" srcset="<?php echo $srcset; ?>" />
        </div>

        <!-- giving widget -->
        <?php if (
            ($GLOBALS["userInfo"] &&
                in_array($GLOBALS["userInfo"], $GLOBALS["usa"])) ||
            $currency == "USD"
        ) { ?>

        <div class="donate-new__giving-widget giving-widget">
            <div class="giving-widget__freq">
                <div class="giving-widget__freq-option" data-freq="once">
                    &nbsp;Once
                </div>
                <div
                    class="giving-widget__freq-option giving-widget__freq-option--active"
                    data-freq="monthly"
                >
                    &nbsp;Monthly
                </div>
            </div>

            <h2 class="font-fk giving-widget__title">
                <?php the_field('usa_widget_guardian_title')?>
                BECOME A <span class="color-red">GUARDIAN</span>
            </h2>

            <h2 class="font-fk giving-widget__title giving-widget__title--once">
                <?php the_field('usa_widget_once_title')?>
                FUND <span class="color-red">FREEDOM</span>
            </h2>

            <p class="giving-widget__text giving-widget__top-text">
                <?php the_field('usa_widget_guardian_text')?>
                GUARDIANS are part of our community of regular givers who know
                that rescue is not an event, it is a process. Let’s rebuild
                lives, together.
            </p>

            <p class="giving-widget__text giving-widget__top-text--once">
                <?php the_field('usa_widget_once_text')?>
                ONCE are part of our community of regular givers who know
                that rescue is not an event, it is a process. Let’s rebuild
                lives, together.
            </p>

            <div class="giving-widget__options">
                <div
                    class="giving-widget__options-option"
                    data-amount="<?php the_field('usa_widget_option_1_amount')?>10"
                    data-amountmonthly="<?php the_field('widget_option_1_amount_monthly')?>12"
                    data-reason="<?php the_field('usa_widget_option_1_reason')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 1"
                    data-monthly="<?php the_field('usa_widget_option_1_reason_monthly')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 1 monthly"
                >
                    <span class="currency">$</span
                    ><span class="giving-widget__options-amount"><?php the_field('widget_option_1_amount_monthly')?>10</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="<?php the_field('usa_widget_option_2_amount')?>25"
                    data-amountmonthly="<?php the_field('widget_option_1_amount_monthly')?>27"
                    data-reason="<?php the_field('usa_widget_option_2_reason')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 2"
                    data-monthly="<?php the_field('usa_widget_option_2_reason_monthly')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 2 monthly"
                >
                    <span class="currency">$</span
                    ><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_2_amount_monthly')?>25</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="<?php the_field('usa_widget_option_3_amount')?>50"
                    data-amountmonthly="<?php the_field('usa_widget_option_3_amount_monthly')?>52"
                    data-reason="<?php the_field('usa_widget_option_3_reason')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 3"
                    data-monthly="<?php the_field('usa_widget_option_3_reason_monthly')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 3 monthly"
                >
                    <span class="currency">$</span
                    ><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_3_amount_monthly')?>50</span>
                </div>

                <div
                    class="giving-widget__options-option giving-widget__options-option--active"
                    data-amount="<?php the_field('usa_widget_option_4_amount')?>100"
                    data-amountmonthly="<?php the_field('usa_widget_option_4_amount_monthly')?>102"
                    data-reason="<?php the_field('usa_widget_option_4_reason')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 4"
                    data-monthly="<?php the_field('usa_widget_option_4_reason_monthly')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 4 monthly"
                >
                    <span class="currency">$</span
                    ><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_4_amount_monthly')?>100</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="<?php the_field('usa_widget_option_5_amount')?>250"
                    data-amountmonthly="<?php the_field('usa_widget_option_5_amount_monthly')?>252"
                    data-reason="<?php the_field('usa_widget_option_5_reason')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 5"
                    data-monthly="<?php the_field('usa_widget_option_5_reason_monthly')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 5 monthly"
                >
                    <span class="currency">$</span
                    ><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_5_amount_monthly')?>250</span>
                </div>

                <div
                    class="giving-widget__options-option giving-widget__options-option--custom"
                    data-amount="custom"
                    data-reason="<?php the_field('usa_widget_option_6_reason')?>Your giving could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 6"
                    data-monthly="<?php the_field('usa_widget_option_6_reason_monthly')?>could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 6 monthly"
                >
                    <span class="text">Custom<br />Amount</span>
                    <span class="currency">$</span>
                    <input
                        id="customAmount"
                        style="display: none"
                        type="number"
                        name="customAmount"
                    />
                </div>
            </div>

            <p class="giving-widget__text">
                <span class="color-red"
                    ><b
                        ><span class="giving-widget__text-currency">$</span
                        ><span class="giving-widget__text-amount"></span></b
                    ></span
                >
                <span class="giving-widget__text-freq">monthly</span>
                <span id="reason"></span>
            </p>

            <div class="giving-widget__other-ways">
                <a href="<?php the_field('usa_widget_other_ways_link')?>">Other ways to give</a>
                <div class="giving-widget__other-ways-divider">|</div>
                <a id="changeCurrency">Change currency</a>
            </div>

            <div class="giving-widget__button">
                Donate
                <span class="giving-widget__button-currency currency">$</span
                ><span class="giving-widget__button-amount"></span>
                <span class="giving-widget__button-freq"></span>
            </div>
        </div>

        <?php } elseif (
            ($GLOBALS["userInfo"] &&
                in_array($GLOBALS["userInfo"], $GLOBALS["norway"])) ||
            $currency == "NOK"
        ) { ?>

        <div class="donate-new__giving-widget giving-widget">
            <div class="giving-widget__freq">
                <div class="giving-widget__freq-option giving-widget__freq-option--active" data-freq="once">
                    &nbsp;Once
                </div>
                <div
                    id="norwayMonthly"
                    class="giving-widget__freq-option"
                    data-freq="monthly"
                >
                    &nbsp;Monthly
                </div>
            </div>

            <h2 class="font-fk giving-widget__title">
                BECOME A <span class="color-red">GUARDIAN</span>
            </h2>

            <h2 class="font-fk giving-widget__title giving-widget__title--once">
                FUND <span class="color-red">FREEDOM</span>
            </h2>

            <p class="giving-widget__text giving-widget__top-text">
                <?php the_field('widget_guardian_text')?>
                GUARDIANS are part of our community of regular givers who know
                that rescue is not an event, it is a process. Let’s rebuild
                lives, together.
            </p>

            <p class="giving-widget__text giving-widget__top-text--once">
                <?php the_field('widget_once_text')?>
                ONCE are part of our community of regular givers who know
                that rescue is not an event, it is a process. Let’s rebuild
                lives, together.
            </p>


            <div class="giving-widget__options">
                <div
                    class="giving-widget__options-option"
                    data-amount="10"
                    data-amountmonthly="12"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 1"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 1 monthly"
                >
                    <span class="giving-widget__options-amount">10</span>
                    <span class="currency">Kr</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="25"
                    data-amountmonthly="27"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 2"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 2 monthly"
                >
                    <span class="giving-widget__options-amount">25</span>
                    <span class="currency">Kr</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="50"
                    data-amountmonthly="52"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 3"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 3 monthly"
                >
                    <span class="giving-widget__options-amount">50</span>
                    <span class="currency">Kr</span>
                </div>

                <div
                    class="giving-widget__options-option giving-widget__options-option--active"
                    data-amount="100"
                    data-amountmonthly="102"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 4"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 4 monthly"
                >
                    <span class="giving-widget__options-amount">100</span>
                    <span class="currency">Kr</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="250"
                    data-amountmonthly="252"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 5"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 5 monthly"
                >
                    <span class="giving-widget__options-amount">250</span>
                    <span class="currency">Kr</span>
                </div>

                <div
                    class="giving-widget__options-option giving-widget__options-option--custom"
                    data-amount="custom"
                    data-reason="Your giving could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 6"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 6 monthly"
                >
                    <span class="text">Custom<br />Amount</span>
                    
                    <input
                        id="customAmount"
                        style="display: none"
                        type="number"
                        name="customAmount"
                    />
                    <span class="currency currency--norway">Kr</span>
                </div>
            </div>

            <p class="giving-widget__text">
                <span class="color-red"
                    ><b
                        ><span class="giving-widget__text-amount">100</span><span class="giving-widget__text-currency">Kr</span
                        ></b
                    ></span
                >
                <span class="giving-widget__text-freq">monthly</span>
                <span id="reason"></span>
            </p>

            <div class="giving-widget__other-ways">
                <a>Other ways to give</a>
                <div class="giving-widget__other-ways-divider">|</div>
                <a id="changeCurrency">Change currency</a>
            </div>

            <div class="giving-widget__button">
                Donate
                <span class="giving-widget__button-amount">100</span><span class="giving-widget__button-currency currency">Kr</span
                >
                <span class="giving-widget__button-freq">monthly</span>
            </div>
        </div>
        <?php } else { ?>

        <div class="donate-new__giving-widget giving-widget">
            <div class="giving-widget__freq">
                <div class="giving-widget__freq-option" data-freq="once">
                    &nbsp;Once
                </div>
                <div
                    class="giving-widget__freq-option giving-widget__freq-option--active"
                    data-freq="monthly"
                >
                    &nbsp;Monthly
                </div>
            </div>

            <h2 class="font-fk giving-widget__title">
                BECOME A <span class="color-red">GUARDIAN</span>
            </h2>

            <h2 class="font-fk giving-widget__title giving-widget__title--once">
                FUND <span class="color-red">FREEDOM</span>
            </h2>

            <p class="giving-widget__text giving-widget__top-text">
                <?php the_field('widget_guardian_text')?>
                GUARDIANS are part of our community of regular givers who know
                that rescue is not an event, it is a process. Let’s rebuild
                lives, together.
            </p>

            <p class="giving-widget__text giving-widget__top-text--once">
                <?php the_field('widget_once_text')?>
                ONCE are part of our community of regular givers who know
                that rescue is not an event, it is a process. Let’s rebuild
                lives, together.
            </p>

            <div class="giving-widget__options">
                <div
                    class="giving-widget__options-option"
                    data-amount="10"
                    data-amountmonthly="12"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 1"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 1 monthly"
                >
                    <span class="currency">£</span
                    ><span class="giving-widget__options-amount">10</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="25"
                    data-amountmonthly="27"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 2"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 2 monthly"
                >
                    <span class="currency">£</span
                    ><span class="giving-widget__options-amount">25</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="50"
                    data-amountmonthly="52"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 3"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 3 monthly"
                >
                    <span class="currency">£</span
                    ><span class="giving-widget__options-amount">50</span>
                </div>

                <div
                    class="giving-widget__options-option giving-widget__options-option--active"
                    data-amount="100"
                    data-amountmonthly="102"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 4"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 4 monthly"
                >
                    <span class="currency">£</span
                    ><span class="giving-widget__options-amount">100</span>
                </div>

                <div
                    class="giving-widget__options-option"
                    data-amount="250"
                    data-amountmonthly="252"
                    data-reason="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 5"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 5 monthly"
                >
                    <span class="currency">£</span
                    ><span class="giving-widget__options-amount">250</span>
                </div>

                <div
                    class="giving-widget__options-option giving-widget__options-option--custom"
                    data-amount="custom"
                    data-reason="Your giving could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 6"
                    data-monthly="could help rescue a child from human trafficking by enabling our investigation team to locate children at risk 6 monthly"
                >
                    <span class="text">Custom<br />Amount</span>
                    <span class="currency">£</span>
                    <input
                        id="customAmount"
                        style="display: none"
                        type="number"
                        name="customAmount"
                    />
                </div>
            </div>

            <p class="giving-widget__text">
                <span class="color-red"
                    ><b
                        ><span class="giving-widget__text-currency">£</span
                        ><span class="giving-widget__text-amount">100</span></b
                    ></span
                >
                <span class="giving-widget__text-freq">monthly</span>
                <span id="reason"></span>
            </p>

            <div class="giving-widget__other-ways">
                <a>Other ways to give</a>
                <div class="giving-widget__other-ways-divider">|</div>
                <a id="changeCurrency">Change currency</a>
            </div>

            <div class="giving-widget__button">
                Donate
                <span class="giving-widget__button-currency currency">£</span
                ><span class="giving-widget__button-amount">100</span>
                <span class="giving-widget__button-freq">monthly</span>
            </div>
        </div>

        <?php } ?>

        <div class="donate-new__picture-description picture-description">
            <div class="picture-description__svg">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="42.3"
                    height="33.9"
                    viewBox="0 0 42.3 33.9"
                >
                    <g
                        id="Group_7286"
                        data-name="Group 7286"
                        transform="translate(-7377.063 -935.93)"
                    >
                        <g
                            id="Group_7284"
                            data-name="Group 7284"
                            transform="translate(7377.063 935.93)"
                        >
                            <path
                                id="Path_17202"
                                data-name="Path 17202"
                                d="M38.1,33.9H4.2A4.2,4.2,0,0,1,0,29.7V9A4.2,4.2,0,0,1,4.2,4.8H6.621A8.7,8.7,0,0,1,14.4,0H27.9a8.7,8.7,0,0,1,7.779,4.8H38.1A4.2,4.2,0,0,1,42.3,9V29.7a4.2,4.2,0,0,1-4.2,4.2ZM21.3,9.9a9.568,9.568,0,1,0,3.737.754A9.541,9.541,0,0,0,21.3,9.9ZM33,8.1a1.2,1.2,0,0,0-1.2,1.2v1.5A1.2,1.2,0,0,0,33,12h4.8A1.2,1.2,0,0,0,39,10.8V9.3a1.2,1.2,0,0,0-1.2-1.2Z"
                                transform="translate(0 0)"
                                fill="#212322"
                            />
                        </g>
                        <circle
                            id="Ellipse_1"
                            data-name="Ellipse 1"
                            cx="6.5"
                            cy="6.5"
                            r="6.5"
                            transform="translate(7392 949)"
                            fill="#212322"
                        />
                    </g>
                </svg>
            </div>
            <div class="picture-description__text">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua.
                </p>
            </div>
            <div class="picture-description__close"></div>
        </div>
    </div>
</div>

<?php
endwhile;
// end of the loop.
?>

<?php get_footer(); ?>