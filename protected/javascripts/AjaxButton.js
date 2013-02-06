/** 
 * Unobtrusive formless submit button
 * Ajax buttons should have 2 attributes:
 * 'data-ajax-url' - the url that the query should point to 
 * 'data-container-selector' - the selector of the object(s) that should be replaced, reloads entire page otherwise
 * @requires jquery.ajax for submitting
**/
(function($) {

	"use strict";

	var buttonSelector = '[data-ajax-url]'; // or ':button' could work
	var ajaxClass = 'ajax-posting';

	/**
	 * Add button behavior to selected items.
	 * @param {String} selector for which elements to apply the button listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.AjaxButton = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || buttonSelector, function() {
				var button = $(this);
				var containers = $(button.data('container-selector'));

				$.ajax({
					'beforeSend':function(jqXHR, settings) {
						containers.addClass(ajaxClass);
					},
					'type':'POST',
					'data':{
						'YII_CSRF_TOKEN':button.data('csrf-token') || $("meta[name=YII_CSRF_TOKEN]").attr("content") 
					},
					'url':button.data('ajax-url'),
					'cache':false,
					'success':function(responseHtml) {
						if(containers) {
							containers.replaceWith(responseHtml);
						}
						else {
							location.reload();
						}
					}
				});
				
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply dropdown to html elements */
	$(function() {
		$(document).AjaxButton(buttonSelector);
	});
})(jQuery);