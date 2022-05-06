<?php
/**
 * Template Name: One off UK
 *
 * @package Hope_for_Justice_2021
 */

get_header(); ?>


<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LeSscYZAAAAABIur1rDAvJtDiR7SayCuAylTV2q"></script>

<div class="main site-main donorfy-donate">
    <div class="grid">
        
        <div class="donorfy-donate__forms">
            
            <!-- form 1 -->
            <form class="donorfy-donate__form" id="formOne"> 

                <h2 class="font-fk">Your details:</h2>  

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
                    <input type="text" name="FirstName" class="required" id="FirstName" placeholder="First Name" maxlength="50"> 
                    <input type="text" name="LastName" class="required" id="LastName" placeholder="Last Name"maxlength="50"> 
                </div>

                <input type="text" name="Email" class="required" type="email" id="Email" maxlength="50" placeholder="Email"> 

                <!-- <div id="testButton" class="button">test</div> -->

                <input type="text" name="Phone" class="" id="Phone" maxlength="50" placeholder="Phone"> 

                <div id="toStepTwo" class="button button--red">Next</div>
            </form>
            <!-- /form 1 -->


            <!-- form 2 -->
            <form class="donorfy-donate__form" id="formTwo">
                <h2 class="font-fk">Address details:</h2> 

                <input type="text" name="Address1" class="" id="Address1" maxlength="50" placeholder="Address 1"> 
                
                <input type="text" name="Address2" class="" id="Address2" maxlength="50" placeholder="Address 2 (optional)"> 

                <div class="donorfy-donate__flex">
                    <input type="text" name="Town" class="" id="Town" maxlength="50" placeholder="City"> 
                    <input type="text" name="County" class="" id="County" maxlength="50" placeholder="State"> 
                </div>

                <input type="text" name="Postcode" class="" id="Postcode" maxlength="10" placeholder="ZIP code"> 

                <div class="donorfy-donate__select">
                    <select name="Country" class="" id="Country" placeholder="Country">
                        <option disabled selected value> -- Country select -- </option>
                        <option value="United States">United States</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Chile">Chile</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Canada">Canada</option>
                        <option value="Philippines">Philippines</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Australia">Australia</option>
                    </select>
                </div>
            
            </form>
            <!-- /form 2 -->
                 

            <!-- form 3 -->
            <form class="donorfy-donate__form" id="formThree">

                <h2 class="font-fk">Payment details:</h2>  

                <div class="donorfy-donate__amount donorfy-donate__amount--uk">
                    <input type="text" name="Amount" class="required numberOnly form-control donate-uk__amount" id="Amount" maxlength="10" placeholder="18.00" value="18.00">
                </div>
                
                <div id="card-number" class="donorfy-donate__input"></div>

                <div class="donorfy-donate__flex">
                    <div id="card-expiry" class="donorfy-donate__input"></div>
                    <div id="card-cvc" class="donorfy-donate__input"></div>
                </div>

                <input type="text" name="Comment" id="Comment" placeholder="What has inspired you to donate?">

                <div id="ErrorContainer" class="ErrorContainer">
                <div style="color: red; font-size: 1.5em;" id="Errors"></div>
                </div>
                <div id="PleaseWait" style="display:none">Please wait ...</div>
                <input class="button button--solid button--red" type="submit" value="Donate" id="submitButton">   
                


                <div style="display: none;">
                    <input type="radio" id="OneOffPayment" name="PaymentType" value="OneOff" checked="checked">
                    <input type="radio" id="RecurringPayment" name="PaymentType" value="Recurring">
                </div>

                <div id="PaymentScheduleRow" style="display: none;">   
                    <input type="radio" id="MonthlyPayment" name="PaymentSchedule" value="Monthly">
                    <input type="radio" id="QuarterlyPayment" name="PaymentSchedule" value="Quarterly">
                    <input type="radio" id="AnnualPayment" name="PaymentSchedule" value="Annually"> 
                </div>

              
                <div>
                    <input id="emailPreference" type="checkbox" value="2" class="KeepInTouch">
                    &nbsp;Email
                    <input id="postPreference" type="checkbox" value="4" class="KeepInTouch">&nbsp;Post
                    <input id="smsPreference" type="checkbox" value="8" class="KeepInTouch">&nbsp;Sms
                    <input id="phonePreference" type="checkbox" value="16" class="KeepInTouch">&nbsp;Phone
                </div>


                <div id="ErrorContainer" class="ErrorContainer">
                    <div style="color: red; font-size: 16px" id="Errors"></div>
                </div>
                <div id="PleaseWait" style="display:none; font-size:14px">Please wait ...</div>  


                <!-- Hidden fields for tags -->
                <input type="hidden" id="ActiveTags" value="" />
                <input type="hidden" id="BlockedTags" value="" />
                <!-- Do not change these values -->
                <input type="hidden" id="PublishableKey" value="pk_live_WMJp57zos3PJGIUIaXRYMY8I002yTFVYpi" />
                <input type="hidden" id="TenantCode" value="HM9DCVXJ56" />
                <input type="hidden" id="WidgetId" value="ee383a63-9733-ea11-8454-00155d5613f8" />
                <input type="hidden" id="DonationPageId" value="" />
                <input type="hidden" id="RedirectToPage" value="http://hopeforjustice.org/thank-you-usa-regular" />
                <input type="hidden" id="ReCaptchaSiteKey" value="6LeSscYZAAAAABIur1rDAvJtDiR7SayCuAylTV2q" />
                <input type="hidden" id="ReCaptchaAction" value="Donorfy" />
            
            </form>
            <!-- /form 3 -->

        </div>

    </div><!-- /grid -->
     
</div>

<script>
function InitialiseForm() {}
</script>


    
<?php get_footer(); ?>