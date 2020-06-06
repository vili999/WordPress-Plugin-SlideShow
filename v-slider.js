jQuery(function($){
	$('#slider').owlCarousel({
		items:1, // for a slider specify "1", for a carousel specify "2" or "3"
		loop:true,
		autoPlay:true,
		autoplayHoverPause:true, // if slider is autoplaying, pause on mouse hover
		autoplayTimeout:380,
		autoplaySpeed:800,
		navSpeed:500,
		dots:false, // dots navigation below the slider
		nav:true, // left and right navigation
		navText:['<','>']
	});
});