( function( $ ) {

	"use strict";

	// For Slider
	$( '.wpsisac-slick-slider' ).each(function( index ) {

		var slider_id   	= $(this).attr('id');
		var slider_conf 	= $.parseJSON( $(this).closest('.wpsisac-slick-slider-wrp').attr('data-conf'));

		if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
			jQuery('#'+slider_id).slick({
				slidesToShow	: 1,
				slidesToScroll	: 1,
				adaptiveHeight 	: false,
				lazyLoad		: slider_conf.lazyload,
				speed			: parseInt( slider_conf.speed ),
				autoplaySpeed	: parseInt( slider_conf.autoplay_interval ),
				dots			: ( slider_conf.dots == "true" )		? true : false,
				arrows			: ( slider_conf.arrows == "true")		? true : false,
				autoplay		: ( slider_conf.autoplay == "true" )	? true : false,
				fade 			: ( slider_conf.fade == "true" )		? true : false,
				infinite 		: ( slider_conf.loop == "true" )		? true : false,
				pauseOnHover    : ( slider_conf.hover_pause == "true" )	? true : false,
				rtl             : ( slider_conf.rtl == "true" )			? true : false,
			});
		}
	});

	// For Carousel Slider
	$( '.wpsisac-slick-carousal' ).each(function( index ) {

		var slider_id   = $(this).attr('id');
		var slider_conf = $.parseJSON( $(this).closest('.wpsisac-slick-carousal-wrp').attr('data-conf'));

		jQuery('#'+slider_id).slick({
			centerPadding	: '0px',
			lazyLoad		: slider_conf.lazyload,
			speed			: parseInt( slider_conf.speed ),
			slidesToShow	: parseInt( slider_conf.slidestoshow ),
			autoplaySpeed	: parseInt( slider_conf.autoplay_interval ),
			slidesToScroll	: parseInt( slider_conf.slidestoscroll ),
			dots			: ( slider_conf.dots == "true" )			? true : false,
			arrows			: ( slider_conf.arrows == "true" )			? true : false,
			autoplay		: ( slider_conf.autoplay == "true" )		? true : false,
			infinite 		: ( slider_conf.loop == "true" )			? true : false,
			pauseOnHover    : ( slider_conf.hover_pause == "true" )		? true : false,
			centerMode 		: ( slider_conf.centermode == "true" )		? true : false,
			variableWidth 	: ( slider_conf.variablewidth == "true" )	? true : false,
			rtl             : ( slider_conf.rtl == "true") 				? true : false,
			mobileFirst    	: ( Wpsisac.is_mobile == 1 ) 				? true : false,
			responsive 		: [{
				breakpoint 	: 1023,
				settings 	: {
					slidesToShow 	: (parseInt(slider_conf.slidestoshow) > 3) ? 3 : parseInt(slider_conf.slidestoshow),
					slidesToScroll 	: 1,
				}
			},{
				breakpoint	: 767,
				settings	: {
					slidesToShow 	: (parseInt(slider_conf.slidestoshow) > 3) ? 3 : parseInt(slider_conf.slidestoshow),
					centerMode 		: (slider_conf.centermode) == "true" ? true : false,
					slidesToScroll 	: 1,
				}
			},{
				breakpoint	: 639,
				settings	: {
					slidesToShow 	: 1,
					slidesToScroll 	: 1,
					dots 			: false,
					centerMode 		: true,
					variableWidth 	: false,
				}
			},{
				breakpoint	: 479,
				settings	: {
					slidesToShow 	: 1,
					slidesToScroll 	: 1,
					dots 			: false,
					centerMode 		: false,
					variableWidth 	: false,
				}
			},{
				breakpoint	: 319,
				settings	: {
					slidesToShow 	: 1,
					slidesToScroll 	: 1,
					dots 			: false,
					centerMode 		: false,
					variableWidth 	: false,
				}
			}]
		});
	});
})( jQuery );