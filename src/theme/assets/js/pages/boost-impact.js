//
// Boost impact script
//
jQuery(document).ready(function ($) {


    // function to get url params
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    }

    let cnumber = $.urlParam('cnumber');
    let rpinumber = $.urlParam('rpi');
    let originalamount = $.urlParam('originalamount');
    let donorfy = $.urlParam('donorfy');
    let boostby = $.urlParam('boostby');

    //https://hopeforjustice.org/?page_id=5201&rpi=9429&boostby=5&Name=James&originalamount=15&cnumber=37054&email=james.holt@hopeforjustice.org&donorfy=UK

    console.log(cnumber);
    console.log(rpinumber);
    console.log(originalamount);
    console.log(donorfy);



    $.ajax({
        type: 'POST',
        method: 'POST',
        url: '/wp-content/themes/hope-for-justice-2020/confirm-impact-boost.php',
        // /wp-content/ wp-engine
        // /build/ local
        data: {
            cnumber,
            rpinumber,
            originalamount,
            donorfy,
            boostby
        },
        success: function (output) {
            let obj = $.parseJSON(output)
            console.log(obj)
        },
        error: function () {
            alert('something went wrong!')
        }
    });

});