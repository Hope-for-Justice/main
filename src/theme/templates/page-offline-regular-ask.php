<?php
/**
 * Template Name: Offline regular ask
 *
 * @package Hope_for_Justice_2021
 *
 */

$fname = $_GET["fname"] ?? "";
$lname = $_GET["lname"] ?? "";
$phone = $_GET["phone"] ?? "";
$postcode = $_GET["postcode"] ?? "";
$email = $_GET["email"] ?? "";

get_header();
?>

<link type="text/css" rel="stylesheet" href="https://az763204.vo.msecnd.net/wwcss/gocardlesspayments.2015.1.css" />
<script type="text/javascript" src="https://az763204.vo.msecnd.net/wwjs/gocardlesspayments.2022.1.js"></script>
<!--<script type="text/javascript" src="https://az763204.vo.msecnd.net/wwjs/gocardlesspayments.2017.1.demo.js"></script>-->
<link rel="stylesheet" type="text/css" href="https://donorfylivecdn.blob.core.windows.net/wwcss/address-3.97.css" />
<script type="text/javascript" src="https://services.postcodeanywhere.co.uk/js/address-3.97.js"></script>
<script>jQuery(document).ready(function(){var e={key:"DN97-JG93-ZJ46-EW48",bar:{showCountry:false},countries:{codesList:"GBR"}},d=[{element:"AddressSearch",field:"",mode:pca.fieldMode.SEARCH},{element:"Address1",field:"Line1",mode:pca.fieldMode.POPULATE},{element:"Address2",field:"Line2",mode:pca.fieldMode.POPULATE},{element:"Town",field:"City",mode:pca.fieldMode.POPULATE},{element:"County",field:"Province",mode:pca.fieldMode.POPULATE},{element:"Postcode",field:"PostalCode",mode:pca.fieldMode.POPULATE},{element:"Country",field:"CountryName",mode:pca.fieldMode.COUNTRY}],o=new pca.Address(d,e);o.listen("populate",function(){document.getElementById("AddressSearch").value=""}),o.load()});</script>

