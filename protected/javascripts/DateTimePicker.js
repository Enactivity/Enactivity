/*
 * DateTimePicker
 * Depends:
 *	jquery.ui.datepicker.js
 *  Modernizr
 */
(function($) {

	"use strict";

	// the generic date and time inputs
	var dateInputSelector = "input[type='date']";
	var timeSelectInputSelector = "select[data-type='time']";
	var dateTimeInputs = dateInputSelector + ' + ' + timeSelectInputSelector;
	var defaultTimeValue = "12:00:00";

	/**
	 * Add date time picker behavior to a date input/time select combo
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.DateTimePicker = function(selector) {
		return this.each(function() {
			$(this).on('change keyup blur', selector || dateInputSelector, function(event) {
				var dateInput = $(this);
				var timeSelect = dateInput.siblings(timeSelectInputSelector);
				if(dateInput.val() && !timeSelect.val()) {
					timeSelect.val(defaultTimeValue);
				};
			});
		});
	};

	// Apply datetime picker on document ready
	$(function() {
		$(document).DateTimePicker(dateInputSelector);
	});

})(jQuery);