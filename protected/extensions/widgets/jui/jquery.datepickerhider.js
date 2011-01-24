	$("#Event_starts").focusin(
		function () {
			$("#Event_starts_container").show("slow");
		}
	);
	
	$("#Event_ends").focusin(
			function () {
				$("#Event_ends_container").show("slow");
			}
	);
	
	$("#Event_ends").focusout(
		function () {
			$("#Event_starts_container").hide("slow");
			$("#Event_ends_container").hide("slow");
		}
	);
	
	$("#Event_starts").focusout(
			function () {
				$("#Event_starts_container").hide("slow");
			}
		);