//
// Donate thankyou scripts
//


jQuery(document).ready(function ($) {

  let donorEmail = Cookies.get('wordpress_donor_email');

  // function to get url params
  $.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
      return null;
    }
    return decodeURI(results[1]) || 0;
  }

  let guardianAmount = Cookies.get('wordpress_guardian_amount');
  let guardianTid = Cookies.get('wordpress_guardian_tid');
  let amount = $.urlParam('amount');
  let currency = $.urlParam('currency');
  let Name = $.urlParam('Name');
  let type = decodeURIComponent($.urlParam('type')).replace("+", " ");
  let id = $.urlParam('tid');

  if (currency == 'NOK') {
    amount = amount.replace(",", ".");
  }

  if (!guardianAmount) {
    //replace characters and parse float for amount
    amount = parseFloat(decodeURIComponent(amount.replace(/[^0-9.]/g, ''))).toFixed(2);
  } else {
    //replace characters and parse float for amount
    guardianAmount = parseFloat(decodeURIComponent(guardianAmount.replace(/[^0-9.]/g, ''))).toFixed(2);
  }


  $("#signUpButton").click(function () {
    setTimeout(
      function () {
        $("#signUpButton").hide();
        $(".modal__text").html("Thank you for signing up to our mailing list!");
      }, 400);
    var data = {
      email: donorEmail,
      currency: currency,
      name: Name
    };
    jQuery.ajax({
      type: 'POST',
      url: "https://hooks.zapier.com/hooks/catch/8597852/bfnvkey/",
      data: JSON.stringify(data),
      success: function (data) {
        console.log('sent to zapier');
      },
      error: function (xhr, status, error) {
        console.log('failed to send to zapier');
      }
    });
  });

  console.log(amount);
  console.log(currency);
  console.log(type);
  console.log(id);

  dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.

  //if amount exists in url do the normal data layer stuff

  if (amount) {

    dataLayer.push({
      event: "purchase",
      ecommerce: {
        transaction_id: id,
        value: amount,
        currency: currency,
        items: [
          {
            item_name: type,
            price: amount,
            currency: currency,
            quantity: 1
          }]
      }
    });


    //if guardian cookie exists and no amount in url do the uk guardian data layer stuff


  } else if (guardianAmount) {
    console.log("guardian signup", guardianAmount, guardianTid);
    dataLayer.push({
      event: "purchase",
      ecommerce: {
        transaction_id: guardianTid,
        value: guardianAmount,
        currency: "GBP",
        items: [
          {
            item_name: "UK Guardian",
            price: guardianAmount,
            currency: "GBP",
            quantity: 1
          }]
      }
    });

  }


});