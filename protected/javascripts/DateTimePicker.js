/*
 * DateTimePicker
 * Depends:
 *	jquery.ui.datepicker.js
 *  Modernizr
 */
(function( $, undefined ) {


	"use strict";

	var buttonSelector = "input[type='date']";

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.DateTimePicker = function(selector) {
	}

})(jQuery);

// Apply date time pickers if no native support
$(function() {
	if(!Modernizr.inputtypes.date) {
		$("input[type='date']").datepicker();
	}
});