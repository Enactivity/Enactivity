/*!
 * jQuery plugin to capture errors and log them against controller
 * author: @ajsharma
 */
;(function ($, window, document, undefined ) {

    var nativeHandler = window.onerror || function(message, url, line) { return true; };

    function ajaxLog(message, url, line) {
        try {
            $.ajax({
                'type': 'POST',
                'data':{
                    'message': message,
                    'url': url,
                    'line': line,
                    'userAgent': window.navigator.userAgent,
                    'YII_CSRF_TOKEN':$("meta[name=YII_CSRF_TOKEN]").attr("content") // TODO: replace hardcoded YII_CSRF_TOKEN name
                },
                'url': $("meta[name=error-handler-url]").attr("content"),
                'cache': false
            });
        }
        catch (e) {
            // do nothing, for we have failed :(
            console.log(e);
        }
    };

    /** Apply ErrorHandler to window events 
    ----------------------------------------- */
    window.onerror = function(message, url, line) {

        ajaxLog(message, url, line);

        return nativeHandler(message, url, line);
    };
})( jQuery, window, document );