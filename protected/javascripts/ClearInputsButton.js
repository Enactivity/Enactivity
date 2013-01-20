/**
 * Creates a button that will clear specified inputs or its siblings' inputs if none are provided
 * Requires two data attributes:
 * @param 'data-type=[clear-button]' to innately apply click functionality
 * @param 'data-inputs' selector or array of selectors that clicking the button should clear
 *   if array, be sure to use double quotes: ["#id1","#id2"]
 **/
(function($) {

	"use strict";

	var buttonSelector = "[data-type=clear-button]";

	var clearInput = function(selector) {
		$(selector).val("");
	}

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.ClearInputsButton = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || buttonSelector, function() {
				var button = $(this);
				var inputs = button.data('inputs') || button.siblings('input, select, textarea');
				if($.isArray(inputs)) {
					for (var i = inputs.length - 1; i >= 0; i--) {
						clearInput(inputs[i]);
					};
				}
				else {
					clearInput(inputs);
				}
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply button to html elements */
	$(function() {
		$(document).ClearInputsButton(buttonSelector);
	});
})(jQuery);