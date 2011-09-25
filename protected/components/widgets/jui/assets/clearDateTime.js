$(document).ready(function(){
	$('.clear-date-time').live('click',function(){
		event.preventDefault();
		$(this).siblings(':input').val("");
		$(this).siblings(':select').val("");
	});
});