/** 
 * Unobtrusive formless submit button
 * @requires jquery.yii.js for submitting
**/
$(document).ready(function() {

	"use strict";

	var buttonSelector = ':button';

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.button = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || buttonSelector, function() {
				var button = $(this);
				jQuery.yii.submitForm(
					this,
					button.data("submit-to"),
					{
						'YII_CSRF_TOKEN':$("meta[name=YII_CSRF_TOKEN]").attr("content")
					}
				);
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply dropdown to html elements */
	$(function() {
		$('body').button(buttonSelector);
	});
});