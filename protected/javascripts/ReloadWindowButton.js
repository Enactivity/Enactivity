/**
 * Creates a button that will refresh the page from the server
 **/
$(function() {

	"use strict";

	var buttonSelector = "[data-type=refresh-button]";

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.ReloadWindowButton = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || buttonSelector, function() {
				location.reload(false);
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply button to html elements */
	$(function() {
		$(document).ReloadWindowButton(buttonSelector);
	});
});