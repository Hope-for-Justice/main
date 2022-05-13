<?php

/**
 * Template Name: Guardian UK
 *
 * @package Hope_for_Justice_2021
 */

get_header('', array( 'page_class' => 'site--full') ); ?>

<div style="font-size:2em;">
<?php 
$campaignPassed = $_COOKIE["wordpress_hfjcampaign"];

echo "campaign cookie: ";
echo $campaignPassed;
echo "<p><br></p>";

$matched_widget;
if( have_rows('campaigns_and_widgets') ):
while ( have_rows('campaigns_and_widgets') ) : the_row();
    $campaign = get_sub_field('campaign_name');
    $widget = get_sub_field('widget_id');

    if($campaignPassed == $campaign) {
        $matched_widget = $widget;
    }

    
    
endwhile;
else :
    // no rows found
endif; 

if ($matched_widget) {
  echo $matched_widget;  
} else {
  echo "e170a6bc-383e-6f05-b282-ff00004460b4";
}

?>


</div>


<div class="main site-main donorfy-donate">
    <div class="full-grid">

        <div class="donorfy-donate__forms">

            <!-- <form method="post" id="DirectDebitForm"> -->
            <form id="formOne">
                <h2>Donation details:</h2>

                <div class="donorfy-donate__amount donorfy-donate__input donorfy-donate__amount--uk">
                   <label class="donorfy-donate__hidden" for="Amount">Amount I would like to give each month</label>
                    <input type="text" name="Amount" class="required numberOnly" id="Amount" maxlength="10" title="Please enter the amount you want to give - don't include the pound sign" 
                    <?php if($_GET['Amount']){ ?> 
                        value="<?php echo $_GET['Amount']?>" 
                    <?php } ?>>   
                </div>

                <label for="paymentDay">Payment day:</label>
                <div class="donorfy-donate__select">
                    <select type="text" class="required" name="paymentDay" id="paymentDay">
                        <option value="">-- Select option--</option>
                        <option value="1">1</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="30">30</option>        
                    </select>
                </div>
                
                            
                <label class="donorfy-donate__hidden" for="Title">Title</label>

                <div class="donorfy-donate__select">
                    <select type="text" name="Title" id="Title">
                        <option value="">-- Title (Optional) --</option>
                        <option value="Mrs">Mrs.</option>
                        <option value="Miss">Miss</option>
                        <option value="Ms">Ms.</option>
                        <option value="Mr">Mr.</option>
                        <option value="Dr">Dr.</option>
                        <option value="Professor">Professor</option>
                        <option value="Rev">None of the above</option>              
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

                <div id="toStepTwo" class="button">Next</div>
            </form>
                
            <form id="formTwo">
                <h2>Address details:</h2>
                
                <div class="donorfy-donate__input">
                    <label class="donorfy-donate__hidden" for="Address1">Address</label>
                    <input type="text" name="Address1" class="required" id="Address1" maxlength="50" placeholder="Address 1">
                </div>

                <div class="donorfy-donate__input">
                    <input type="text" name="Address2" class="" id="Address2" maxlength="50" placeholder="Address 2">
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

                <div class="donorfy-donate__buttons">
                    <div id="backToStepOne" class="button button--white">Previous</div>
                    <div id="toStepThree" class="button">Next</div>
                </div>
            </form>

            <form id="DirectDebitForm">
                
                <h2>Gift Aid:</h2>

                <div class="donorfy-donate__select">
                    <select id="GiftAidSelect" class="required">
                        <option value="">-- Select option --</option>
                        <option value="true">Yes please</option>
                        <option value="false">No thank you</option>
                    </select>
                </div>
                <p class="donorfy-donate__larger"><b>Hope for Justice will claim 25p on every £1 I donate.</b></p>
                <p>
                    <br>
                    Please add Gift Aid to all donations I’ve made to Hope for Justice in the past four years and all donations in future until I notify Hope for Justice otherwise.
                    <br><br>
                    By selecting 'Yes', I confirm that I am a UK taxpayer and understand that if I pay less Income Tax and/or Capital Gains Tax than the amount of Gift Aid claimed on all my donations in the tax year, it is my responsibility to pay any difference. I confirm that this is my own money and I am not paying over donations made by third parties such as monies collected at an event, a company donation or a donation from a friend or family member. I am not receiving anything in return for my donation such as a book, prize or ticket. I am not making a donation as part of a sweepstake, raffle or lottery.
                </p>

                <hr>
                
                <h2>Your communication preferences:</h2>

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

                <p class="donorfy-donate__larger"><b>These are the preferences we have for this email address.</b></p>
                <p>
                    <br>
                    Select 'Yes' if you wish Hope for Justice to contact you via that method for the following purposes: To keep you informed of our ongoing activities, news, campaigns and appeals; and to invite you to events we think might interest you. You can unsubscribe from receiving communications at any time, or change your preferences, at: <a>hopeforjustice.org/manage-your-preferences</a>
                    <br><br>
                    We will always store your personal information securely. We will use it to provide the service(s) you have requested, and communicate with you in the way(s) you have agreed to. We will only allow your information to be used by third parties working on our behalf. We will share your information if required to do so by law. For details see our <a>Privacy Policy</a>.
                    <br><br>
                    <br><br>
                </p>
                
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
                <div id="PleaseWait" style="display:none">Please wait ...</div>

                <div class="donorfy-donate__buttons">
                    <div id="backToStepTwo" class="button button--white">Previous</div>
                    <div id="submitButton" class="button">Setup Direct Debit</div>
                </div>
                
                <div class="donorfy-donate__hidden">
                    <input type="button" value="Setup Direct Debit ..." id="submitButton">
                </div>
                        
                    
                <!-- Hidden fields for tags --->
                <input type="hidden" id="ActiveTags" value="" />
                <input type="hidden" id="BlockedTags" value="" />
                <!-- Do not change these values --->
                <input type="hidden" id="TenantCode" value="GO66X0NEL4" />




                <input type="hidden" id="WidgetId" value="e170a6bc-383e-6f05-b282-ff00004460b4" />

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

    </div>
</div>

<?php get_footer(); ?>