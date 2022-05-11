//
// donorfy webhooks
//


jQuery(document).ready(function($) {

$('#test').click(function(){ 

    $.ajax({
        method : 'GET',
        url : '/build/themes/hope-for-justice-2020/duplicate-check.php',
        success: function(output) {
            //let obj = $.parseJSON(output)
            //console.log(obj[0].LastName);
            console.log(output);
        }
    });

});

});

