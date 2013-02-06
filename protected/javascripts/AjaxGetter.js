/** 
 * Unobtrusive GET getter: GETs link, replaces container selecter with results
 * Ajax getters should have 2 attributes:
 * 'data-get-url' - the url that the query should point to 
 * 'data-container-selector' - the selector of the object(s) that should be replaced, reloads entire page otherwise
 * @requires jquery.ajax for submitting
**/
(function($) {

	"use strict";

	var getterSelector = '[data-get-url]'; // or ':getter' could work

	/**
	 * Add getter behavior to selected items.
	 * @param {String} selector for which elements to apply the getter listener to
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.AjaxGetter = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || getterSelector, function() {
				var getter = $(this);
				$.ajax({
					'type':'GET',
					'url':getter.data('get-url'),
					'cache':false,
					'success':function(responseHtml) {
						if(getter.data('container-selector')) {
							$(getter.data('container-selector')).replaceWith(responseHtml);
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

	/* Apply ajaxgetter to appropriate html elements */
	$(function() {
		$(document).AjaxGetter(getterSelector);
	});
})(jQuery);