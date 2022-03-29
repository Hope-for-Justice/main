jQuery(document).ready(function($) {

if( $(window).width() >= 1024 ) {

	let src = $("#video").attr('value');
	$("#video").show().attr('src', src);

	//$('iframe').parent().fitVids();
	
	$('#video').on("load", function() {
		
       $(".freedom-run-video").css('background-color', 'transparent');
	
	});

	$(".freedom-run").css({opacity:1, top:0});

	function parallax() {
	
	let up = 0 - $(window).scrollTop() /10;
	let down = $(window).scrollTop() /10;
	  $(".freedom-run-video, .freedom-run-second__img, .freedom-run-second__place, .freedom-run-hero").css({
	  	top:0 + up + "px"});

	  $(".freedom-run-hero__lines, .freedom-run-hero__slant").css({
	  	bottom:0 - down + "px"});

	  $(".freedom-run-second__plus").css({
	  	top:10 + down + "px"});
	  
	  //alert(yPos);
	}

	$(window).scroll(function(){
		parallax();	
	});

} else {
	
	$(".freedom-run").css({opacity:1, top:0});
	
}

// $(window).scroll(function() {
//   $(".freedom-run__plus").css({
//     "top": ($(window).scrollTop()) + 5 + "px"
//   });
// });




});