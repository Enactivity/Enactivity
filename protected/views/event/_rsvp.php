<?php 
/**
 * Widget for user to RSVPs to an event
 * @param $eventuser
 */
?>

<!-- RSVP here -->
<div class="item rsvp">
	<?php
	$form = $this->beginWidget('ext.pwidgets.PActiveForm', array(
		    'enableAjaxValidation'=>false,
		));
	
	echo $form->hiddenField($event, 'id');
		
	if($eventuser->status == EventUser::STATUS_ATTENDING) {
		//can't use constants for button names b/c rendering removes spaces
	    echo PHtml::submitButton('You are attending', array('name'=>'Attending_Button', 'disabled'=>'disabled', 'class'=>'disabled'));
	}
	else {
		echo PHtml::submitButton('I\'m attending', array('name'=>'Attending_Button'));
	}
		
	if($eventuser->status == EventUser::STATUS_NOT_ATTENDING) {
		echo PHtml::submitButton('You are not attending', array('name'=>'Not_Attending_Button', 'disabled'=>'disabled', 'class'=>'disabled'));
	}
	else {
		echo PHtml::submitButton('I\'m not attending', array('name'=>'Not_Attending_Button'));
	}
	$this->endWidget();
	?>
	<!-- end of rsvp form -->
</div>
<!-- rsvp -->