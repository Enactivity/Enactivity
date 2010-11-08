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
				echo "You are currently " . CHtml::encode(strtolower($eventuser->status));
			}
			else {
				echo "You have not yet responded.";
			}
		?>
	</span>
	<div class="form2">
	<?php
	$form=$this->beginWidget('CActiveForm', array(
		    'id'=>'event-user-rsvp-form',
		    'enableAjaxValidation'=>false,
		));  
	if($eventuser->status != EventUser::STATUS_ATTENDING):
		//can't use constants for button names b/c rendering removes spaces
	    echo CHtml::submitButton('I\'m attending', array('name'=>'Attending_Button'));
	endif;
	
	if($eventuser->status != EventUser::STATUS_NOT_ATTENDING):
		echo CHtml::submitButton('I\'m not attending', array('name'=>'Not_Attending_Button'));
	endif;
	$this->endWidget();
	?>
	</div>
	<!-- end of rsvp form -->
</div>
<!-- rsvp -->