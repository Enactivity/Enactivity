$("#Event_starts").focusin(
	function () {
		// prevent smartphone keyboard
		$("#Event_starts").blur();
		$("#Event_starts_container").show("slow");
	}
);
	
$("#Event_ends").focusin(
	function () {
		// prevent smartphone keyboard
		$("#Event_ends").blur(); 
		$("#Event_ends_container").show("slow");
	}
);