/**
 * Anchor scrolling on hash load
 */
$(window).load(function() { // load vs ready because ready is too soon

	"use strict";

	if(window.location.hash !== '') {
		var targetOffset = $(window.location.hash).offset().top;
		$('body').scrollTop(targetOffset); // header height + nav height
	};
});