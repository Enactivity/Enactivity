/*
 * DateInput Polyfill
 * Provides 
 * Depends:
 *	jquery.ui.datepicker.js
 *  Modernizr
 */
(function( $, undefined ) {


	"use strict";

	var dateInputSelector = "input[type='date']";

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.DateInputPolyfill = function(selector) {
		// Apply date time pickers if no native support
		if(!Modernizr.inputtypes.date) {
			selector = selector || dateInputSelector; // fall back to date input

			return this.each(function() {
				$(selector).datepicker();
			});
		};
		return $;
	};
	
	/* Apply button to html elements */
	$(function() {
		$('body').DateInputPolyfill(dateInputSelector); // apply to JQuery UI datepicker
	});

})(jQuery);