<div class="offline-regular-ask">
<form method="post" id="DirectDebitForm">
    <!-- You can change the layout, mark up, add css classes & styles etc however do not change the field names or field ids -->
    <h3>Offline Giving Form</h3>
    <table>
        <tbody>
        <tr>
                <td>
                    <label class="" for="Amount">Amount</label><br>
                   <div class="flex"><span class="flex justify-center align-center" id="AmountPrefix">&pound;</span><input type="text" name="Amount" class="required numberOnly" id="Amount" maxlength="10" title="Please enter the amount you want to give - don't include the pound sign"></div> 
                </td>
            </tr>
            <tr style="display: none;">
                <td>
                    <label class="" for="Title">Title</label><br>
                    <input type="text" name="Title" id="Title" maxlength="50">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="FirstName">First Name*</label><br>
                    <input type="text" name="FirstName" class="required" id="FirstName" maxlength="50" value="<?php echo $fname; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="LastName">Last Name*</label><br>
                    <input type="text" name="LastName" class="required" id="LastName" maxlength="50" value="<?php echo $lname; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="AddressSearch">Address Search</label><br>
                    <input type="text" class="" id="AddressSearch" maxlength="50" placeholder="Use Postcode or Address" value="<?php echo $postcode; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="Address1">Address</label><br>
                    <input type="text" name="Address1" class="required" id="Address1" maxlength="50">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="Address2" class="" id="Address2" maxlength="50">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="Town">Town</label><br>
                    <input type="text" name="Town" class="" id="Town" maxlength="50">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="County">County</label><br>
                    <input type="text" name="County" class="" id="County" maxlength="50">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="Postcode">Postcode</label><br>
                    <input type="text" name="Postcode" class="required" id="Postcode" maxlength="10" value="<?php echo $postcode; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="Phone">Phone</label><br>
                    <input type="text" name="Phone" class="" id="Phone" maxlength="50" value="<?php echo $phone; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="" for="Email">Email*</label><br>
                    <input type="text" name="Email" class="required" type="email" id="Email" maxlength="50"value="<?php echo $email; ?>">
                </td>
            </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <tr style="display:none;">
                <td>
                    <label class="" for="SortCode1">Sort Code*</label><br>
                    <input type="text" id="SortCode1" name="SortCode1" class="digits numberOnly" maxlength="2" size="2" title="Sort Code is required" /><span>-</span><input type="text" id="SortCode2" name="SortCode2" class="digits numberOnly" maxlength="2" size="2" title="Sort Code is required" /><span>-</span><input type="text" id="SortCode3" name="SortCode3" class="digits numberOnly" maxlength="2" size="2" title="Sort Code is required" />
                </td>
            </tr>
            <tr style="display:none;">
                <td>
                    <label class="" for="AccountNumber">Account Number*</label><br>
                    <input type="text" id="AccountNumber" name="AccountNumber" class="digits numberOnly" value="" maxlength="8" size="10" title="Account Number is required" />
                </td>
            </tr>
            <tr id="PaymentScheduleRow" style="display:none;">
                <td>
                    <label class="" for="MonthlyPayment">I would like to donate*</label><br>
                    <label><span>Monthly</span><input type="radio" id="MonthlyPayment" name="PaymentSchedule" value="Monthly" checked="checked"></label><label><span>Quarterly</span><input type="radio" id="QuarterlyPayment" name="PaymentSchedule" value="Quarterly"></label><label><span>Annually</span><input type="radio" id="AnnualPayment" name="PaymentSchedule" value="Annually"></label>
                </td>
            </tr>
            <tr>
                <td>
                    <!-- <label class="" for="Comment">Comments</label><br> -->
                    <label for="Comment">On what date each month would you like your payment to be taken?</label>
                <br>
                    <select style="width: 100%;" type="text" class="required" name="Comment" id="Comment">
                            <option value="">-- Select date --</option>
                            <option value="1">1st</option>
                            <option value="15">15th</option>
                            <option value="25">25th</option>
                            <option value="30">30th</option>
                        </select>
                        <p style="margin-top: 10px;">Please note: The exact date that your gift will be taken by Direct Debit can depend on your bank and other factors, including weekends and bank holidays.</p>
                    <!-- <textarea rows="3" cols="40" class="" name="Comment" id="Comment" title="Optional comments you may wish to make regarding this payment"></textarea> -->
                </td>
            </tr>
        </tbody>
    </table>
    <!-- insert your gift aid logo here -->
    <div class="gdpr">
    <input id="GiftAid" type="checkbox" /><div class="subtitle" style="display: inline-block; margin-left:10px;">Yes I would like you to claim Gift Aid on my donation</div> 
        <p>
            I want all donations I've made to you in the past four years and all donations in future to be treated as Gift Aid donations until I notify you otherwise.<br /><br />
            I am a UK taxpayer and understand that if I pay less Income Tax and/or Capital Gains Tax than
            the amount of Gift Aid claimed on all my donations in that tax year it is my responsibility to pay any
            difference.<br /><br />
            We will claim 25p on every &pound;1 you donate.
        </p>
    </div>

    <!-- <div class="gdpr">
        <div class="subtitle">I would like to be kept up to date with your projects and activities by the methods I choose below: </div>
               <input type='checkbox' value='2' class='KeepInTouch' checked>&nbsp;Email<br />
               <input type='checkbox' value='4' class='KeepInTouch'checked>&nbsp;Post<br />
               <input type='checkbox' value='8' class='KeepInTouch' checked>&nbsp;SMS<br />
               <input type='checkbox' value='16' class='KeepInTouch' checked>&nbsp;Phone<br />
        <p>Check the box if you wish Hope for Justice to contact you via that method for the following purposes: To keep you informed of our ongoing activities, news, campaigns and appeals; and to invite you to events we think might interest you. You can unsubscribe from receiving communications at any time, or change your preferences, at: <a href="https://hopeforjustice.org/manage-your-preferences">hopeforjustice.org/manage-your-preferences</a>
                        <br><br>
                        We will always store your personal information securely. We will use it to provide the service(s) you have requested, and communicate with you in the way(s) you have agreed to. We will only allow your information to be used by third parties working on our behalf. We will share your information if required to do so by law. For details see our <a href="/privacy-policy">Privacy Policy</a>.</p>
  </div> -->
    

    

    <table>
        <tbody>
            <tr>
                <td style="text-align: right;">
                    <div id="ErrorContainer" style="display:none" class="ErrorContainer">
                        There is a problem with your payment -
                        <div id="Errors"></div>
                    </div>
                    <div id="PleaseWait" style="display:none">Please wait ...</div>
                    <input type="submit" value="Setup Direct Debit ..." id="submitButton">
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Hidden fields for tags --->
    <input type="hidden" id="ActiveTags" value="" />
    <input type="hidden" id="BlockedTags" value="" />
    <!-- Do not change these values --->
    <input type="hidden" id="TenantCode" value="GO66X0NEL4" />
    <input type="hidden" id="WidgetId" value="1662ba57-16a1-ef11-a81c-002248a36b1f" />
</form>

<div id="spinner" style="display:none;">
    <img id="img-spinner" src="http://cdn.donorfy.com/wwimages/loading.gif" alt="Loading" />
</div>

</div>

<?php get_footer(); ?>
