/**
 * Overrides default JQuery.scrollTop to account for top header nav
 * @requires JQuery 
 * @see http://api.jquery.com/scrollTop/
 * @see https://github.com/jquery/jquery/blob/master/src/offset.js for scrollTop declaration
 **/
(function($) {

	var topOffset = 120; // height to account for in scrolling

    // maintain a reference to the existing function
    var jqueryScrollTop = $.fn.scrollTop;
    
    // Overwriting the jQuery extension point
    $.fn.scrollTop = function() {

    	if(arguments.length > 0 && $.isNumeric(arguments[0])) {
    		arguments[0] = Math.max(0, arguments[0] - topOffset); // scrolling negative is pointless
	    }

        // original behavior - use function.apply to preserve context
        return jqueryScrollTop.apply(this, arguments);
    };
})(jQuery);