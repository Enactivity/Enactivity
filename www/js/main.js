/*
 * Drop down plugin
 */
$(function() {

	"use strict";

	var dropdownSelector = '.dropdown-toggle';

	/**
	 * Removes .open class from all dropdown-enabled objects.
	 */
	function clearMenus() {
		$(dropdownSelector).parent('li').removeClass('open');
	}

	/**
	 * Add dropdown behavior to selected items. Items should have a parent
	 * <li> tag and expect to have an .open class when expanded.
	 * 
	 * @param {String} selector
	 * @return {JQuery} see http://api.jquery.com/each/
	 */
	$.fn.dropdown = function(selector) {
		return this.each(function() {
			$(this).on('click', selector || dropdownSelector, function() {
				var li = $(this).parent('li');
				var isActive = li.hasClass('open');

				clearMenus();
				!isActive && li.toggleClass('open');
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply dropdown to html elements */
	$(function() {
		$('html').bind("click", clearMenus);
		$('body').dropdown(dropdownSelector);
	});

});

/*
 * Smooth scrolling plugin @requires JQuery 1.7
 */
$(function() {

	"use strict";

	$('a[href*=#]').each(function() {
		if ($(this).attr('href').indexOf("#") == 0) {
			$(this).click(function(e) {
				e.preventDefault();
				var targetOffset = $($(this).attr('href')).offset().top;
				$('body').animate({
					scrollTop : targetOffset
				}, 400);
			});
		}
	});
});

$(function() {

	"use strict";

	if(window.location.hash) {
		$('body').animate({
			scrollTop : 150
			}, 400);
	}
});

// Ajax beautification
$(document).ajaxStart(function() {
	$('body').addClass('ajax-loading');
});

$(document).ajaxStop(function() {
	$('body').removeClass('ajax-loading');
});