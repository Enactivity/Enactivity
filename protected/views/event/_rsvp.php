<?php 
/**
 * Widget for user to RSVPs to an event
 * @param $eventuser
 */
?>

<!-- RSVP here -->
<div class="item rsvp">
	<div class="status"><span><?php echo $eventuser->status ? "You are " . CHtml::encode(strtolower($eventuser->status)) : "You have not yet responded.";?></span></div>
	<div class="formblock">
		<?php
		$form = $this->beginWidget('CActiveForm', array(
			    'enableAjaxValidation'=>false,
			));
			
		echo $form->hiddenField($event, 'id');
		
		if($eventuser->status == EventUser::STATUS_ATTENDING) {
			//can't use constants for button names b/c rendering removes spaces
		    echo CHtml::submitButton('You are attending', array('name'=>'Attending_Button', 'disabled'=>'disabled', 'class'=>'disabled'));
		}
		else {
			echo CHtml::submitButton('I\'m attending', array('name'=>'Attending_Button'));
		}
		
		if($eventuser->status == EventUser::STATUS_NOT_ATTENDING) {
			echo CHtml::submitButton('You are not attending', array('name'=>'Not_Attending_Button', 'disabled'=>'disabled', 'class'=>'disabled'));
		}
		else {
			echo CHtml::submitButton('I\'m not attending', array('name'=>'Not_Attending_Button'));
		}
		$this->endWidget();
		?>
		<!-- end of rsvp form -->
	</div>
</div>
<!-- rsvp -->