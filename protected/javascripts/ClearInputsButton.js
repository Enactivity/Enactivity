$(document).ready(function(){
	$('.clear-date-time').click(function(event){
		$(this).siblings('input').val("");
		$(this).siblings('select').val("");
		return false;
	});
});

$(function() {

	"use strict";

	var buttonSelector = '[data-type-clear-button]';

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.ClearButton = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || buttonSelector, function() {
				var button = $(this);
				$.ajax({
					'type':'POST',
					'data':{
						'YII_CSRF_TOKEN':button.data('csrf-token') || $("meta[name=YII_CSRF_TOKEN]").attr("content") // TODO: replace hardcoded YII_CSRF_TOKEN name
					},
					'url':button.data('ajax-url'),
					'cache':false,
					'success':function(responseHtml) {
						$(button.data('container-id')).replaceWith(responseHtml);
					}
				});
				return false; /* prevent bubbles */
			});
		});
	};

});

/** 
 * Clear inputs button
**/
$(function() {

	"use strict";

	var buttonSelector = '[data-ajax-url]'; // or ':button' could work

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.AjaxButton = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || buttonSelector, function() {
				var button = $(this);
				$.ajax({
					'type':'POST',
					'data':{
						'YII_CSRF_TOKEN':button.data('csrf-token') || $("meta[name=YII_CSRF_TOKEN]").attr("content") // TODO: replace hardcoded YII_CSRF_TOKEN name
					},
					'url':button.data('ajax-url'),
					'cache':false,
					'success':function(responseHtml) {
						$(button.data('container-id')).replaceWith(responseHtml);
					}
				});
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply dropdown to html elements */
	$(function() {
		$('body').AjaxButton(buttonSelector);
	});
});