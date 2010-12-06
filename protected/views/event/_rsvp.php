<?php 
/**
 * Widget for user to RSVPs to an event
 * @param $eventuser
 */
?>

<!-- RSVP here -->
<div class="rsvp">
	<span>
		<?php 
			if($eventuser->status) {
				echo "You are " . CHtml::encode(strtolower($eventuser->status));
			}
			else {
				echo "You have not yet responded.";
			}
		?>
	</span>
	<?php
	$form = $this->beginWidget('CActiveForm', array(
		    'id'=>'event-user-rsvp-form',
		    'enableAjaxValidation'=>false,
		));
		
	echo $form->hiddenField($event, 'id');
	
	if($eventuser->status == EventUser::STATUS_ATTENDING) {
		//can't use constants for button names b/c rendering removes spaces
	    echo CHtml::submitButton('I\'m attending', array('name'=>'Attending_Button', 'disabled'=>null));
	}
	else {
		echo CHtml::submitButton('I\'m attending', array('name'=>'Attending_Button'));
	}
	
	if($eventuser->status == EventUser::STATUS_NOT_ATTENDING) {
		echo CHtml::submitButton('I\'m not attending', array('name'=>'Not_Attending_Button', 'disabled'=>null));
	}
	else {
		echo CHtml::submitButton('I\'m not attending', array('name'=>'Not_Attending_Button'));
	}
	$this->endWidget();
	?>
	<!-- end of rsvp form -->
</div>
<!-- rsvp -->