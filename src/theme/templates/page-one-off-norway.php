<?php
/**
 * Template Name: One off Norway
 *
 * @package Hope_for_Justice_2021
 */

get_header('', array( 'page_class' => 'site--full') ); ?>

<?php 
$campaignPassed = $_COOKIE["wordpress_hfjcampaign"];

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
?>



<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LeSscYZAAAAABIur1rDAvJtDiR7SayCuAylTV2q"></script>

<div class="main site-main donorfy-donate">
    <div class="full-grid">
        
        <div class="donorfy-donate__forms">
        
            <!-- form 1 -->
            <form id="formOne"> 

                <h2>Your details:</h2>

                <div class="donorfy-donate__amount donorfy-donate__input donorfy-donate__amount--norway">
                    <label class="donorfy-donate__hidden" for="Amount">Amount I would like to give each month</label>
                    <input type="text" name="Amount" class="required numberOnly form-control" id="Amount" maxlength="10" 
                    <?php if($_GET['Amount']){ ?> 
                        value="<?php echo $_GET['Amount']?>" 
                    <?php } ?>>
                </div> 

                <div class="donorfy-donate__flex">
                    <div class="donorfy-donate__input">
                        <label class="donorfy-donate__hidden" for="FirstName">First Name*</label>
                        <input type="text" name="FirstName" class="required" id="FirstName" placeholder="First Name" maxlength="50"> 
                    </div>
                    <div class="donorfy-donate__input">
                        <label class="donorfy-donate__hidden" for="LastName">Last Name*</label>
                        <input type="text" name="LastName" class="required" id="LastName" placeholder="Last Name"maxlength="50"> 
                    </div>
                </div>

                <div class="donorfy-donate__input">
                    <label class="donorfy-donate__hidden" for="Email">Email*</label>
                    <input type="text" name="Email" class="required" type="email" id="Email" maxlength="50" placeholder="Email"> 
                </div>

        
                <div class="donorfy-donate__input">
                    <label class="donorfy-donate__hidden" for="Phone">Phone</label>
                    <input type="text" name="Phone" class="" id="Phone" maxlength="50" placeholder="Phone"> 
                </div>

                <div id="toStepTwo" class="button button--red">Next</div>
            </form>
            <!-- /form 1 -->


            <!-- form 2 -->
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

                <div class="donorfy-donate__select">
                    <select name="Country" class="required" id="Country" placeholder="Country">
                        <option disabled value=""> -- Country select -- </option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bonaire, Saint Eustatius and Saba">Bonaire, Saint Eustatius and Saba</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Curaçao">Curaçao</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Côte D'ivoire">Côte D'ivoire</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                        <option value="Holland">Holland</option>
                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran, Islamic Republic Of">Iran, Islamic Republic Of</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Laos">Laos</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libya">Libya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia">Macedonia</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia">Micronesia</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="North Korea">North Korea</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option selected value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Réunion">Réunion</option>
                        <option value="Saint Barthélemy">Saint Barthélemy</option>
                        <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                        <option value="South Korea">South Korea</option>
                        <option value="South Sudan">South Sudan</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                        <option value="Taiwan, Province Of China">Taiwan, Province Of China</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania">Tanzania</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-Leste">Timor-Leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="United States">United States</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Vietnam">Vietnam</option>
                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                        <option value="Åland Islands">Åland Islands</option>
                    </select>
                </div>

                <div class="donorfy-donate__buttons">
                    <div id="backToStepOne" class="button button--white">Previous</div>
                    <div id="toStepThree" class="button">Next</div>
                </div>
            
            </form>
            <!-- /form 2 -->
                 

            <!-- form 3 -->
            <form id="CreditCardForm">
                
                <h2>Card Details:</h2> 

                <div id="card-number" class="donorfy-donate__input"></div>

                <div class="donorfy-donate__flex">
                    <div id="card-expiry" class="donorfy-donate__input"></div>
                    <div id="card-cvc" class="donorfy-donate__input"></div>
                </div>

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
                </p>

                <div class="donorfy-donate__input donorfy-donate__comment">
                    <textarea rows="2" cols="40" class="" name="Comment" id="Comment" placeholder="What inspired you to give?"></textarea>
                </div>

                <hr>

                <div class="donorfy-donate__hidden">
                    <input id="emailPreference" type="checkbox" value="2" class="KeepInTouch">
                    &nbsp;Email
                    <input id="postPreference" type="checkbox" value="4" class="KeepInTouch">&nbsp;Post
                    <input id="smsPreference" type="checkbox" value="8" class="KeepInTouch">&nbsp;Sms
                    <input id="phonePreference" type="checkbox" value="16" class="KeepInTouch">&nbsp;Phone
                </div>

                <div id="ErrorContainer" class="ErrorContainer">
                    <div style="color: red; font-size: 1.5em;" id="Errors"></div>
                </div>

                <div id="PleaseWait" style="display:none">Please wait ...</div>
                
                
                <div class="donorfy-donate__buttons">
                    <div id="backToStepTwo" class="button button--white">Previous</div>
                    <div id="submitButton" class="button">Donate</div>
                </div>


                <div style="display: none;">
                    <input type="radio" id="OneOffPayment" name="PaymentType" value="OneOff" checked="checked">
                    <input type="radio" id="RecurringPayment" name="PaymentType" value="Recurring">
                </div>

                <div id="PaymentScheduleRow" style="display: none;">   
                    <input type="radio" id="MonthlyPayment" name="PaymentSchedule" value="Monthly">
                    <input type="radio" id="QuarterlyPayment" name="PaymentSchedule" value="Quarterly">
                    <input type="radio" id="AnnualPayment" name="PaymentSchedule" value="Annually"> 
                </div>



                <!-- Hidden fields for tags -->
                <input type="hidden" id="ActiveTags" value="" />
                <input type="hidden" id="BlockedTags" value="" />
                <!-- Do not change these values -->
                <input type="hidden" id="PublishableKey" value="pk_live_516S0p5DOK0OXJCvhKeBNMXaSLRz4CicqeGgZXBezPFFs0ZIOeLQ5Qvv74uQ6yI2T8AWRhyYrQ3nOQaOne3ziOZle00dp3xEgeZ" />
                <input type="hidden" id="TenantCode" value="N2SOZ58ZN2" />
                
                <input type="hidden" id="WidgetId" value="<?php if ($matched_widget) {echo $matched_widget;}else{echo 'f248ca1a-d8d2-ec11-bea1-0003ff443d07';}?>" />


                <input type="hidden" id="DonationPageId" value="" />
                <!-- <input type="hidden" id="RedirectToPage" value="http://hopeforjustice.org/thank-you-usa-regular" /> -->
                <input type="hidden" id="ReCaptchaSiteKey" value="6LeSscYZAAAAABIur1rDAvJtDiR7SayCuAylTV2q" />
                <input type="hidden" id="ReCaptchaAction" value="Donorfy" />
                
                <input type="hidden" id="currency" value="NOK" />
                <input type="hidden" id="type" value="Norway+one-off" />
                <input type="hidden" id="zapierUrl" value="https://hooks.zapier.com/hooks/catch/8597852/bk7nv5v/" />

                <div class="donorfy-donate__hidden">
                    <input id="GiftAid" type="checkbox" />
                </div>
            
            </form>
            <!-- /form 3 -->

        </div>

    </div><!-- /grid -->
     
</div>

<script>
function InitialiseForm() {}
</script>


    
<?php get_footer(); ?>