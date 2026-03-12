/**
 * Frontend JavaScript for WC Category Display Block
 */

document.addEventListener("DOMContentLoaded", function () {
	// Initialize all sliders on the page
	const sliders = document.querySelectorAll(".wc-cat-slider .swiper");

	sliders.forEach(function (sliderElement) {
		// Skip if already initialized
		if (sliderElement.swiper) {
			return;
		}

		// Get configuration from data attributes
		const columns =
			parseInt(sliderElement.closest(".wc-category-block").dataset.columns) ||
			3;

		// Initialize Swiper if library is loaded
		if (typeof Swiper !== "undefined") {
			new Swiper(sliderElement, {
				slidesPerView: 1,
				spaceBetween: 20,
				loop: false,
				navigation: {
					nextEl: sliderElement.querySelector(".swiper-button-next"),
					prevEl: sliderElement.querySelector(".swiper-button-prev"),
				},
				pagination: {
					el: sliderElement.querySelector(".swiper-pagination"),
					clickable: true,
				},
				breakpoints: {
					640: {
						slidesPerView: Math.min(2, columns),
					},
					768: {
						slidesPerView: Math.min(3, columns),
					},
					1024: {
						slidesPerView: columns,
					},
				},
				on: {
					init: function () {
						// Add loaded class
						sliderElement.classList.add("swiper-initialized");
					},
				},
			});
		}
	});
});
