// Ajax beautification
$(document).ajaxStart(function() {
	$('body').addClass('ajax-loading');
});

$(document).ajaxStop(function() {
	$('body').removeClass('ajax-loading');
});