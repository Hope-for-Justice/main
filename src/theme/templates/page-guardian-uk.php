<?php

/**
 * Template Name: Guardian UK
 *
 * @package Hope_for_Justice_2021
 */

get_header('', array('page_class' => 'site--full')); ?>

<div style="font-size:2em;">
    <?php
    $campaignPassed = $_COOKIE["wordpress_hfjcampaign"];
    $urlWidget = $_GET["wid"];

    $matched_widget;
    if (have_rows('campaigns_and_widgets')) :
        while (have_rows('campaigns_and_widgets')) : the_row();
            $campaign = get_sub_field('campaign_name');
            $widget = get_sub_field('widget_id');

            if ($campaignPassed == $campaign) {
                $matched_widget = $widget;
            }



        endwhile;
    endif;

    if ($urlWidget) :
        $matched_widget = $urlWidget;
    endif;

    ?>


</div>


<div class="main site-main donorfy-donate">
    <div class="donorfy-donate__grid">
        <div class="grid donorfy-donate__inner-grid">

            <div class="donorfy-donate__forms">

                <div class="donorfy-donate__dots">
                    <div id="dotOne" class="donorfy-donate__dot donorfy-donate__dot--active"></div>
                    <div id="dotTwo" class="donorfy-donate__dot"></div>
                    <div id="dotThree" class="donorfy-donate__dot"></div>
                    <div id="dotFour" class="donorfy-donate__dot"></div>
                </div>

                <!-- <form method="post" id="DirectDebitForm"> -->
                <form id="formOne">

                    <div class="donorfy-donate__giving-text">
                        You’re giving £<span id="textAmount"><?php echo $_GET['Amount'] ?></span> monthly
                        <a id="changeAmount">Change amount</a>
                    </div>
                    <h2 class="font-canela">Your details:</h2>

                    <div class="donorfy-donate__amount donorfy-donate__input donorfy-donate__amount--uk">
                        <label class="donorfy-donate__hidden" for="Amount">Amount I would like to give each month</label>
                        <input type="text" name="Amount" class="required numberOnly" id="Amount" maxlength="10" title="Please enter the amount you want to give - don't include the pound sign" <?php if ($_GET['Amount']) { ?> value="<?php echo $_GET['Amount'] ?>" <?php } ?>>
                    </div>

                    <label class="donorfy-donate__hidden" for="Title">Title</label>

                    <div class="donorfy-donate__select">
                        <select type="text" name="Title" id="Title">
                            <option value="">-- Title (Optional) --</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Miss">Miss</option>
                            <option value="Ms">Ms</option>
                            <option value="Dr">Dr</option>
                            <option value="Bishop">Bishop</option>
                            <option value="Friar">Friar</option>
                            <option value="Councillor">Councillor</option>
                            <option value="Professor">Professor</option>
                            <option value="Sir">Sir</option>
                            <option value="Lady">Lady</option>
                            <!-- <option value="Rev">None of the above</option>      -->
                        </select>
                    </div>

                    <div class="donorfy-donate__flex">
                        <div class="donorfy-donate__input">
                            <label class="donorfy-donate__hidden" for="FirstName">First Name*</label>
                            <input type="text" name="FirstName" class="required" id="FirstName" maxlength="50" placeholder="First Name">
                        </div>
                        <div class="donorfy-donate__input">
                            <label class="donorfy-donate__hidden" for="LastName">Last Name*</label>
                            <input type="text" name="LastName" class="required" id="LastName" maxlength="50" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="donorfy-donate__input">
                        <label class="donorfy-donate__hidden" for="Email">Email*</label>
                        <input type="text" name="Email" class="required" type="email" id="Email" maxlength="50" placeholder="Email">
                    </div>

                    <div class="donorfy-donate__input">
                        <label class="donorfy-donate__hidden" for="Phone">Phone</label>
                        <input type="text" name="Phone" class="required numberOnly" id="Phone" maxlength="50" placeholder="Phone">
                    </div>

                    <label for="paymentDay">On what date each month would you like your payment to be taken?</label>
                    <div class="donorfy-donate__select">
                        <select type="text" class="required" name="paymentDay" id="paymentDay">
                            <option value="">-- Select date --</option>
                            <option value="1">1st</option>
                            <option value="15">15th</option>
                            <option value="25">25th</option>
                            <option value="30">30th</option>
                        </select>
                    </div>

                    <p style="margin-bottom: 20px;">Please note: The exact date that your gift will be taken by Direct Debit can depend on your bank and other factors, including weekends and bank holidays.</p>

                    <div id="toStepTwo" class="button button--spinner">Next</div>
                </form>

                <form id="formTwo">
                    <h2 class="font-canela">Address details:</h2>

                    <p class="donorfy-donate__larger donorfy-donate__larger--mb">
                        We need this to set up your monthly Direct Debit gift. We will not send you anything in the post unless you choose to hear from us in this way.
                    </p>

                    <div class="donorfy-donate__input">
                        <label class="donorfy-donate__hidden" for="Address1">Address</label>
                        <input type="text" name="Address1" class="required" id="Address1" maxlength="50" placeholder="Address 1">
                    </div>

                    <div class="donorfy-donate__input">
                        <input type="text" name="Address2" class="" id="Address2" maxlength="50" placeholder="Address 2 (optional)">
                    </div>

                    <div class="donorfy-donate__flex">
                        <div class="donorfy-donate__input">
                            <label class="donorfy-donate__hidden" for="Town">Town</label>
                            <input type="text" name="Town" class="required" id="Town" maxlength="50" placeholder="Town/City">
                        </div>

                        <div class="donorfy-donate__input">
                            <label class="donorfy-donate__hidden" for="Postcode">Postcode</label>
                            <input type="text" name="Postcode" class="required" id="Postcode" maxlength="10" placeholder="Postcode">
                        </div>
                    </div>

                    <label class="donorfy-donate__hidden" for="County">County</label>
                    <input class="donorfy-donate__hidden" type="text" name="County" class="" id="County" maxlength="50">

                    <div class="donorfy-donate__select">
                        <select name="Country" class="required" id="Country" placeholder="Country">
                            <option disabled value=""> -- Country select -- </option>
                            <option selected value="United Kingdom">United Kingdom</option>
                        </select>
                    </div>

                    <div class="donorfy-donate__buttons">
                        <div id="backToStepOne" class="button button--white button--spinner">Previous</div>
                        <div id="toStepThree" class="button button--spinner">Next</div>
                    </div>
                </form>

                <!-- form 3 -->
                <form id="formThree">
                    <h2 class="font-canela">Gift Aid:</h2>

                    <p class="donorfy-donate__larger donorfy-donate__larger--mb">Boost your monthly gifts by 25p for every £1 you donate, at no extra cost to you. Do you want to Gift Aid your monthly donation?</p>

                    <div class="donorfy-donate__select">
                        <select id="GiftAidSelect" class="required">
                            <option value="">-- Select option --</option>
                            <option value="true">Yes please</option>
                            <option value="false">No thank you</option>
                        </select>
                    </div>

                    <p class="donorfy-donate__small-text">
                        <br>
                        Please add Gift Aid to all donations I’ve made to Hope for Justice in the past four years and all donations in future until I notify Hope for Justice otherwise.
                        <br><br>
                        By selecting 'Yes', I confirm that I am a UK taxpayer and understand that if I pay less Income Tax and/or Capital Gains Tax than the amount of Gift Aid claimed on all my donations in the tax year, it is my responsibility to pay any difference. I confirm that this is my own money and I am not paying over donations made by third parties such as monies collected at an event, a company donation or a donation from a friend or family member. I am not receiving anything in return for my donation such as a book, prize or ticket. I am not making a donation as part of a sweepstake, raffle or lottery.
                    </p>

                    <div class="donorfy-donate__buttons">
                        <div id="backToStepTwo" class="button button--spinner button--white">Previous</div>
                        <div id="toStepFour" class="button button--spinner">Next</div>
                    </div>
                </form>

                <!-- form 4 -->
                <form id="formFour">

                    <h2 class="font-canela">Hear about your impact:</h2>
                    <p class="donorfy-donate__larger donorfy-donate__preferences-preview-text"><span id="preferenceText">We would love for you to hear about the life-changing difference that your donation will make and more ways you can support this work. Can we contact you via:</span> <span style="display: none; text-decoration: underline; font-weight: bold;" id="emailText">james.holt@hopeforjustice.org</span> <span id="emailAppend">for how we can contact you about the work of Hope for Justice and how your support is making a difference:</span></p>

                    <div class="donorfy-donate__preferences">
                        <div class="donorfy-donate__preference">
                            <p class="donorfy-donate__select-text">Email:</p>
                            <div class="donorfy-donate__select donorfy-donate__select--preference">
                                <select id="emailSelect" class="required" name="emailSelect">
                                    <option value="">Select</option>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="donorfy-donate__preference">
                            <p class="donorfy-donate__select-text">Post:</p>
                            <div class="donorfy-donate__select donorfy-donate__select--preference">
                                <select id="postSelect" class="required" name="postSelect">
                                    <option value="">Select</option>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="donorfy-donate__preference">
                            <p class="donorfy-donate__select-text">SMS:</p>
                            <div class="donorfy-donate__select donorfy-donate__select--preference">
                                <select id="smsSelect" class="required" name="smsSelect">
                                    <option value="">Select</option>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="donorfy-donate__preference">
                            <p class="donorfy-donate__select-text">Phone:</p>
                            <div class="donorfy-donate__select donorfy-donate__select--preference">
                                <select id="phoneSelect" class="required" name="phoneSelect">
                                    <option value="">Select</option>
                                    <option value="true">Yes</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <p class="donorfy-donate__small-text">
                        <span style="display: none;" id="emailNo">
                            <br>
                            By choosing ‘No’ to email, you will receive no further emails from Hope for Justice about the impact of your giving or the fight against modern slavery and human trafficking. We will still send you emails when necessary for administrative reasons, including a receipt confirming your Direct Debit details.
                            <br>
                        </span>
                        <br>
                        Select 'Yes' if you wish Hope for Justice to contact you via that method for the following purposes: To keep you informed of our ongoing activities, news, campaigns and appeals; and to invite you to events we think might interest you. You can unsubscribe from receiving communications at any time, or change your preferences, at: <a>hopeforjustice.org/manage-your-preferences</a>
                        <br><br>
                        We will always store your personal information securely. We will use it to provide the service(s) you have requested, and communicate with you in the way(s) you have agreed to. We will only allow your information to be used by third parties working on our behalf. We will share your information if required to do so by law. For details see our <a>Privacy Policy</a>.
                    </p>

                    <label class="donorfy-donate__hidden" for="inspiration_question">What inspired you to give?</label>
                    <div class="donorfy-donate__select">
                        <select name="inspiration_question" id="inspiration_question">
                            <option value="">What inspired you to give? (optional)</option>
                            <option value="Inspiration_Faith">Faith based</option>
                            <option value="Inspiration_SocialMedia">Social media</option>
                            <option value="Inspiration_StaffContact">I know a Hope for Justice staff member/ volunteer</option>
                            <option value="Inspiration_Celebration">Gift of celebration</option>
                            <option value="Inspiration_Cause">Passion to end modern slavery</option>
                            <option value="Inspiration_Event">Event or talk</option>
                            <option value="Inspiration_Other">Other</option>
                        </select>
                    </div>

                    <div class="donorfy-donate__input donorfy-donate__comment">
                        <textarea rows="2" cols="40" class="" name="Comment" id="Comment" placeholder="Tell us more"></textarea>
                    </div>

                    <h3 class="donorfy-donate__summary-title">Giving Summary</h3>
                    <div class="donorfy-donate__summary-hr">
                        <hr>
                    </div>
                    <div class="donorfy-donate__summary-text">
                        Donation total: <b>£<span id="donationTotalConfirm"><?php echo $_GET['Amount'] ?></span></b>
                        <br>
                        Giving frequency: <b><span id="givingFrequencyConfirm">Monthly direct debit</span></b>
                        <br>
                        Gift Aid: <b><span id="giftAidConfirm">Yes</span></b>
                    </div>

                    <div class="donorfy-donate__hidden">
                        <input id="emailPreference" type="checkbox" value="2" class="KeepInTouch">
                        <input id="postPreference" type="checkbox" value="4" class="KeepInTouch">
                        <input id="smsPreference" type="checkbox" value="8" class="KeepInTouch">
                        <input id="phonePreference" type="checkbox" value="16" class="KeepInTouch">
                    </div>

                    <!-- <label class="donorfy-donate__hidden" for="Comment">Comments</label>
                    <textarea rows="2" cols="40" class="" name="Comment" id="Comment" title="Optional comments you may wish to make regarding this payment"></textarea>
                     -->


                    <div id="ErrorContainer" style="display:none" class="ErrorContainer">
                        There is a problem with your payment -
                        <div id="Errors"></div>
                    </div>
                    <!-- <div id="PleaseWait" style="display:none">Please wait ...</div> -->

                    <div class="donorfy-donate__buttons">
                        <div id="backToStepThree" class="button button--white button--spinner">Previous</div>
                        <div id="submitButton" class="button button--spinner">Set up Direct Debit</div>
                    </div>

                    <!-- Hidden fields for tags --->
                    <input type="hidden" id="ActiveTags" value="" />
                    <input type="hidden" id="BlockedTags" value="" />
                    <!-- Do not change these values --->
                    <input type="hidden" id="TenantCode" value="GO66X0NEL4" />

                    <input type="hidden" id="currency" value="GBP" />
                    <input type="hidden" id="type" value="UK+Guardian" />
                    <input type="hidden" id="zapierUrl" value="https://hooks.zapier.com/hooks/catch/8597852/bk64mw8/">


                    <input type="hidden" id="WidgetId" value="<?php if ($matched_widget) {
                                                                    echo $matched_widget;
                                                                } else {
                                                                    echo 'e170a6bc-383e-6f05-b282-ff00004460b4';
                                                                } ?>" />

                    <div id="PaymentScheduleRow" style="display:none;">
                        <label class="" for="MonthlyPayment">I would like to donate*</label><br>
                        <label><span>Monthly</span><input type="radio" id="MonthlyPayment" name="PaymentSchedule" value="Monthly" checked="checked"></label><label><span>Quarterly</span><input type="radio" id="QuarterlyPayment" name="PaymentSchedule" value="Quarterly"></label><label><span>Annually</span><input type="radio" id="AnnualPayment" name="PaymentSchedule" value="Annually"></label>
                    </div>

                    <div style="display:none;">

                        <label class="" for="AccountNumber">Account Number*</label><br>
                        <input type="text" id="AccountNumber" name="AccountNumber" class="digits numberOnly" value="" maxlength="8" size="10" title="Account Number is required" />

                    </div>

                    <div style="display:none;">

                        <label class="" for="SortCode1">Sort Code*</label><br>
                        <input type="text" id="SortCode1" name="SortCode1" class="digits numberOnly" maxlength="2" size="2" title="Sort Code is required" /><span>-</span><input type="text" id="SortCode2" name="SortCode2" class="digits numberOnly" maxlength="2" size="2" title="Sort Code is required" /><span>-</span><input type="text" id="SortCode3" name="SortCode3" class="digits numberOnly" maxlength="2" size="2" title="Sort Code is required" />
                    </div>

                    <div class="donorfy-donate__hidden">
                        <input id="GiftAid" type="checkbox" />
                    </div>

                </form>


            </div>

            <div class="donorfy-donate__secure">
                <svg xmlns="http://www.w3.org/2000/svg" width="10.667" height="14" viewBox="0 0 10.667 14">
                    <g id="Group_7324" data-name="Group 7324" transform="translate(-160 -720)">
                        <g id="Group_7323" data-name="Group 7323" transform="translate(160 720)">
                            <path id="Path_17203" data-name="Path 17203" d="M2,0H8.667a2,2,0,0,1,2,2V7.333a2,2,0,0,1-2,2H2a2,2,0,0,1-2-2V2A2,2,0,0,1,2,0Z" transform="translate(0 4.667)" fill="#212322" />
                            <path id="Union_1" data-name="Union 1" d="M5.333,7.334V3.467a2.072,2.072,0,0,0-2-2.134,2.072,2.072,0,0,0-2,2.134V7.334h4M6.666,8.667H0v-5.2A3.4,3.4,0,0,1,3.333,0,3.4,3.4,0,0,1,6.666,3.467Z" transform="translate(2 0)" fill="#212322" />
                        </g>
                    </g>
                </svg>
                <div>SSL Secure donation</div>
            </div>

        </div><!-- /inner-grid -->
        <div style="background-image: url(https://hopeforjustice.org/wp-content/uploads/2022/05/donate-pic.jpg);" class="donorfy-donate__photo">
            <!-- replace with responsive image markup -->
            <h3 class="donorfy-donate__photo-text font-canela">End Slavery.<br>Change Lives.</h3>
        </div>

    </div><!-- /grid -->
</div>

<?php get_footer(); ?>