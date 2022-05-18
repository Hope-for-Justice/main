//
// Donate thankyou scripts
//


jQuery(document).ready(function($) {

// function to get url params
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}

//replace characters and parse float for amount
let amount = parseFloat(decodeURIComponent($.urlParam('amount')).replace(/[^0-9.]/g, '')); 

let currency = $.urlParam('currency');
let type = decodeURIComponent($.urlParam('type')).replace("+", " ");
let id = $.urlParam('tid');

console.log(amount);
console.log(currency);
console.log(type);
console.log(id);

dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.


let guardianAmount = Cookies.get('wordpress_guardian_amount');
let guardianTid = Cookies.get('wordpress_guardian_tid');



if (guardianAmount) {

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

} else {

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

}



});