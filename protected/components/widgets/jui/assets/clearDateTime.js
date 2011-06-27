$(document).ready(function(){
	$('.clear-date-time').live('click',function(){
		$(this).siblings(':input').val("");
		$(this).siblings(':select').val("");
	});
});