jQuery(document).ready(function(){
    if ( 'undefined' === typeof Swiper ) {
	  const asyncSwiper = elementorFrontend.utils.swiper;

	  new asyncSwiper( '.ts-slider', {
      // Navigation arrows
        autoplay: {
              delay: 2500,
              disableOnInteraction: false,
            },
      navigation: {
        nextEl: '.ts-slider-button-next',
        prevEl: '.ts-slider-button-prev',
      } }).then( ( newSwiperInstance ) => {
		console.log( 'New Swiper instance is ready: ', newSwiperInstance );

		mySwiper = newSwiperInstance;
	  } );
	} else {
	  console.log( 'Swiper global variable is ready, create a new instance: ', Swiper );

	  const swiper = new Swiper('.ts-slider', {
      // Navigation arrows
        autoplay: {
              delay: 2500,
              disableOnInteraction: false,
            },
      navigation: {
        nextEl: '.ts-slider-button-next',
        prevEl: '.ts-slider-button-prev',
      },

    });
	}
});