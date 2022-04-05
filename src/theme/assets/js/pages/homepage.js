jQuery(document).ready(function($) { 

    // lottie
    var getInvolved;
    var elem = document.getElementById('getInvolved');

    if (elem != undefined) {
        var animData = {
            container: elem,
            renderer: 'canvas',
            loop: true,
            autoplay: true, //change to false when using trigger
            rendererSettings: {
                progressiveLoad:false
            },
            path: '/build/themes/hope-for-justice-2020/assets/img/getinvolved.json',
            //on wp-engine /wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json
            //on local setup /build/themes/hope-for-justice-2020/assets/img/getinvolved.json
        };
        getInvolved = bodymovin.loadAnimation(animData);


        // //waypoint
        // var waypoint = new Waypoint({
        // element: document.getElementById('getInvolved'),
        //   handler: function(direction) {
        //     getInvolved.play();
        //   },
        //   offset: '50%'
        // }); 

    }

    //pillars
    $("#pillarA").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
    	$(this).toggleClass("homepage-pillars__card--active");
    	$(this).css('z-index', '4');
    	$("#pillarB").css('z-index', '3');
    	$("#pillarC").css('z-index', '2');
    	$("#pillarD").css('z-index', '1');
    });

    $("#pillarB").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
    	$(this).toggleClass("homepage-pillars__card--active");
    	$(this).css('z-index', '4');
    	$("#pillarC").css('z-index', '2');
    	$("#pillarD").css('z-index', '1');
    	$("#pillarA").css('z-index', '3');
    });

    $("#pillarC").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
    	$(this).toggleClass("homepage-pillars__card--active");
    	$(this).css('z-index', '4');
    	$("#pillarD").css('z-index', '1');
    	$("#pillarA").css('z-index', '2');
    	$("#pillarB").css('z-index', '3');
    });

    $("#pillarD").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
    	$(this).toggleClass("homepage-pillars__card--active");
    	$(this).css('z-index', '4');
    	$("#pillarA").css('z-index', '1');
    	$("#pillarB").css('z-index', '2');
    	$("#pillarC").css('z-index', '3');
    });

});