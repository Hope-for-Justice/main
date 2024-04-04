gsap.registerPlugin(ScrollToPlugin);

const tl = gsap.timeline();

tl.from(".ff-gsap-group-1", { y: 10, opacity: 0, stagger: 0.2 }, 0);
tl.from(".ff-gsap-group-2", { y: 10, opacity: 0, stagger: 0.2 }, 0.25);
tl.from(".ff-gsap-group-3", { y: 10, opacity: 0, stagger: 0.2 }, 0.5);

let tl2 = gsap.timeline({
	scrollTrigger: {
		trigger: ".ff-appeals",
		start: "top center",
	},
});

tl2.from(".ff-gsap-group-4", { y: 10, opacity: 0, stagger: 0.2 });

let tl3 = gsap.timeline({
	scrollTrigger: {
		trigger: ".ff-updates",
		start: "top center",
	},
});

tl3.from(".ff-gsap-group-5", { y: 10, opacity: 0, stagger: 0.2 });

let tl4 = gsap.timeline({
	scrollTrigger: {
		trigger: ".ff-contact",
		start: "top center",
	},
});

tl4.from(".ff-gsap-group-6", { y: 10, opacity: 0, stagger: 0.2 });

const seeAppeals = document.querySelector("#seeAppeals");

seeAppeals.addEventListener("click", function (e) {
	e.preventDefault();
	gsap.to(window, {
		duration: 0.5,
		scrollTo: { y: ".ff-appeals", offsetY: 50 },
	});
});

const getInTouch = document.querySelector("#getInTouch");

getInTouch.addEventListener("click", function (e) {
	e.preventDefault();
	gsap.to(window, {
		duration: 0.5,
		scrollTo: { y: ".ff-contact", offsetY: 50 },
	});
});

const items = document.querySelectorAll(".ff-appeals__grid-item");

const popup = document.querySelector(".ff-popup");
const popupCircle = document.querySelector(".ff-popup__circle");
const popupTitle = document.querySelector(".ff-popup__title");
const popupDescription = document.querySelector(".ff-popup__desc");
const popupPDF = document.querySelector(".ff-popup__pdf-button");
let wid = "";
let appealImage = null;

for (let item of items) {
	item.addEventListener("click", function () {
		gsap.to(popup, {
			y: 0,
			autoAlpha: 1,
			duration: 0.3,
		});
		gsap.to(".ff-popup__scroll-container", {
			scrollTo: { y: 0 },
			duration: 0.2,
		});
		popupCircle.style.backgroundImage = `url(${this.dataset.image})`;
		appealImage = encodeURIComponent(this.dataset.image);
		popupTitle.innerHTML = this.dataset.title;
		popupDescription.innerHTML = this.dataset.description;
		popupPDF.href = this.dataset.pdf;
		document.body.classList.add("ff-body-fixed");
		wid = this.dataset.widget;
	});
}

const popupBackdrop = document.querySelector(".ff-popup__backdrop");

popupBackdrop.addEventListener("click", function () {
	gsap.to(popup, { y: 0, autoAlpha: 0, duration: 0.3 });
	document.body.classList.remove("ff-body-fixed");
});

const popupClose = document.querySelector(".ff-popup__close");

popupClose.addEventListener("click", function () {
	gsap.to(popup, { y: 0, autoAlpha: 0, duration: 0.3 });
	document.body.classList.remove("ff-body-fixed");
});

const donateButton = document.querySelector("#ff-donate");
const donationInput = document.querySelector("#donateAmount");
const country = document.querySelector("#main").dataset.country;
const errorContainer = document.querySelector("#errors");

donateButton.addEventListener("click", function () {
	if (donationInput.value >= 1000) {
		handleRedirect();
	} else {
		if (country === "USA") {
			errorContainer.innerHTML =
				"Please enter a valid donation amount (minimum $1,000)";
		} else {
			errorContainer.innerHTML =
				"Please enter a valid donation amount (minimum £1,000)";
		}
	}
});
donationInput.addEventListener("input", function (e) {
	if (e.target.value >= 1000) {
		errorContainer.innerHTML = "";
	} else {
		if (country === "USA") {
			errorContainer.innerHTML =
				"Please enter a valid donation amount (minimum $1,000)";
		} else {
			errorContainer.innerHTML =
				"Please enter a valid donation amount (minimum £1,000)";
		}
	}
});

function handleRedirect() {
	let amount = donationInput.value;
	console.log(amount, country);

	let url = window.location.origin;
	let urlAmount = parseFloat(amount).toFixed(2);

	if (country == "USA") {
		url += "/donate-USD-once/";
	} else {
		url += "/donate-GBP-once/";
	}

	if (wid) {
		url += `?Amount=${urlAmount}&wid=${wid}`;
	}

	if (appealImage) {
		url += `&image=${appealImage}`;
	}

	console.log(url);

	window.location.href = url;
}
