/**
 * Frontend JavaScript for Category Display for WooCommerce.
 */
( function () {
	function cat_display_init_sliders() {
		if ( typeof Swiper === 'undefined' ) {
			return;
		}

		var cat_display_sliders = document.querySelectorAll(
			'.cat-display-layout-slider .swiper'
		);

		cat_display_sliders.forEach( function ( cat_display_swiper_el ) {
			if ( cat_display_swiper_el.swiper ) {
				return;
			}

			var cat_display_wrap    = cat_display_swiper_el.closest( '.cat-display-block' );
			var cat_display_columns = parseInt( cat_display_wrap ? cat_display_wrap.dataset.columns : 3, 10 ) || 3;

			new Swiper( cat_display_swiper_el, {
				slidesPerView: 1,
				spaceBetween: 20,
				loop: false,
				navigation: {
					nextEl: cat_display_swiper_el.querySelector( '.swiper-button-next' ),
					prevEl: cat_display_swiper_el.querySelector( '.swiper-button-prev' ),
				},
				pagination: {
					el: cat_display_swiper_el.querySelector( '.swiper-pagination' ),
					clickable: true,
				},
				breakpoints: {
					640:  { slidesPerView: Math.min( 2, cat_display_columns ) },
					768:  { slidesPerView: Math.min( 3, cat_display_columns ) },
					1024: { slidesPerView: cat_display_columns },
				},
				on: {
					init: function () {
						cat_display_swiper_el.classList.add( 'swiper-initialized' );
					},
				},
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', cat_display_init_sliders );
	} else {
		cat_display_init_sliders();
	}
} )();
