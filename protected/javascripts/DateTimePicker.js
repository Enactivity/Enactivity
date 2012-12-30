/*
 * DateTimePicker
 * Depends:
 *	jquery.ui.datepicker.js
 *  Modernizr
 */
(function( $, undefined ) {


	"use strict";

	// the generic date and time inputs
	var dateInputSelector = "input[type='date']";
	var timeSelectInput = "select[data-type='time']";
	var dateTimeInputs = dateInputSelector + ' + ' + timeSelectInput;
	var defaultTime = "12:00:00";

	var changeHandler = function() {
		var dateInput = $(this);
		var timeSelect = dateInput.siblings(timeSelectInput);
		if(dateInput.val() && !timeSelect.val()) {
			timeSelect.val(defaultTime);
		};
	};

	/**
	 * Add date time picker behavior to a date input/time select combo
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.DateTimePicker = function() {
		return this.each(function() {
			$(this).change(changeHandler);
		});
	};

	$(function() {
		$(dateInputSelector).DateTimePicker();
	});

})(jQuery);