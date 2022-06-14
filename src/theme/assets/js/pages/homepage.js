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
            path: '/wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json',
            //on wp-engine /wp-content/themes/hope-for-justice-2020/assets/img/getinvolved.json
            //on local setup /build/themes/hope-for-justice-2020/assets/img/getinvolved.json
        };
        getInvolved = bodymovin.loadAnimation(animData);

    }

    //pillars
    $("#pillarA, #pillarAText").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
        $(".homepage-pillars__pillar--active").toggleClass("homepage-pillars__pillar--active");
        $("#pillarAText").toggleClass("homepage-pillars__pillar--active");
    	$("#pillarA").toggleClass("homepage-pillars__card--active");
    	$("#pillarA").css('z-index', '4');
    	$("#pillarB").css('z-index', '3');
    	$("#pillarC").css('z-index', '2');
    	$("#pillarD").css('z-index', '1');
    });

    $("#pillarB, #pillarBText").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
        $(".homepage-pillars__pillar--active").toggleClass("homepage-pillars__pillar--active");
        $("#pillarBText").toggleClass("homepage-pillars__pillar--active");
    	$("#pillarB").toggleClass("homepage-pillars__card--active");
    	$("#pillarB").css('z-index', '4');
    	$("#pillarC").css('z-index', '2');
    	$("#pillarD").css('z-index', '1');
    	$("#pillarA").css('z-index', '3');
    });

    $("#pillarC, #pillarCText").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
        $(".homepage-pillars__pillar--active").toggleClass("homepage-pillars__pillar--active");
        $("#pillarCText").toggleClass("homepage-pillars__pillar--active");
    	$("#pillarC").toggleClass("homepage-pillars__card--active");
    	$("#pillarC").css('z-index', '4');
    	$("#pillarD").css('z-index', '1');
    	$("#pillarA").css('z-index', '2');
    	$("#pillarB").css('z-index', '3');
    });

    $("#pillarD, #pillarDText").click(function(){
    	$(".homepage-pillars__card--active").toggleClass("homepage-pillars__card--active");
        $(".homepage-pillars__pillar--active").toggleClass("homepage-pillars__pillar--active");
        $("#pillarDText").toggleClass("homepage-pillars__pillar--active");
    	$("#pillarD").toggleClass("homepage-pillars__card--active");
    	$("#pillarD").css('z-index', '4');
    	$("#pillarA").css('z-index', '1');
    	$("#pillarB").css('z-index', '2');
    	$("#pillarC").css('z-index', '3');
    });

});