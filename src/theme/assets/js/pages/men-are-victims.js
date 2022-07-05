

function preloadImages(srcs, imgs) {
    let img;
    let remaining = srcs.length;
    for (let i = 0; i < srcs.length; i++) {
        img = new Image();
        img.onload = function() {
            --remaining;
            if (remaining <= 0) {
                loadedImages();
            }
        };
        img.src = srcs[i];
        imgs.push(img);
    }
}

const imageSrcs = [

"https://hopeforjustice.org/wp-content/uploads/2022/06/mav-4.jpg",
"https://hopeforjustice.org/wp-content/uploads/2022/06/mav-3.jpg",
"https://hopeforjustice.org/wp-content/uploads/2022/06/mav-2.jpg",
"https://hopeforjustice.org/wp-content/uploads/2022/06/mav-1.jpg",

]
const images = [];

preloadImages(imageSrcs, images);

function loadedImages() {
	let main = document.querySelector('#main');
	main.classList.remove("loading");
	jQuery(document).ready(function($) { 

		const pictures = $(".men-are-victims__picture");
		const logo = $(".men-are-victims__logo");

		gsap.to(logo, {duration: 0.5, opacity: 1, y: 0,});


		function loopImages() {
			let time = 0;
			$.each(images, function(i,v){
				let img = v.src;
				    setTimeout(function() {
				    	$(pictures).css("background-image", 'url(' + img + ')');
				    }, time);
				time += 500;
			});
		}
		loopImages();
		//setInterval(loopImages, 2000);​
		


	});
}

jQuery(document).ready(function($) { 

	$('input[type="submit"]').val("Join the fight");

	const logo = $("#mavLogo");
	const pictures = $(".men-are-victims__picture");
	const width = window.innerWidth;

	if (width >= 1024){
		$(document).mousemove(function(event){
		    
		    let xPos = (event.clientX/$(window).width())-0.5,
		       yPos = (event.clientY/$(window).height())-0.5
		  
			  gsap.to(logo, 1, {
			    x: xPos * 100, 
			    y: yPos * 100,
			    ease: Power1.easeOut,
			  });

			  gsap.to(pictures, 1, {
			    x: 0 - xPos * 100, 
			    y: 0 - yPos * 100,
			    ease: Power1.easeOut,
			  });
		});
	}

	const gsapReveal = $(".gsapReveal");
	const gsapStagger = $(".cta");
	gsap.set(gsapReveal, {opacity: 0, y: 40});
	gsap.set(gsapStagger, {opacity: 0, y: 40});


	$.each(gsapReveal, function(i,v){
		gsap.to(this, 1, {
		  	scrollTrigger: {
	   			trigger: this,
	    		//scrub: true,
	  		}, 
			y: 0,
			autoAlpha: 1,
		}); 
	});

	gsap.to(".men-are-victims__bottom-img", 1, {
	  	scrollTrigger: {
   			trigger: ".men-are-victims__bottom-img",
    		//scrub: true,
  		}, 
		y: 0,
		marginBottom:-100,
		autoAlpha: 1,
	}); 

	
	gsap.to(gsapStagger, 1, {
	  	scrollTrigger: {
   			trigger: ".men-are-victims__cta",
    		//scrub: true,
  		}, 
		y: 0,
		autoAlpha: 1,
		stagger: 0.3
	}); 

	$(".men-are-victims__accordian-item").click( function(){
		$(this).children("svg").toggleClass("men-are-victims__accordian-svg--active");
		$(this).next().toggleClass("men-are-victims__accordian-text--active");
	});

	$("#resources").click(function(){
		dataLayer.push({event: "men_are_victims_download_click"});
	});

	$('input[type="submit"]').click(function(){
		dataLayer.push({event: "men_are_victims_signup_click"});
	});

	$("#donateButton").click(function(){
		dataLayer.push({event: "men_are_victims_donate_click"});
	});

});


















