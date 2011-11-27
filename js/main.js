/* ============================================================
 * nav.js is based off of Twitter's bootstrap-dropdown.js v1.4.0
 * http://twitter.github.com/bootstrap/javascript.html#dropdown
 * ============================================================
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

/* Requires JQuery 1.7+ */
!function ($) {

	"use strict";

	var dropdownSelector = '.dropdown-toggle';

	/**
	 * Removes .open class from all dropdown-enabled
	 * objects.
	**/
	function clearMenus() {
		$(dropdownSelector).parent('li').removeClass('open');
	}

	/**
	 * Add dropdown behavior to selected items.
	 * Items should have a parent <li> tag and 
	 * expect to have an .open class when
	 * expanded.
	 * @param {String} selector 
	 * @return {JQuery} see http://api.jquery.com/each/
	**/
	$.fn.dropdown = function (selector) {
		return this.each(function () {
			$(this).on('click', selector || dropdownSelector, function () {
				var li = $(this).parent('li');
				var isActive = li.hasClass('open');

				clearMenus();
				!isActive && li.toggleClass('open');
				return false; /* prevent bubbles */
			});
		});
	};

	/* Apply dropdown to html elements */
	$(function () {
		$('html').bind("click", clearMenus);
		$('body').dropdown(dropdownSelector);
	});

}(window.jQuery || window.ender);