<?php

/**
 * Template Name: Donate new
 *
 * @package Hope_for_Justice_2021
 */

get_header("", ["page_class" =>
"site--full"]);

$currency = $_GET["Currency"];
$default_form = true;

?>

<?php while (have_posts()) :
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

    <main class="main site-main donate-new">
        <div class="full-grid">
            <div class="donate-new__hero-image donate-new__hero-image--main">
                <img src="<?php echo $src[0]; ?>" srcset="<?php echo $srcset; ?>" alt="" />
            </div>
            <div class="donate-new__hero-image donate-new__hero-image--hidden donate-new__hero-image--alt">
                <img <?php acf_responsive_image(get_field('alternate_image'), 'full', '100vw'); ?> alt="" />
            </div>

            <!-- giving widget -->
            <?php if (($GLOBALS["userInfo"] && in_array($GLOBALS["userInfo"], $GLOBALS["usa"])) || $currency == 'USD') { ?>

                <?php if ($currency != 'NOK' && $currency != 'GBP') { ?>

                    <!-- USA -->
                    <div data-currency="USD" class="donate-new__giving-widget giving-widget">
                        <div class="giving-widget__freq">
                            <div class="giving-widget__freq-option" data-freq="once">
                                &nbsp;Once
                            </div>
                            <div class="giving-widget__freq-option giving-widget__freq-option--active" data-freq="monthly">
                                &nbsp;Monthly
                            </div>
                        </div>

                        <h2 class="font-fk giving-widget__title">
                            <?php the_field('usa_widget_guardian_title') ?>

                        </h2>

                        <h2 class="font-fk giving-widget__title giving-widget__title--once">
                            <?php the_field('usa_widget_once_title') ?>
                        </h2>

                        <p class="giving-widget__text giving-widget__top-text">
                            <?php the_field('usa_widget_guardian_text') ?>

                        </p>

                        <p class="giving-widget__text giving-widget__top-text--once">
                            <?php the_field('usa_widget_once_text') ?>

                        </p>

                        <div class="giving-widget__options">
                            <div class="giving-widget__options-option" data-amount="<?php the_field('usa_widget_option_1_amount') ?>" data-amountmonthly="<?php the_field('usa_widget_option_1_amount_monthly') ?>" data-reason="<?php the_field('usa_widget_option_1_reason') ?>" data-monthly="<?php the_field('usa_widget_option_1_reason_monthly') ?>">
                                <span class="currency">$</span><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_1_amount_monthly') ?></span>
                            </div>

                            <div class="giving-widget__options-option" data-amount="<?php the_field('usa_widget_option_2_amount') ?>" data-amountmonthly="<?php the_field('usa_widget_option_2_amount_monthly') ?>" data-reason="<?php the_field('usa_widget_option_2_reason') ?>" data-monthly="<?php the_field('usa_widget_option_2_reason_monthly') ?>">
                                <span class="currency">$</span><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_2_amount_monthly') ?></span>
                            </div>

                            <div class="giving-widget__options-option" data-amount="<?php the_field('usa_widget_option_3_amount') ?>" data-amountmonthly="<?php the_field('usa_widget_option_3_amount_monthly') ?>" data-reason="<?php the_field('usa_widget_option_3_reason') ?>" data-monthly="<?php the_field('usa_widget_option_3_reason_monthly') ?>">
                                <span class="currency">$</span><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_3_amount_monthly') ?></span>
                            </div>

                            <div class="giving-widget__options-option giving-widget__options-option--active" data-amount="<?php the_field('usa_widget_option_4_amount') ?>" data-amountmonthly="<?php the_field('usa_widget_option_4_amount_monthly') ?>" data-reason="<?php the_field('usa_widget_option_4_reason') ?>" data-monthly="<?php the_field('usa_widget_option_4_reason_monthly') ?>">
                                <span class="currency">$</span><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_4_amount_monthly') ?></span>
                            </div>

                            <div class="giving-widget__options-option" data-amount="<?php the_field('usa_widget_option_5_amount') ?>" data-amountmonthly="<?php the_field('usa_widget_option_5_amount_monthly') ?>" data-reason="<?php the_field('usa_widget_option_5_reason') ?>" data-monthly="<?php the_field('usa_widget_option_5_reason_monthly') ?>">
                                <span class="currency">$</span><span class="giving-widget__options-amount"><?php the_field('usa_widget_option_5_amount_monthly') ?></span>
                            </div>

                            <div class="giving-widget__options-option giving-widget__options-option--custom" data-amount="custom" data-reason="<?php the_field('usa_widget_option_6_reason') ?>" data-monthly="<?php the_field('usa_widget_option_6_reason_monthly') ?>">
                                <span class="text">Custom<br />Amount</span>
                                <span class="currency">$</span>
                                <input id="customAmount" style="display: none" type="number" name="customAmount" />
                            </div>
                        </div>

                        <p class="giving-widget__text">
                            <span class="color-red"><b><span class="giving-widget__text-currency">USD $</span><span class="giving-widget__text-amount"></span></b></span>
                            <span class="giving-widget__text-freq">monthly</span>
                            <span id="reason"></span>
                        </p>

                        <div class="giving-widget__other-ways">
                            <a href="<?php the_field('usa_widget_other_ways_link') ?>">Other ways to give</a>
                            <div class="giving-widget__other-ways-divider">|</div>
                            <a data-toggle="modal" data-target="#modal" id="changeCurrency">Change currency</a>
                        </div>

                        <div class="giving-widget__button">
                            Donate
                            <span class="giving-widget__button-currency currency">USD $</span><span class="giving-widget__button-amount"></span>
                            <span class="giving-widget__button-freq"></span>
                        </div>
                    </div>

                    <?php $default_form = false; ?>

                <?php } ?>

            <?php } ?>

            <?php if (($GLOBALS["userInfo"] && in_array($GLOBALS["userInfo"], $GLOBALS["norway"])) || $currency == 'NOK') { ?>

                <?php if ($currency != 'USD' && $currency != 'GBP') { ?>

                    <!-- Norway -->
                    <div data-currency="NOK" class="donate-new__giving-widget giving-widget">
                        <div class="giving-widget__freq">
                            <div class="giving-widget__freq-option giving-widget__freq-option--active" data-freq="once">
                                &nbsp;Once
                            </div>
                            <div id="norwayMonthly" class="giving-widget__freq-option" data-freq="monthly" data-link="<?php the_field('no_widget_monthly_link') ?>">
                                &nbsp;Monthly
                            </div>
                        </div>

                        <h2 class="font-fk giving-widget__title">
                            <?php the_field('no_widget_once_title') ?>

                        </h2>

                        <h2 class="font-fk giving-widget__title giving-widget__title--once">
                            <?php the_field('no_widget_once_title') ?>
                        </h2>

                        <p class="giving-widget__text giving-widget__top-text">
                            <?php the_field('no_widget_once_text') ?>

                        </p>

                        <p class="giving-widget__text giving-widget__top-text--once">
                            <?php the_field('no_widget_once_text') ?>

                        </p>

                        <div class="giving-widget__options">
                            <div class="giving-widget__options-option" data-amount="<?php the_field('no_widget_option_1_amount') ?>" data-amountmonthly="<?php the_field('no_widget_option_1_amount') ?>" data-reason="<?php the_field('no_widget_option_1_reason') ?>" data-monthly="<?php the_field('no_widget_option_1_reason') ?>">
                                <span class="giving-widget__options-amount"><?php the_field('no_widget_option_1_amount') ?></span><span class="currency">Kr</span>
                            </div>

                            <div class="giving-widget__options-option" data-amount="<?php the_field('no_widget_option_2_amount') ?>" data-amountmonthly="<?php the_field('no_widget_option_2_amount') ?>" data-reason="<?php the_field('no_widget_option_2_reason') ?>" data-monthly="<?php the_field('no_widget_option_2_reason') ?>">
                                <span class="giving-widget__options-amount"><?php the_field('no_widget_option_2_amount') ?></span><span class="currency">Kr</span>
                            </div>

                            <div class="giving-widget__options-option" data-amount="<?php the_field('no_widget_option_3_amount') ?>" data-amountmonthly="<?php the_field('no_widget_option_3_amount') ?>" data-reason="<?php the_field('no_widget_option_3_reason') ?>" data-monthly="<?php the_field('no_widget_option_3_reason') ?>">
                                <span class="giving-widget__options-amount"><?php the_field('no_widget_option_3_amount') ?></span><span class="currency">Kr</span>
                            </div>

                            <div class="giving-widget__options-option giving-widget__options-option--active" data-amount="<?php the_field('no_widget_option_4_amount') ?>" data-amountmonthly="<?php the_field('no_widget_option_4_amount') ?>" data-reason="<?php the_field('no_widget_option_4_reason') ?>" data-monthly="<?php the_field('no_widget_option_4_reason') ?>">
                                <span class="giving-widget__options-amount"><?php the_field('no_widget_option_4_amount') ?></span><span class="currency">Kr</span>
                            </div>

                            <div class="giving-widget__options-option" data-amount="<?php the_field('no_widget_option_5_amount') ?>" data-amountmonthly="<?php the_field('no_widget_option_5_amount') ?>" data-reason="<?php the_field('no_widget_option_5_reason') ?>" data-monthly="<?php the_field('no_widget_option_5_reason') ?>">
                                <span class="giving-widget__options-amount"><?php the_field('no_widget_option_5_amount') ?></span><span class="currency">Kr</span>
                            </div>

                            <div class="giving-widget__options-option giving-widget__options-option--custom" data-amount="custom" data-reason="<?php the_field('no_widget_option_6_reason') ?>" data-monthly="<?php the_field('no_widget_option_6_reason') ?>">
                                <span class="text">Custom<br />Amount</span>

                                <input id="customAmount" style="display: none" type="text" name="customAmount" class="customAmountNorway" />
                                <span class="currency currency--norway">Kr</span>
                            </div>
                        </div>

                        <p class="giving-widget__text">
                            <span class="color-red"><b><span class="giving-widget__text-amount">100</span><span class="giving-widget__text-currency">Kr</span></b></span>
                            <span id="reason"></span>
                        </p>

                        <div class="giving-widget__other-ways">
                            <a href="<?php the_field('no_widget_other_ways_link') ?>">Other ways to give</a>
                            <div class="giving-widget__other-ways-divider">|</div>
                            <a data-toggle="modal" data-target="#modal" id="changeCurrency">Change currency</a>
                        </div>

                        <div class="giving-widget__button">
                            Donate
                            <span class="giving-widget__button-amount"></span><span class="giving-widget__button-currency currency">Kr</span>
                            <span class="giving-widget__button-freq"></span>
                        </div>
                    </div>

                    <?php $default_form = false; ?>

                <?php } ?>

            <?php } ?>

            <?php if ($default_form) { ?>

                <!-- (else) UK + others -->
                <div data-currency="GBP" class="donate-new__giving-widget giving-widget">
                    <div class="giving-widget__freq">
                        <div class="giving-widget__freq-option" data-freq="once">
                            &nbsp;Once
                        </div>
                        <div class="giving-widget__freq-option giving-widget__freq-option--active" data-freq="monthly">
                            &nbsp;Monthly
                        </div>
                    </div>

                    <h2 class="font-fk giving-widget__title">
                        <?php the_field('uk_widget_guardian_title') ?>

                    </h2>

                    <h2 class="font-fk giving-widget__title giving-widget__title--once">
                        <?php the_field('uk_widget_once_title') ?>
                    </h2>

                    <p class="giving-widget__text giving-widget__top-text">
                        <?php the_field('uk_widget_guardian_text') ?>

                    </p>

                    <p class="giving-widget__text giving-widget__top-text--once">
                        <?php the_field('uk_widget_once_text') ?>

                    </p>

                    <div class="giving-widget__options">
                        <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_1_amount') ?>" data-amountmonthly="<?php the_field('uk_widget_option_1_amount_monthly') ?>" data-reason="<?php the_field('uk_widget_option_1_reason') ?>" data-monthly="<?php the_field('uk_widget_option_1_reason_monthly') ?>">
                            <span class="currency">£</span><span class="giving-widget__options-amount"><?php the_field('uk_widget_option_1_amount_monthly') ?></span>
                        </div>

                        <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_2_amount') ?>" data-amountmonthly="<?php the_field('uk_widget_option_2_amount_monthly') ?>" data-reason="<?php the_field('uk_widget_option_2_reason') ?>" data-monthly="<?php the_field('uk_widget_option_2_reason_monthly') ?>">
                            <span class="currency">£</span><span class="giving-widget__options-amount"><?php the_field('uk_widget_option_2_amount_monthly') ?></span>
                        </div>

                        <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_3_amount') ?>" data-amountmonthly="<?php the_field('uk_widget_option_3_amount_monthly') ?>" data-reason="<?php the_field('uk_widget_option_3_reason') ?>" data-monthly="<?php the_field('uk_widget_option_3_reason_monthly') ?>">
                            <span class="currency">£</span><span class="giving-widget__options-amount"><?php the_field('uk_widget_option_3_amount_monthly') ?></span>
                        </div>

                        <div class="giving-widget__options-option giving-widget__options-option--active" data-amount="<?php the_field('uk_widget_option_4_amount') ?>" data-amountmonthly="<?php the_field('uk_widget_option_4_amount_monthly') ?>" data-reason="<?php the_field('uk_widget_option_4_reason') ?>" data-monthly="<?php the_field('uk_widget_option_4_reason_monthly') ?>">
                            <span class="currency">£</span><span class="giving-widget__options-amount"><?php the_field('uk_widget_option_4_amount_monthly') ?></span>
                        </div>

                        <div class="giving-widget__options-option" data-amount="<?php the_field('uk_widget_option_5_amount') ?>" data-amountmonthly="<?php the_field('uk_widget_option_5_amount_monthly') ?>" data-reason="<?php the_field('uk_widget_option_5_reason') ?>" data-monthly="<?php the_field('uk_widget_option_5_reason_monthly') ?>">
                            <span class="currency">£</span><span class="giving-widget__options-amount"><?php the_field('uk_widget_option_5_amount_monthly') ?></span>
                        </div>

                        <div class="giving-widget__options-option giving-widget__options-option--custom" data-amount="custom" data-reason="<?php the_field('uk_widget_option_6_reason') ?>" data-monthly="<?php the_field('uk_widget_option_6_reason_monthly') ?>">
                            <span class="text">Custom<br />Amount</span>
                            <span class="currency">£</span>
                            <input id="customAmount" style="display: none" type="number" name="customAmount" />
                        </div>
                    </div>

                    <p class="giving-widget__text">
                        <span class="color-red"><b><span class="giving-widget__text-currency">£</span><span class="giving-widget__text-amount"></span></b></span>
                        <span class="giving-widget__text-freq">monthly</span>
                        <span id="reason"></span>
                    </p>

                    <div class="giving-widget__other-ways">
                        <a href="<?php the_field('uk_widget_other_ways_link') ?>">Other ways to give</a>
                        <div class="giving-widget__other-ways-divider">|</div>
                        <a data-toggle="modal" data-target="#modal" id="changeCurrency">Change currency</a>
                    </div>

                    <div class="giving-widget__button">
                        Donate
                        <span class="giving-widget__button-currency currency">£</span><span class="giving-widget__button-amount"></span>
                        <span class="giving-widget__button-freq"></span>
                    </div>
                </div>

            <?php } ?>

            <div style="display: none;" class="donate-new__picture-description picture-description">
                <div class="picture-description__svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="42.3" height="33.9" viewBox="0 0 42.3 33.9">
                        <g id="Group_7286" data-name="Group 7286" transform="translate(-7377.063 -935.93)">
                            <g id="Group_7284" data-name="Group 7284" transform="translate(7377.063 935.93)">
                                <path id="Path_17202" data-name="Path 17202" d="M38.1,33.9H4.2A4.2,4.2,0,0,1,0,29.7V9A4.2,4.2,0,0,1,4.2,4.8H6.621A8.7,8.7,0,0,1,14.4,0H27.9a8.7,8.7,0,0,1,7.779,4.8H38.1A4.2,4.2,0,0,1,42.3,9V29.7a4.2,4.2,0,0,1-4.2,4.2ZM21.3,9.9a9.568,9.568,0,1,0,3.737.754A9.541,9.541,0,0,0,21.3,9.9ZM33,8.1a1.2,1.2,0,0,0-1.2,1.2v1.5A1.2,1.2,0,0,0,33,12h4.8A1.2,1.2,0,0,0,39,10.8V9.3a1.2,1.2,0,0,0-1.2-1.2Z" transform="translate(0 0)" fill="#212322" />
                            </g>
                            <circle id="Ellipse_1" data-name="Ellipse 1" cx="6.5" cy="6.5" r="6.5" transform="translate(7392 949)" fill="#212322" />
                        </g>
                    </svg>
                </div>
                <div class="picture-description__text">
                    <p>
                        Photo shows the joyful moment that a family in Ethiopia were reunited as Hope for Justice brought their daughter home to them.
                    </p>
                </div>
                <div class="picture-description__close"></div>
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