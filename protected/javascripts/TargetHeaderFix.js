/**
 * Anchor scrolling on hash load
 */
$(function() {

	"use strict";

	if(window.location.hash) {
		var targetOffset = $(window.location.hash).offset().top;
		console.log(targetOffset);
		$('body').animate({
			scrollTop : targetOffset - 120 // header height + nav height
			}, 
			400
		);
	}
});