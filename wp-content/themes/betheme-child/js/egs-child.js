(function($) {
	'use strict';

	var owl = $('.egs-owl-carousel');
	owl.owlCarousel({
	    items: 2,
		loop: true,
		autoplay: true,
		autoplayTimeout: 1000,
		autoplayHoverPause: true,
	});
})(jQuery);